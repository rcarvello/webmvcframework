## Introduction

You just learned how WebMVC let you decompose an application using subsystems. However, this is not the unique way for
organizing software design in an efficient way.      
For introducing a new approach for decomposing a system, we consider
the [previous example](https://github.com/rcarvello/webmvcframework/wiki/Controller-autorun-method#usage-example-of-autorun),
when we showed you the web page for browsing products of an e-commerce application. We discovered how it can dispose of
different sections of content (such as navigation bar, status bar, and credits information) could be shared with other
pages, such as product detail page, cart and so on.  
So, in addition of applying a decomposition by subsystems, we use for logically organize our e-commerce application (we
can design subsystems such as the store, orders, users and so on), we can also design the content of a web page by
composing it using different and small sections. Also, we could reuse each of these sections when they are shared across
different pages.

## Designing content decomposition

While subsystems provide an efficient way to apply separation of logical application roles, we can use a feature of
WebMVC, named **HMVC** (Hierarchical MVC), to decompose the application from the point of view of its "Content".  
**By assuming that the content of a web page, in WebMVC, is obtained as a result of the execution of Controller, we can
state:**
> A content of a generic web page that can be designed by using nested and smaller sections of content can be generated
> by running nested controllers where each controller is responsible to produce one section of the page content.

HMCV is a built-in feature of WebMVC framework that allows you for nesting Controllers in a very simple way for
producing nested contents inside a web page. The standard assembly of Model, View (with Template), and Controller will
become layered into a "hierarchy of parent-child MVC layers". The image below illustrates how this works:

![HMVC Structure](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/HMVC-structure.png)

Each assembly functions independently from one another. An assembly can request access to another WebMVC assembly via
their controllers. Both of these points allow the application to be distributed over multiple locations if needed. In
addition, the layering of WebMVC assembly allows for a more in-depth and robust application development. This leads to
several advantages:

- <u>M</u>odularization: Reduction of dependencies between the disparate parts of the application.
- <u>O</u>rganization: Having a composition mechanism of WebMVC assemblies lighter workloads.
- <u>R</u>eusability: By nature of the design it is easy to reuse nearly every piece of code.
- <u>E</u>xtendibility: Makes the application more extensible without sacrificing ease of maintenance.

These advantages will allow you to get **M.O.R.E** out of your application with less headaches.

Let's start the e-commerce application design now!   
First of all, we simplify it by assuming we need to develop just the products list, the product detail page and by
sharing among them a simple navigation bar.   
Now, take a look at the following UML diagram we made for representing controller classes relationships:

![HMVC UML Diagram](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/HMVC-01b.png)

Note that, just for simplifying, we are only considering controller classes. Models and Views will have a similar
design.   
The diagram defines:

- Two primary subsystems illustrated using two boundary rectangles: `framework` (obtained from WebMVC)
  and `e-commerce` (we will use it for encapsulating all e-commerce classes). Also, you must remember that subsystems
  must be logically encapsulated by using namespaces (in the figure the names preceding colon)
- Inside the `e-commerce` subsystem, we design two child subsystems: `store` and `common` respectively used for
  encapsulating the store classes and the common classes we need to reuse across the e-commerce application.
- Inside `store` namespace we put `ProductsList `and `ProductDetail` controllers for managing their respective pages
- Inside `common `namespace we put `NavigationBar`controller for managing the content needed for painting a navigation
  bar
- Finally, the diagram shows you the following relationships representing pages composition:
    - `ProductsList` contains a `NavigationBar`. Look at the composition relationship into the UML diagram.
    - `ProductDetails` also contains the previous `NavigationBar`
    - `ProductsList`, `ProductDetail` and `NavigationBar` are controllers extending the base class `Controller` provided
      by WebMC

The file system structure for representing subsystems and classes for controllers is shown in the following figure:

![HMVC UML Diagram](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/HMVC-02-controllers.png)

Note that you can imagine having moreover subsystems: `users`, `sales`and so on.    
As shown in the figure below, Models, Views, and Templates will have a mirror structure:

![HMVC UML Diagram](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/HMVCFS.png)

You already knew that the `Templates` folder will contain the HTML files for GUI.

## Coding content decomposition

In the following section, we code controllers, and templates by omitting views and models because they are not relevant
for this purpose. Let's start by coding first the ProductsList and NavigationBar writing the following files

* Controllers:
    * `controllers\ecommerce\store\ProductsList.php`
    * `controllers\ecommerce\common\NavigationBar.php`
* Templates:
    * `templates\ecommerce\store\products_list.html.tpl`
    * `templates\ecommerce\common\navigation_bar.html.tpl`

The ProductsList controller:

```php
/**
 * Class ProductsList
 *
 */
namespace controllers\ecommerce\store;

use framework\Controller;
use framework\Model;
use framework\View;
use controllers\ecommerce\common\NavigationBar as NavigationBar;


class ProductsList extends Controller
{
    protected $view;
    protected $model;

    /**
    * Object constructor.
    *
    * @param View $view
    * @param Model $mode
    */
    public function __construct(View $view=null, Model $model=null)
    {
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view,$this->model);
    }

    /**
    * Autorun method is automatically executed after object creation.
    * We do the nesting of the navigation bar.
    *
    * @param mixed|null $parameters Parameters to manage
    *
    */
    protected function autorun($parameters = null)
    {
  
        $navigation = new NavigationBar();
        $this->bindController($navigation);
    }

    /**
    * Get the View by using an instance of concrete framework\View class.
    * The instance will use the template containing the GUI design stored into 
    * ecommerce/store/products_list.html.tpl
    */
    public function getView()
    {
        $view = new View("/ecommerce/store/products_list");
        return $view;
    }

    /**
    * Get the Model by using an instance of concrete framework\Model class.
    */
    public function getModel()
    {
        $model = new Model();
        return $model;
    }
}

```

Pay attention to the folowing lines inside the `autorun() method:

```php
       $navigation = new NavigationBar();
       $this->bindController($navigation); 
```

With this two lines of code, we first create an instance of `NavigationBar` (remember we designed the `NavigationBar` as
a child of the root controller `ProducstList`). Secondly, we put the instance inside the `ProductsList` controller
simply by binding it into the GUI of the caller controller (`ProductsList`). The `bind` method also requires a special
placeholder that must be present into the GUI template of `ProducstList` and the placeholder must be also named equal to
the child controller. Look at the following `protucts_list.html.tpl` template we designed for `ProductsList`. You will
find the placeholder we just described named  `{Controller:ecommerce\common\NavigationBar}`:

```html
<!DOCTYPE html>
<html>
<head>
    <title>eCommerce Demo - Products list</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">

</head>
<body>

<div class="container">

    {Controller:ecommerce\common\NavigationBar}

    <h1>This is the products list demo page</h1>
    <hr>
    
    <table id="" class="table table-hover">
        <thead>
            <tr>
                <th>Product name</th>
                <th>Description</th>
                <th class="text-right">Price</th>
                <th> </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Mouse</td>
                <td>High quality mouse</td>
                <td class="text-right">30,45</td>
                <td><a href="#">Show detail</a></td>
            </tr>
            <tr>
                <td>Printer</td>
                <td>Laserjet 20 pages/mm</td>
                <td class="text-right">90,00</td>
                <td><a href="#">Show detail</a></td>
            </tr> 
            <tr>
                <td>Monitor</t></td>
                <td>LCD 23''</td>
                <td class="text-right">150,00</td>
                <td><a href="#">Show detail</a></td>
            </tr>  
        </tbody>
    </table>
    
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>

</body>
</html>
```

The following figure is the static output produced by the GUI template in which you will see the placeholder we designed
for nesting the `NavigationBar` into `ProductsList`

![HMVC template](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/ecommerce-grab-00.png)

So to make the example up and running we need also to code the `NavigationBar` (child) controller:

```php
/**
 * Class NavigationBar 
 *
 */
namespace controllers\ecommerce\common;

use framework\Controller;
use framework\Model;
use framework\View;

class NavigationBar extends Controller
{
    protected $view;
    protected $model;

    /**
    * Object constructor.
    *
    * @param View $view
    * @param Model $mode
    */
    public function __construct(View $view=null, Model $model=null)
    {
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view,$this->model);
    }

    /**
    * Autorun method. Put your code here for running it after object creation.
    * @param mixed|null $parameters Parameters to manage
    *
    */
    protected function autorun($parameters = null)
    {

    }

    /**
    * Get the View by using an instance of concrete framework\View class.
    * The instance will use the template containing the GUI design stored into 
    * ecommerce/common/navigation_bar.html.tpl
    */
    public function getView()
    {
        $view = new View("/ecommerce/common/navigation_bar");
        return $view;
    }

    /**
    * Get the Model by using an instance of concrete framework\Model class.
    */
    public function getModel()
    {
        $model = new Model();
        return $model;
    }
}
```

and its GUI template `navigation_bar.html.tpl`

```html
 <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">eCommerce Demo</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="">Catalog</a></li>
                    <li><a href="#">Contact us</a></li>
                    <li><a href="#">Cart</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">User Profile <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Language settings</li>
                            <li><a href="?locale=en">English</a></li>
                            <li><a href="?locale=it-it">Italian</a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">User settings</li>
                            <li><a href="#">Payments</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
```

The GUI template simply draws:

![HMVC nav bar template](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/ecommerce-grab-04.png)

Finally the following figure shows you the result running `https://server/ecommerce/store/products_list` and producing
HMVC:

![HMVC products list](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/ecommerce-grab-02.png)

Now, just for concluding the e-commerce example we designed in the previous UML diagram, we show you the necessary code
for implementing the product detail page. Like the previous `ProductsList`, `ProductDetail` will use HMVC for nesting
of (the previous and shared) `NavigationBar`.

The code for `ProductDetail` controller:

```php
/**
 * Class ProductDetail
 *
 */
namespace controllers\ecommerce\store;

use framework\Controller;
use framework\Model;
use framework\View;
use controllers\ecommerce\common\NavigationBar as NavigationBar;


class ProductDetail extends Controller
{
    protected $view;
    protected $model;

    /**
    * Object constructor.
    *
    * @param View $view
    * @param Model $mode
    */
    public function __construct(View $view=null, Model $model=null)
    {
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view,$this->model);
    }

    /**
    * Autorun method is automatically executed after object creation.
    * We do the nesting of the navigation bar.
    *
    * @param mixed|null $parameters Parameters to manage
    *
    */
    protected function autorun($parameters = null)
    {
  
        $navigation = new NavigationBar();
        $this->bindController($navigation);
    }

    /**
    * Get the View by using an instance of concrete framework\View class.
    * The instance will use the template containing the GUI design stored into 
    * ecommerce/store/products_list.html.tpl
    */
    public function getView()
    {
        $view = new View("/ecommerce/store/product_detail");
        return $view;
    }

    /**
    * Get the Model by using an instance of concrete framework\Model class.
    */
    public function getModel()
    {
        $model = new Model();
        return $model;
    }
}

```

A very simple GUI template (`product_detail.html.tpl`) for the product detail ...

```html
<!DOCTYPE html>
<html>
<head>
    <title>eCommerce Demo - Product detail</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">

</head>
<body>

<div class="container">

    {Controller:ecommerce\common\NavigationBar}

    <h1>This is the product detail demo page</h1>
    <hr>
    
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
```

Running `https://server/ecommerce/store/product_detail` you will produce:

![HMVC product detail](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/ecommerce-grab-03.png)

## Summary

The largest practical benefit of using an HMVC architecture is the **_widgetization_** of content structures. An example
might be comments, ratings, Twitter or blog RSS feed displays, or the display of shopping cart contents across pages of
an e-commerce website. It is essentially a piece of content that needs to be displayed across multiple pages, and
possibly even in different places, depending on the context of the main HTTP request.

Traditional MVC frameworks generally don't provide a direct answer for these types of content structures, so people
generally end up duplicating and switching layouts, using custom helpers, creating their own widget structures or
library files, or pulling in unrelated data from the main requested Controller to push through to the View and render in
a partial. None of these are particularly good options, because the responsibility of rendering a particular piece of
content or loading required data ends up leaking into multiple areas and getting duplicated in the places it is used.

The HMVC feature of WebMVC has the ability to dispatch sub-requests to a Controller to handle these kinds of
responsibilities. In this regard, HMVC is really just a natural byproduct of striving for increased code modularity,
re-usability, and maintaining a better separation of concerns. This is the selling point of HMVC provided by the
framework.

## What's next

In the [next](https://github.com/rcarvello/webmvcframework/wiki/Decomposition-by-Internationalization--and-Localization)
section, you will learn how to create a multi-language application.