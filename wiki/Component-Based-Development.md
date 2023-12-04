## Introduction

Components-based development (CBD), is a branch of software engineering that emphasizes the separation of concerns with
respect to the wide-ranging functionality available throughout a given software system. It is a reuse-based approach to
defining, implementing and composing loosely coupled independent components into systems. This practice aims to bring
about an equally wide-ranging degree of benefits in both the short-term and the long-term for the software itself and
for organizations that sponsor such
software. ([from wikipedia](https://en.wikipedia.org/wiki/Component-based_software_engineering))

In [Sommerville](https://en.wikipedia.org/wiki/Ian_Sommerville_(software_engineer)), you can find a discussion about the
benefits of component-based software engineering. The following definition of software component is due
to [Szyperski](https://books.google.it/books?id=KrMOioC9NAUC&printsec=frontcover&dq=inauthor:%22Clemens+Szyperski%22&hl=it&sa=X&ved=0ahUKEwid-6n5kLPpAhXPwMQBHWlmB8MQ6AEIQDAC#v=onepage&q&f=false):

> “_A software component is a **Unit** of composition with contractually-specified interfaces and explicit context
dependencies only. A software component can be deployed independently and is subject to composition by third parties._”

A widely used definition is due to UML:

> “A modular part of a system, that encapsulates its content and whose manifestation is replaceable within its
> environment. A component defines its behavior in terms of provided and required interfaces".
<p align="center">
<img src="https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/umlcomponent.png">
</p>

A component may be replaced by another if and only if their provided and required interfaces are identical. This idea is
the underpinning for the plug-and-play capability of component-based systems and promotes software reuse.

## WebMVC Components: Components designed for the web

For recurring problems occurring during the implementation of data-intensive applications, WebMVC provides software
components that can be reused to easy software development.
Framework’s components, in fact, realize common **Aspects** that can occur, in a similar way, into different
web applications. Many of these aspects are regarding the database, for example, data listing, data listing with
sorting, data listing with filtering, data listing with pagination, record management with common table’s
operations regarding select, insert, delete and update operations. The framework offers a set of pre-built components
for implementing the necessary server logic for these common database management aspects.

You must keep in mind that, unlike a canonical component that implements a reusable behavior, a component designed for
the web must possibly also consider the graphic layout that it will have to expose on the GUI. For this reason, WebMCV
components are equipped with specific functions to manage this need, and there are two major advantages for using them:

1. The first is because each WebMVC component is designed like an MVC Assembly. In fact, it assembles a Controller,
   Model, View, and a Template. So a developer can easily customize its GUI just by updating its Template according to
   the needs of the application. The component internal logic will remain fully reusable without the need for any source
   code modifications.

2. Because components are designed like MVC assemblies, developers can also use and aggregate many of them into one
   parent controller for the purpose of building a complex application page regarding database management. In the
   provided examples you will find a typical DB application
   implemented [here](https://www.webmvcframework.com/examples/db/part_list_manager) (`controllers\examples\db\PartListManager`)
   that uses different components assembled into one root Controller.

## Conclusion

Now you learned about the roles and goals of the components, in
the [this section](https://github.com/rcarvello/webmvcframework/wiki/Using-Components) you will find a detailed
description for all WebMVC components