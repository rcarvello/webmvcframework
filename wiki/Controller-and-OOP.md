## Introduction

In OOP we build classes following the principle of the _**single responsibility**_ that states that every module or
class should have responsibility over a single part of the functionality provided by the software and that
responsibility should be entirely encapsulated by the class.   
In this section, you will learn how to use the OOP inheritance and method overriding to handle, generalize, reuse and
extend a controller responsibility. Although all the following examples are focused on the Controller, all of the
concepts inherent the OOP can also be applied to the development of the View and Model classes of WebMVC (which we will
discuss later).

## OOP inheritance and methods overriding

In
the [previous example](https://github.com/rcarvello/webmvcframework/wiki/Controller#insights-controller-and-object-methods),
we used the **OOP inheritance** to take the advantages of extending the "_abstract responsibilities_"
of `framework\Controller` class to "_custom and specialized responsibilities_" of the concrete `controllers\HelloWorld`
class.   
Now we will give you another example regarding another OOP feature: **method overriding**, but before you must know
that:

> Technically speaking, the main responsibility of a WebMVC Controller is to implement some application logic and to
> expose it through an interface to be called like a common HTTP request. Controller application logic has the main role
> to establish automatic cooperation among two external classes: **View** and **Model** we will discuss later but, right
> now, you must take into consideration an important aspect of WebMVC architecture: **anytime you invoke from HTTP a
controller execution, its default, and automatic behavior is to connect a View and a Model. Then WebMVC will show you
the GUI design provided by the connected View.**

To see in action this behavior, first reconsidering the previous `controllers\HelloWord`:

```php
<?php
namespace controllers;

use framework\Controller;

class HelloWorld extends Controller
{
    public function sayHello()
    {
        echo "Hello World";
    }
}
```  

But now, instead of typing  `http://localhost/hello_world/say_hello`, like we made in the previous example, just
invoking HelloWord without requesting any method execution. Type:

`http://localhost/hello_world`

By now we are requesting the execution of the HelloWorld standard behavior, supplied by its `__construct()`, and we will
obtain an exception:

`framework\exceptions\NotInitializedViewException`

Are you surprised? That happens because, by typing  `http://localhost/hello_world`, we invoke the `controller\HelloWord`
standard behavior inherited from its parent: the `__construct()` method which is defined and built into the
abstract `framework\Controller` class.   
The parent  `__construct()`, implements the following behavior: it uses a generic and null View when it does not have
any reference to a custom instance of it. It does the same for the Model. But, when WebMVC tries to show the View it
throws an exception because the design of a generic null View, by default, is not initialized. In the example, we have
an uninitialized design because we are just echoing a message rather than printing an HTML GUI design.

Fortunately, by using the OOP method overriding we can build an extended version, we call
it `controllers\EchoController`, of `framework\Controller` that will implement an "overridden" behavior with the purpose
of avoiding the exception when we don't want use any GUI design.   
Take a look at the following class:

```php
<?php
namespace controllers;

use framework\Controller;

class EchoController extends Controller
{
    /**
     *  @override framework\Controller __construct()
     */
    public function __construct()
    {
        parent::__construct();
        $this->hookViewInitialization();
    }
   
    /**
     * A custom hook to initialize the design managed by the View.
     * @note: We use replaceTpl to initialize design to a space when it is Null
     */
    protected function hookViewInitialization()
    {
        $this->view->replaceTpl(" ");
    }
}
``` 

In this version, we override the standard parent behavior by building (and automatically calling) a hook to the View
initialization, because we haven't the need of using a GUI design. You must don't take care, right now,
of `hookViewInitialization` implementation. Simply you must consider that by calling it we are always able to initialize
the View avoiding the exception.   
So with the availability of `controllers\EchoController`, in witch a GUI design is always initialized, we can now
refactor the previous  `controllers\HelloWorld` in this way:

```php
<?php
namespace controllers;

use controllers\EchoController;

class HelloWorld extends EchoController
{
    public function sayHello()
    {
        echo "Hello World";
    }
}
```  

Now by making the request `http://localhost/hello_world` no exception will be thrown.   
Finally, if you want to automatically show the echo message by using the previous request, override the __construct in
this way:

```php
<?php
namespace controllers;

use controllers\EchoController;

class HelloWorld extends EchoController
{
    /**
     *  @override controllers\EchoController __construct()
     */
    public function __construct()
    {
        parent::__construct();
        echo "Hello World";
    }

    /**
     * Note:
     * We don't need of sayHello() now because
     * we put an echo message in the constructor
     */
}
```

## Summary

In this section, you learned how to apply OOP for extending and overriding a controller behavior. You also learned how
you can use the `__construct` to automatically execute some code when instantiating a controller

## What's next

In the next section, we will speak about interesting feature regarding automatic code execution of a controller:
the [autorun method](https://github.com/rcarvello/webmvcframework/wiki/Controller-autorun-method).
