## Introduction

In the [previous page](https://github.com/rcarvello/webmvcframework/wiki/Handling-blocks), you learned how to
dynamically generate content by repeating and valorizing many times a static content of a block. Another interesting
feature you can do with a block is the capability to hide or to replace its content.

## Hiding and replacing the content of a block

By supposing that:

1. We want to hide the users' list of the previous `templates\users_manager.html.tpl`, statically defined using a block
   named `Users`.
2. We want to replace the users' table with a message "_Sorry, you are not allowed to access users' list_" for
   simulating a protected information.

For this purpose, we add a new block called `ContenUsers` in the template. See the template code below:

```html
<!DOCTYPE html>
<html>
<head>
   <title>Users list</title>
</head>
<body>
   <h1>Users list</h1>
   <!-- BEGIN ContenUsers -->
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
    <!-- END ContenUsers -->
</body>
</html>
```

The view `views\UsersManager` will remain the same of the previous example

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
     *                     array(array('Username'=>,'UserEmai'=>''))
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

Now we need to update the `controllers\UsersManager` by adding two methods: `hideUsers` and `disallowUsers`. See the
code:

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

    /**
     * Hides users list
     */
    public function hideUsers()
    {
        $this->hide("ContenUsers");
        $this->render();
    }

    /**
     * Disallows users list
     */
    public function disallowUsers()
    {
        $this->view->openBlock("ContenUsers");
        $this->view->setBlock("Sorry, you are not allowed to access users' list");
        $this->render();
    }
}
```

Now you can run the controller in three different ways:

1\) By running `http://localhost/users_manager` you will get the following users list:

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

2\) By running `http://localhost/users_manager/hide_users` you will get the following output:
<h3>Users list</h3>

3\) By running `http://localhost/users_manager/disallow_users` you will get the following output:  
<h3>Users list</h3>
<h4>Sorry, you are not allowed to access users' list</h4>

## Summary

In this page, you learned how to use the `hide($blockName)` method for hiding the content inside a block. You also
learned another capability of the `setBlock()` method. In fact by calling `setBlock($text)` and by passing it a text
message you can replace the content of an opened block with the given message.

## Whats Next

In the next page, we speak about [nesting blocks](https://github.com/rcarvello/webmvcframework/wiki/Nesting-of-blocks)