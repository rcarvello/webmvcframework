<?php

/**
 * route.php
 * Routing for PHP built-in web server
 *
 * Example (windows):
 * php -c "C:\PHP_INSTALL_DIR\php.ini" -S localhost:8000 "C:\PATH_OF_WEBMVCFRAMEWORK\route.php" -t "C:\PATH_OF_WEBMVCFRAMEWORK"
 * (for Linux or Mac replace path)
 *
 * Usage example of route.php is inside mvc_bootstrap.bat batch script
 *
 * This file implements HTTP routing when using PHP built in web server instead of Apache HTTP server.
 * It can detect both application or content centric HTTP request.
 * 1) When application centric:
 *      It provides the autoloading features of classes and the MVC objects creations, by using
 *      framework\Loader and framework\Dispatcher classes (depending on the requested URL).
 * 2) When content centric:
 *      Just serve the content of requested resource (or execute a standard php file)
 *
 * @filesource index.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @copyright (c) 2016-2023 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */


// Enable error reporting. Optionally disable notices by replacing with: error_reporting(E_ALL & ~E_DEPRECATED)
error_reporting(E_ALL);

// Only when using PHP built-in web server
chdir(__DIR__);

// Console Output
$green = "\033[32m";
$yellow = "\033[33m";
$cyan = "\033[36m";
$red = "\033[31m";
$blue = "\033[34m";
$reset = "\033[0m";

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$time = date('Y-m-d H:i:s');

file_put_contents('php://stdout', "\033[33m $time \033[36m $method  \033[32m $uri \033[0m \n");

// Parse the request
$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$filePath = ltrim($url_path, '/');

// If request is an existing physical resource handle it with the server (CONTENT CENTRIC REQUEST)
if ($filePath && is_file($filePath)) {
    return false;

}
// If no physical resource is requested then is a virtual resource to be managed by the Framework (APPLICATION CENTRIC REQUEST)

// Set path CONSTANT (required by the Framework)
define("RELATIVE_PATH", "");

// Common initializations and configurations loading
// Note: for changing framework or application setting see config folder.
header('Content-Type: text/html; charset=utf-8');

// Load Framework main configuration
include_once RELATIVE_PATH . "config/framework.config.php";

// Starting and securing session
session_start();
session_regenerate_id();

// Set url variable (required by th Framework)
$_GET['url'] = ltrim($url_path, '/');

// Use of Framework classes for handling request
use framework\Dispatcher;
use framework\Loader;

// Set classes autoloader simply by instantiating the framework Loader
$loader = new Loader();

// Create a Dispatcher to dispatch URL request to the appropriate user controller
$dispatcher = new Dispatcher();
$dispatcher->dispatch();
