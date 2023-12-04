## Introduction

We are now introducing the concrete class `frameworks\View.php` which is the WebMVC entity that provides you all the
necessary methods to interact with the HTML pages. You will learn to use it as an object instance or, when occurring the
need to produce complex and dynamic web pages, by extending it with custom classes designed for your needs.

## Using the View

In MVC Design pattern the View layer has the prior responsibility to manage and show data in graphical structures like
HTML page. With WebMVC, this responsibility is managed by a View that operates together with a Template file containing
the HTML static design. To use a View you must:

* Creating a custom Template file containing the static HTML design of the page you want to be shown
* Using the concrete framework\View class provided by WebMVC to create a View object for managing the custom template
* Creating a custom Controller to handle the View object

So, when you having the need to show an HTML page rather than a simple message (like we made with the EchoController)
you must create a template file containing the HTML. Later you also need to manage the template by creating an object of
the concrete class  "frameworks\View.php".
You also need to build a controller in a way to enabling the execution of the view object previously introduced to
produce the output. This because the controller is the only MVC entity that you are able to instantiate and run (by
typing an HTTP request).

Pratically:

Create the template `templates\home.html.tpl` containing the HTML of the web page:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Site home page</title>
</head>
<body>
<p>Welcome to the site Home Page</p>
</body>
</html>
```

Then create the Hello controller `controllers\Home.php` as follow (pay attention to the comments):

```php
namespace controllers;

use framework\Controller;
use framework\View;

class Home extends Controller
{
    /**
     * Home constructor.
     * @override framework\Controller __construct()
     */
    public function __construct()
    {
        /**
         * A reference to the file: templates/home.html.tpl
         * @note Do not to specify the file extension ".html.tpl".
         */
        $tplName = "home";


        /**
         * Set the view with a new object of type framework\View. 
         * @note: We create the View object by using the template reference.
         */
        $this->view = new View($tplName);

        /**
         *  To starting up the standard WebMVC behavior of acting
         *  cooperation between Controller and the View just
         *  invoke the parent constructor by passing the current view  
         */

        parent::__construct($this->view);
    }
    
}
```

The following figure shows the WebMVC directory tree with files location:

![WebMVC Files](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/view_tree._01.png)

Finally, run the controller by typing the following address into your web browser:

`http://localhost/home`

You should see the page:

![Home page](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/home_web_pge_01.png)

## Explanation: Controller, View and Template cooperation

We create an HTML static content into a file and save it in the directory _templates_. The file must have a .tpl
extension in order to be accepted by WebMVC. Note that the template file must be written only by using client-side
technologies like _HTML_, _JavaScript_ or _CSS_ programming languages. This is a constraint specially designed in WebMVC
to avoid mixing between server-side, like PHP, and client-side technologies within a single source code file.    
Then, in order to manage and render out the static HTML design of  `templates\home.html.tpl`, WebMVC let you use the
concrete framework\View class by creating an object of this type. By convention, we specified the template name in
lowercase (
see [naming convention](https://github.com/rcarvello/webmvcframework/wiki/Understanding-WebMVC#naming-convention)
specifications we previously discussed).
Finally, as shown in the code, you can automatically use the view object inside `controllers\Home.php` by overriding
the __construct of the abstract `framework\Controller`. This practice gives you the ability to automatically produce the
output simply by instantiating form HTTP the controller without the need of invoking any of its methods.

## Insights: Best practices of using OOP and autorun for extending the GUI design

The purpose of this section is to give you another example regarding the advantages deriving from using OOP and autorun.
Supposing we want to have a "Bootstrap" mobile version of the previous page. We can do this job simply by extending
the `controllers\Home.php` by creating `controllers\HomeBootstrap.php` in which we quickly hook the `autorun` by loading
a different GUI template appositely designed for mobile devices.     
See the code below:

```php
namespace controllers;

use controllers\Home;

class HomeBootstrap extends Home
{
    /**
     * @override autorun($parameters = null)
     */
    protected function autorun($parameters = null)
    {
        /**
         * Replaces the GUI template of the parent with a Bootstrap 
         * mobile template coded into templates/home.bootstrap.html.tpl
         * We used loadCustomTemplate method provided by framework\View
         */
        $this->view->loadCustomTemplate("templates/home.bootstrap");
    }
}
```

Now we use Bootstrap for the mobile template of GUI. Note that it is ineffective on the server-side code developed so
far thanks to the features of WebMVC that isolate client-side technologies in external template files

```html
<!DOCTYPE html>
<html>
<head>
    <title>Site Home Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap core CSS -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" 
          rel="stylesheet" media="screen"
    >
</head>
<body>
<div class="jumbotron text-center">
    <h1>Welcome to the site Home Page</h1>
</div>
<!-- Bootstrap and jQuery core JS -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
```

Now run by typing:

`http://localhost/home_bootstrap`

You should see the bootstrap mobile version of the homepage

![Home page](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/home_web_pge_02.png)

## Summary

This example shows you how WebMVC, by separating GUI Design, View and Controller and by managing their cooperation
realizes an efficient implementation of the "Separation of Concern". We will
discuss [here](https://github.com/rcarvello/webmvcframework/wiki/Skills-and-technologies-decomposition) in depth about
this benefit. Right now consider only the advantage deriving from avoid to mix programming languages into a single
source code when you need to show the **static content** of a web page rather than simple string messages.   
We also focused on how OOP and even more the controller autorun behavior give you effective ways to specialize your
code.
The figure below shows the View usage

![View](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/request-handling-view.png)

## Whats next

In the next example, we expose how to
manage [dynamic content](https://github.com/rcarvello/webmvcframework/wiki/Dynamic-content). For dynamic content, we
define a content inside a web page that is evaluated and generated at runtime, rather than static content we can design
at development time inside a template. For this purpose, we can adopt a better practice to using and instantiating the
View.