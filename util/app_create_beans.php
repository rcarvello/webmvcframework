<?php
/**
 *  Demo application: generate classes from a mysql db schema
 */
error_reporting(E_ALL);
include_once("mysqlreflection/mysqlreflection.config.php");

header('Content-Type: text/html; charset=utf-8');

echo "Building classes for mysql schema: <b>" . DBNAME . "</b><hr>";

// Destination path for the generated classes
$destinationPath = dirname(__FILE__) . "/../models/beans/";
// $destinationPath = "source/";

// Create reflection object and invoke classes generation from the specified schema into mysql_connection.inc.php
$reflection = new MVCMySqlSchemaReflection();

// Generates the classes into the given path. During the generation it outputs the results.
$reflection->generateClassesFromSchema($destinationPath);

echo "<hr>Done.";
echo "<script> window.scrollTo(0,document.body.scrollHeight);</script>";