# Copilot Instructions For This Repository

This repository uses the author's personal PHP WebMVC framework. Before inferring framework behavior from code, always
consult the wiki in the `md/` folder. Treat that documentation as the primary reference for framework conventions.

## General Framework Rules

- WebMVC assemblies are convention-based and are typically made of four aligned artifacts with the same logical name:
    - `controllers/.../Name.php`
    - `models/.../Name.php`
    - `views/.../Name.php`
    - `templates/.../name.html.tpl`
- Namespace must reflect the folder structure exactly.
- Namespaces are also used to organize and decompose the application into subsystems (for example `examples\db`,
  `examples\cms`, `ai`).
- There is a direct correspondence between namespace path, physical filesystem path, and URL path.
- This direct mapping simplifies routing, which is convention-based rather than configuration-based (convention over
  configuration).
- Example mapping:
    - namespace/class: `controllers\examples\db\PartList`
    - filesystem: `controllers\examples\db\PartList.php`
    - URL endpoint: `http://HOST/controllers/examples/db/part_list`
- Controller classes use PascalCase names.
- URL routing uses snake_case path notation.
- Public controller methods are callable from URL by convention and are effectively GET-oriented; optional method
  parameters are passed as path segments separated by `/`.
- If an endpoint must serve AJAX data over POST, prefer a dedicated service extending `framework\RestService` rather
  than adding POST semantics to a normal controller method.

## HMVC, Locales, And Runtime Template Replacement

- For HMVC page composition, prefer binding reusable child controllers (for example `NavigationBar`) from parent
  controllers using `bindController(...)`.
- When an assembly uses `{RES:...}` placeholders defined in external locale files, ensure its locale file explicitly
  imports those dependencies using `#Load:`.
- The `#Load` directive in locale `.txt` files is the standard way to compose translation resources: instead of
  redefining each `{RES:...}` key, load existing resource files that already contain the required translations.
- Use locale include paths with full filename, for example:
    - `#Load:locales/en/controllers/examples/cms/NavigationBar.txt`
    - `#Load:locales/it-it/controllers/examples/cms/NavigationBar.txt`
- Keep locale resources scoped per assembly (`locales/<locale>/controllers/.../Assembly.txt`) and use `#Load` only for
  shared dependencies to avoid key duplication.
- When a child controller template needs framework/UI compatibility changes (for example Bootstrap 3 vs Bootstrap 5), do
  not overwrite legacy templates; create a new static template and switch it at runtime with `loadCustomTemplate(...)`.

Minimal HMVC + runtime template override pattern:

```php
$navigation = new \controllers\examples\cms\NavigationBar();
$navigation->view->loadCustomTemplate('templates/examples/cms/navigation_bar_bs5');
$this->bindController($navigation);
```

## AI Namespace Conventions

The `ai` namespace is the current canonical example area for new code generation in this repository.

### Implemented Assemblies

- `ai/Category`
    - page controller for category DataTable
    - uses `ai/DataTable` REST service for AJAX data
- `ai/CategoryForm`
    - editable form for the `category` table
    - opened from the Category table by clicking the primary key
- `ai/CategoryProducts`
    - master-details form for one `category` with dynamic `product` rows
    - opened from a dedicated action button in `ai/Category` rows
    - submit handled with custom SQL transaction (not with Record component)
- `ai/PartsManager`
    - page controller for the `part` table DataTable
    - uses `ai/DataTable` REST service for AJAX data
- `ai/DataTable`
    - REST service extending `framework\RestService`
    - exposes POST endpoints for DataTables payloads
    - currently supports `category` and `parts_manager`

### REST/DataTable Pattern

- Because normal controller methods are callable only in GET semantics, all DataTables AJAX endpoints in the `ai`
  namespace must be served by `controllers\ai\DataTable` extending `framework\RestService`.
- Use allowed REST methods such as:
    - `ai/data_table/category`
    - `ai/data_table/parts_manager`
- DataTables pages in `ai` must call those endpoints with `POST`.
- DataTables server-side logic should stay in models and be reused by the REST service model.

Example route pattern:

- page routes:
    - `ai/category`
    - `ai/parts_manager`
- form routes:
    - `ai/category_form/open/12`
    - `ai/category_form/add/new`
- REST/DataTable routes:
    - `ai/data_table/category`
    - `ai/data_table/parts_manager`

Minimal REST service pattern:

```php
namespace controllers\ai;

use framework\RestService;
use models\ai\DataTable as DataTableModel;

class DataTable extends RestService
{
    public function __construct()
    {
        parent::__construct(null, new DataTableModel());
        $this->allowMethod('category');
    $this->allowMethod('parts_manager');
    }
}
```

## Template And Layout Rules For `templates/ai`

- Use Bootstrap `5.3.8`.
- Use DataTables Bootstrap 5 integration.
- Use Bootstrap Icons for button icons.
- Keep visual styling simple, readable, and consistent on a white page background.
- DataTable toolbar conventions in `ai`:
    - export buttons before reload
    - `record per pagina` control aligned left
    - `cerca` control aligned right
    - info and pagination on the same bottom row
- Export buttons in `ai` use these colors:
    - CSV: `btn-warning text-dark`
    - EXCEL: `btn-info text-dark`
    - PDF: `btn-danger text-white`
    - PRINT: `btn-dark text-white`
- Standard action buttons in `ai`:
    - reload buttons use `btn-primary` and `bi-arrow-clockwise`
    - create/new buttons use `btn-success` and `bi-plus-circle`

## DataTable UX Rules In `ai`

- Enable server-side DataTables.
- Enable export buttons: CSV, EXCEL, PDF, PRINT.
- Do not enable COPY.
- Support `?search=VALUE` in page URLs and auto-apply the filter on load.
- The search input should include an internal clear `X` button inside the input area.
- Save DataTable state in `localStorage` so order, filter, page length, and pagination are restored when reopening the
  page.
- Use stable, explicit `localStorage` keys per table, for example:
    - `datatable:ai:category`
    - `datatable:ai:parts_manager`

## Forms In `ai`

- For editable records, follow the `CategoryForm` pattern.
- Use `framework\components\Record` with a bean and `framework\BeanAdapter`.
- For add actions, follow the framework routing convention and provide a dummy positional parameter such as `/add/new`.
- Clicking the primary key in a table should open the edit form of the corresponding record.

Minimal form controller pattern:

```php
public function open($pk)
{
  $_GET['category_id'] = $pk;
  $this->autorun();
  $this->render();
}

public function add($dummy)
{
  $this->autorun();
  $this->render();
}
```

## Master-Details Pattern (any namespace)

**UI/UX NOTE:**
When there are no detail rows (e.g. no products for a category), the GUI must not render any empty row in the table. Do
not auto-create a blank row on page load or after deleting all rows. The user should add new rows manually using the "
Add" button. This avoids HTML required field issues and ensures correct validation. Apply this pattern in
`templates/ai/category_products.html.tpl` and similar master-detail forms.

Use this pattern when a page edits one master row and a dynamic detail list (for example `category` + `product` rows).

- Canonical example: `ai/CategoryProducts`.
- Use standard aligned artifacts:
    - `controllers/ai/CategoryProducts.php`
    - `models/ai/CategoryProducts.php`
    - `views/ai/CategoryProducts.php`
    - `templates/ai/category_products.html.tpl`
- Open flow:
    - from DataTable listing (`ai/category`) through a dedicated per-row action button
    - route pattern: `ai/category_products/open/<master_pk>`
- Prefer custom SQL transaction for submit logic when multiple detail rows are edited in one postback:
    - `START TRANSACTION`
    - update master row
    - update existing detail rows
    - insert new detail rows
        - **IMPORTANT:** After each INSERT, retrieve the new ID (e.g. `$this->getInsertId()`) and add it to the array of
          existing IDs (e.g. `$existingProductIds[]`). This ensures the new row is not immediately deleted by the
          subsequent DELETE statement.
    - delete removed detail rows
    - `COMMIT` / `ROLLBACK`
- Use beans as field/schema reference (`BeanCategory`, `BeanProduct`) even when persistence uses custom SQL.
- Keep controller thin:
    - resolve current master id from URL
    - delegate save/load to model
    - redirect after successful save to avoid duplicate submit
- In templates, detail rows must be dynamic client-side (add/remove row buttons) but always validated server-side.
- Validation and errors:
    - collect model errors as string array
    - call `parseErrors(...)` only when array is non-empty; otherwise hide `ValidationErrors` block.

Minimal route pattern:

- listing page: `ai/category`
- master-detail page: `ai/category_products/open/12`

## Model And Bean Rules

- When generating table-oriented models, derive field names from the corresponding bean in `models/beans/`.
- Do not reintroduce `close()` methods into beans under `models/beans`.
- Keep changes minimal and consistent with the existing style of the framework.

## Practical Guidance For Future Code Generation

- If the request concerns framework behavior, read the relevant wiki page in `md/` first.
- If the request matches one of the scoped instruction files in `.github/instructions/`, apply that file as the primary
  rule set for the matching paths.
- If the request concerns core framework internals under `framework/` (Dispatcher, Controller, View, Model, RestService,
  BeanAdapter, components), use `.github/instructions/framework-core-logic-instructions.md` as the primary guide.
- If the request concerns blocks/placeholders, nested blocks, OOP controller patterns, localization via `locales/` and
  `{RES}`, HMVC page composition, static replacement, or TreeStructure component usage, use
  `.github/instructions/framework-content-components.instructions.md` as canonical framework guidance, even outside
  `examples/cms` when relevant.
- If `{RES:...}` placeholders render unresolved, first check that the current assembly locale file contains the correct
  `#Load:` entries for every referenced external locale file (including HMVC child assemblies when present).
- If the request concerns DataTable-based data management with row drilldown to Record-based edit forms, use
  `.github/instructions/datatable-record-forms.instructions.md`,
  `.github/instructions/datatable-models.instructions.md`, and
  `.github/instructions/datatable-templates.instructions.md` as canonical guidance, then adapt namespaces/routes to the
  target area.
- If the request concerns a table CRUD or DataTable in `ai`, reuse the existing patterns from:
    - `controllers/ai/Category.php`
    - `controllers/ai/CategoryForm.php`
    - `controllers/ai/CategoryProducts.php`
    - `controllers/ai/PartsManager.php`
    - `controllers/ai/DataTable.php`
    - `models/ai/Category.php`
    - `models/ai/CategoryProducts.php`
    - `models/ai/PartsManager.php`
    - `models/ai/DataTable.php`
    - `templates/ai/category.html.tpl`
    - `templates/ai/category_form.html.tpl`
    - `templates/ai/category_products.html.tpl`
    - `templates/ai/parts_manager.html.tpl`
- Prefer extending those examples rather than inventing a new local convention.

## Subfolder Instruction References

When a change falls into one of these path scopes, consult and apply the related instruction file first:

- `framework/**/*.php`
    - `.github/instructions/framework-core-logic-instructions.md`

- `controllers/**/*Form.php`, `models/**/*Form.php`, `views/**/*Form.php`, `templates/**/*form.html.tpl`
    - `.github/instructions/datatable-record-forms.instructions.md`
- `models/**/*.php`
    - `.github/instructions/datatable-models.instructions.md`
- `templates/**/*.tpl`
    - `.github/instructions/datatable-templates.instructions.md`
- `controllers/**/*.php`, `models/**/*.php`, `views/**/*.php`, `templates/**/*.tpl`
    - `.github/instructions/framework-content-components.instructions.md`
- `templates/**/*.tpl`, `controllers/**/*.php`, `models/**/*.php`, `views/**/*.php` — when the request concerns
  drag-and-drop row reordering or `list_order` persistence on a DataTable
    - `.github/instructions/data-table-drag-order.instructions.md`

## General Guidance For New CRUD/REST DataTable Code (Any Namespace)

When generating new code for CRUD pages, DataTable browsing, or REST endpoints (not only in `ai`, but in any namespace):

- First identify the bean under `models/beans/`.
- Derive field names from the bean accessors and DB mapping.
- Decide whether the page is:
    - a GET page controller
    - a Record-based form controller
    - a master-details custom SQL form controller
    - a `RestService` POST endpoint for AJAX tables
- If the table has a `list_order` column that users should be able to drag to reorder, apply
  `.github/instructions/data-table-drag-order.instructions.md` (and remember to handle both snake_case and camelCase
  REST method names).
- Keep page controllers thin and move table payload generation into models.