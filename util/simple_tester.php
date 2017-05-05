<?php
/**
 *  Demo application: generate classes from a mysql db schema
 */
error_reporting(E_ALL);
include_once("mysqlreflection/mysqlreflection.config.php");

header('Content-Type: text/html; charset=utf-8');

$a = new MVCMySqlPKAnalyzer();
$a->analyze("multiple_pk");

/*
echo "<pre>";
echo $a->getPKWhereCondition();
echo $a->getPKDMLFunctionParameters();
echo "</pre>";
if ($a->hasCompositePK()) echo "si";
*/


/*
$ar = array(1,2);




interface myI {
        public function test($a);
}


class One implements myI
{

    public function test($a)
    {
        list($a, $b) = func_get_args();
        echo $a;
        echo $b;
    }
}
*/


$components = array();
$components[] = "Controller:";
$components[] = "Record:";
$components[] = "RES:";
$components[] = "Sorter:";
$components[] = "Paginator:";
$components[] = "SorterBootstrap:";
$components[] = "PaginatorBootstrap:";
$components[] = ":";
$comp = json_encode($components);
$placeHolder = "Paginators_Pippo";
foreach ($components as $component) {
    //if (strstr($string, $url)) { // mine version
    if (strpos($placeHolder, $component) !== FALSE) { // Yoshi version
        echo "Match found";
        return true;
    }
}



