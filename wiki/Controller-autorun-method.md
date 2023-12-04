## Introduction

We learned how, by using the `__construct` method of the controller, we can implement some actions to be automatically
executed. However, having in some circumstances the goal of managing complex web pages, we could involve mixing, when
writing the code for the constructor, of some generics actions together with more specialized ones. The `autorun` method
gives you the ability to separate, outside the controller constructor, the coding of those specialized actions that must
be automatically executed. As result of this separation, you will obtain a smart reuse of a controller any times you
will need to extend it to a more specialized behavior.

## Usage example of autorun

First, consider the following and simple extension of the previous `controllers\EchoController`, we call
it `controllers\WebPageProductsList` and we use it for simulating the behavior that must be executed automatically
inside a web page having the responsibility of showing a list of products for a hypothetical e-commerce application.

```php

<?php
namespace controllers;

use controllers\EchoController;

class WebPageProductsList extends EchoController
{
    /*
     * @override controllers\EchoController __construct()
     */
    public function __construct()
    {
        echo "Building page navigation bar <br>";
        echo "Building page status bar <br>";
        echo "Building page credits information <br>";
        echo "Building products list <br>";
        parent::__construct();
    }
}
```

We are simulating a page having a specialized responsibility to show a section containing products list. The page also
shows many sections that should be shared across the different pages of the e-commerce application. These sections are
the site navigation bar, the status bar, and credit information. Finally, we emulated the output of the page that shows
the products list just by printing one message respectively for each section.    
Now suppose we need a new web page, we call it  `controllers\WebPageProductDetail`, that must show the same generics
section regarding navigation, credits information and status bar but it must show a product detail rather than the
products list.  
We can code `controllers\WebPageProductDetail` in this way:

```php

<?php
namespace controllers;

use controllers\EchoController;

class WebPageProductDetail extends EchoController
{
    /*
     * @override controllers\EchoController __construct()
     */
    public function __construct()
    {
        echo "Building page navigation bar <br>";
        echo "Building page status bar <br>";
        echo "Building page credits information <br>";
        echo "Building product detail<br>";
        parent::__construct();
    }
}
```

Now try to type the following HTTP requests to show the results:

`http://localhost/web_page_products_list`   
and    
`http://localhost/web_page_product_detail`

You will get the following results:

**Building page navigation bar**   
**Building page status bar**   
**Building page credits information**   
**Building products list**

and

**Building page navigation bar**   
**Building page status bar**   
**Building page credits information**   
**Building product detail**

Although these implementations are both correct, it is certainly not the most efficient way to write their code. In
fact, all the two classes contain parts of repeated code but necessary to carry out the (shared) generic actions for
computing the navigation bar, the credits information, and the status bar.   
By using autorun, in conjunction with OOP extension, you can code better versions of previous controllers. See the code
below:

```php
<?php
namespace controllers;

use controllers\EchoController;

class WebPageProductsList extends EchoController
{
    /*
     * @override controllers\EchoController __construct()
     */
    public function __construct()
    {
        echo "Building page navigation bar <br>";
        echo "Building page status bar <br>";
        echo "Building page credits information <br>";
        parent::__construct();
    }

    /**
     * @override framework\Controller autorun()
     */
    protected function autorun($parameters = null)
    {
        echo "Building products list <br>";
    }
}
```

```php
<?php
namespace controllers;

use controllers\WebPageProductsList;

class WebPageProductDetail extends WebPageProductsList
{
    /**
     * @override controllers\WebPageProductsList autorun()
     */
    protected function autorun($parameters = null)
    {
        echo "Building product detail <br>";
    }
}
```

In this version, we coded a parent plus a child controller. Then we shared the generic actions built inside the parent
constructor leaving to the autorun method the responsibility for implementing, respectively, the different and
specialized behavior of each controller.   
So by running these two controllers, you will get the same result as above because what will happen will be:

* by running  `controllers\WebPageProductsList`
    * its __construct() will be executed and the three messages about navigation, status, and credit information will be
      shown
    * then, its autorun() method will be automatically invoked by showing you the message about products list
* by running  `controllers\WebPageProductDetail`
    * the parent __construct() will be executed and the three messages about navigation, status, and credit information
      will be shown
    * then, its autorun() method will be automatically invoked by showing you the message about product detail

## Insights: using autorun

Finally, you understand the Controller and some advantages of using OOP and of the method autorun. With this premise,
now we want to show you how you can build HelloWorld in a more efficient way.
First of all, we customizing the generic behavior of the abstract `framework\Controller` by writing a reusable abstract
Controller we can use any time having the need of printing out a simple text message. We call
it `controllers\EchoWebPage`;

```php
<?php
namespace controllers;

use framework\Controller;

abstract class EchoWebPage extends Controller
{
    /**
     * @override framework\Controller __construct().
     */
    public function __construct()
    {
        parent::__construct();
        $this->view->replaceTpl(" ");
    }
}
```

Now, by having an abstract Controller that implements an "echo behavior" without throwing any exceptions and, also,
having a Hook (provided by autorun) to a logic that can be automatically executed, we can write the final and well
engineered release of HelloWorld:

```php
<?php
namespace controllers;

class HelloWorld extends EchoWebPage 
{
    /**
     * @override  autorun()
     */
    protected function autorun($parameters = null)
    {
        echo "Hello World";
    }
}
```

Note that in the above `controllers\HelloWorld` we are extending and concretizing the abstract `controllers\EchoWebPage`
also by omitting the initial instruction 'use controllers\EchoWebPage'. That's because both `controllers\HelloWorld`
and `contollers\EchoWebPage` are encapsulated in the same `controllers` namespace (we will discuss its details later).

By typing

`http://localhost/hello_world`

You (still) will obtain

**Hello World**

## Summary

By using the controller `autorun` you have the ability to automatically execute some custom code, even located outside
its constructor. Then, you can potentially extend a controller just by writing or overriding the autorun code for
extending a parent behavior that must be executed automatically without the need to override the constructor.
> In others terms, you can think about `autorun` like an event that is generated after a controller object creation. So
> you can **hook** this event in any child controller, to extend the main responsibility of a parent one without the need
> to override the constructor.

From Wikipedia
> In computer programming, the term hooking covers a range of techniques used to alter or augment the behavior of
> software components by intercepting function calls or messages or events passed between software components. Code that
> handles such intercepted function calls, events or messages is called a hook.

## Whats next

Until now we have focused on the WebMVC Controller. To clearly showing its basic features, we have introduced extended
versions of it, called EchoController and EchoWebPage, that we built with different design principles. We designed both
of them as sub-classes to modify the Controller basic behavior, that is, the interaction with the View and Model.
Starting from now we will introduce the use of the [View](https://github.com/rcarvello/webmvcframework/wiki/View), an
essential WebMVC class we need for generating web pages rather than simple text messages.