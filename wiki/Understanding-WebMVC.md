## Introduction

This section provides you with a high-level overview of **Model**, **View**, and **Controller** of WebMVC and how it
works to generate web pages.
After reading this introduction, you should understand how the different parts of a WebMVC application are physically
and logically organized and how they work together. You should also understand how the architecture of a WebMVC
application differs from a standard PHP application.

## Basic organization of a WebMVC application

Building a WebMVC application requires you to put your custom code into four **special sub-folders** of the server
application root folder: **models**, **views**, **templates**, and **controllers**. As you might guess from the folder
names, these folders physically organize the classes for implementing models, views, and controllers. In addition to
structuring the physical organization of files, these folders also represent the logical organization of **Namespaces**
in which each class will be encapsulated.    
About the templates folder, the only thing you must know is that it will contain the HTML code that will be used by
WebMVC PHP classes to generate the dynamic page of your application. The figure below shows the tree structure for
folders:

![WebMVC Folders Structure](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/WebMVCFolders.png)

## Load and Dispatch by "Convention over Configuration"

When you build a traditional PHP application, there is a one-to-one correspondence between a URL and a PHP page. If you
make an HTTP request like `http://server/home.php` from the server, then there had better be a page on disk
named `home.php`. If the `home.php` file does not exist, you get an ugly 404 - Page Not Found error.

When building a WebMVC application, in contrast, there is no correspondence between the URL that you type into your
browser's address bar and the files that you find in your application.
_**In a WebMVC application, a URL corresponds to a controller action instead of a page on disk**_.

> In a traditional PHP application, browser requests are mapped into pages. In a WebMVC application, in contrast,
> browser requests are mapped to controller actions. A PHP application is content-centric. A _**WebMVC application**_, in
> contrast, _**is application logic centric**_.

In WebMVC any browser request gets mapped to a controller action through a feature called **_Loading_** and *
*_Dispatching_**. This feature is built on architectural design named "_Convention over Configuration_" to automatically
handle incoming HTTP requests and routes them to the corresponding controller actions. We will give you later more
technical details about this feature in [Controller Page](https://github.com/rcarvello/webmvcframework/wiki/Controller),

## <a href="Understanding-Controller"></a>Understanding Controller

A Controller is responsible for controlling the way that a user interacts with a WebMVC application. A controller
contains the flow control logic for an application. A controller determines what response to send back to a user when a
user makes a browser request.    
Technically speaking a controller is just a concrete class of the abstract `framework\Controller` class. When you write
a controller class it must be saved under the `controllers` folder of your web application to allow its instantiation.

## Understanding View and Template

The View has the responsibility to organize and show data in graphical structures.   
The development of a View in the web environment, unlike what happened for desktop applications, involves the use of
different programming languages: some server-side, like PHP, and other client-side, like HTML, CSS, and JavaScript. In
WebMVC these differences are used respectively by involving two distinct entities rather than just one as was expected
by the MVC pattern, originally designed for desktop applications. These entities are the `framework\View` concrete class
of the framework, and a common static HTML file, the _Template_ that will contain the GUI design. Custom views and
templates must respectively reside into **views** and **templates** folders. Separating HTML design contained into a
template from the class View offers considerable advantages on several sides. We will discuss this in
detail [later](https://github.com/rcarvello/webmvcframework/wiki/Skills-and-technologies-decomposition).

## Understanding Model

The Model handles the state of the application. The state is what your application is about. In WebMVC model is provided
by the `framework\Model` concrete class that has the responsibility for data management of **MySql**. You can use an
instance of this class or extend it with a custom class and save it under **models** folder.  
The framework also provides you with a tool for automatically generating all the Model classes needed to manage all
tables of a given MySQL schema.

## Handling incoming HTTP requests

Now you learned that WebMVC, as a result of an HTTP request, loads and runs a Controller, connected in turn with the
View and with the Model. Below, we show a flow diagram to illustrate you the interaction of all these entities:

![WebMVCRequestHandling](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/WebMVCRequestHandling.png)

The flow description is the following;

1. An incoming HTTP request is delivered to the Web MVC Dispatcher
2. The Dispatcher automatically recognizes in the HTTP request a call for a Controller execution. Then it uses the
   Loader to load the appropriate Controller class.
3. The Loader imports Controller class and all its dependencies
4. The Dispatcher is now enabled to instantiate the appropriate Controller
    * 4b...z Its also possible that the Controller aggregates and manages the execution of one or more controllers. This
      is a feature of WebMVC known as "Hierarchical MVC". We will discuss it later, in
      this [section](https://github.com/rcarvello/webmvcframework/wiki/Content-based-decomposition-and-HMVC)
5. The Controller uses and runs the Model
    * 5b Model connects to MySQL to retrieve or store data
6. The Controller uses and runs the View
    * 6b The View reads the static design of the web page from an HTML Template. The static design of the Template will
      be used by the View for generating the dynamic web page also by using data provided by the Model.
7. The Controller, after loading and processing the Model and View, is enabled to provide back to the Dispatcher the
   output that was dynamically produced.
8. Finally, the Dispatcher sends back the output as an HTTP response

## Naming convention

WebMVC requires that **you must mandatorily use PascalCase and camelCase notation for naming, respectively, classes and
methods**. Furthermore is strictly recommended (but optional)  to use a unique name for all MVC parts. For example, if
you are designing the home page of your site, you can use the name "Home" for all classes such as the Controller, View,
Model, and the name 'home' for the Template, You must also use the name 'Home' for many other files, such as language
translation files, which we will show you later. See the following figure:

![Naming convention](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/naming_convention.png)

> From a conceptual point of view, this means that you can specify a unique name that identifies the MVC triad
> cooperation. In this example, we call it _Home_ and it identifies a **WebMVC assembly** that will be generated at
> runtime for the aggregating of the MVC triad and the template.   
> Summarizing, a WebMVC assembly identifies an entity generated at runtime that will provide a primary service (typically
> a web page) and we can identify by a name. Then we can use this name for physically naming the MVC triad and template
> that cooperate together for producing the service. The name of a WebMVC assembly will match the Controller name of the
> triad and will be also used by the framework for providing to you an endpoint you will use for consuming the service.

Although we can use the same name for the different MVC classes triad, the unique identification of a single class name
still will be possible because WebMVC uses the **PHP namespaces** for encapsulating each class; this convention allows
avoiding naming conflicts and the proliferation of names in complex projects. We will provide more details about using
namespaces when they will be used
for [managing subsystems](https://github.com/rcarvello/webmvcframework/wiki/Subsystems#subsystems-and-namespaces) for
decomposing the system.

## Insights WebMVC assembly

Generally, a WebMVC assembly, that inherits its name from Controller (alias root Controller), can furthermore aggregate
together many more parts, rather than only its related Controller, Model View, and Template. In fact, it can assemble,
into a hierarchical structure, many more parts like nested MVC triad and/or Components. All those nested elements may be
also considered as child MVC assemblies. We will give you more technical details later about the hierarchy of MVC
assemblies when
introducing [Content Decomposition](https://github.com/rcarvello/webmvcframework/wiki/Content-based-decomposition-and-HMVC)
and [Components](#).

By looking at the figure above, in which we used a WebMVC Assembly name '_Home_', see the positioning of the `Home.php`
classes for the Controller, View, Model in the directory hierarchy of WebMVC. Also, see how we have been using the
name '_home_' for the template `home.html.tpl` by putting it under the '_templates_' folder. By convention, we used
the "_**snake_case** notation_" (by specifying the name using lowercase) for naming those files, like template ones,
that doesn't contain any classes.
Don't forget that, at the occurrence of composite words in the WebMVC assembly name, snake_case notation uses an
underscore for separating words, eg. 'hello_world.html.tpl' for naming a Template related to a WebMVC assembly having
the name HelloWorld. The file extension ".html.tpl" is mandatory when naming a Template.    
Finally, we can use the endpoint `http:/server/home` for running the controller `controllers\Home`, or better for
consuming the service provided by the `Home` WebMVC assembly. The name of the callable endpoint will be automatically
provided to you by the framework. It will be represented in snake_notation and it will match exactly the Assembly name.

Note that the convention we discussed so far, of using a single name for all the main parts of MVC assembly, is not
mandatory. If you prefer you can also decide to name classes and templates by using the traditional suffixes,
eg. `HomeController.php`, `HomeModel.php`, `HomeView.php` and `home_template.html.tpl`

## Summary

We exposed the basic concepts you need to understand before using WebMVC framework for developing an application.
They are:

- The roles of models, views, controllers (MVC) classes and of templates.
- Files organization by using special folders: models, views, controllers, and templates for storing MVC classes and
  HTML templates.
- PascalCase notation for naming classes
- camelCase notation for naming their methods
- snake_case notation for naming templates
- snake_case notation for typing the endpoint (URL requests) and running controllers
- At runtime MVC triad and template are managed in the form of an assembly. We can identify it with a name for using
  when naming files.

So you simply:

- Code your MVC classes and the GUI HTML template.
- Use PascalCase, camelCase notations when coding/saving classes and snake_case notation when saving the template.
- We strongly suggest to you to identify WebMVC assembly name representing the service produced by the MVC triad and
  using it when naming files.
- Store all files into their respective folders
- Tu execute a Controller (or better to consume the service produced by the WebMVC assembly) type its name (endpoint)
  from the web browser by using the snake_case notation for the URL request.

## What's next

After the explanation of the main architecture of WebMVC, and by understanding its basic structure we are now ready to
start coding its first entity: the [Controller](https://github.com/rcarvello/webmvcframework/wiki/Controller).