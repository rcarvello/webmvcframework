---
applyTo: "framework/**/*.php"
description: "Guidelines for analyzing, generating, and editing core framework logic in Dispatcher/Controller/View/Model, REST services, bean adapters, and framework components."
---

# Framework Core Logic Instructions

These instructions apply to core framework code under `framework/`.

Use this file when the task touches framework internals, lifecycle, routing, template engine behavior, REST dispatching,
bean/record interoperability, or core components.

## Core Design Boundaries

- Preserve backward compatibility in public framework APIs unless the request explicitly asks for breaking changes.
- Keep conventions stable because application code depends on convention-over-configuration behavior.
- Prefer minimal, localized changes in `framework/` and avoid cross-cutting refactors unless required.

## Canonical Core Files

- Request parsing and method dispatch: `framework/Dispatcher.php`
- Controller lifecycle/composition/auth/rendering: `framework/Controller.php`
- Template/placeholders/blocks/XSS clean: `framework/View.php`
- DB base model and query lifecycle: `framework/Model.php`
- REST service behavior: `framework/RestService.php`
- Bean contract and adapter: `framework/Bean.php`, `framework/BeanAdapter.php`
- Record-driven form actions: `framework/components/Record.php`
- Tree component behavior: `framework/components/TreeStructure.php`
- Autoloading and subsystem detection: `framework/Loader.php`

## Config Folder Analysis (`config/`)

Core framework behavior depends on constants loaded by configuration files. When changing framework internals, always
verify compatibility with this configuration chain.

### Loading Order And Bootstrap Contract

- `config/framework.config.php` is the orchestrator and includes, in order:
    - `config/security.config.php`
    - `config/locale.config.php`
    - `config/application.config.php`
    - `config/mail.config.inc`
- `framework/Loader.php` is required from `framework.config.php` before `SUBSYSTEMS` is defined.
- Keep include order stable unless explicitly requested; many constants are consumed downstream during bootstrap.

### Runtime Paths And Namespace Mapping

- `framework.config.php` defines core paths used by Loader and runtime resolution:
    - `APP_CONTROLLERS_PATH`, `APP_MODELS_PATH`, `APP_VIEWS_PATH`, `APP_TEMPLATES_PATH`
    - `JSFRAMEWORK`
    - `CLASSES` and `SUBSYSTEMS`
- `SUBSYSTEMS` is auto-derived from controller folders (`Loader::listFolders(APP_CONTROLLERS_PATH)`), so controller
  directory changes affect routing behavior.
- `SECURING_OUTSIDE_HTTP_FOLDER` (from `security.config.php`) changes path assumptions for locale/controller variable
  resolution in `Controller`.

### Application Constants That Drive Framework Logic

- DB constants from `application.config.php` (`DBHOST`, `DBUSER`, `DBPASSWORD`, `DBNAME`, `DBPORT`) are consumed by
  `Model` constructor.
- Routing defaults from `application.config.php` (`DEFAULT_CONTROLLER`, `DEFAULT_LOGIN_PAGE`) directly affect
  Dispatcher/Auth redirects.
- Output/rendering behavior depends on:
    - `COMPRESS_OUTPUT` (framework-level output compression)
    - `CHARSET` (used by sanitization and output routines)
- Date constants (`FETCHED_*`, `STORED_*`) must stay aligned with SQL conversion behavior in record/bean workflows.

### Security And Session Contract

- `security.config.php` defines user schema constants used by built-in auth classes (`USER_*`, `ADMIN_ROLE_ID`).
- Record component CSRF flow depends on `CSRF_TOKEN_FORM_FIELD` and session hardening settings.
- XSS behavior depends on:
    - `XSS_PROTECTION`
    - `USE_HTMLPURIFIER`
- Cookie/session/chiper constants (`CRYPT_ALGO`, `CHIPER_*`) are cross-cutting and should be treated as
  compatibility-sensitive.

### Locale And Global Placeholder Contract

- `locale.config.php` controls localization lookup roots and request parameter semantics:
    - `APP_LOCALE_PATH`, `CURRENT_LOCALE`, `LOCALE_REQUEST_PARAMETER`
- `globals.config.php` defines `GLOBAL_*` constants used by `{GLOBAL:...}` placeholders.
- Keep naming conventions stable (`GLOBAL_` prefix, locale file conventions) because `View`/`Controller` localization
  depends on them.

### Operational Guidance For Core Edits

- If a framework change introduces new required constants, document and wire defaults in `config/*.php`.
- Prefer additive constants over renaming/removing existing ones.
- Avoid hardcoding values in framework classes when equivalent config constants already exist.
- Keep `application.config.template.php` synchronized when application-level constants change.

## Routing And Dispatch Rules

- URL conversion is convention-based:
    - controller path uses snake_case URL segments mapped to PascalCase class names
    - method path uses snake_case mapped to camelCase
- Dispatcher invokes only public methods and blocks access to `__construct`.
- Method parameter count must match URL parameter count.
- Child controllers/components are not directly invocable from URL.
- Respect subsystem resolution logic from `Loader::getCurrentSubSystem(...)`.

## Controller Lifecycle Rules

- `autorun()` executes for main controller invocation (controller URL without method).
- `render()` pipeline is: View parse -> localization -> globalization -> optional compression.
- Use `bindController(...)` for HMVC/controller composition and keep root/child behavior intact.
- Use `bindComponent(...)` for framework components with component placeholder naming conventions.
- Preserve observer/getState behavior (`setAsObserver`, `getState`) when modifying dynamic refresh logic.

## View Engine Rules

- Keep placeholder syntax `{VarName}` and block syntax `<!-- BEGIN Name --> ... <!-- END Name -->` unchanged.
- Preserve current block lifecycle semantics (`openBlock`, `parseCurrentBlock`, `setBlock`, `closeCurrentBlock`).
- Do not silently ignore missing placeholders/blocks where framework currently throws exceptions.
- Keep template path depth behavior (`TEMPLATE_PATH`) and custom template loading conventions.
- For sanitization changes, preserve compatibility with `xssCleanString(...)` behavior and configuration flags.

## Model And Data Access Rules

- `Model` is a DB-connected base class; constructor side effects (connection + `autorun`) are framework behavior.
- Keep SQL/resultset flow consistent (`sql`, `updateResultSet`, `resultSet`).
- Preserve MySQL helper behavior in `MySqlRecord` and adapter style in `BeanAdapter`.
- Bean interoperability must keep `Bean` interface contract stable (`select/insert/update/delete/...`).
- In `MySqlRecord::parseValue(...)`, preserve strict NULL handling for numeric fields: `NULL`/empty input must remain
  SQL `NULL` (especially for PK auto-increment), while `0` must remain `0`.

## REST Service Rules

- REST endpoint exposure is explicit through `allowMethod(...)` + `__call(...)`.
- Preserve request-method switching behavior (`GET/POST/PUT/DELETE` handlers).
- Keep response envelope shape stable unless explicitly requested.
- Keep CORS/auth/RBAC restrictions behavior compatible with existing `RestService` semantics.

## Record Component Rules

- `Record` expects a BeanAdapter-compatible model and manages add/update/delete/close/reset actions.
- Keep CSRF token field flow and validation behavior compatible.
- Respect current edit/add mode switching based on registered PK URL parameters.
- Preserve redirect hooks (`redirectAfterAdd/Update/Delete/Close`) and disallow action behavior.

## TreeStructure Component Rules

- Preserve expected input node fields and setter-based field remapping behavior.
- Keep generated markup contract compatible with existing component template placeholders/blocks.
- Keep CSS/JS injection helpers behavior stable unless explicitly requested to redesign it.

## Test And Validation Guidance

- When changing core behavior, check existing tests in `tests/framework/` first and keep aligned semantics.
- Prefer adding/updating focused tests for any behavior change in Dispatcher, Controller, View, Model, or components.

## Wiki References (md)

When working on framework core logic, consult these wiki pages in `md/`:

- Core architecture and MVC boundaries:
    - `md/Understanding-WebMVC.md`
    - `md/Software-decomposition-and-System-Architecture.md`
- Controllers, OOP patterns, and lifecycle:
    - `md/Controller.md`
    - `md/Controller-and-OOP.md`
    - `md/Controller-autorun-method.md`
- Views, placeholders, blocks, and dynamic content:
    - `md/View.md`
    - `md/Handling-placeholders.md`
    - `md/Handling-blocks.md`
    - `md/Nesting-of-blocks.md`
    - `md/Dynamic-Content.md`
    - `md/Hiding-and-replacing-the-content-of-a-block.md`
- HMVC/composed pages and decomposition:
    - `md/Content-based-decomposition-and-HMVC.md`
    - `md/Role-Based-Decomposition.md`
- Model and database behavior:
    - `md/Model.md`
    - `md/Interacting-with-MySQL.md`
    - `md/MySQL-ORM.md`
- Components:
    - `md/Using-Components.md`
    - `md/Component-Based-Development.md`
    - `md/DataRepeater.md`
- HTTP method semantics:
    - `md/Handling-of-HTTP-Request-Methods.md`
- Security and access control:
    - `md/Security.md`
    - `md/RBAC.md`
