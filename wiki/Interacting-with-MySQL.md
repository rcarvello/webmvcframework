## Introduction

WebMVC `framework\Model` extends PHP `\mysqli` class for a native interaction with MySQL. In this page, we will show you
the basic steps for creating and connecting to a MySQL database as well as for the data retrieving.

## WebMVC and MySQL interaction

We can modify the [previous example](https://github.com/rcarvello/webmvcframework/wiki/Model) and retrieve the array of
users and roles from a database. Before we do so, it must be taken into account that:

* WebMVC `framework\Model` extends the PHP `\mysqli` class to interact with MySQL database
* `framework\Model` also provides you with a custom `$sql` attribute, the methods `updateResultSet()`,
  and `getResultSet()` for:
    * `Model->$sql` is a class attribute designed to store any valid SQL statement, e.g a SELECT query, INSERT, UPDATE,
      DELETE, and more.
    * With `Model->updateResultSet() ` you can execute the SQL statement you previously stored in the
      attribute `Model->$sql`
    * With `Model->getResultSet() ` you are able to access the result of the executed SQL statement by means
      of `Model->updateResultSet()`.
      The result can be one of the following:
        * FALSE on failure regarding the execution of the SQL statement
        * for successful SELECT, SHOW, DESCRIBE or EXPLAIN statements (which returning data rows) it returns a
          PHP `\mysqli_result` object. The object will contain some data rows you can fetch by using some specialized
          methods it provides, or better it inherits from parent mysqli class. These methods are (see the \mysqli_result
          full documentation [here](http://php.net/manual/en/class.mysqli-result.php)):
          ```php
              mixed fetch_all()
              mixed fetch_array()
              array fetch_assoc()
              object fetch_field()
              array fetch_fields()
              object fetch_object()
              mixed fetch_row()
          ```

        * for other successful SQL statements (which do not return any data rows) it returns TRUE.
* You can also consume all public methods and attributes provided by the parent PHP `\mysqli` class,
  eg. `mysqli:query()`, `mysqli:real_escape_string`, etc. (see the `mysqli` full
  documentation [here](http://php.net/manual/en/book.mysqli.php)).
* You must configure the file `config\application.config.php`. Specifically, you must modify the constants **DBHOST**, *
  *DBUSER**, **DBPASSWORD**, **DBNAME**, and **DBPORT** according to your MySQL setting.    
  The code belowe shows the section in `config\application.config.php` regarding MySQL configuration:

```php
/**
 * Defines the constants for MySQL database connection parameters.
 */
/**
 *  MySQL Host
 */
define("DBHOST","TOUR_DB_HOST");
/**
 *  MySQL User
 */
define("DBUSER","YOUR_USER");
/**
 * MySQL Password
 */
define("DBPASSWORD","YOUR_PASSWORD");
/**
 *  MySQL Database
 */
define("DBNAME","YOUR_DB_NAME");
/**
 *  MySQL Port
 */
define('DBPORT', '3306');
```

In this example, we modify the `models\NestedBlocks` for enable it to retrieve data from some database tables.
We assume:

* the availability of a relational database schema, named _mvc_wiki_, containing tables and data for managing users and
  roles.
* the availability of a table called _user_ containing the same data of the array `$users` shown in
  the [previous example](https://github.com/rcarvello/webmvcframework/wiki/Model)
* the availability of a table called _application_role_ containing all available application roles that can be assigned
  to a user
* the availability of a table called _users_roles_ containing roles of each user and also reflecting the same roles
  assignment we did in the array `$usersRoles` shown in
  the [example before](https://github.com/rcarvello/webmvcframework/wiki/Model)

The following figure shows the database schema and tables' relationships:

![db_schema](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/wiki_db.png)

> Note that, when we design the database, we use the **snake_case notation** (_lowercase_ and _under_scores_), rather
> the _camelCase_ or _PascalCase_, for naming convention of tables and fields. This convention is widely adopted for MySQL
> design. Furthermore, by adopting this convention, WebMVC will provide you with an ORM engine to handle database tables
> with some specialized classes. We will discuss it later in
> this [page](https://github.com/rcarvello/webmvcframework/wiki/MySQL-ORM).

To build the required DB schema and data you can use the following `mvc_wiki_db.sql` MySQL script:

```sql
-- MySQL Script for mvc_wiki database

-- Temporary disabling DB constraints checking
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Create the schema for a simple database named mvc_wiki
-- -----------------------------------------------------
CREATE DATABASE IF NOT EXISTS `mvc_wiki` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mvc_wiki`;

-- -----------------------------------------------------
-- Create table `user`
-- Stores users information
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(45) NULL,
  `user_email` VARCHAR(100) NULL,
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Create table `application_role`
-- Stores all available application roles 
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `application_role` (
  `role_id` INT NOT NULL AUTO_INCREMENT,
  `role_name` VARCHAR(45) NULL,
  PRIMARY KEY (`role_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Create table `users_roles`
-- Stores users roles 
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users_roles` (
  `user_id` INT NOT NULL,
  `role_id` INT NOT NULL,
  PRIMARY KEY (`user_id`, `role_id`),
  INDEX `fk_user_has_application_role_application_role1_idx` (`role_id` ASC),
  INDEX `fk_user_has_application_role_user_idx` (`user_id` ASC),
  CONSTRAINT `fk_user_has_application_role`
    FOREIGN KEY (`user_id`)
    REFERENCES `user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_application_role_assigned_to_user`
    FOREIGN KEY (`role_id`)
    REFERENCES `application_role` (`role_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- Restoring DB constraints checking
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Sample data for table `user`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `user` (`user_id`, `user_name`, `user_email`) VALUES (1, 'Mark', 'mark@email.com');
INSERT INTO `user` (`user_id`, `user_name`, `user_email`) VALUES (2, 'Elen', 'elen@email.com');
INSERT INTO `user` (`user_id`, `user_name`, `user_email`) VALUES (3, 'John', 'john@email.com');
COMMIT;


-- -----------------------------------------------------
-- Sample data data for table `application_role`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `application_role` (`role_id`, `role_name`) VALUES (5, 'admin');
INSERT INTO `application_role` (`role_id`, `role_name`) VALUES (4, 'webmaster');
INSERT INTO `application_role` (`role_id`, `role_name`) VALUES (3, 'moderator');
INSERT INTO `application_role` (`role_id`, `role_name`) VALUES (2, 'editor');
INSERT INTO `application_role` (`role_id`, `role_name`) VALUES (1, 'user');
COMMIT;


-- -----------------------------------------------------
-- Sample data for table `users_roles`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES (1, 5);
INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES (1, 4);
INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES (1, 3);
INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES (2, 3);
INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES (2, 2);
INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES (2, 1);
INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES (3, 2);
INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES (3, 1);
COMMIT;
```

To create the schema on your MySQL database open a command line prompt and type (be sure the mysql excutable file is in
your PATH):

`mysql -uYOUR_USER -pYOUR_PASSWORD < mvc_wiki_db.sql`

Finally, we can modify the `models\NestedBlocks` by updating `getUsersData()` and `getUsersRoles()` with database access
PHP instructions for retrieving information. Pay attention that we need to returns data retrieved from the DB by using
arrays also having the same formats required by the `views\NestedBlocks`. For example, the format of `$usersRoles` array
must be the following:

![array_format](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/users_roles_array.png)

See the code below for the new version `models\NestedBlocks` by paying attention to comments:

```php
<?php
namespace models;

use framework\Model;

class NestedBlocks extends Model
{

    /**
     * Retrieves users from db
     *
     * @return array|false Array of users in the format:
     *                     array( array('Username'=>'','UserEmai'=>'') )
     *                     Returns false when no data found
     */
    public function getUsersData()
    {
        // Notice: 
        // - We use PHP HereDoc to specify the SQL string
        $this->sql = <<<SQL
        SELECT 
            user_name as UserName,
            user_email as UserEmail
        FROM
            user;
SQL;
        // Run the SQL statement and store the result
        $this->updateResultSet();

        // getResultSet() returns a mysqli_result already with the format
        // array( array('Username'=>'','UserEmai'=>'') )
        return $this->getResultSet();
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
     * Retrieves users' roles from db.
     *
     * @return array|false Array of users roles in the format:
     *                     array(array("UserEmail"=>'',"UserRoles"=>array(r1,r2...,rn)))
     *                     Returns false when no data found
     */
    public function getUsersRoles()
    {

        // Notice: 
        // - We use PHP HereDoc to specify the SQL string
        // 
        // - The SQL below joins tables user and application_role for retrieving
        //   the values for email and role name of each id stored into the
        //   users_roles table.
        $this->sql = <<<SQL
        SELECT 
            user.user_id,
            user.user_email,
            application_role.role_name 
        FROM 
            user 
              JOIN users_roles ON ((user.user_id = users_roles.user_id)) 
                JOIN application_role ON ((users_roles.role_id = application_role.role_id))
        ORDER BY 
            application_role.role_id DESC 
SQL;
        // Run the SQL statement and store the result
        $this->updateResultSet();

        // Gets the results into a variable for processing
        $mySqlResults = $this->getResultSet();

        // Initializing an empty array for storing users roles
        $usersRoles= array();

        if ($mySqlResults) {
            while ($row = $mySqlResults->fetch_array()) {
                $userId=$row["user_id"];
                $userEmail=$row["user_email"];
                $userRoleName=$row["role_name"];
                
                // Adds email to $usersRoles array
                $usersRoles[$userId]["UserEmail"]=$userEmail;

                // Adds role to $usersRoles array
                $usersRoles[$userId]["UserRoles"][] = $userRoleName;
            }
        }
        return !empty($usersRoles)? $usersRoles : false;
    }

}
```

So we can run once again `controllers\Nested Blocks` by typing `http://localhost/nested_blocks` to obtain the same
result we shown on the [previous page](https://github.com/rcarvello/webmvcframework/wiki/Model), but now by having data
provided by MySQL:

![Model](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/nested_blocks04.png)

> Note that we don't need any updates on the Controller, View, and Template. This is the main purpose of MVC design,
> that is to separate the computational tasks in different layers also avoiding that, making a change on a layer, involves
> the need to update the others.

## Summary

By understanding how to interacting with MySQL we are now potentially ready to build a web application. We finally,
described all the steps needed to design and run a **MVC instance** which provide a dynamic web page. They are:

* create a Model class interacting with the database and fetching data, to be used within the View
* create a View class linking it to a Template file which provides the static design of a web page.
* replace a value, provided by the Model, to a Placeholder within the Template
* define, within the Template, a Block of static content, that must be dynamically replaced, for example with a list of
  values provided by the Model
* create a Controller for managing and linking Model and View
* run a Controller and/or its public Methods calling them from the URL

Pay also attention to the flow of operations when you run an MVC Instance with WebMVC:

1. The URL calls a Controller or one of its Method (either with or without parameters)
2. The Controller links and retrieves data from the Model
3. The Controller links the View
4. The View loads the static design from the Template
5. The data retrieved from the Model are sent to the View by the Controller
6. The View organizes the data for the presentation and generates the output.
7. Finally, the Controller fetches the output from the View and sends back it to the user.

Note that, in the flow above, we intentionally omitted to describe Loader and Dispatcher actions because they are
automatically executed by WebMVC

The following figure gives a graphical representation of these points:

![mvc mysql summary](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/request-handling-in-webmvc-mysql.png)

## Whats next

In the [next page](https://github.com/rcarvello/webmvcframework/wiki/MySQL-ORM), we show you how to INSERT, UPDATE, and
DELETE data from a database by using the WEB MVC ORM Engine. 