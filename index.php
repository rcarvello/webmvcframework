<?php
/**
 * index.php
 *
 * This file is automatically invoked after every URL request and only when the rewrite
 * conditions defined into the .htaccess file are satisfied
 * It provides the auto loading of classes and the MVC objects creations, by using
 * framework\Loader and framework\Dispatcher classes, depending on the requested URL.
 *
 * Note:
 * You can also use this file as header template for building your own PHP file based script
 * containing code that use Web MVC Framework classes.
 * For this purpose simply comment out each line of code that contain a Dispatcher use.
 *
 * @filesource index.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @copyright (c) 2016-2023 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 *
 */

/* Path of this script */
define ("RELATIVE_PATH", "");
ini_set('display_errors', 1);
/* Enable error reporting and disable notices */
// error_reporting(E_ALL & ~E_NOTICE);
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

/*
  Commons initializations and configurations loading
  Note: To change framework or application setting see the config folder.
*/

header('Content-Type: text/html; charset=utf-8');
include_once(RELATIVE_PATH . "config/framework.config.php");

/* Starting and securing session */
session_start();
session_regenerate_id(true);

/* Use of framework classes */
use framework\Loader;
use framework\Dispatcher;

/* Set classes auto loader simply by instantiating framework Loader */
$loader = new Loader();

/* Create a dispatcher for handling URL request to the appropriate user controller */
$dispatcher = new Dispatcher();
$dispatcher->dispatch();


