<?php
/**
 * security.config.php
 *
 * Main application security configuration parameters.
 * You can change those values according to your security
 * MySQL environment or Chiper preferences
 *
 * @filesource security.config.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
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
 *  User enable can temporary disable users. Values must be 1 or -1
 */

define('USER_ENABLED', 'enabled');

/**
 * Defines the constants for Cookie Chiper
 */

/**
 *  Chiper SALT
 */
define('CHIPER_CREDENTIALS_COOKIE_SALT','8454fBh9c%=%bg3766GTDg7FD');

/**
 *  Chiper credentials cookie expiration c (2592000 secs = 30 days)
 */
define('CHIPER_CREDENTIALS_COOKIE_EXPIRATION_DATE',2592000);

/**
 *  Slides credentials cookie expiration date if true
 */
define('CHIPER_CREDENTIALS_COOKIE_SLIDING_EXPIRATION',true);

/**
 *  Credentials cookie name
 */
define('CHIPER_CREDENTIALS_COOKIE_NAME','PDCredentials');

/*
 *  Constant for login warning message of common/Login controller when
 *  user is not logged in and page requires authentication.
 *  Note: It appears when is set the $_GET["login_warning_message"] and is
 *  automatically translated by the Locale engine by using Login controller
 *  translation file
 */
define("LoginAuthWarningMessage", "{RES:LoginAuthWarningMessage}");

/*
 *  Constant for login warning message of common/Login controller
 *  when page requires authentication, user is logged but his
 *  role is not granted.
 *  Note: It appears when is set the $_GET["login_warning_message"] and is
 *  automatically translated by the Locale engine by using Login controller
 *  translation file
 *
 */
define("LoginRBACWarningMessage", "{RES:LoginRBACWarningMessage}");


/**
 * Securing session cookie
 */
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_lifetime ', 0);
ini_set('session.cookie_secure', isset($_SERVER["HTTPS"]));
ini_set('session.name','WEBMVCFramework');


/* TODO  Add XSS and HTMLPURIFIER */

/**
 * Securing file access.
 * Specifies a path, outside HTTP access, where framework and application classes
 * could be located. In this way, you can protect directory access from HTTP.
 * Note: if it's value is null all framework files and classes must be located
 * inside the same application directory (anythings is potentially accessible from HTTP).
 *
 * Setting example:
 *
 *    define ("SECURING_OUTSIDE_HTTP_FOLDER","C:/Wamp/Apache2.2/mvcout_framework/");
 *
 * If you set SECURING_OUTSIDE_HTTP_FOLDER you also must set RELATIVE_PATH inside
 * index.php
 *
 * For example:
 *
 *    define ("RELATIVE_PATH", "C:/Wamp/Apache2.2/mvcout_framework/");
 *
 *
 *
 * WARNING: When using SECURING_OUTSIDE_HTTP_FOLDER you must to separate files and
 * directors in this way;
 *
 * PATH NOT ACCESSIBLE FROM HTTP                PATH ACCESSIBLE FROM HTTP
 * =============================                =========================
 * classes                                      css
 * config                                       js
 * framework                                    framework/js
 * controllers                                  util (only if you want to run builders)
 * models                                       temp (a temporary folder)
 * views                                        index.php
 * templates                                    .htaccess
 * locales
 *
 */
define ("SECURING_OUTSIDE_HTTP_FOLDER","");
