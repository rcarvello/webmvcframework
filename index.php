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

