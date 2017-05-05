<?php
/**
 * Demo usage of the generated class SaleAgent
 */
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');
include_once("mysqlreflection/mysqlreflection.config.php");

include_once("../framework/Bean.php");
include_once("../framework/Model.php");
include_once("../framework/MySqlRecord.php");
include_once("../models/beans/BeanSinglePkDate.php");

// Insert a new user and gets the id

$bean = new \models\beans\BeanSinglePkDate();


$result = addTuple($bean);
showBeanOperationResult("INSERT",$bean,$bean->affected_rows,false);
$lastInserted = $bean->getIdDate();
echo $lastInserted . " last inserted<br>";
$bean->close();

// Select  previously inserted user
$bean = new \models\beans\BeanSinglePkDate($lastInserted);
showBeanOperationResult("SELECT",$bean,$bean->affected_rows);
$bean->close();

// Update previously inserted user
// $bean = new \models\beans\BeanSinglePkDate("Intentional error");
$bean = new \models\beans\BeanSinglePkDate($lastInserted);
$bean->setFieldDate("10/10/1900");
$bean->setFieldDecimal(11.20);
$bean->setFieldInt(100);
$bean->setFieldString("String nuova");
$bean->setFieldText("Long string nuova");
$result = $bean->updateCurrent();
showBeanOperationResult("UPDATE",$bean,$result,true);
$bean->close();

// Delete previously updated user
$bean = new \models\beans\BeanSinglePkDate($lastInserted);
$result = $bean->delete($lastInserted);
showBeanOperationResult("DELETE",$bean,$result);
$bean->close();

// Select after deletion after deletion
$bean = new \models\beans\BeanSinglePkDate($lastInserted);
showBeanOperationResult("SELECT AFTER DELETION",$bean,$bean->affected_rows);
$bean->close();

/**
 * Support functions
 */

/**
 * Show Sale beab information and the MySQLi result for the current object operation
 * @param string $operation the class operation
 * @param mixed $bean current object
 * @param mysqli $result the mysql result for the operation
 * @param bool $ddl if true show the DDL
 */
function showBeanOperationResult($operation, \models\beans\BeanSinglePkDate $bean,$result,$ddl = false)
{
    echo "BEGIN application operation: $operation<br>";
    showBean($bean,$operation,$ddl);
    showMySqlResult($result);
    echo "END application operation: $operation <br><br><br>";
}

/**
 * Shows some information about current sales agent object
 * @param mixed $bean
 * @param string $operation the class operation
 * @param bool $showDdl
 */
function showBean(\models\beans\BeanSinglePkDate $bean = null, $operation, $showDdl = false)
{
    // If no errors
    if ($bean && !$bean->isSqlError()) {
        echo "<br>";
        echo "<b>Bean information:</b>:<hr>";
        echo "field_id          :   {$bean->getIdDate()}<br>";
        echo "field_date          : {$bean->getFieldDate()}<br>";
        echo "field_date_time     : {$bean->getFieldDateTime()}<br>";
        echo "field_int           : {$bean->getFieldInt()}<br>";
        echo "field_decimal       : {$bean->getFieldDecimal()}<br>";
        echo "field_string        : {$bean->getFieldString()}<br>";
        echo "field_text          : {$bean->getFieldText()}<br>";
        echo "<br>";
        // Shows sql statements
        echo "<div style='background: lightgrey'>";
        echo "<sup>Executed SQL statemtent:</sup><br>";
        echo $bean->lastSql() . "<br>";
        echo "</div>";
    }

    // If errors
    if ($bean && $bean->isSqlError()) {
        echo "<br>";
        echo "<b>Error Unable to show bean object information:</b>";
        echo "<hr>";
        echo "<div style='background:indianred'>";
        echo "Error:" . $bean->lastSqlError();
        echo "<br>";
        echo $bean->lastSql();
        echo "</div>";
    }

    // If DDL info requested and no error
    if ($bean && $showDdl){
        echo "<br>";
        echo "<br><sup>You requested to see DDL information:</sup><br>";
        echo "<div style='background: yellowgreen'>";
        echo "<pre>";
        echo $bean->getDdl();
        echo "</pre>";
        echo "</div>";
    }

}


/**
 * Show MySql Result
 * @param mixed MySql $result
 */
function showMySqlResult($result){
    echo "<br>";
    echo "<div style='background: lightcyan'>";
    echo "<sup>MySQL result for operation:</sup>";
    var_dump($result);
    echo "</div>";
}


/**
 * Sets sales agent object properties.Then runs insert to add object into mysql table
 * @param SaleAgent $user
 */
function addTuple(\models\beans\BeanSinglePkDate $bean)
{
    $bean->setIdDate("10/10/1950");
    $bean->setFieldDate("10/10/1951");
    $bean->setFieldDateTime("10/10/1952 10:11:12");
    $bean->setFieldInt(100);
    $bean->setFieldDecimal(100.30);
    $bean->setFieldString('Dell\'era è à');
    $bean->setFieldText("Stringa apo'strofata e accentatà");
    $result = $bean->insert();
    return $result;
}


/**
 * Sets sales agent object properties.Then runs insert to add object into mysql table
 */
function addTuple2(\framework\BeanAdapter $adapter)
{
    $bean = $adapter->getBean();
    $bean->setIdDate("10/10/1950");
    $bean->setFieldDate("10/10/1951");
    $bean->setFieldDateTime("10/10/1952 10:11:12");
    $bean->setFieldInt(100);
    $bean->setFieldDecimal(100.30);
    $bean->setFieldString("Strimg à");
    $bean->setFieldText("String à è ì");
    $result = $adapter->insert();
    return $result;
}