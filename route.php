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
 * @copyright (c) 2016-2025 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
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

try {
    // Set classes autoloader simply by instantiating the framework Loader
    $loader = new Loader();

    // Create a Dispatcher to dispatch URL request to the appropriate user controller
    $dispatcher = new Dispatcher();
    $dispatcher->dispatch();

} catch (\Throwable $th) {

    //throw throwable;
    printCatch($th);
} catch (Exception $e) {

    //throw exception;
    printCatch($e);
}


function printCatch($e)
{
    $html = <<<HTML
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>PHP Error</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap 5 CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <div class="container">
        <body class="bg-white text-light">
            <div class="container py-5">
                <div class="alert bg-dark shadow-lg">
                    <h1 class="display-5 fw-bold text-danger">
                        <i class="bi bi-bug-fill"></i> Error!
                    </h1>
                    <hr class="border-light">
                    <p>
                        <span class="badge bg-warning text-dark">File</span>
                        <code class="h3">{$e->getFile()}</code>
                    </p>
                    <p>
                        <span class="badge bg-info text-dark">Line</span>
                        <code class="h2" >{$e->getLine()}</code>
                    </p>
                    <hr>
                    <p class="lead text-light">
                        <span class="badge bg-danger text-dark">Error info</span><br>
                        <code class="text-warning h2">{$e->getMessage()}</code>
                    </p>
                    <button class="btn btn-outline-light mt-3" onclick="location.reload()">🔁 Reload page</button>
                </div>
            </div>
            <div class="alert bg-dark shadow-lg">
                <div class="text-center text-yellow bg-dark"> 
                    PHP WEB MVC Framework - [ 
                    <a href="https://github.com/rcarvello/webmvcframework/wiki">Wiki Pages</a> | 
                    <a href="https://github.com/rcarvello/webmvcframework">GitHub</a> ]
                </div>
        </body>
    </div>
    </html>
HTML;
    echo $html;
}
