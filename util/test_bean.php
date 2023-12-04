<?php
/**
 * Usage demo of the generated class
 */
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');
include_once("mysqlreflection/mysqlreflection.config.php");

include_once("../framework/Bean.php");
include_once("../framework/Model.php");
include_once("../framework/MySqlRecord.php");
include_once("../models/beans/BeanCategory.php");

// Insert a new user and gets the id

$bean = new \models\beans\BeanCategory();
$bean->query("DELETE FROM category WHERE category_id>3");

// #
$bean->setCategoryName("Caffè aromati");
$bean->insert();
$bean->setCategoryName("Caffè all'anice");
$bean->updateCurrent();
var_dump($bean->successLast());

// ##
$bean->setCategoryName("Caffè aromati");
$bean->setListOrder(1);
$bean->insert();
var_dump($bean->successLast());

/* Resulting table
    1,Computer,1
    2,Memory,3
    3,Monitor,2
    #,Caffè all'anice,
   ##,Caffè aromati,1
 */
