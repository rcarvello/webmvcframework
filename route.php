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
 * It provides the auto-loading of classes and the MVC objects creations, by using
 * framework\Loader and framework\Dispatcher classes, depending on the requested URL.
 *
 *
 * @filesource index.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @copyright (c) 2016-2023 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */


// Enable error reporting and disable notices
// error_reporting(E_ALL & ~E_DEPRECATED);
error_reporting(E_ALL);

// Only when using PHP built in web server
chdir(__DIR__);
$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$filePath = ltrim($url_path, '/');

// First check if request is regarding a physical resource
if ($filePath && is_file($filePath)) {
    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
    // if is .php file include it and run
    if (strtoupper($ext) == 'php') {
        $current_path = dirname($filePath);
        chdir($current_path);
        include_once $filePath;
    // else (is not a .php file, for example .css, .js and more) echoing it
    } else {
        $extensions = array (
            "js"=>"text/javascript",
            "css"=>"text/css",
            "json"=>"text/json",
            "xml"=>"text/xml");
        $content = file_get_contents($filePath);
        $contentTypeExt = array_key_exists($ext,$extensions) ? $extensions[$ext]: "text/html";
        header('Content-Type: '.$contentTypeExt);
        echo $content;
    }
    // no virtual request need to be processed so exiting the route execution
    exit;
}
// If no physical resource is requested then assuming to request a virtual resource

// Set path CONSTANT (required by framework)
define("RELATIVE_PATH", "");

// Commons initializations and configurations loading
// Note: for changing framework or application setting see config folder.
header('Content-Type: text/html; charset=utf-8');

// Load Framework main configuration
include_once RELATIVE_PATH . "config/framework.config.php";

// Starting and securing session
session_start();
session_regenerate_id();

// Set url variable (required by framework)
$_GET['url'] = ltrim($url_path, '/');

// Use of framework classes for handling request
use framework\Dispatcher;
use framework\Loader;

// Set classes autoloader simply by instantiating framework Loader
$loader = new Loader();

// Create a Dispatcher to dispatch URL request to the appropriate user controller
$dispatcher = new Dispatcher();
$dispatcher->dispatch();

