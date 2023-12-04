## Introduction

This section provides you with basic information for download, setup and configure WebMVC framework.

## Software requirements

In order to develop using WebMVC framework you need:

* Operating System: Linux, Mac or Windows
* Server: Apache web server with mod_rewrite enabled
* Database: MySQL (from 5.0 to the latest version)
* Programming language: PHP (from 5.3 to the latest version) with DOM, MySQLi and GD extensions enabled

## Skills requirements

The technical skills you need for developing with WebMVC are:

* Good knowledge of PHP programming language and OOP
* Basic knowledge of HTML, JavaScript, and CSS
* Basic knowledge of MySQL database

## Setup and configuration

To install the framework:

1. [Download](https://github.com/rcarvello/webmvcframework/archive/master.zip) it from Github
2. Create a project folder in the root folder of your web server
3. Copy all the directories downloaded from Github into the project folder
4. Run `sql/mrp.sql` to install database sample tables. See the comments inside `sql/mrp.sql` to see default users and
   passwords
5. Go into the project folder and modify the following lines of `config/application.config.php` according to your MySQL
   database and Apache Web Server configuration

```php
/**
 *  MySQL User
 */
define("DBUSER","PUT_YOUR_USERNAME");

/**
 * MySQL Password
 */
define("DBPASSWORD","PUT_YOUR_PASSWORD");

/**
 *  MySQL Database
 */
define("DBNAME","PUT_YOUR_DB_NAME");

/**
 *  MySQL Port
 */
define('DBPORT', '3306');

/**
 * Defines a constant for site URL
 * @note without the ending slash
 * @example: http://localhost/webmvc
 */
define("SITEURL","http://PUT_YOUR_HOST/PUT_YOUR_WEB_FOLDER");

/**
 * Defines a constant for indicating the default login controller
 * You can use URL notation for specifying your custom Controller
 */
define("DEFAULT_LOGIN_PAGE", "common/login");

/**
 *  Instructs framework if MySQL uses FULL_GROUP_BY SQL mode.
 *  On MySQL > 5.7  FULL_GROUP_BY is enabled by default.
 *  When MySQL FULL_GROUP_BY is ON set this constant to true
 *  else false.
 *  Note: 
 *  FULL_GROUP_BY ON reduces the Paginator component performances.
 *  So is highly recommended to configure your MySQL and set it 
 *  to OFF.
 */
define ("MYSQL_MODE_FULL_GROUP_BY",false);

.......


/**
 * Defines a constant for a temporary folder
 */
define("APP_TEMP_PATH", "D:\\gitmvc\\temp");
```

Finally, make sure you set it properly Apache configuration for enabling mod_rewrite.
Look [here](https://github.com/rcarvello/webmvcframework/wiki/Configuring-apache-mod-rewrite) for details

## Whats next

In the next section, we show you how to configure
some [advanced option](https://github.com/rcarvello/webmvcframework/wiki/Advanced-configuration). Alternatively, you can
start understanding [how WebMVC works](https://github.com/rcarvello/webmvcframework/wiki/Understanding-WebMVC).