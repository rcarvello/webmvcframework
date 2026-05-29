---
applyTo: "{controllers/**/*.php,models/**/*.php,views/**/*.php,templates/**/*.tpl}"
description: "Framework-level guidelines for generating and editing blocks, placeholders, nested blocks, OOP controller patterns, localization via locales/{RES}, HMVC composed pages, static replacement, and TreeStructure component usage (with examples/cms as canonical references)."
---

# Framework Content And Components Instructions

These are framework-level instructions for content composition and selected components.

`examples/cms` remains the canonical reference implementation for these WebMVC capabilities:

- blocks and placeholders
- nested blocks
- OOP usage at controller level (for example `BlockExtended`)
- multilingual pages via `locales/` and `{RES:...}` resources (assembly-specific and application-global)
- composed pages (HMVC) built from multiple assemblies/controllers
- static assembly replacement patterns
- TreeStructure component usage

## Wiki References (md)

When a task touches one of these capabilities, consult the corresponding wiki pages in `md/` first:

- Framework overview and architecture:
    - `md/Understanding-WebMVC.md`
    - `md/Software-decomposition-and-System-Architecture.md`
- Controller OOP patterns and lifecycle:
    - `md/Controller.md`
    - `md/Controller-and-OOP.md`
    - `md/Controller-autorun-method.md`
- Views, placeholders, and dynamic template content:
    - `md/View.md`
    - `md/Handling-placeholders.md`
    - `md/Dynamic-Content.md`
- Blocks, nested blocks, and block replacement/hiding:
    - `md/Handling-blocks.md`
    - `md/Nesting-of-blocks.md`
    - `md/Insight-about-nesting-of-blocks.md`
    - `md/Hiding-and-replacing-the-content-of-a-block.md`
- HMVC/composed pages and decomposition:
    - `md/Content-based-decomposition-and-HMVC.md`
    - `md/Role-Based-Decomposition.md`
    - `md/Skills-and-technologies-decomposition.md`
- Localization and resource placeholders `{RES}`:
    - `md/Decomposition-by-Internationalization--and-Localization.md`
- Components and reusable framework elements:
    - `md/Using-Components.md`
    - `md/Component-Based-Development.md`
    - `md/DataRepeater.md`

## Reference Scope

- Treat `examples/cms` as the canonical showcase for page-oriented WebMVC features rather than DB CRUD.
- Prefer these examples when the task involves:
    - template placeholders
    - blocks and nested blocks
    - controller composition
    - alternate templates
    - localization
    - reusable controllers or components
- For changes outside `examples/cms`, reuse these patterns as conceptual framework guidance and adapt namespaces/routes
  to the target assembly.

## Standard Assembly Structure

- Most `examples/cms` assemblies follow the aligned 4-artifact pattern:
    - `controllers/examples/cms/Name.php`
    - `models/examples/cms/Name.php`
    - `views/examples/cms/Name.php`
    - `templates/examples/cms/name.html.tpl`
- Namespace must reflect the folder structure exactly.
- View constructors should point to template paths like `/examples/cms/name`.

## Canonical Controller Pattern

- The common controller structure is:
    - optional injected `?View $view` and `?Model $model`
    - assign concrete model and view in the constructor
    - call `parent::__construct($this->view, $this->model)`
    - keep `autorun()` as the main initialization point
- Controllers in `examples/cms` are typically GET page controllers.
- Public methods often demonstrate URL-invocable actions such as alternate rendering, block hiding, or dynamic binding.

Minimal controller pattern:

```php
public function __construct(?View $view = null, ?Model $model = null)
{
    $this->view = empty($view) ? $this->getView() : $view;
    $this->model = empty($model) ? $this->getModel() : $model;
    parent::__construct($this->view, $this->model);
}

protected function autorun($parameters = null)
{
    // initialize page state here
}
```

## Canonical View Pattern

- Views should wrap placeholder and block operations into semantic methods such as:
    - `setMessage(...)`
    - `setUsers(...)`
    - `openBlockUsers()`
    - `openBlockNames()`
- Prefer explicit view methods over filling placeholders directly from controllers when the template logic is
  non-trivial.

## Template Placeholders And Blocks

- Use simple placeholders for scalar values:
    - `{Message}`
    - `{BodyMessage}`
- Use block syntax for repeated content:

```html
<!-- BEGIN Users -->
<tr>
    <td>{FirstName}</td>
    <td>{LastName}</td>
</tr>
<!-- END Users -->
```

- Nested blocks are supported and shown by `InnerBlocks`.
- Blocks can be hidden by controller or view logic using `hide(...)`.

## Canonical Examples By Feature

- Basic MVC placeholder flow:
    - `HelloWorld`
- Alternate template loading and page variants:
    - `HelloWorldSecond`
- Basic repeated blocks:
    - `Block`
- Manual block population and DataRepeater comparison:
    - `HelloBlock`
    - `BlockDataRepeater`
- Inheritance and alternate template variants:
    - `BlockExtended`
- Nested blocks:
    - `InnerBlocks`
- Controller composition / composite pages:
    - `CompositePage`
- Dynamic child controller binding:
    - `DynamicBinding`
- Localization and locale-dependent content:
    - `Localization`
- Reusable child controller as page fragment:
    - `NavigationBar`
- Component usage:
    - `TreeDemo`
    - `CaptchaComponent`
- Static or near-static content replacement:
    - `StaticReplacement`

## Dynamic Binding Rules

- Use `bindController(...)` when one controller must be rendered inside another controller's template.
- Use a named placeholder binding when the destination is dynamic in the template.
- `DynamicBinding` is the reference example.

Example pattern:

```php
$this->hide("Info");
$controller = new HelloWorld();
$this->bindController($controller, "whitchController");
$this->render();
```

## Composite Page Rules

- `CompositePage` is the reference when a page includes reusable child controllers such as `NavigationBar`.
- Prefer composition over duplicating repeated page fragments in multiple templates.
- For HMVC composition, keep child controllers reusable and parent-driven: instantiate in the parent `autorun()`, then
  bind with `bindController(...)`.

Example pattern:

```php
$navigation = new NavigationBar();
$this->bindController($navigation);
```

## HMVC Localization Rules (`#Load`)

- When a parent assembly binds a child controller that uses `{RES:...}` placeholders (for example `NavigationBar`), the
  parent locale file must import child locale resources via `#Load:`.
- Use fully qualified locale paths including `.txt` to avoid ambiguous loading.
- Add one `#Load` per active locale, for example:
    - `#Load:locales/en/controllers/examples/cms/NavigationBar.txt`
    - `#Load:locales/it-it/controllers/examples/cms/NavigationBar.txt`
- Keep shared text in child locale files and avoid copying the same keys into every parent assembly.
- If `{RES:...}` renders literally in output, treat missing/incorrect `#Load:` as the first diagnostic check.

## Alternate Template Rules

- If the same controller/view logic must render a different presentation, use `loadCustomTemplate(...)`.
- `HelloWorldSecond` and `BlockExtended` are the canonical examples.
- For compatibility migrations (for example Bootstrap 3 to Bootstrap 5), keep legacy templates untouched and create a
  new static template variant, then switch at runtime using `loadCustomTemplate(...)`.

Example pattern:

```php
$this->view->loadCustomTemplate("templates/examples/cms/hello_world_mobile");
```

HMVC child override example:

```php
$navigation = new NavigationBar();
$navigation->view->loadCustomTemplate('templates/examples/cms/navigation_bar_bs5');
$this->bindController($navigation);
```

## Localization Rules

- `Localization` is the canonical reference for locale-dependent page content.
- Use `{RES:...}` placeholders in templates for resource-driven text.
- Localization resources may be scoped to a specific assembly and can also be defined globally at application level.
- Keep locale files under `locales/` and keep resource keys stable across templates/controllers.
- If model content depends on locale, pass the active locale or read the locale request parameter consistently with the
  framework example.

## Component Rules

- Use `bindComponent(...)` for framework components that are not standalone controllers.
- `TreeDemo` and `CaptchaComponent` are the reference examples.
- Treat `TreeDemo` as the reference for TreeStructure component integration patterns.
- `BlockDataRepeater` is the reference when using `framework\components\DataRepeater` inside CMS-style page assembly
  logic.

## Practical Guidance

- If the task is about page composition, start from `CompositePage` or `DynamicBinding`.
- If the task is about repeated HTML sections, start from `Block`, `HelloBlock`, or `InnerBlocks`.
- If the task is about visual variants, start from `HelloWorldSecond` or `BlockExtended`.
- If the task is about localized CMS pages, start from `Localization`.
- If the task is outside `examples/cms` but concerns framework capabilities listed above, still apply these rules and
  examples as the primary implementation guideline, then map them to the target namespace.
- Keep these examples educational and focused: avoid mixing DB CRUD patterns from `examples/db` into `examples/cms`
  unless the task explicitly asks for that crossover.
