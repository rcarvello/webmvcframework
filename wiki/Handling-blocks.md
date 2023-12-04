## Introduction

We can extend the idea of dynamic substitution of a placeholder with some value to the case where we have to handle a
block of content and we need to perform some actions on it. For this purpose, WebMVC uses the concept of **Block**.

## Handling blocks by using Template, View, and Controller

A Block is nothing more than a piece of code (typically HTML but it can be also Javascript or CSS inside the HTML)
delimited by two comments for marking its beginning and ending limit. The content inside a block is usually subject to
an action in order to generate a dynamic page in the browser. The block management is a useful feature of WebMVC for
computing dynamic actions like:

* [Content repetition and/or dynamic rendering](https://github.com/rcarvello/webmvcframework/wiki/Handling-blocks#repetitions-andor-dynamic-valorizations-of-the-content)
* [Content replacement and hiding](https://github.com/rcarvello/webmvcframework/wiki/Hiding-and-replacing-the-content-of-a-block)
* [Nesting of blocks](https://github.com/rcarvello/webmvcframework/wiki/Nesting-of-blocks)

## Repetitions and/or dynamic rendering of the content

Supposing we want to show a list of users rather than a single one like we previously done in
the [`controllers\Home`](https://github.com/rcarvello/webmvcframework/wiki/Handling-placeholders#handling-placeholders-by-using-template-view-and-controller).
On the section
about [Dynamic Content](https://github.com/rcarvello/webmvcframework/wiki/Dynamic-content#understanding-blocks), we
introduced and coded the following `templates\users_manager.html.tpl`, by using a block named `Users` suitable for this
purpose.

```html
<!DOCTYPE html>
<html>
<head>
   <title>Users list</title>
</head>
<body>
   <h1>Users list</h1>
   <table>
      <thead>
         <tr>
            <th>User</th>
            <th>Email</th>
         <tr>
      </thead> 
      <tbody>
         <!-- BEGIN Users -->
         <tr>
            <td>{UserName}</td>
            <td>{UserEmail}</td>
         </tr>
        <!-- END Users -->
      </tbody>
    </table>
</body>
</html>
```

As you can guess from the HTML code, the expected dynamic behavior of the web page will be to show a table containing
some users. For each user, it will show the username and email.

> This means that the HTML contained in the Users block can be considered as a **Template pattern** that must be
> dynamical **repeated** N times, and **valued** each time with different values representing a user.


In the HTML code, two comments have been added, and they together wrap the block of code that will be dynamically
replaced many times in the HTML file. These comments mark the BEGIN and the END of a block of name `Users`. This means
that WebMVC will be able to recognize the block.

Now, we can write the code of `views\UsersManager` and `controllers\UsersManager` in order to show a table of users.

First, we code `views\UsersManager` and save it as `views\UsersManager.php`

```php
<?php

namespace views;

use framework\View;

class UsersManager extends View
{
    /**
     * @override framework\View __construct()
     */
    public function __construct($tplName = null)
    {
        if (empty($tplName)) {
            $tplName = "/users_manager";
        }
        parent::__construct($tplName);
    }

    /**
     * Shows the given $user in the block Users
     * of tempalates\users_manager.html.tpl
     *
     * @param array $users Array of users in the format
     *                      array(array('Username'=>,'UserEmai'=>''))
     */
    public function setUsersBlock($users)
    {
        $this->openBlock("Users");
        foreach ($users as $user) {
            $this->setVar("UserName", $user["UserName"]);
            $this->setVar("UserEmail", $user["UserEmail"]);
            $this->parseCurrentBlock();
        }
        $this->setBlock();
    }
}
```

In the view we have created a method `setUsersBlock` that uses the block `Users` and processes it with all the elements
contained in the given `$users` array; specifically, we:

* Invoking the `openBlock `method inherited from `framework\View`. This method, behind the scenes, do:
    * It recognizes the block `Users`
    * It creates a swap, initially empty, variable to store the dynamic content to be generated. We refer it
      as `dynamic_content`
    * It generates an internal template that contains the HTML eclosed in the Users block. We refer it
      as `template_pattern`
    * It predisposes each future calling of the `setVar` method to be restricted to the content of `template_pattern`.

* Then, we start a PHP `foreach` loop on `$users`. For each element of $users:
    * We call the `setVar` method by valorizing placeholders `{UserName}` and `{UserEmail}` with the values referenced
      by the array keys `UserName` and `UserEmail ` of the current element, `$user`, of `$users`
    * We call the `parseCurrentBlock()` which, behind the scenes do:
        * It concatenates the content of `template_pattern`, which now contain data rather than placeholders, to the
          content of `dynamic_content`. Note that, on each iteration, `parseCurrentBlock()` will add one user to
          dynamic_content. On the ending of `forech, `dynamic_content` will contain all users.
        * It regenerates the `template_pattern` for using it, once again, on the next iteration.
    * Then `foreach` evaluates if exist the next element in $users:
        * When the element exists, `foreach` backs to _i_ for processing the next element. This means that placeholders
          contained in the  (just regenerated) `template_pattern` are, once again, ready to be valorized, but now with
          the values of the next element of `$users`
        * Else `foreach` loop exit

* Finally, by calling the `setBlock` method, we stop the processing on the opened block and, behind the scenes, method
  replaces the text originally enclosed in the block `Users` with the text contained into its internal
  variable `dynamic_content`

Now we code the `controllers\UsersManager `and save it as `controllers\UsersManager.php`

```php
<?php

namespace controllers;

use framework\Controller;
use views\UsersManager as UsersManagerView;

class UsersManager extends Controller
{

    /**
     * @override framework\Controller __construct()
     */
    public function __construct()
    {
        $this->view = new UsersManagerView();
        parent::__construct($this->view);
        $users = $this->getUsersData();
        $this->view->setUsersBlock($users);
    }

    /**
     * Provides users data
     *
     * @return array  Array of users in the
     *                format array(array('Username'=>,'UserEmai'=>''))
     */
    private function getUsersData()
    {
        $users = array(
            array('UserName' => 'Mark', 'UserEmail' => 'mark@email.com'),
            array('UserName' => 'Elen', 'UserEmail' => 'elen@email.com'),
            array('UserName' => 'John', 'UserEmail' => 'john@email.com')
        );
        return $users;
    }
}
```

Now you can run the controller:

`http://localhost/users_manager`

...and you will get the users table (see the page summary below)

## Summary

In this section, we show how handling the content repetition and valorization of a block. What we have done is:

##### 1. By assuming the need for processing a multidimensional array of users:

```php  
 $users = array(
            array('UserName'=>'Mark', 'UserEmail'=>'mark@email.com'), 
            array('UserName'=>'Elen', 'UserEmail'=>'elen@email.com'),  
            array('UserName'=>'John', 'UserEmail'=>'john@email.com')    
          );
```

##### 2. We built a static GUI design `templates\users_manager.html,tpl`, containing a block and two placeholders:

<h3>Users list</h3>
   <table>
      <thead>
         <tr>
            <th>User</th>
            <th>Email</th>
         <tr>
      </thead> 
      <tbody>
         <tr>
            <td colspan="2"><i>&lt;!-- BEGIN Users --&gt;<i></td>
         </tr>
         <tr>
            <td>{UserName}</td>
            <td>{UserEmail}</td>
         </tr>
         <tr>
            <td colspan="2"><i>&lt;!-- END Users --&gt;<i></td>
         </tr>
      </tbody>
    </table>    

##### 3. We built the custom class `views\UsersManager` for handling the template

##### 4. We build the custom class `controllers\UsersManager` for handling the view, users as well as the HTTP requests

##### 5. Finally, on requesting `http//localhost/users_manager`, we dynamically produced out:

<h3>Users list</h3>
   <table>
      <thead>
         <tr>
            <th>User</th>
            <th>Email</th>
         <tr>
      </thead> 
      <tbody>
         <tr>
            <td>Mark</td>
            <td>mark@email.com</td>
         </tr>
         <tr>
            <td>Elen</td>
            <td>elen@email.com</td>
         </tr>
         <tr>
            <td>John</td>
            <td>john@email.com</td>
         </tr>
      </tbody>
    </table>

## Whats Next

In the next page, we show you
how [hiding and replacing](https://github.com/rcarvello/webmvcframework/wiki/Hiding-and-replacing-the-content-of-a-block)
the content inside a block.