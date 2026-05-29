---
applyTo: "templates/**/*.tpl"
description: "Guidelines for generating and editing DataTable templates, including Bootstrap 5.3.8 layout, toolbar behavior, search UX, export buttons, and localStorage state."
---

# DataTable Template Instructions

These instructions are framework-level guidance for DataTable pages.

`templates/ai` remains the canonical reference implementation.

## Wiki References (md)

For template composition, placeholders/blocks, and dynamic rendering behavior, consult:

- View/template responsibilities:
    - `md/View.md`
    - `md/Understanding-WebMVC.md`
- Dynamic content and placeholders:
    - `md/Dynamic-Content.md`
    - `md/Handling-placeholders.md`
- Blocks and repeated rendering:
    - `md/Handling-blocks.md`
    - `md/DataRepeater.md`
- HTTP method and request handling context:
    - `md/Handling-of-HTTP-Request-Methods.md`

## Visual Stack

- Use Bootstrap `5.3.8`.
- Use DataTables Bootstrap 5 integration.
- Use Bootstrap Icons for button icons.
- Keep the page background white and the overall look simple, readable, and stable.

## DataTable Layout

- DataTables in `ai` are AJAX/server-side tables.
- Toolbar order in `ai`:
    - top row left: `record per pagina`
    - top row right: `cerca`
    - export buttons before reload button
    - bottom row: info text and pagination on the same row
- Use an explicit `dom` configuration rather than default DataTables layout when needed to preserve this arrangement.

## Search UX

- Support `?search=VALUE` in the page URL and auto-apply it when the page loads.
- The search input must include an internal clear `X` inside the input box.
- Keep the clear action synchronized with the DataTables filter value.

## Persisted State

- Save DataTable state in `localStorage`.
- Persist at least:
    - ordering
    - global filter
    - page length
    - current pagination page
- Use explicit keys:
    - `datatable:ai:category`
    - `datatable:ai:parts_manager`

## Button Styling

- Export buttons must use these classes:
    - CSV: `btn btn-warning text-dark`
    - EXCEL: `btn btn-info text-dark`
    - PDF: `btn btn-danger text-white`
    - PRINT: `btn btn-dark text-white`
- Do not enable COPY.
- Reload buttons use `btn btn-primary` with icon `bi-arrow-clockwise`.
- Create/new buttons use `btn btn-success` with icon `bi-plus-circle`.
- Add icons to export buttons too.

## Template Pattern

- A page-level `ai` DataTable template should typically:
    - load Bootstrap 5.3.8 CSS and JS
    - load DataTables Bootstrap 5 CSS and JS
    - load Buttons CSS and JS plus `jszip` and `pdfmake`
    - initialize DataTables in JavaScript
    - call the `ai/DataTable` REST endpoints with `POST`

Example endpoint usage:

- `ai/data_table/category`
- `ai/data_table/parts_manager`

Example ajax block:

```javascript
"ajax": {
    "url": "{CategoryAjaxDataUrl}",
    "type": "POST"
}
```
