![alt tag](https://raw.githubusercontent.com/rcarvello/webmvcframework/master/docs/webmvclogo.png)
<sup>Supported PHP versions from 5.3 to 8.3</sup>
>[![trophy](https://github-profile-trophy.vercel.app/?username=rcarvello)](https://github.com/ryo-ma/github-profile-trophy)
>
> 
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=rcarvello_webmvcframework&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=rcarvello_webmvcframework)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=rcarvello_webmvcframework&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=rcarvello_webmvcframework)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=rcarvello_webmvcframework&metric=bugs)](https://sonarcloud.io/summary/new_code?id=rcarvello_webmvcframework)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=rcarvello_webmvcframework&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=rcarvello_webmvcframework)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=rcarvello_webmvcframework&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=rcarvello_webmvcframework)

# PHP WEB MVC Framework 
The package **webmvcframework**, with the acronym of **WebMVC**, is an **object oriented** PHP framework designed using **MVC architectural  pattern** for building web-based MySQL applications.

It is an open-source web framework that is business-oriented and purposely written for programmer happiness and sustainable productivity. It lets you write beautiful code by favoring the Convention over the Configuration paradigm. The result is a web framework that allows you to transition from idea to implementation quickly.

It offers to developers a complete set of functionalities for rapid development of data-intensive web applications. Generally, it provides services for system decomposition that developers can do at different levels when they coding a complex web application. Firstly it provides the classes to achieve the Model, View, Controller decomposition and also to divide PHP code from HTML during the GUI designing. However, this is not the only feature provided by the Framework for acting on the application's decomposition.

The **Component Based Development**, which was used for building many framework’s features, permits to developers to apply another level of software decomposition and reuse. Framework’s components, in fact, realize **recurrent aspects** of web applications. Many of these aspects are regarding MySQL, e.g. data listing, data listing and sorting, data listing and filtering, data listing and pagination, record management and the common table’s operations of select, insert, delete and update. 

> WebMVC offers a set of pre-built components for implementing the necessary server logic for frequently database management operations. Each component is itself designed with an MVC architecture and is equipped by a Controller, Model, View, and HTML Template.
> Components are easy to use and developers can aggregate them into a root controller by using composition criteria when building complex web pages.
> The component GUI can also easily updated or replaced to reflect the graphics experience, simply by editing or replacing the component HTML template. The component internal logic will remain fully reusable without the need for any source code modifications.

## Thanks
Many and many thanks to   

![https://www.jetbrains.com](https://raw.githubusercontent.com/rcarvello/webmvcframework/master/docs/jetbrains.png)  
for granting me an open source license of magic   
   
![https://www.jetbrains.com/phpstorm/](https://raw.githubusercontent.com/rcarvello/webmvcframework/master/docs/phpstorm.png)   **PHPStorm**       
    
that I used in the development of PHP Web MVC Framework.   

## How to install
To install the framework download and copy it into an Apache web folder. Then go to the **config directory** and modify **application.config.php** according to your MySQL server configuration and Apache web folder you want to use for your application.
By default framework provides a small set  of examples. For using them run the provided SQL script into the **sql** folder.
In a future time, I will provide you with more examples illustrating its functionalities.

### Using composer

To create a new PHP Web MVC project into a given project folder open a terminal session and run:

```
composer create-project rcarvello/webmvcframework PROJECT-FOLDER
```

## How to autogenerate PHP Model classes from your MySQL database
The util directory contains a file named **app_create_beans.php**.
Run it from your browser or from command line for executing ORM classes code auto generation regarding tables of a given MySQL database.

Warning !
Before running it you must configure MySQL access parameters by modifying **util\mysqlreflection\mysqlreflection.config.php** according to your MySQL configuration.
After running the utility you will find the autogenerated PHP classes into the **models\beans directory**.

## Documentation

###  WebMVC official wiki
You can start reading the wiki from [here](https://github.com/rcarvello/webmvcframework/wiki)

### Other information
You can dowload some PDFs, PPTs, and diagrams from [here](https://github.com/rcarvello/webmvcframework/tree/master/docs)

### Video Tutorial
An introduction to PHP WebMVC Framework   

[![IMAGE Video Tutorial](https://i.ytimg.com/vi/7zJFXLd4rk8/hqdefault.jpg?custom=true&w=196&h=220&stc=true&jpg444=true&jpgq=90&sp=67&sigh=5Dym90YTR05kyX82Kg8gW9VseUk)](https://www.youtube.com/watch?v=7zJFXLd4rk8&t=37s)

## Diagrams

### Main classes
![alt tag](https://raw.githubusercontent.com/rcarvello/webmvcframework/master/docs/framework.png)

### Handling HTTP requests - Loading and dispatching controllers
![alt tag](https://raw.githubusercontent.com/rcarvello/webmvcframework/master/docs/Dispatch%20and%20Create%20MVC%20Instance.png)


![alt tag](https://raw.githubusercontent.com/rcarvello/webmvcframework/master/docs/wiki_resource/WebMVCRequestHandling.png)

The flow description is the following;
1. An incoming HTTP request is delivered to the Web MVC Dispatcher 
2. The Dispatcher automatically recognizes in the HTTP request a call for a Controller execution. Then it uses the Loader to load the appropriate Controller class.
3. The Loader imports Controller class and all its dependencies
4. The Dispatcher is now enabled to instantiate the appropriate Controller
   * 4b...z Its also possible that the Controller aggregates and manages the execution of one or more controllers. This is a feature of WebMVC known as "Hierarchical MVC". We will discuss it later,  in this [section](https://github.com/rcarvello/webmvcframework/wiki/Content-based-decomposition)
5. The Controller uses and runs the Model
   * 5b Model connects to MySQL to retrieve or store data
6. The Controller uses and runs the View
   * 6b The View reads the static design of the web page from an HTML Template. The static design of the Template will be used by the View for generating the dynamic web page also by using data provided by the Model.
7. The Controller, after loading and processing the Model and View, is enabled to provide back to the Dispatcher the output that was dynamically produced.
8. Finally, the Dispatcher sends back the output as an HTTP response

