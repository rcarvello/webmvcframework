## Introduction

You are going to learn how fast is to start coding with the WebMVC framework.   
We have already discussed the role of the Controller in the MVC design
pattern [here](https://github.com/rcarvello/webmvcframework/wiki/Understanding-WebMVC#understanding-controller).
As follow of that, for designing and implementing your first application you only need a basic knowledge of OOP
programming for writing special classes: the Controllers. In fact, by writing a Controller, also equipped with some
public methods, WebMVC will enable you to instantiate and execute it's logic, simply by typing special HTTP requests
from your browser.

## Let's start coding

Coding and running your first controller is extremely simple!   
Just write and save the following file **HelloWorld.php** into the **controllers** folder:

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

The figure below shows you the path for **HelloWorld.php**. Note that **you must use the _PascalCase_ notation for
naming a controller**.

![](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/controller.png)

At this point, the only thing you have to understand is how to instantiate the `HelloWorld` Controller and execute
its `sayHello` method. Just open your favorite web browser and type the following URL address:

`http://localhost/hello_world/say_hello` [(Click to run)](https://www.webmvcframework.com/hello_world/say_hello)

You should see:

**Hello World**

Congratulations, you have just developed and executed your first application using the WebMVC framework!

## Explanation: How coding and executing Controller

WebMVC requires you to code a custom Controller for implementing application logic. In general, a Controller has the
responsibility to handle the logic and control flow of a software application. To do this you must create a PHP Class
that extends the `framework\Controller` and save it under the `controllers` directory. That is what we did by
providing `HelloWorld` controller. Later we ran it by requesting it from browser URL, that's mean we typed its name and
its `sayHello`method by using a **snake_case notation**. This notation is very intuitive because it mirrors the *
*PascalCase or camelCase notation that must be mandatory used when naming classes or methods**. It simply consists of
typing the HTTP request by specifying both the Controller and Method names you want to run, using lowercase and by
separating names with a slash. Snake_case notation also requires an underscore for separating an eventual occurrence of
composite names for the controller or for methods. In fact, we used:

**hello_world** -> for specifying **HelloWorld** Controller that must mandatory named by using the PascalCase notation

**say_hello** -> for specifying its **sayHello** method that must be mandatory named by using the camelCase notation

then we typed both controller and method names by separating them with a  "/" (we assumed localhost is the application
root):

`http://localhost/hello_world/say_hello`

That's it all.

Therefore, you don't need to configure the execution of a particular Controller, but you just use the URL notation
proposed by WebMVC. This simplicity derives from the _convention over configuration_ approach that the framework uses
for object instantiation and method invocation in order to avoid tedious operations of configuration for running the
controllers. The _convention over configuration_ mechanism used by WebMVC is simple: as we just said before, you must
mandatorily use the PascalCase and camelCase notation when naming, respectively, classes and methods.

## Reference: Controller and object methods

As you can see in the example, for creating a Controller you must write a common PHP Class that uses and extends the
abstract `framework\Controller` class. Then you must and save it into the directory controllers. By adding public
methods to `controllers\Home class`, you are able to implement some application logic that can be executed by an HTTP
request.
The only skill you need right now is about the **OOP programming**. For this purpose, the next example will show you
other concepts regarding the interaction between WebMVC and OOP programming. Specifically, they are about **parameters**
and  **visibility** of Controller methods.    
Look and run the code below in which to the previous example we add:

* a new public method that accepts one input parameter: `sayHelloMessage($message)`
* a new protected method: `cantSayHello()`:

```php
<?php
namespace controllers;

use framework\Controller;

class HelloWorld extends Controller
{

    public function sayHello()
    {
        echo "Hello world";
    }
	
    public function sayHelloMessage($message)
    {
        echo "Hello $message";
    }

    protected function cantSayHello()
    {
        echo "This method cannot be called from Url";
    }
}
```

Now type the following address:

`http://localhost/hello_world/say_hello_message/Mark` [(Click to run)](https://www.webmvcframework.com/hello_world/say_hello_message/Mark)

The output will be

**Hello Mark**

Also type:

`http://localhost/hello_world/say_hello_message/John` [(Click to run)](https://www.webmvcframework.com/hello_world/say_hello_message/John)

The output now will be:

**Hello John**

As you can note we requested the execution of the method `sayHelloMessage` and for specifying a value `Mark` (or `John`)
for its single parameter `$message` we simply typed its value into the URL. We also used a slash for separating the
requested method name `say_hello_message` and the value for its parameter `$message`. This is the **WebMVC convention**
for passing one, and also multiples, values to a method parameters through the browser URL. In other words, you must
simply specify the values, corresponding to the parameters, into URL and separate them with slashes. But, take care of
passing the exact numbers of values that a method requires as input parameters otherwise, an exception will be thrown.
You further note that the requested method was defined as public. The reason is that **only public methods can be
executed**.   
In fact, if you try to type:

`http://localhost/hello_world/say_hello_message/Mark/John`   
or also    
`http://localhost/hello_world/cant_say_hello`

in both cases, you will obtain an exception. The first exception is because we passed wrong numbers of values, `Mark`
and `John`, to the single parameter `$message` designed into the method `sayHelloMessage` while the second one regards
the access denied that occur any time we try to call from the URL a **protected** method, like `cantSayHello`.

## Summary

This page exposes to you how simple is to start coding with WebMVC in accordance with the OOP programming. Just design
and write your application in terms of concrete Controller classes and public methods. Then WebMVC let you execute them
as common HTTP requests. Technically speaking, it means that every valid HTTP request performed by a user will match the
execution of an action managed by a controller. The figure below illustrates this behavior:

![Controller](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/request-handling-controller.png)

## Whats next

In the next page, we expose how you
can [handle HTTP GET/POST requests](https://github.com/rcarvello/webmvcframework/wiki/Handling-of-HTTP-Request-Methods).
