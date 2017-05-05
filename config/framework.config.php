<?php
/**
 * framework.config.php
 *
 * Main framework configuration parameters.
 * Usually you don't need to change those value.
 *
 * @filesource framework.config.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

/**
 *  Basic initialization
 */
require_once(RELATIVE_PATH . "framework/Loader.php");
use framework\Loader;

/**
 * Defines a constant for compressing HTML output
 */
define("COMPRESS_OUTPUT", false);

/**
 * Defines a constant for folder path of applications controllers
 */
define("APP_CONTROLLERS_PATH", RELATIVE_PATH . "controllers");

/**
 * Defines a constant for folder path of applications models
 */
define("APP_MODELS_PATH", RELATIVE_PATH . "models");

/**
 * Defines a constant for folder path of applications views
 */
define("APP_VIEWS_PATH", RELATIVE_PATH . "views");

/**
 * Defines a constant for folder path of applications templates
 */
define("APP_TEMPLATES_PATH", RELATIVE_PATH . "templates");

/**
 * Defines a constant for folder path of applications templates
 */
// define("APP_LOCALES_PATH", "locales");

/**
 * Defines a constant for path of JavaScript frameworks files
 */
define("JSFRAMEWORK","framework/js/");

/**
 * Defines a constant for framework's classes directories
 */
define("CLASSES", serialize(array("framework", "framework/exceptions", APP_CONTROLLERS_PATH, APP_VIEWS_PATH, APP_MODELS_PATH, APP_MODELS_PATH . "/beans", "util/mysqlreflection")));

/**
 * Defines a constant for application's subsystems directories
 */
define ("SUBSYSTEMS",serialize(Loader::listFolders(APP_CONTROLLERS_PATH)));



/**
 * Includes Security configuration parameters.
 */
include_once(RELATIVE_PATH . "config/security.config.php");

/**
 * Includes Security configuration parameters.
 */
include_once(RELATIVE_PATH . "config/locale.config.php");


/**
 * Includes Application configuration parameters.
 */
include_once(RELATIVE_PATH . "config/application.config.php");


/**
 * Auto generated Constants.
 * Do not change any lines in the sections below.
 */

/**
 * Define server OS Encoding. Values are Windows or Linux
 */
if  (isWindows()) {
    define("SERVER_OS_ENCODING", "Windows");
} else {
    define("SERVER_OS_ENCODING", "Linux");
}


/**
 * Return true if Linux
 * @return bool
 */
function IsLinux() {
    return (stristr(PHP_OS, 'linux') !== false);
}

/**
 * Return true if Windows
 * @return bool
 */
function  IsWindows() {
    return (stristr(PHP_OS, 'winnt')!==false || stristr(PHP_OS, 'win32')!==false);
}