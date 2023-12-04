## Introduction

Consider the common situation where you have to manage and show data dynamically on the web pages. You just learned that
showing output is the main role of the View. This is still valid also when data to show are dynamical. For this purpose,
in this paragraph, we expose a solution for handling dynamic web page by a using static Template, View, and Controller

## Handling placeholders by using Template, View, and Controller

Look again at the following `templates\home.html.tpl`, we shown it on
the [previous page](https://github./rcarvello/webmvcframework/wiki/Dynamic-content#understanding-placeholders). You can
note we have placed the static placeholder {UserName}. Now supposing we want to assign to it a value, eg. 'Mark' but the
assignment must be dynamically provided at run-time.

```html
<!DOCTYPE html>
<html>
  <head>
    <title>Site home page</title>
  </head>
  <body>
    <p>Welcome to the site Home Page</p>
    <br />
    <p>Welcome {UserName}</p>
  </body>
</html>
```

To do this job we procede by creating the following View class we call `views\Home.php`, which extends `framework\View`:

```php
<?php
namespace views;
use framework\View;

/**
 * Class views\Home
 * Handles the treatment of the placeholder designed
 * into templates\home.html.tpl and provides the dynamic page.
 */
class Home extends View
{
    /* Contructor.
     * Override framework\View __construct() to 
     * use templates\home.html.tpl as design
     */
    public function __construct($tplName = null)
    {
        $tplName = "home";
        parent::__construct($tplName);
    }
    
    /* Custom method designed to manage the dynamic content 
     * of the placeholder {UserName}.
     *
     * @param string $name The value to assign to {UserName}
     */
    public function setUserName($name)
    {
        // setVar is a method inherited from framework\View
        $this->setVar("UserName",$name);
    }
    
}

```

We are using the method `setVar()` provided by framework\View to replace a value to placeholder `{UserName}`.

Note that, unlike the instance of the abstract `framework\View` we used to show the static content in
the [previous example](https://github.com/rcarvello/webmvcframework/wiki/View#using-the-view), we are now creating a
custom class, `views\Home.php`, that extends `framework\View`. The reasons we make so are:

* Unlike a template that cloth with a static behavior, one containing placeholders or even blocks, assumes a dynamic and
  specialized behavior. Consequently, it is better to manage a dynamic design by creating a custom View and by using an
  instance of it to provide the expected dynamic content rather than using an instance of `framework\View`.

> Generally, **a custom View should be appositely written anytime you need the treatment of the dynamism of Placeholders
and Blocks coded into a Template**.

* The `framework\View` provides only abstract behaviors like: showing a static design, replacing a value to a
  placeholder, and repeating n times the content of a block. It does not know anything about a custom logic necessary
  for providing a dynamic web page. We need to build a custom View and one or more methods for this purpose, in which we
  can use all the (abstract) functionalities provided by its parent `framework\View`. Note that it's what we have done
  with `setUserName($name)`. You can see we used `setVar()` that is provided by the parent `framework\View`.

* By implementing a custom View, we are respecting
  the [SOC](https://github.com/rcarvello/webmvcframework/wiki/Skills-and-technologies-decomposition#soc-advantages)
  principle. Note that the custom `views\Home` view we used is the only entity enabled to manage the specialized
  behavior we expected to obtain from the placeholders or blocks of the custom `templates\home.html.tpl` template. If we
  had chosen to use, inside the Controller, an instance of `framework\View` rather than wrote `views\Home` for handling
  the placeholder, probably we had coupled altogether different responsibilities and concerns inside the Controller.

Then, we modify the controller **controllers\Home.php** as follow to enable it to communicate with `views\Home.php` (pay
attention to the comments):

```php
namespace controllers;

use framework\Controller;
use views\Home as HomeView;

/**
 * Class controllers\Home
 * Handles home HTTP request.
 * Provides home web page
 */
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
         * Set the view with a new object of type views\Home. 
         * @note: We create the views\Home object by using the 
         *        template reference.
         */
        $this->view = new HomeView($tplName);

        /**
         *  To starting up the standard WebMVC behavior of acting
         *  cooperation between Controller and the View just
         *  invoke the parent constructor by passing the current view  
         */
        parent::__construct($this->view);
        
        /**
         * By default, the controller behavior will be 
         * that to greet a Guest
         */
        $this->view->setUserName("Guest");

    }

    /**
     * Handles home/set_user_name/(value) HTTP request.
     * Provides greeting to the given value.
     *
     * @param string $user The value to be greet
     * @use views\Home->setUserName($name) 
     */    
    public function userToGreet($user) {
        $this->view->setUserName($user);
        $this->render();
    }
    
}
```

The following figure shows the WebMVC directory tree with files location:

![WebMVC Files](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/view_tree_02.png)

Note we used 'Home' name for naming Controller, View, and 'home' for Template. We talked about this on
the [naming convention page](https://github.com/rcarvello/webmvcframework/wiki/Understanding-WebMVC#naming-convention)
page.

Finally, run the controller by typing the following address into your web browser:

`http://localhost/home/user_to_greet/Mark`

You should see the page:

![Home web page](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/home_web_pge_03.png)

You can also run the controller without calling its `userToGreet()` method. Type:

`http://localhost/home/`

Now, you should see:

![Home web page](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/home_web_pge_04.png)

## Insight: General considerations

Although this example is very simple, there are still many feasible considerations to do:

#### What `setVar()` exactly does ?

The method `setVar($placeholder, $value)` provided by framework\View find a given placeholder in the active template and
replace it with a given value.
Bear in mind that:

* If many occurrences of placeholders (like {UsenName}) are designed in a template, then they will be all replaced in
  one single **setVar()** call.
* You must call a `setVar()` method after the view has been initialized in the controller.
* You must not call twice the setVar() method by giving it, each time, the same placeholder.This because after the first
  time the placeholder will be replaced with a value, then, at the second call of setVar(), no placeholder will be found
  and an exception will be thrown.
* It provides some useful actions. Follow the method reference extracted from `framework\View` source code:

```php
    /**
     * Replaces all occurrences of the given placeholder with a given value.
     * If the placeholder is contained into a (previously opened) block
     * the replacement is made against the opened block.
     *
     * You can also specify if the given placeholder is enclosed in braces,
     * if you need to purify the given value against XSS and CHARSET for the given value
     *
     * @param string $placeholder  The placeholder to find
     * @param string $value        The value for replacing to founded placeholder
     * @param bool|true $useBraces If true (default) the placeholder name contain braces {}
     * @param bool $xssPurify      If true (default=false) purify the value against XSS
     * @param string $charset      Charset string for the give value. Default (UTF8) is the CHARSET 
     *                             constant value defined into config\application.config.php
     * 
     * @throws VariableNotFoundException.  If variable/placeholder was not found
     * @throws NotInitializedViewException If template was not loaded
     */
    public function setVar($placeholder, $value, $useBraces=true, $xssPurify=false, $charset = CHARSET)
```    

#### What about the use of `render()`?

Although you can invoke the `render()` method from the Controller, in action this is a service implemented by the View
for showing the GUI to the screen.   
When you are writing a public method of a Controller, you need to manually invoke method `render()` anytime you want to
output the GUI to the screen. Differently, you will not need to invoke it when you are writing a Controller constructor.
The reason is that WebMVC, by default, when you are invoking a Controller without calling any of its methods,
automatically executes `render()` for you. See the previous `controller\Home` source and you will find that we
invoke `render()` inside `userToGreet()` but never in `__construct()`;

## Summary

In this section, we speak about the need of creating a View with the purpose of handling the placeholders and of
generating dynamic content.

## Whats next

In the next page, we will introduce the
dynamic [Blocks handling](https://github.com/rcarvello/webmvcframework/wiki/Handling-blocks) for generating dynamic
pages containing repeated sections