---
applyTo: "{controllers/**/*Form.php,models/**/*Form.php,views/**/*Form.php,templates/**/*form.html.tpl}"
description: "Guidelines for generating and editing Record-based CRUD forms opened from DataTable rows, using BeanAdapter and bean-backed models."
---

# DataTable Record Form Instructions

These instructions are framework-level guidance for editable Record forms connected to DataTable row drilldown.

`ai/CategoryForm` is the canonical reference implementation.

## Wiki References (md)

For DataTable-to-Record edit workflows, consult these wiki pages:

- MVC and controller/view responsibilities:
    - `md/Understanding-WebMVC.md`
    - `md/Controller.md`
    - `md/View.md`
- Model/ORM and data access patterns:
    - `md/Model.md`
    - `md/Interacting-with-MySQL.md`
    - `md/MySQL-ORM.md`
- End-to-end DB application flow:
    - `md/A-fully-functioning-DB-application.md`
- HTTP method behavior and endpoint semantics:
    - `md/Handling-of-HTTP-Request-Methods.md`

## Canonical Pattern

- Follow the `CategoryForm` assembly pattern for editable records.
- The standard aligned artifacts are:
    - `controllers/ai/NameForm.php`
    - `models/ai/NameForm.php`
    - `views/ai/NameForm.php`
    - `templates/ai/name_form.html.tpl`

## Master-Details Exception

When the requested page is a true master-details form (one master row + many detail rows edited in the same submit), do
not force the `Record` component pattern.

- Canonical example: `ai/CategoryProducts`.
- In this case, prefer a dedicated assembly with custom SQL transaction logic and multiple beans as schema references.
- Keep the same aligned artifact convention even when the class name does not end with `Form`:
    - `controllers/ai/CategoryProducts.php`
    - `models/ai/CategoryProducts.php`
    - `views/ai/CategoryProducts.php`
    - `templates/ai/category_products.html.tpl`

## Controller Pattern

- Use `framework\components\Record`.
- Use `framework\BeanAdapter` with the corresponding bean from `models/beans/`.
- Register the primary key URL parameter with `registerPkUrlParameter(...)`.
- For add operations, expose `add($dummy)` and expect route usage like `/add/new`.
- For edit operations, expose `open($pk)` and set the matching `$_GET` parameter before rendering.
- Redirect close/delete/add/update back to the listing page.
- After `Record::init(...)`, explicitly handle SQL errors from BeanAdapter (`isSqlError()` / `lastSqlError()`) and add
  them to Record errors.
- When needed, catch `\mysqli_sql_exception` and map the message to `Record::addError(...)` so the form can render it in
  ValidationErrors.

For master-details exception pages:

**UI/UX NOTE:**
When there are no detail rows (e.g. no products for a category), the GUI must not render any empty row in the table. Do
not auto-create a blank row on page load or after deleting all rows. The user should add new rows manually using the "
Add" button. This avoids HTML required field issues and ensures correct validation. Apply this pattern in
`templates/ai/category_products.html.tpl` and similar master-detail forms.

-- Keep controller responsibilities minimal: load master id from URL, delegate save/load to model, render/redirect.
-- For successful save, use redirect-after-post to avoid duplicate submit.
-- If model returns an empty error array, hide `ValidationErrors` block directly instead of calling `parseErrors([])`.

Example route pattern:

- open existing record: `ai/category_form/open/12`
- add new record: `ai/category_form/add/new`

## View Pattern

- The view should populate form fields from the bean using a dedicated method such as `setFieldsWithBeanData(...)`.
- The form title should switch between new/edit mode.
- The primary key should be visible in edit mode and should not be freely editable for existing records.
- If the page uses Bootstrap 5, keep the markup compatible with it.

## Model Pattern

- The form model should only map posted fields onto the bean.
- Field names must come from the corresponding bean in `models/beans/`.
- Keep business logic minimal in the form model unless there is a strong reason otherwise.

For master-details exception pages:

- Use beans as canonical field/schema references (master bean + detail bean).
- Implement save with explicit SQL transaction:
    - update master
    - update existing details
    - insert new details
    - delete removed details
    - commit or rollback
- Keep sanitization and type normalization inside model methods.

## Integration With DataTables

- Clicking the primary key in the corresponding `ai` table must open the form.
- Table pages should link to forms through the primary key, for example:
    - `SITEURL . '/ai/category_form/open/' . $id`

For master-details pages, add an explicit action button in the listing row and route to:

- `SITEURL . '/ai/category_products/open/' . $id`

## Validation And Consistency

- Keep changes minimal and aligned with the existing `CategoryForm` implementation.
- Do not invent a new CRUD pattern when `CategoryForm` already demonstrates the intended framework style.
- Keep error surfacing consistent: `parseErrors($record->getErrors())` must include SQL errors and business validation
  errors.
