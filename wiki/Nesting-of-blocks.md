## Introduction

There are two general purposes of using the nesting of blocks:

1. Showing a set of different values when each value, in turn, contains a set of shared values
2. Showing a set of different values when each value, in turn, contains a set of custom values

## Nesting of blocks for showing a subset of shared values

We start by showing you the following `templates\nested_blocks.html.tpl`

```html
<!DOCTYPE html>
<html>
<head>
    <title>Users list</title>
</head>
<body>
<h1>Users list</h1>
{CurrentAction}
<table border="1">
    <thead>
    <tr>
        <th>User</th>
        <th>Email</th>
        <th>Actions</th>
    <tr>
    </thead>
    <tbody>
    <!-- BEGIN Users -->
    <tr>
        <td>{UserName}</td>
        <td>{UserEmail}</td>
        <td>
            <ul>
                <!-- BEGIN UserActions -->
                <li><a href="{GLOBAL:SITEURL}/nested_blocks/do_action/{ActionName}/{UserEmail}">{ActionCaption}</a> </li>
                <!-- END UserActions -->
            </ul>
        </td>
    </tr>
    <!-- END Users -->
    </tbody>
</table>

</body>
</html>
```

As you can guess from the code above the purpose of this template is to representing the static structure of a table of
users and to show, for each user, a set of links for performing some actions, e.g. send email, edit or delete the user
data. Note that each user will share the same names of action links. Only links parameters will be different among
differnt users.

To achieve this goal, we nested the block `UserActions` inside the main block `Users` we used to show users list. Then
we designed inside `UserActions` the static representation of an unnumbered list of actions links. Also note that, like
we have done for the user data, we coded only the static representation of one action link by representing a call
to `doAction()` method of `controller\NestedBlocks` controller and by passing it two parameters: the action name and the
user email, their respectively designed by using `{ActionName}` and `{UserEmail}` placeholders.
Pay also attention that:

* We used the placeholder {CurrentAction} for dynamically showing an information about the link clicked by the user
* We used
  the [global placeholder](https://github.com/rcarvello/webmvcframework/wiki/Dynamic-content#special-placeholders) `{GLOBAL:SITEURL}`
  for getting the root URL of links that will be generated at runtime

The following picture shows you the output of the static design in which we highlighted with green the Users block and
its inner block UserActions with red:

_Figure 1_   
![nested blocks 1](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/nested_blocks00.png)

For dynamically producing the output we also code the following `views\NestedBlocks`. Pay attention to comments for
understanding the purpose of its methods:

```php
<?php

namespace views;

use framework\View;

class NestedBlocks extends View
{
    /**
     * @override framework\View __construct()
     */
    public function __construct($tplName = null)
    {
        if (empty($tplName)) {
            $tplName = "/nested_blocks";
        }
        parent::__construct($tplName);
    }

    /**
     * Shows the given $user in the block Users
     * of tempalates\nested_blocks.html.tpl
     *
     * @param array $users Array of users in the format:
     *                      array( array('Username'=>'','UserEmail'=>'') )
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

    /**
     * Shows the given $actions in the block UserActions
     * of tempalates\nested_blocks.html.tpl
     *
     * @param array $actions Array of actions in the format:
     *                       array( array('ActionName'=>'','ActionCaption'=>'') )
     */
    public function setUserActionsBlock($actions)
    {
        $this->openBlock("UserActions");
        foreach ($actions as $action) {
            $this->setVar("ActionName", $action["ActionName"]);
            $this->setVar("ActionCaption", $action["ActionCaption"]);
            $this->parseCurrentBlock();
        }
        $this->setBlock();
    }
}
```

Finally, we code the `controllers\NestedBlocks` for providing the users' data, handling links actions, and for
interacting with the previous view `views\NestedBlocks`:

```php
<?php

namespace controllers;

use framework\Controller;
use views\NestedBlocks as NestedBlockView;

class NestedBlocks extends Controller
{
    /**
     * @override framework\Controller __construct()
     */
    public function __construct()
    {
        $this->view = new NestedBlockView();
        parent::__construct($this->view);

        $actions = $this->getUserActions();
        $this->view->setUserActionsBlock($actions);

        $users = $this->getUsersData();
        $this->view->setUsersBlock($users);
    }

    /**
     * Set the default behaviour when no actions is performed
     */
    protected function autorun($parameters = null)
    {
        $this->view->setVar("CurrentAction","Please, perform an action on user");
    }

    /**
     * Provides users data.
     *
     * @return array Array of users in the
     *               format array( array('Username'=>'','UserEmai'=>'') )
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

    /**
     * Provides users actions.
     *
     * @return array Array of actions in the format:
     *               array( array('ActionName'=>'','ActionCaption'=>'') )
     */
    private function getUserActions()
    {
        $userActions = array(
            array("ActionName" => "email" ,"ActionCaption" => "Send email"),
            array("ActionName" => "edit"  ,"ActionCaption" => "Edit information"),
            array("ActionName" => "erase","ActionCaption" => "Delete user")
        );
        return $userActions;
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

By running `http://localost/nested_blocks` you will obtain:

_Figure 2_    
![nested blocks 1](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/nested_blocks01.png)

The following picture shows the result after clicking email link of the user Elen:

_Figure 3_   
![nested blocks 1](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/nested_blocks02.png)

The following code shows you the HTML dynamically generated after running `http://localost/nested_blocks` of Figure 2.
You can notice how the two blocks, `Users `and `UsersActions`, were dynamically valued with the data provided by the two
arrays `$userActions`, and `$user` of the controller `controllers\NestedBlocks`.

```html
<!DOCTYPE html>
<html>
<head>
    <title>Users list</title>
</head>
<body>
<h1>Users list</h1>
<h3>Please, perform an action on user</h3>
<table border="1">
    <thead>
    <tr>
        <th>User</th>
        <th>Email</th>
        <th>Actions</th>
    <tr>
    </thead>
    <tbody>
    <!-- BEGIN Users -->
    <tr>
        <td>Mark</td>
        <td>mark@email.com</td>
        <td>
            <ul>
                <!-- BEGIN UserActions -->
                <li><a href="http:/localhost/mvccourse/nested_blocks/do_action/email/mark@email.com">Send email</a> </li>
                
                <li><a href="http:/localhost/mvccourse/nested_blocks/do_action/edit/mark@email.com">Edit information</a> </li>
                
                <li><a href="http:/localhost/mvccourse/nested_blocks/do_action/erase/mark@email.com">Delete user</a> </li>
                <!-- END UserActions -->
            </ul>
        </td>

    </tr>
    
    <tr>
        <td>Elen</td>
        <td>elen@email.com</td>
        <td>
            <ul>
                <!-- BEGIN UserActions -->
                <li><a href="http:/localhost/mvccourse/nested_blocks/do_action/email/elen@email.com">Send email</a> </li>
                
                <li><a href="http:/localhost/mvccourse/nested_blocks/do_action/edit/elen@email.com">Edit information</a> </li>
                
                <li><a href="http:/localhost/mvccourse/nested_blocks/do_action/erase/elen@email.com">Delete user</a> </li>
                <!-- END UserActions -->
            </ul>
        </td>
    </tr>
    
    <tr>
        <td>John</td>
        <td>john@email.com</td>
        <td>
            <ul>
                <!-- BEGIN UserActions -->
                <li><a href="http:/localhost/mvccourse/nested_blocks/do_action/email/john@email.com">Send email</a> </li>
                
                <li><a href="http:/localhost/mvccourse/nested_blocks/do_action/edit/john@email.com">Edit information</a> </li>
                
                <li><a href="http:/localhost/mvccourse/nested_blocks/do_action/erase/john@email.com">Delete user</a> </li>
                <!-- END UserActions -->
            </ul>
        </td>
    </tr>
    <!-- END Users -->
    </tbody>
</table>

</body>
</html>
```

## Summary

In this page, we showed how to code the nesting of blocks for producing a set of multiple values relating to parent
data. The examples we showed assumed to share the same set of values but with different parents.

## What's next

In the [next](https://github.com/rcarvello/webmvcframework/wiki/Insight-about-nesting-of-blocks) page, we will show you
a similar example but with the need of producing a set of custom values related to each parent data.
