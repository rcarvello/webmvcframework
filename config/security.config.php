<?php
/**
 * security.config.php
 *
 * Main application security configuration parameters.
 * You can change these values according to your security
 * MySQL environment or for the Chiper preferences
 *
 * @filesource security.config.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

/**
 * Defines all constants for qualifying MySQL User table.
 * The framework built-in class User uses these information.
 */

/**
 *  Constant representing the User MySQL Table name
 */
define("USER_TABLE","user");

/**
 *  Constant representing the (mandatory integer) primary key field
 *  used to identify a user
 */
define("USER_ID","id_user");

/**
 *  Defines a constant representing (mandatory unique) EMAIL field name.
 *  Note: Email is required as user Login name
 */
define("USER_EMAIL","email");

/**
 *  Defines a constant representing the PASSWORD field name.
 *  Note: password is used during login process
 */
define("USER_PASSWORD","password");

/**
 *  Defines a constant representing the (mandatory integer) ROLE field used
 *  for grouping users that must have the same access level rights
 *  on controllers.
 *  Note: The framework R.B.A.C. (Role Based Access Control) Engine can
 *  grant access to one ore more roles on controllers execution
 *
 */
define('USER_ROLE', 'id_access_level');

/**
 *  Defines a constant representing the SALT field.
 *  Salt is used for user password encryption. Leave it blank If you
 *  don't like to use it and using a system default one.
 */
define('USER_SALT', 'salt');

/**
 *  Defines a constant representing  the (mandatory integer) USER_ENABLED
 *  field used as flag for enabling/disabling user.
 *  Only enabled users are able to authenticate and login on the system.
 *  If you don't like to manage this capabilities leave blank this value.
 *  The value that this field can assume are only:
 *     1 (for enabling a user to authentication)
 *     or
 *    -1 (for temporary disabling user).
 */
define('USER_ENABLED', 'enabled');

/**
 *  Defines a constant for identifying administrators role vale
 *  Note: Framework need to known the value you want use for identifying
 *  administrators role. So it can automatically assign
 *  administration rights
 */
define('ADMIN_ROLE_ID', 100);

/*
 Below is an example to create the MySQL table previously defined:

    -- Tables:

    DROP TABLE IF EXISTS `access_level`;
    CREATE TABLE IF NOT EXISTS `access_level` (
      `id_access_level` int(11) NOT NULL,
      `name` varchar(45) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Access levels';

    DROP TABLE IF EXISTS `user`;
    CREATE TABLE IF NOT EXISTS `user` (
      `id_user` int(11) NOT NULL,
      `id_access_level` int(11) NOT NULL,
      `full_name` varchar(45) NOT NULL,
      `email` varchar(100) NOT NULL,
      `password` varchar(200) NOT NULL,
      `salt` varchar(256) NOT NULL,
      `enabled` int(11) NOT NULL DEFAULT '1'
    ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Users credentials';

    -- Simple data. WARNING: All users password are = 'password`:

    INSERT INTO `access_level` (`id_access_level`, `name`) VALUES
    (50, 'user'),
    (60, 'manager'),
    (100, 'admin');

    INSERT INTO `user` (`id_user`, `id_access_level`, `full_name`, `email`, `password`, `salt`, `enabled`) VALUES
    (1, 100, 'The admin, 'rosario.carvello@gmail.com', 'c0c7e179876ffce487a8f0494795d310782afd5f639beb897f3fe74b5d493136e1958c4d82b06003a0f1c4f92b0b2bd38be6709ada6d9892e415df11a4b25a78', '7944735265b159264b47d83.57046201', 1),
    (2, 60, 'Manager', 'manager@email.it', '035432d6f1a769b653123a24d3273494fc2b79bf525a481020dc7c446cdfec2af5c42669b8ec77d1796f5df0e29ab502b63600cb15bb110e385699d21ccd2de8', '21120102305b159287d7fee8.43527519', 1),
    (3, 50, 'User', 'user@email.it', 'a1b6028feed6dadcff553d2336ee34bf96545ccb357ba46b3a4fbb758b990f2be4dad006aa2f187b37e414343f6aa06feeff178b77f19ba087c5f41be1b9e550', '202125205b1592980029f9.55802183', 1);

    -- Indexes, primary and foreign key , limits:

    ALTER TABLE `access_level`
     ADD PRIMARY KEY (`id_access_level`);

    ALTER TABLE `user`
     ADD PRIMARY KEY (`id_user`), ADD UNIQUE KEY `unique_email` (`email`), ADD KEY `fk_user_access_level_idx` (`id_access_level`), ADD KEY `idx_full_name` (`full_name`);

    ALTER TABLE `user`
    ADD CONSTRAINT `fk_user_access_level1` FOREIGN KEY (`id_access_level`) REFERENCES `access_level` (`id_access_level`) ON DELETE NO ACTION ON UPDATE NO ACTION;

    ALTER TABLE `user`
    MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;

 */



/**
 * Defines the constants for Cookie Chiper
 */

/**
 *  Defines a constant for setting cryptography algo used by Chiper.
 *  Value must be one of the following:
 *      md5
 *      sha1
 *      sha256
 *      sha384
 *      sha512
 */
define('CRYPT_ALGO', 'sha512');

/**
 *  System Chiper SALT
 *  Used for Cookies. It is also the default used for password
 *  when no user salt was defined
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
define('CHIPER_CREDENTIALS_COOKIE_NAME', 'AppCredentials');

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
 */
define("LoginRBACWarningMessage", "{RES:LoginRBACWarningMessage}");

/**
 * Securing PHP session and cookies
 */
// session.entropy_file = "/dev/urandom" (better entropy source)
ini_set('session.use_strict_mode', 1);
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_lifetime ', 0);
ini_set('session.cookie_secure', isset($_SERVER["HTTPS"]));
ini_set('session.name','WEBMVCFramework');

/**
 * Securing XSS
 * Specifies if automatically securing output data against XSS
 */
define("XSS_PROTECTION", true);

/**
 *  Specifies XSS protection by using external HTMLPURIFIER library
 */
define("USE_HTMLPURIFIER", false);

if (XSS_PROTECTION) {
    if (USE_HTMLPURIFIER) {
        require_once(RELATIVE_PATH . 'framework/htmlpurifier/HTMLPurifier.auto.php');
    }
}

/**
 * Securing forms
 * Specifies csrftoken token fields for Record Component
 */

define("CSRF_TOKEN_FORM_FIELD", "csrftoken");


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
