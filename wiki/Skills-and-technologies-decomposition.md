## Introduction

The architecture of WebMVC is designed by following the Separation of Concerns (SOC) design principle.
In the next section, we discuss the advantages deriving from SOC as well as by focusing on all possible organizational
benefits due to the technologies separation provided by the framework.

## SOC advantages

In general, SOC is a design principle for separating a computer program into distinct sections, such that each section
addresses a separate concern. A concern is a set of information that affects the code of a computer program. A concern
can be as general as the details of the hardware the code is being optimized for or as specific as the name of a class
to instantiate. MVC, which is a SOC implementation, is a software architectural pattern for user interfaces that divides
an application into three interconnected parts. This is done to separate internal representations of information (Model)
from the ways information is managed (Controller) and then presented (View) to, and accepted from, the user.
> The value of separation of concerns is simplifying development and maintenance of computer programs. When concerns are
> well-separated, individual sections can be reused, as well as developed and updated independently. Of special value is
> the ability to later improve or modify one section of code without having to know the details of other sections, and
> without having to make corresponding changes to those sections.

## Organizational benefits

In general, organizational benefits usually derive from a better organization of work through specialization and
coordination. Specialization concerns the division of a work into smaller parts and their assignment to specialized
workers.
This is a standard practice in modern software development methodologies where the work can proceed in parallel in
relatively little increments assigned to software developers and testing activities can be pursued as soon as possible.
However, the specialization that comes from the division of work also requires coordination because what has been broken
by specialization (subsystem decomposition) has to be reconducted to unity by coordination (system integration).

## Effective advantages with WebMVC

The advantages deriving from the division of work are possible when we decide to use the MVC architectural pattern
provided by WebMVC. Furthermore, **the technologies used in each MVC layer are homogeneous (e.g. HTML and Javascript for
the Template, PHP for the View and Controller, and PHP with SQL for the Model part). The code reflects the separation of
the professional skills necessary to deal with the various aspects of development** as shown in the following table. The
code is easier to design, implement, verify and maintain, and you can use pre-existing code where appropriate (e.g. by
using a pre-built website template). The same information can be presented in several ways (e.g. textual/graphics) and
on different devices. Note that the Controller assumes the role of coordinator of View and Model and this easy the
system integration activity necessary to build a software system perceived as a unity.

Table  _Separation of skills and technologies for the development of Web MVC applications_.

![SOC Matrix](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/mvc_soc_sot_sor_matrix.png)

With WebMVC, the usage of different types of programming languages is broken down amongst the Model, View, Template, and
Controller in order to avoid mixing them within a single code file.

![Programming languages](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/programming-languages.png)

## Whats next

In the next sections we speak about an important feature of WebMVC that emphasizes the separation of
concerns: [Component Based Development]()