WebMVC uses a security model known as _**RBAC**_, "_Role Based Access Control_".  
RBAC establishes that:

a) Every user must be authenticated, identified, and assigned to an application role (i.e. admin, user, power user, and
so on).  
b) Afterward, a user, after logging in, can access only to web pages that were designed to be having restricted access
only to its own role.   
c) Roles can (or not) restrict user access to web pages. They can also restrict database record operations, like INSERT,
UPDATE, or DELETE.

WebMVC, let you implementing a),b) and, c) by providing you services for:

1) Defining the database tables in which to store: users, credentials, roles, and assignment of a role to users
2) Implementing a login mechanism for authenticating and identifying users.
3) Implementing a mechanism to establish that the access for execution of given MVC assemblies is allowed only to an
   authenticated user and/or who has the appropriate role.
4) Limiting database record operations depending on user role

## Database tables for storing users, credentials, roles, and assignment of a role to users.

You can use the `sql\rbac.sql` script for automatically creating these tables. The generated tables will also contain
sample data for users and roles. User credentials will be given by its email and password and password will be
optionally stored by using md5 or password_hash one-way encryption algorithm. In sample data, all md5 passwords are
equal to "password".  
The figure below shows you the tables diagram:

![System Architecture](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/RBACdb.png)

These tables define the RBAC design will be automatically used by the framework. Specifically, the `framework/User.php`
class will use tables and data for implementing the following methods that you can/must use during the development of
your MVC classes for managing user authentication, login, logout and so on (read comments):

First of all "_getter_" methods:

```php
<?php

    /**
     * Gets user id. The id is the primary key
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
     * @return int The number identifying user role
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
     * @return bool true if login ok, else false
     */
    public function login($email, $password)

    /**
     * Logout user
     *
     * @return bool 
     */
    public function logout()

    /**
     * Checks if user is successful logged in
     *
     * @return bool true if logged in, else false
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
     *                The return link to be used for redirecting if the user is successful 
     *                logged in.
     *                If null it (still) will be the default login page
     * @param null|string $LoginWarningMessage  
     *                A custom warning message to show into the login form after 
     *                unsuccessful login
     *                If null it will be the a default message
     *
     */
    public function checkForLogin($redirect=null, $returnLink=null, $LoginWarningMessage=null)

    /**
     * Auto-login by using Cookies
     *
     * @uses ChiperService
     * It uses ChiperService class to decrypt Cookie
     */
    public function autoLoginFromCookies()

```

If you prefer to define and use your custom tables for storing and managing users and roles you must instruct WebMVC how
to find tables for getting information. In this case, it will be necessary to modify the
file `config/security.config.php` (please read comments)

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
 * Class User uses these information.
 */

/**
 *  Constant for the User MySQL Table
 */
define("USER_TABLE","user");

/**
 *  Defines a constant for INT Primary Key field of the User MySQL Table
 */
define("USER_ID","id_user");

/**
 *  Defines a constant for the UNIQUE email field of the User MySQL Table
 *  Email is used as credential
 */
define("USER_EMAIL","email");

/**
 *  Defines a constant for the password field of the User MySQL Table
 *  Password is used as credential
 */
define("USER_PASSWORD","password");

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