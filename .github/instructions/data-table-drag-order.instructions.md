---
applyTo: "{controllers/**/*.php,models/**/*.php,views/**/*.php,templates/**/*.tpl}"
description: "Guidelines for adding drag-and-drop row reordering on server-side DataTables in the ai namespace, with automatic list_order persistence via a REST endpoint."
---

# DataTable Drag-And-Drop Row Reorder Instructions

These instructions describe how to add drag-and-drop row reordering to any server-side DataTable in the `ai` namespace
to automatically update a `list_order` (or equivalent) integer field.

`ai/Category` is the canonical reference implementation.

## When To Apply

Apply this pattern when:

- The DataTable rows have an explicit `list_order` (or equivalent) integer column that controls display order.
- The user should be able to manually reorder rows by dragging and the new order should be persisted immediately.

## Required Files — Checklist

For a table `foo` with a `list_order` column, the following artifacts must be changed or reused:

| Artifact                       | Change                                                                                          |
|--------------------------------|-------------------------------------------------------------------------------------------------|
| `templates/ai/foo.html.tpl`    | Add RowReorder CSS/JS, handle column, `rowReorder` config, `row-reorder` event handler          |
| `views/ai/Foo.php`             | Add `setFooOrderUrl(string $url)` setter                                                        |
| `controllers/ai/Foo.php`       | Call `$view->setFooOrderUrl(SITEURL . '/ai/data_table/foo_order')` in `autorun()`               |
| `controllers/ai/DataTable.php` | `$this->allowMethod('foo_order')` in constructor; `case 'foo_order':` in `httpPostRequest()`    |
| `models/ai/DataTable.php`      | Add `saveFooListOrder(array $post)` delegating to `Foo` model                                   |
| `models/ai/Foo.php`            | Add `updateFooListOrder(array $post)` with individual `UPDATE` per row; adjust column index map |

---

## Template Changes

### 1. CSS — add RowReorder stylesheet after the Buttons stylesheet

```html
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.bootstrap5.min.css" rel="stylesheet">
```

### 2. JS — add RowReorder script after the Buttons print script

```html
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js"></script>
```

### 3. Table `<thead>` — add an empty header cell as first column (the handle)

```html
<tr>
    <th style="width:30px;"></th>
    <th>Actions</th>
    <th>Foo ID</th>
    ...
    <th>List order</th>
</tr>
```

The handle column must be the **first** `<th>`. All other column indexes shift by 1.

### 4. JavaScript variable — declare the order URL

```javascript
var fooOrderUrl = '{FooOrderUrl}';
```

### 5. DataTable `"order"` — shift indexes by 1 to account for the new first column

```javascript
"order": [[N+1, "asc"], [N, "asc"]],
```

where `N+1` is the new 0-based index of `list_order` after adding the handle column.

### 6. DataTable `"columns"` — insert handle column as first entry

```javascript
"columns": [
    {
        "data": null,
        "orderable": false,
        "searchable": false,
        "render": function() {
            return '<i class="bi bi-grip-vertical text-secondary" style="cursor:grab;font-size:1.1rem" title="Trascina per riordinare"></i>';
        }
    },
    // ... existing columns follow
]
```

### 7. DataTable `"columnDefs"` — mark both the handle column and any static actions column as non-orderable

```javascript
"columnDefs": [
    { "targets": 0, "orderable": false, "searchable": false },
    { "targets": 1, "orderable": false, "searchable": false }
],
```

If the table has no actions column, only mark `targets: 0`.

### 8. DataTable `"rowReorder"` option — set `dataSrc` to the 0-based index of
`list_order` and restrict drag to the first cell

```javascript
"rowReorder": {
    "dataSrc": N,
    "selector": "td:first-child"
},
```

`N` is the 0-based column index of `list_order` after adding the handle column.

### 9. `row-reorder` event handler — recalculate and persist order

```javascript
table.on('row-reorder', function(e, diff, edit) {
    if (diff.length === 0) {
        return;
    }

    var updates = [];
    var start = table.page.info().start;

    $(table.table().node()).find('tbody tr').each(function(idx) {
        var rowData = table.row(this).data();
        if (rowData) {
            updates.push({
                foo_id: rowData.foo_id,
                list_order: start + idx + 1
            });
        }
    });

    $.ajax({
        url: fooOrderUrl,
        type: 'POST',
        data: { updates: updates },
        success: function() {
            table.ajax.reload(null, false);
        },
        error: function() {
            table.ajax.reload(null, false);
        }
    });
});
```

Key rules:

- Use `table.page.info().start` as base offset so `list_order` is globally consistent across pages.
- `list_order = start + idx + 1` (1-based).
- Always reload after AJAX (success and error) to keep the visual state in sync with the DB.
- Pass `false` to `ajax.reload()` to stay on the current page.
- Use the table's primary key field name, not a hardcoded `id`.

---

## View Changes

Add a dedicated setter for the order URL placeholder:

```php
public function setFooOrderUrl($url)
{
    $this->setVar('FooOrderUrl', $url);
}
```

---

## Controller Changes

Call the setter inside `autorun()`:

```php
$view->setFooOrderUrl(SITEURL . '/ai/data_table/foo_order');
```

---

## REST Service Changes (`controllers/ai/DataTable.php`)

Register the new method in the constructor and handle both snake_case and camelCase in `httpPostRequest()` for maximum
compatibility:

```php
public function __construct()
{
    parent::__construct(null, new DataTableModel());
    $this->allowMethod('foo');
    $this->allowMethod('foo_order');
    $this->allowMethod('fooOrder'); // Support both snake_case and camelCase for router compatibility
}

public function httpPostRequest($method, $args)
{
    switch ($method) {
        case 'foo':
            return $model->getFooDataTableResponse($_POST);
        case 'foo_order':
        case 'fooOrder':
            return $model->saveFooListOrder($_POST);
        // ...
    }
}
```

---

## REST Model Changes (`models/ai/DataTable.php`)

Add a thin delegator:

```php
public function saveFooListOrder(array $post)
{
    $model = new Foo();
    return $model->updateFooListOrder($post);
}
```

---

## Page Model Changes (`models/ai/Foo.php`)

### Column index map

Shift all column indexes by 1 to account for the handle column:

```php
$columns = array(
    2 => 'foo_id',
    3 => 'foo_name',
    4 => 'list_order',
);

$columnIndex = 4;
```

### `updateFooListOrder` method

```php
public function updateFooListOrder(array $post)
{
    $updates = (isset($post['updates']) && is_array($post['updates'])) ? $post['updates'] : array();

    foreach ($updates as $item) {
        $fooId    = (int)@$item['foo_id'];
        $listOrder = (int)@$item['list_order'];

        if ($fooId <= 0) {
            continue;
        }

        $this->query("UPDATE foo SET list_order = {$listOrder} WHERE foo_id = {$fooId}");
    }

    return array('success' => true);
}
```

Rules:

- Cast both `foo_id` and `list_order` to `int` before DML.
- Skip rows with `foo_id <= 0`.
- Return `array('success' => true)` as JSON response.

---

## Constraints And Compatibility

- RowReorder **requires** server-side mode (`"serverSide": true`) to be configured with `"selector": "td:first-child"`
  so that only the handle cell triggers drag, not clicks on action buttons, links, o altre celle.
- The `"dataSrc"` value in `rowReorder` must match the **column index** of `list_order` in the `columns` array, not the
  database field position.
- The handle column icon (`bi-grip-vertical`) must be in the first `<th>` / first `<td>` of every row; do not shift it
  to any other position.
- When the table has a static actions column (buttons), that column must also be marked
  `orderable: false, searchable: false` in `columnDefs`.
- This pattern does **not** require any changes to the DataTables AJAX payload or server-side
  `getCategoriesDataTableResponse`-style methods — the drag order is saved through a separate dedicated endpoint.
- **IMPORTANT:** If the framework or router converts snake_case to camelCase (e.g. `foo_order` → `fooOrder`), always
  register and handle both variants in `allowMethod()` and in the switch-case. Otherwise, the method may not be
  recognized and you will get a 404 or unsupported method error.
