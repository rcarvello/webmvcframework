## RBAC

WebMVC uses a security model known as _**RBAC**_, "_Role Based Access Control_".  
RBAC establishes that:

a) Every user must be authenticated, identified, and assigned to an application role (i.e. admin, user, power user, and
so on).  
b) Afterward, a user, after logging in, can access only web pages that were designed to have restricted access only to
their role.   
c) Roles can (or not) restrict user access to web pages. They can also restrict database record operations, like INSERT,
UPDATE, or DELETE.

WebMVC, lets you implement a),b) and, c) by providing you services for:

1) Defining the database tables in which to store: users, credentials, roles (access_level), and assignment of a role to
   users
2) Implementing a login mechanism for authenticating and identifying users.
3) Implementing a mechanism to establish that the access for execution of given MVC assemblies is allowed only to an
   authenticated user and/or who has the appropriate role.
4) Limiting database record operations depending on user role

## Database tables for storing users, credentials, roles, and assignment of a role to users.

You can use the `sql\rbac.sql` script to automatically create these tables. The generated tables will also contain
sample data for users and roles.
In the example, data access_level = 100 is for Administrators while 60 is for Managers.
User credentials will be given by its email and password and password will be optionally stored by using md5 or
password_hash one-way encryption algorithm. In sample data, all md5 passwords are equal to "password".  
The figure below shows you the tables diagram:

![System Architecture](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/RBACdb.png)

While tables are used to store the RBAC information regarding users and roles, the `framework\User` class provides you
with all methods and helpers for handling user status every time you need and from everywhere (inside of a controller,
model, or view).
Specifically, the `framework/User.php` class will use tables and data for implementing the following methods that you
can/must use during the development of your MVC classes for managing user authentication, login, logout, and so on (read
comments):

First of all "_getter_" methods:

```php
<?php

    /**
     * Gets user ID. The id is the primary key
     *
     * @return int
     */
    public function getId()

    /**
     * Gets user email. Used for credential
     *
     * @return string
     */
    public function getEmail()

    /**
     * Gets user password. Used for credential
     *
     * @return string (Optionally encrypted by md5 algo)
     */
    public function getPassword()

    /**
     * Gets user role
     *
     * @return int The number identifying the user role
     */
    public function getRole()

```
Here are some useful methods to manage user login and logout:

```php
<?php

    /**
     * Login user
     *
     * @param string $mail User email
     * @param string $password User password
     *
     * @return bool True if login ok, else false
     */
    public function login($email, $password)

    /**
     * Logout user
     *
     * @return bool 
     */
    public function logout()

    /**
     * Checks if a user is successfully logged in
     *
     * @return bool True if logged in, else false
     */
    public function isLogged()
 
    /**
     * Checks if a user is logged in. If false it redirects to a custom link used for showing 
     * the login form and requiring authentication. If true it redirects to a custom link.
     *
     * @param null|string $redirect 
     *                The Controller URL for redirecting when the user is not logged in.
     *                If null it automatically redirects to the default login page.
     * @param null|string $returnLink 
     *                The return link is to be used for redirecting if the user is successfully logged in.
     *                If null it (still) will be the default login page
     * @param null|string $LoginWarningMessage  
     *                A custom warning message to show in the login form after 
     *                unsuccessful login
     *                If null it will be the default message
     *
     */
    public function checkForLogin($redirect=null, $returnLink=null, $LoginWarningMessage=null)

    /**
     * Auto-login by using Cookies
     *
     * @uses ChiperService
     * It uses the ChiperService class to decrypt Cookie
     */
    public function autoLoginFromCookies()

```

If you prefer to define and use your custom tables for storing and managing users and roles you must instruct WebMVC how
to find tables for getting information. In this case, it will be necessary to modify the file
`config/security.config.php` (please read comments)

```php
<?php

/**
 * security.config.php
 *
 * Main application security configuration parameters.
 * You can change those values according to your security
 * MySQL environment or Chiper preferences
 */

/**
 * Defines the constants for MySQL database User table.
 * Class User uses this information.
 */

/**
 *  Constant for the User MySQL Table
 */
define("USER_TABLE", "user");

/**
 *  Defines a constant for INT Primary Key field of the User MySQL Table
 */
define("USER_ID","id_user");

/**
 *  Defines a constant for the UNIQUE email field of the User MySQL Table
 *  Email is used as the credential
 */
define("USER_EMAIL","email");

/**
 *  Defines a constant for the password field of the User MySQL Table
 *  Password is used as the credential
 */
define("USER_PASSWORD"," password");

/**
 *  Defines a constant for the role field of the User MySQL Table
 *  User role defines access levels criteria managed by RBAC Engine
 */
define('USER_ROLE', 'id_access_level');

/**
 *  Defines a constant for Administrator role id
 *
 */
define('ADMIN_ROLE_ID', 100);

/**
 *  Defines a constant for the enable field of the User MySQL Table
 *  User enable field can temporarily disable users. 
 *  Leave blank the value for USER_ENABLED if you don't want to manage the enabling/disabling of users.
 *  Note: User enable database field value must be 1 or -1
 */
define('USER_ENABLED', 'enabled');

```

## Using RBAC

You can protect access and execution of a Controller by using RBAC features.
To do this the abstract Controller class of WebMVC provides you with the following methods:

```php
  /**
     * Restricts on RBAC. User role must have a role contained into RBACL.
     *
     * @param string $redirect The Controller URL path to redirecting when access is denied.
     *                         If null it redirects to the default login page.
     * @param null|string $returnLink The return link after logging in with the default login page
     * @param null|string $LoginWarningMessage A custom warning message to show
     * @return User
     */
    protected function restrictToRBAC($redirect = null, $returnLink = null, $LoginWarningMessage = null)


    /**
     * Restricts access only to authenticated users
     *
     * @param string $redirect The Controller URL path to redirecting when the user is not logged in.
     *                         If null it redirects to the default login page.
     * @param null|string $returnLink The return link after logging in with the default login page
     * @param null|string $LoginWarningMessage A custom warning message to show
     * @return User
     */
    protected function restrictToAuthentication($redirect = null, $returnLink = null, $LoginWarningMessage = null)


   /**
     * Grants a user role for access
     *
     * @param int $role number
     */
    protected function grantRole($role)
    {
        $role = (int)$role;
        $this->roleBasedACL[] = $role;
    }

```

So you can restrict access and execution of a Controller only to authenticated users or to users having a specific role.

In `controller\examples\cms\InnerBlocks` you can find an example of how to implement RBAC. The following code section
illustrates how the access
restriction can be implemented into the `__construct ` class constructor.

```php
    /**
    * Object constructor.
    *
    * @param View $view
    * @param Model $mode
    */
    public function __construct(View $view=null, Model $model=null)
    {
        $this->grantRole(100);  // Administrator
        $this->grantRole(60);   // Manager (see access_level table)
        $this->restrictToRBAC(null,"examples/cms/inner_blocks");
        // Alternatively, you can limit access to only the authenticated user, regardless of role
        // $this->restrictToAuthentication(null,"examples/cms/inner_blocks");

        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view,$this->model);
    }
```

It means that just by writing the first three lines of code you restricted the execution only to Administrator (role
100)  and Manager (60).
So if you try to access to:
``
 http://localhost/examples/cms/inner_blocks
``
the response will be:

* If you never logged in before, then you will be redirected to the `login` Controller/Page to specify your credentials
* After authentication (or if you are previously authenticated) framework checks your credentials and, then if you have
  an appropriate role granted into `controller\examples\cms\InnerBlocks` (defined with the first two lines of code into
  the constructor)
* If you successfully match the role then the framework lets you access and execute
  `controller\examples\cms\InnerBlocks`, otherwise you will be redirected to the login page and a login warning message
  will be shown (the message text is an optional parameter of  `restrictToRBAC` and `restrictToAuthentication`)

Finally, If you just want to restrict access to authenticated users, regardless of role/access_level assigned to each
user, you can use `restrictToAuthentication` method in a similar way described before.

## Limiting database record operations depending on user role

To evaluate the user role you can simply use the "getRole" method of "framework\User" and thus determine the correct
database operation that you need to implement and that is required by your application.
Below is an example of code that you can, arbitrarily, put into a Model (as well as Controller or View) to illustrate
how to implement a DB operation depending on the role of the current user logged in

```php

// ...some code before
$user = new framework\User();
$userRole = $user->getRole(); 
if ($userRole == 100) {
 // custom code to allow add or update a record
}
// custom code to read a record
```
