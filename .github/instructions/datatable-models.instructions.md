---
applyTo: "models/**/*.php"
description: "Guidelines for generating and editing models for bean-derived mappings, server-side DataTable payloads, and thin-controller architecture."
---

# DataTable Model Instructions

These instructions are framework-level guidance for DataTable-oriented models.

`models/ai` remains the canonical reference implementation.

## Wiki References (md)

For model design, SQL/ORM mapping, and server-side payload behavior, consult:

- Model role and architecture:
    - `md/Model.md`
    - `md/Understanding-WebMVC.md`
- Database interaction and ORM mapping:
    - `md/Interacting-with-MySQL.md`
    - `md/MySQL-ORM.md`
- Full DB application patterns:
    - `md/A-fully-functioning-DB-application.md`
- Controller/model boundary and request method handling:
    - `md/Controller.md`
    - `md/Handling-of-HTTP-Request-Methods.md`

## Architectural Role

- Keep controllers thin in the `ai` namespace.
- Put DataTable query construction, filtering, ordering, paging, and payload generation in models.
- If a REST service is used, the REST model should delegate to page-specific models rather than duplicating SQL.

## Bean-Driven Field Mapping

- Derive table field names from the corresponding bean under `models/beans/`.
- Use the bean as the canonical reference for:
    - primary key name
    - field names
    - data types
    - semantic meaning of fields
- Do not invent field names that are not backed by the bean or the schema.

## DataTable Server-Side Logic

- For AJAX/server-side DataTables, the model should expose methods that return a DataTables-compatible array with:
    - `draw`
    - `recordsTotal`
    - `recordsFiltered`
    - `data`
- Handle these concerns in the model:
    - paging from `start` and `length`
    - ordering from DataTables request payload
    - global search filter
    - conversion to row arrays suitable for JSON output

## Reuse Pattern

- `models/ai/DataTable.php` should be a thin delegator when possible.
- Prefer reusing methods already implemented in:
    - `models/ai/Category.php`
    - `models/ai/PartsManager.php`
- Avoid duplicating SQL between the page model and the REST service model.

## Query Style

- Keep SQL readable with heredoc when queries are multi-line.
- Use explicit `ORDER BY` defaults for stable results.
- Keep helper methods private when they are internal to DataTable payload generation.

## Master-Details Model Pattern

When implementing master-details pages (single master record + dynamic detail rows in one submit), use a dedicated model
with explicit transactional persistence.

- Use the involved beans as canonical field references (for example `BeanCategory` + `BeanProduct`).
- Keep persistence in model methods, not in the controller.
- Use explicit transaction workflow:
    - `START TRANSACTION`
    - update master data
    - update existing detail rows
    - insert new detail rows
    - delete removed detail rows
    - `COMMIT` on success, `ROLLBACK` on failure
- Return validation/SQL errors as a string array to the controller.
- Normalize posted arrays and field types in model code before DML execution.

## Consistency Rules

- Return stable, typed values where practical.
- Keep naming aligned with current `ai` examples.
- Do not add unrelated business logic when the model’s role is only DataTable serving or bean field mapping.
