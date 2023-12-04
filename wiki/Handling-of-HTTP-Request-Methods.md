## Introduction

In the previous page, we saw how to pass values using methods and parameters of a controller. However, the Hypertext
Transfer Protocol (HTTP) is designed to enable communications between clients and servers. HTTP works as a
request-response protocol between a client and server. A web browser may be the client, and an application on a computer
that hosts a website may be the server.
> Example: A client (browser) submits an HTTP request to the server; then the server returns a response to the client.
> The response contains status information about the request and may also contain the requested content.

## Two HTTP Request Methods: GET and POST

Two commonly used methods for a request-response between a client and server are **GET** and **POST**.

* GET - Requests data from a specified resource
* POST - Submits data to be processed to a specified resource

Both GET and POST methods are able to send to the server a query string containing name/value pairs that must be
processed by a resource  (that is a controller) residing on the server.

### The GET Method

Note that the query string (name/value pairs) is sent in the URL of a GET request:

```php
http:/localhost/hello_world.php?name=Mark&skill=Developer
```

Usually, HTTP GET requests are sent through the browser URL bar or by HTML links.

### The POST Method

Note that the query string (name/value pairs) is sent in the HTTP message body of a POST request:

```php
POST /hello_world.php HTTP/1.1
Host: localhost
name=Mark&skill=Developer
```

Usually, HTTP POST requests are submitted by using HTML forms.

## Handling of GET and POST with WebMVC

PHP provides:

* $_GET associative array to access all the sent information using the GET method.
* $_POST associative array to access all the sent information using the POST method.

Inside a Controller, you can use both of these arrays for handling HTTP GET and/or POST requests.  
In the following example, we added the method `sayWhatYouGet` to `HelloWorld` for showing you how using $_GET for
handling HTTP GET requests:

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

    /**
     * A simple method for showing of $_GET processing
     */
    public function sayWhatYouGet()
    {     
        echo "You get the following requests:<br>";
           foreach($_GET as $get_variable => $value) {
               echo "$get_variable = $value <br>";
           }
    }

    protected function cantSayHello()
    {
        echo "This method cannot be called from Url";
    }
}
```

Now, to execute the `sayWhatYouGet `method in conjunction with an HTTP GET request containing some data, type:

`http://localhost/hello_world/say_what_you_get?name=Mark&skill=Developer`

You will get the following results:

**You get the following requests:**      
**name = Mark**    
**skill = Developer**

Handling HTTP POST by using $_POST array can be done in a similar way: you need to replace it instead of $_GET in the
code above. Then, to execute the `sayWhatYouGet `method in conjunction with an HTTP POST you can use a tool like Linux
CURL (for emulating a POST request of HTML form) and type:

```php
curl --data "name=Mark&skill=Developer" -H "Content-Type: application/x-www-form-urlencoded" -X POST http://localhost/hello_world/say_what_you_get
```

> Note: instead of using S_GET or $_POST in the code above you can also use the $_REQUEST, the PHP associative array
> that by default contains the contents of $_GET, $_POST (and also $_COOKIE).

## Suggestions when using $_GET and $_POST

Be careful when using the values contained in $ _GET and $ _POST because they come from external users and may contain
malicious data. You always must sanitize data from $_GET and $_POST before using it.   
Sanitize your data depending on what it's being used for and, by using different functionalities provided by PHP:

* If you are inserting data into the database then use `mysql_real_escape_string()` for quoting strings and typecasting
  for numbers would be the way to go (or ideally use "prepared statements"). Regarding database, WebMVC provides the
  autogeneration of special ORM classes equipped with sanitizing functionalities.

* If you plan on outputting the data onto the webpage then we would recommend something like the
  PHP `htmlspecialchars()`. WebMVC provides a special function, `setVar`, that automatically includes this capability.

* About sending emails or HTML forms, the following should suffice:    
  `filter_var($_POST['variable'], FILTER_SANITIZE_CONSTANT) `    
  In this case, WebMVC provides the **Record Component** that automatically includes this functionality.

All this does is basically  "strip tags" and "encode" the special characters.   
We just said that WebMVC provides some functionalities for automatically sanitize data in the proper way. We will
discuss later these arguments when we will show you the View, ORM and the Record component.

> Furthermore, there is no correct way to do blanket sanitation. What sanitation method you need depends on what is done
> to the data. **Sanitize the data directly before it is used**.

## Summary

You learned how using HTTP GET and POST to passing values to the Controller. Depending on your needs, you are able to
use both HTTP GET/POST request and HTTP request of a method/parameters of a Controller for handling some values to be
processed.

## Whats Next

In the next page, we expose some advantages deriving from the conjunction
of [OOP and WebMVC](https://github.com/rcarvello/webmvcframework/wiki/Controller-and-OOP) 
