## Introduction

In an MVC software architecture, a Model is a component that has the responsibility for data management. In other words,
the model maintains a repository of data and provides the methods for data recording and retrieval.
It is worthwhile to observe that the decomposition into the three components of an MVC architecture reflects the
approach of _divide et impera_ in which the controller assumes the role of coordinator that assigns the tasks of data
management and data presentation to the model and view components respectively.

## WebMVC Model

In WebMVC, the instantiation of a model is similar to that of a controller or a view; in fact, it is sufficient to
extend the `framework\Model` class. As an example, we can further discuss the problem of showing a list of people in a
browser. In
the [previous page](https://github.com/rcarvello/webmvcframework/wiki/Insight-on-nesting-of-blocks#nesting-of-blocks-for-showing-a-subset-of-custom-values),
the list of users, actions, and roles were taken from the controller; while this could be convenient when the problem to
solve is of small dimension (we could do without the model), it is more frequent the case where the data are managed by
the model. So we can build a news class, `models\NestedBlocks`, in this way:

```php
namespace models;

use framework\Model;

class NestedBlocks extends Model
{

    /**
     * Provides users data.
     *
     * @return array  Array of users in the format:
     *                array( array('Username'=>'','UserEmai'=>''))
     */
    public function getUsersData()
    {

        $users = array(
            array('UserName' => 'Mark', 'UserEmail' => 'mark@email.com'),
            array('UserName' => 'Elen', 'UserEmail' => 'elen@email.com'),
            array('UserName' => 'John', 'UserEmail' => 'john@email.com')
        );
        return $users;
    }

    /**
     * Provides users actions.
     *
     * @return array Array of actions in the format:
     *               array( array('ActionName'=>'','ActionCaption'=>'') )
     */
    public function getUserActions()
    {
        $userActions = array(
            array("ActionName" => "email" ,"ActionCaption" => "Send email"),
            array("ActionName" => "edit"  ,"ActionCaption" => "Edit information"),
            array("ActionName" => "erase","ActionCaption" => "Delete user")
        );

        return $userActions;
    }

    /**
     * Provides users' roles.
     *
     * @return array Array of users roles in the format:
     *               array ( array("UserEmail"=>'',"UserRoles"=>array(r1,r2...,rn)))
     */
    public function getUsersRoles()
    {
        $usersRoles = array(
            array("UserEmail" => "mark@email.com",
                  "UserRoles" => array("admin","webmaster","moderator")
            ),
            array("UserEmail" => "elen@email.com",
                  "UserRoles" => array("moderator","editor","user")
            ),
            array("UserEmail" => "john@email.com",
                  "UserRoles" => array("user","editor")
            )
        );
        return $usersRoles;
    }

}

```

By using the new class `models\NestedBlocks`, in which we coded methods for providing all the necessary data, we can now
refactor the `controllers\NestedBlocks` by:

* Adding a reference to `models\NestedBlocks`
* Eliminating its protected methods `getUsersData()`, `getUserActions()`, and `getUsersRoles()` because they are now
  provided by `models\NestedBlocks` as public services.

See the code below for the new version of `controllers\NestedBlocks` :

```php
<?php

namespace controllers;

use framework\Controller;
use views\NestedBlocks as NestedBlockView;
use models\NestedBlocks as NestedBlockModel;

class NestedBlocks extends Controller
{
    /**
     * @override framework\Controller __construct()
     */
    public function __construct()
    {
        $this->view = new NestedBlockView();
        $this->model = new NestedBlockModel();
        parent::__construct($this->view,$this->model);

        $actions = $this->model->getUserActions();
        $this->view->setUserActionsBlock($actions);

        $users = $this->model->getUsersData();
        $this->view->setUsersBlock($users);

        $usersRoles = $this->model->getUsersRoles();
        $this->view->setUsersRoles($usersRoles);
    }

    /**
     * Set the default behaviour when no actions is performed
     */
    protected function autorun($parameters = null)
    {
        $this->view->setVar("CurrentAction","Please, perform an action on user");
    }

    /**
     * Performs the given action on a given user.
     *
     * @param string $actionName The action to performs
     * @param string $userEmail The user email on which to perform the action
     */
    public function doAction($actionName,$userEmail)
    {
        $currentAction = "Current action: $actionName on user $userEmail";
        $this->view->setVar("CurrentAction",$currentAction);
        $this->render();
    }
}
```

We don't need to update
the [previuos](https://github.com/rcarvello/webmvcframework/wiki/Insight-on-nesting-of-blocks#nesting-of-blocks-for-showing-a-subset-of-custom-values) `views\NestedBlokcs`
and `templates\nested_blocks.html.tpl` because they are already decoupled from control and data logic.     
The figure below shows the files structure of model, view, template, and controller:

![Figure1](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/view_tree_mvc.png)

So we can run again `controllers\NestedBlocks` by typing  `http://localhost/nested_blocks` to obtain the same result of
the previous page:

![Model](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/nested_blocks04.png)

## Summary

By using Model, the Controller must now take into account the coordination of View and Model following these steps:

* Link the variable `$this->view` and `$this->model` to the corresponding class instances passing them to the
  constructor of the framework\Controller class
* Use the instantiated model and view to retrieve and visualize the array of data provided by the Model

Summary the controller, retrieve the data from the model; then, calling the view, it arranges the presentation.
Note that the code of view and the corresponding template are unchanged.

By introducing the Model you can now better understand the **WebMVC architecture** that separates an application into
four layers: Model, View, Template, and Controller.

* **Model**: Model represents the shape of the data and business logic. It maintains the data of the application. Model
  objects retrieve and store model state in some data structures like a database, array and so on.   
  Model is a data and business logic.

* **View**: View handles the user interface. View display data using Model and Template to the user and also enables
  them to submit an update on data. These requests will be later interceped and managed by the controller.   
  View is a User Interface logic to provide data dynamically.


* **Template**: Templates provides the static GUI design. A template is used by the View to generate dynamic web pages
  also by consuming data provided by the Model.   
  Template is the User Interface design.

* **Controller**: Controller handles the user request. Typically, a user interacts with View, which in-tern raises
  appropriate URL request, this request will be handled by a controller. The controller renders the appropriate view
  with the model data as a response.   
  Controller is a request handler and a coordinator for Model and View.

The following figure summarizes the interaction between Model, View, Template, and Controller.

![MVC Request](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/request-handling-in-webmvc.png)

## Whats next

Having in mind the role of a Model and how to use it in the MVC architecture, we can now introduce the data structures
most used by WebMVC Model: [MySQL database](https://github.com/rcarvello/webmvcframework/wiki/Interacting-with-MySQL)