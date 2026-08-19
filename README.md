# WebMVCFramework

**WebMVCFramework** is a lightweight PHP application kernel for building maintainable database-driven web applications without adopting a large, opinionated full-stack framework.

> **Think of it as an Application Kernel, not as an ecosystem.**
>
> It provides the small set of infrastructure services that almost every business web application needs, while leaving the application itself in plain PHP, HTML, SQL and JavaScript.

[![PHP](https://img.shields.io/badge/PHP-%3E%3D5.6-777bb4.svg)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

Repository: https://github.com/rcarvello/webmvcframework

---

## Why an Application Kernel?

Modern web development often leads to a large stack of frameworks, build systems, abstractions and dependencies before any business functionality is implemented.

WebMVCFramework takes a different approach:

- **PHP remains PHP.**
- **HTML remains HTML.**
- **SQL remains SQL.**
- **JavaScript remains JavaScript.**
- The kernel supplies the repetitive infrastructure around them.

The goal is not to reproduce every capability of a large framework. The goal is to establish a **stable application foundation** with predictable conventions and a small conceptual footprint.

This makes the framework particularly suitable for:

- business and administrative applications;
- CRUD-heavy applications backed by MySQL;
- internal enterprise applications;
- custom CRM/ERP-style systems;
- applications maintained for many years;
- projects where developers want direct control of PHP, SQL, HTML and JavaScript;
- applications developed with AI-assisted coding, where a small and explicit codebase is easier to understand and modify safely.

## What the Kernel Provides

WebMVCFramework concentrates on the infrastructure that is useful across many applications.

### Application structure and MVC

- convention-over-configuration routing;
- Controller / View / Model separation;
- content-oriented decomposition and HMVC-style composition;
- reusable components;
- predictable application directory conventions.

### Routing and dispatching

URLs are mapped to controllers and methods using conventions rather than extensive route configuration.

For example, URL segments are translated into controller and method names according to the framework conventions. This keeps routing visible in the filesystem and source code instead of hiding it in a large configuration layer.

### Lightweight template engine

The view layer deliberately uses **HTML-oriented templates** rather than introducing a programming language inside the templates.

It provides:

- placeholders such as `{Name}`;
- reusable blocks using HTML comments;
- nested blocks;
- localization/global placeholders;
- dynamic content rendering.

The template engine is intentionally simple: application logic stays in PHP, while templates remain recognizable HTML.

### Database access and MySQL ORM

The framework is designed around MySQL and provides a database model layer with automatic mapping between database structures and application models.

It includes support for:

- MySQL access through native PHP extensions;
- model-based data access;
- CRUD operations;
- result sets;
- Bean/Record abstractions;
- automatic database-oriented model behavior;
- reusable data components.

The intention is **not to hide SQL completely**. SQL remains available whenever a query is more appropriate than an abstraction.

### Security

The kernel includes infrastructure for common web application security requirements, including:

- authentication support;
- authorization;
- RBAC (Role-Based Access Control);
- CSRF protection for supported form workflows;
- session and cookie security configuration;
- XSS protection and optional HTML sanitization;
- password/security-related application configuration.

Security-sensitive behavior is centralized so that applications do not need to reinvent the same mechanisms for every project.

### Internationalization

The framework provides a localization mechanism based on application locale resources and framework conventions.

This allows applications to keep translations outside controllers and templates while preserving a simple rendering model.

### REST support

A lightweight REST service layer is available for applications that need HTTP APIs without introducing a separate backend framework.

The application can expose explicit methods for HTTP verbs such as:

- GET
- POST
- PUT
- DELETE

The same application architecture can therefore serve both HTML pages and REST endpoints where appropriate.

### Components

Reusable components can encapsulate recurring UI/application behaviors such as records, data presentation and hierarchical structures.

Components are designed to remain part of the application architecture rather than becoming an independent framework ecosystem.

---

## The Design Philosophy

WebMVCFramework follows a few deliberately conservative principles.

### 1. Convention over configuration

If something can be determined reliably from the application structure, it should not require another configuration file.

### 2. Explicit over magical

The framework should reduce boilerplate, not hide the application.

A developer should be able to open a controller, model, template or SQL query and understand what the application is doing.

### 3. HTML-first views

Templates should be readable by a web developer without learning a second programming language.

Business logic belongs in PHP, not in a template DSL.

### 4. SQL remains a first-class citizen

An ORM is useful for repetitive CRUD operations, but complex SQL should not be forced through an abstraction merely for the sake of abstraction.

### 5. Native web technologies remain valuable

The kernel does not require a large JavaScript application framework. It can be used with:

- Vanilla JavaScript;
- modern browser APIs;
- Bootstrap;
- HTMX;
- jQuery where an existing application requires it;
- any other frontend library when it genuinely adds value.

This makes it possible to build modern interfaces while keeping the server-side architecture small.

### 6. Long-term maintainability

A business application can remain useful for 5, 10 or more years. The architecture should therefore minimize unnecessary dependencies and avoid coupling the application to a rapidly changing frontend/backend ecosystem.

The kernel provides infrastructure; the application owns the business logic.

---

## Application Kernel vs. Full-Stack Framework

WebMVCFramework is intentionally **smaller in scope** than frameworks such as Laravel or Symfony.

That is a feature, not a missing capability.

| Concern | WebMVCFramework approach |
|---|---|
| Routing | Convention-based |
| Controllers | Plain PHP classes |
| Views | HTML-oriented templates |
| ORM | Lightweight, MySQL-oriented |
| SQL | Always available |
| Authentication | Built-in application infrastructure |
| Authorization | RBAC |
| REST | Lightweight native layer |
| Frontend | No mandatory SPA framework |
| JavaScript | Vanilla JS / HTMX / Bootstrap compatible |
| Build system | Optional, not the center of the architecture |
| Dependencies | Kept deliberately limited |
| Business logic | Owned by the application |
| Architecture | Application-centric |

The objective is to avoid the situation where a simple CRUD or business application requires a chain of frameworks simply to render a form, read a database record and return HTML.

---

## A Modern Lightweight Stack

WebMVCFramework fits particularly well with a stack such as:

```text
Browser
   |
   | HTML / HTMX / Fetch / Vanilla JS
   v
Bootstrap (optional)
   |
   v
WebMVCFramework Application Kernel
   |
   +-- Controllers
   +-- Models / ORM
   +-- Views / HTML templates
   +-- Components
   +-- Authentication / RBAC
   +-- REST
   +-- Localization
   |
   v
MySQL
```

This architecture is deliberately server-centric and can avoid the complexity of maintaining a separate SPA frontend and API backend when the application does not actually need them.

For many business applications, **HTML + HTTP + PHP + MySQL + a small amount of JavaScript** is still an extremely capable architecture.

---

## Suitable Frontend Technologies

The kernel does not prescribe a frontend framework.

A typical application can use:

```text
HTML
CSS
Bootstrap
Vanilla JavaScript
HTMX
Fetch API
Web Components
```

Use whichever browser technology solves the problem with the least complexity.

For example, HTMX can progressively enhance server-rendered pages without turning the application into a JavaScript-heavy SPA.

---

## Project Structure

A typical application follows the framework's conventions and separates application code from the framework core.

The repository contains the main framework areas including:

```text
config/
controllers/
framework/
models/
views/
templates/
components/
tests/
md/
```

The exact application structure can evolve, but the important principle is that the **framework supplies the kernel and the application supplies the domain**.

---

## Getting Started

Clone the repository and install its dependencies with Composer:

```bash
git clone https://github.com/rcarvello/webmvcframework.git
cd webmvcframework
composer install
```

Configure the application using the files under `config/`, in particular the application and framework configuration files.

The repository also contains development tooling and PHPUnit integration for supported PHP versions.

### Development server

The Composer configuration provides a development command:

```bash
composer dev
```

### Tests

When running on a supported PHP version with PHPUnit installed:

```bash
composer test
```

> **Compatibility note:** the package declares PHP `>=5.6` for its runtime dependency contract, while the current development/test tooling includes PHPUnit versions that require modern PHP. For new applications, use a currently supported PHP release.

---

## Documentation

The repository contains detailed Markdown documentation under `md/`, covering topics such as:

- WebMVC architecture;
- controllers and lifecycle;
- views and templates;
- placeholders and blocks;
- HMVC/content decomposition;
- models and MySQL;
- ORM behavior;
- components;
- HTTP methods;
- security;
- RBAC.

These documents are intended not only as tutorials but also as **architecture documentation for long-lived applications**.

---

## AI-Assisted Development

A lightweight and explicit architecture is particularly well suited to modern AI-assisted development.

An AI coding assistant can reason about a project more reliably when:

- conventions are stable;
- business logic is visible in ordinary PHP classes;
- templates are ordinary HTML;
- database structure is explicit;
- dependencies are limited;
- framework behavior is documented in Markdown;
- the application does not depend on a large chain of implicit framework services.

WebMVCFramework therefore works well as a **human-readable application kernel for AI-assisted coding**: the AI can generate controllers, models, views, SQL and JavaScript while the kernel provides the stable architectural rules those artifacts must follow.

The goal is not to make the framework AI-specific. The goal is to make the architecture **simple enough that both humans and AI tools can understand it**.

---

## When You Should Use It

WebMVCFramework is a good fit when you want:

- a conventional MVC architecture without a large ecosystem;
- PHP and MySQL as the core platform;
- direct access to SQL;
- server-rendered HTML;
- optional HTMX/Vanilla JS/Bootstrap enhancement;
- integrated authentication and RBAC infrastructure;
- a lightweight ORM/data layer;
- a codebase that remains understandable without learning a large framework first;
- low dependency and low architectural overhead;
- long-term ownership of the application code.

It is less appropriate when your project specifically requires the ecosystem, integrations or conventions of a large full-stack framework.

---

## Core Principle

> **Do not build a framework to develop an application. Build an application on top of a small, stable kernel.**

WebMVCFramework is intended to provide exactly that kernel: enough infrastructure to avoid reinventing the basics, but not so much abstraction that the framework becomes the application.

---

## License

WebMVCFramework is released under the MIT license. See `config/License.txt` for the repository license text.

---

## Author

**Rosario Carvello**

GitHub: https://github.com/rcarvello
