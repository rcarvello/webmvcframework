## Introduction

Welcome to the **webmvcframework** wiki.   
The package webmvcframework, with the acronym of **WebMVC**, is a powerful object-oriented PHP framework, suitable as a
web design and development tool.   
You can use WebMVC to effectively create small and medium-sized web projects regarding data-intensive web applications,
sites, mobile web apps and web APIs.

## WebMVC concepts

WebMVC defines:

* A set of assumptions, models, and practices constituting a way for building and compounding software application
* A software system that is intended to be instantiated for:
    * defining the architecture for a family of sub-systems and providing the basic building blocks to create them
    * defining the places where adaptations for specific functionality should be made and run

## WebMVC features

Main features:

* Providing a set of functionalities to organize your application using the Model View Controller (MVC) architecture for
  acting the Separation of Concern (SOC) regarding Business, User Interface, and Processing responsibilities
* Let you organize an application in subsystems to cope with the complexity of big projects
* Extending the basic MVC architecture by providing hierarchical and composition capabilities (HMVC) among different
  Controllers. HMVC, by adopting the "divide and impera" paradigm, accelerates the development of complex web pages that
  can be realized through the composition of many smaller and simple MVC sections
* Avoiding the mixing of client-side programming languages, like HTML, CSS, and JavaScript, necessary for building the
  GUI o web application, together with server-side programming languages, needed for implementing the application logic.
  By unmixing those technologies it improves the collaboration process among people having different skills (e.g. GUI,
  PHP and Database designers and developers) needed for building complex projects
* Using only standard web technologies without introducing new ad hoc syntax both in client-side and server-side
  programming languages
* Providing ORM code automatic generation by reversing engineering a given MySQL database schema
* Bundling a set of ready to run and useful software components for implementing some recurring problems in web
  development
* Providing facilities with pre-built and customizable solutions for the rapid development of frequently occurring
  software functionalities in a WEB application like internationalization, SEO URL, authentication, users management and
  role-based access control

## Why WebMVC

The guidelines that led the development process of WebMVC are the need to having a design environment in which many key
principles of software engineering could be easily applied when developing web applications. Particularly:

* **OOP** - Having a simple mechanism for treating web pages like classes, with the capabilities to apply them all the
  fundamental properties of the OOP, such as extension, override, reuse and composition

* **AVOID MIXING OF PROGRAMMING LANGUAGES** - Having, at the same time, the capability for decoupling server-side
  technologies from client-side ones, avoiding mixing them when writing code of classes handling the GUI design

* **DECOMPOSITION** - Having the capability to simultaneously decompose an application and web pages under different
  engineering principles: first of all MVC but also sub-systems, internationalization, page contents, access roles

* **COMPONENT BASED DEVELOPMENT** - Getting a set of reusable, customizable, and useful server-side components, also
  built as MVC parts, for implementing recurring patterns in data-intensive web applications

* **NAMING CONVENTION OVER CONFIGURATION** - Having an OOP-like, simple, and intuitive naming notation to be used for
  the logical representations of MVC classes and sub-systems, their correspondent physical representation into files and
  sub-directories, their usage, as well as for making easy and automatic the object instantiation of Controllers by
  using HTTP requests without the need of manual configurations of routing

* **INTERNATIONALIZATION SUPPORT**
  Disposing of a simple and useful mechanism for applying language translations of a software application

* **TOOLS AIDED FRAMEWORK**
  Providing a set of software tools to facilitate the prototyping and automatic code generation to be used for building
  web pages and interacting with MySQL

## Summary

By putting all these guidelines principles of WebMVC in the order:

* **C**OMPONENT BASED DEVELOPMENT
* **A**VOID MIXING OF PROGRAMMING LANGUAGES
* **N**AMING CONVENTION OVER CONFIGURATION
* **D**ECOMPOSITION
* **O**OP
* **I**NTERNATIONALIZATION SUPPORT
* **T**OOLS AIDED FRAMEWORK

we could imagine using the acronym of "**CAN DO IT**" for indicating the criteria by which a WebMVC application could be
designed and developed.

## Whats next

Follow this wiki to learn and to start using the framework!. Let's start with
the [Setup](https://github.com/rcarvello/webmvcframework/wiki/Setup) of WebMVC
