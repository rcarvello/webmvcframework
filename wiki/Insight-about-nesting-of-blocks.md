## Introduction

In this page, we are going to expose a little variation of
the [previous example](https://github.com/rcarvello/webmvcframework/wiki/Nesting-of-blocks). We now consider the need of
showing a set of custom values that must be assigned to each user we previously have shown.

## Nesting of blocks for showing a subset of custom values

Now supposing the need of adding a new column to
the [previous table](https://github.com/rcarvello/webmvcframework/wiki/Nesting-of-blocks) containing distinct roles for
each user. So we need to rearrange the template templates\nested_blocks.htpl.tpl in the following way:

```html
<!DOCTYPE html>
<html>
<head>
    <title>Users list</title>
</head>
<body>
<h1>Users list</h1>
<h3>{CurrentAction}</h3>
<table border="1">
    <thead>
    <tr>
        <th>User</th>
        <th>Email</th>
        <th>Actions</th>
        <th>Roles</th>
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
        <td>
            <ul>
                <!-- BEGIN {UserEmail}Roles -->
                <li>{UserRoleName}</li>
                <!-- END {UserEmail}Roles -->
            </ul>
        </td>
    </tr>
    <!-- END Users -->
    </tbody>
</table>
</body>
</html>
```

In the table header, we simply added a new column containing the caption _Role_. In the body, we also added a new column
but containing a new block. We assigned the name `{UserEmail}Roles` to this block with the purpose of dynamically
generate many distinct block name, in the format 'UserEmailRoles', for how many users will be shown in the table.

You can better understand this result by running `http://localhost/nested_blocks`. You will obtain:

![netsed blocks](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/nested_blocks03.png)

Now, if you will give a look inside the source code below, regarding the HTML that was dynamically generated, you will
find these blocks named `mark@email.comRoles`, `elen@email.comRoles`, and `john@email.comRoles`:

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
        <th>Roles</th>
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
                <li><a href="https://server.local/mvccourse/nested_blocks/do_action/email/mark@email.com">Send email</a> </li>
                
                <li><a href="https://server.local/mvccourse/nested_blocks/do_action/edit/mark@email.com">Edit information</a> </li>
                
                <li><a href="https://server.local/mvccourse/nested_blocks/do_action/erase/mark@email.com">Delete user</a> </li>
                <!-- END UserActions -->
            </ul>
        </td>
        <td>
            <ul>
                <!-- BEGIN mark@email.comRoles -->
                <li>{UserRoleName}</li>
                <!-- END mark@email.comRoles -->
            </ul>
        </td>
    </tr>
    
    <tr>
        <td>Elen</td>
        <td>elen@email.com</td>
        <td>
            <ul>
                <!-- BEGIN UserActions -->
                <li><a href="https://server.local/mvccourse/nested_blocks/do_action/email/elen@email.com">Send email</a> </li>
                
                <li><a href="https://server.local/mvccourse/nested_blocks/do_action/edit/elen@email.com">Edit information</a> </li>
                
                <li><a href="https://server.local/mvccourse/nested_blocks/do_action/erase/elen@email.com">Delete user</a> </li>
                <!-- END UserActions -->
            </ul>
        </td>
        <td>
            <ul>
                <!-- BEGIN elen@email.comRoles -->
                <li>{UserRoleName}</li>
                <!-- END elen@email.comRoles -->
            </ul>
        </td>
    </tr>
    
    <tr>
        <td>John</td>
        <td>john@email.com</td>
        <td>
            <ul>
                <!-- BEGIN UserActions -->
                <li><a href="https://server.local/mvccourse/nested_blocks/do_action/email/john@email.com">Send email</a> </li>
                
                <li><a href="https://server.local/mvccourse/nested_blocks/do_action/edit/john@email.com">Edit information</a> </li>
                
                <li><a href="https://server.local/mvccourse/nested_blocks/do_action/erase/john@email.com">Delete user</a> </li>
                <!-- END UserActions -->
            </ul>
        </td>
        <td>
            <ul>
                <!-- BEGIN john@email.comRoles -->
                <li>{UserRoleName}</li>
                <!-- END john@email.comRoles -->
            </ul>
        </td>
    </tr>
    <!-- END Users -->
    </tbody>
</table>
</body>
</html>
```

Now, by having distinct blocks regarding each user's roles, for dynamically assigning him the corresponding set of
values, we need to rearrange the `views\NetsedBlocks` by adding the method `setUsersRoles($usersRoles)`. See the code
below and also pay attention to its comments:

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

    /**
     * Shows the given $usersRoles in the block {UserEmail}Roles
     * of tempalates\nested_blocks.html.tpl
     *
     * @param array $usersRoles Array of users roles  in the format:
     *                         array ( array("UserEmail"=>'',"UserRoles"=> array(r1,r2...,rn)))
     */
    public function setUsersRoles($usersRoles)
    {
        foreach ($usersRoles as $userRoles ) {
            $email = $userRoles["UserEmail"];
            $roles = $userRoles["UserRoles"];
            $this->openBlock("$email"."Roles");
            foreach ($roles as $roleName) {
                $this->setVar("UserRoleName", $roleName);
                $this->parseCurrentBlock();
            }
            $this->setBlock();
        }
    }
}
```

Finally we udate the `controllers\NestedBlocks` for providing users' roles data and for handling the View

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

        $usersRoles = $this->getUsersRoles();
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
     * Provides users data.
     *
     * @return array  Array of users in the
     *                format array( array('Username'=>'','UserEmai'=>'') )
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
     *                       array( array('ActionName'=>'','ActionCaption'=>'') )
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
     * Provides users roles.
     *
     * @return array Array of users roles in the format:
     *                       array ( array("UserEmail"=>'',"UserRoles"=>array(r1,r2...,rn)))
     */
    private function getUsersRoles()
    {
        $usersRoles = array(
                        array(  "UserEmail" => "mark@email.com",
                                "UserRoles" => array("admin","webmaster","moderator")
                        ),
                        array(  "UserEmail" => "elen@email.com",
                                "UserRoles" => array("editor","webmaster","user")
                        ),
                        array(  "UserEmail" => "john@email.com",
                                "UserRoles" => array("user","editor")
                        )
                    );
        return $usersRoles;
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

Now by running `http://localhost/nested_blocks` you will see the following result:

![nested bocks](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/nested_blocks04.png)

## Insight the example

Keep in mind that when you nesting of blocks you have to manage the correct sequence on how to produce the repetitions
of the data in order to obtain the desired output. In this example, in fact, when coding the controller `__construct`,
we first generated the data relating to the _actions_ common to each _user_. Then we produced the _list of users_, also
producing distinct blocks for each user's specific roles. Finally, we have enhanced the _roles_ for each distinct block
in the format UserEmailRole. If you try to change this sequence, the result could not be correct.

## Summary

In this page, we discussed another dynamic behavior you can obtain when using the nesting of blocks. Although we used
the nesting of blocks, or even blocks in general, to produce simple HTML list, you must take in consideration that you
can apply them on different GUI components like, for example, options' list, radio buttons, check boxes, divs and so on.

## Whats next

In the next page, we starting to introduce another important entity of MVC design pattern:
the [Model](https://github.com/rcarvello/webmvcframework/wiki/Model)