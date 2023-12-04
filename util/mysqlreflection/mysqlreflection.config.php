<?php
/**
 * Defines the constants for MySQL database connection parameters.

define("DBHOST","YOUR_HOST");
define("DBUSER","YOUR_USER");
define("DBPASSWORD","YPUR_PASSWORD");
define("DBNAME","YOUR_DB");
define('DBPORT', '3306');
 */

define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASSWORD", "letmysql");
define("DBNAME", "mrp");
define('DBPORT', '3306');

/**
 * Date formats:
 * @note HTML5 date format is like 2016/01/20 - aaaa/mm/dd
 */

/**
 * Defines a constant for the transformation of the date format of all
 * date fields fetched from mysql tables
 * You may change this value according to your language format.
 * For more information read the MySQL specifications for date format
 * Most used  format: define("FETCHED_DATE_FORMAT","d/m/Y");
 */
define("FETCHED_DATE_FORMAT","d/m/Y");
// define("FETCHED_DATE_FORMAT","Y-m-d");

/**
 * Defines a constant for the transformation of the datetime format of all
 * datetime fields fetched from mysql tables.
 * You may change this value according to your language format.
 * For more information read the MySQL specifications for date format
 * Most used format: define("FETCHED_DATETIME_FORMAT","d/m/Y H:i:s");
 *
 */
define("FETCHED_DATETIME_FORMAT","d/m/Y H:i:s");
// define("FETCHED_DATETIME_FORMAT","Y-m-d H:i:s");

/**
 * Defines a constant for interpreting of dates format used into all the
 * SQL statements for inserting or updating mysql date fields.
 * You may change this value according to your language format.
 * For more information read the MySQL specifications for date format
 * Most used format: define("STORED_DATE_FORMAT","%d/%m/%Y");
 */
define("STORED_DATE_FORMAT","%d/%m/%Y");
// define("STORED_DATE_FORMAT","%Y-%m-%d");

/**
 * Defines a constant for interpreting of datetime format used into all the
 * SQL statements for inserting or updating mysql datetime fields.
 * You may change this value according to your language format.
 * For more information read the MySQL specifications for date format
 * Most used format: define("STORED_DATETIME_FORMAT","%d/%m/%Y %H:%i:%s");
 */
define("STORED_DATETIME_FORMAT","%d/%m/%Y %H:%i:%s");
// define("STORED_DATETIME_FORMAT","%Y-%m-%d %H:%i:%s");

/**
 * Defines lenght of subustring for MVCMySqlTableReflection::buildUptateFileldsEqualValues()
 * Linux=-6, Wndows =-7
 */

if (isWindows()) {
    define("PHP_EOL_SUBSTRING_LENGHT", -7);
} else {
    define("PHP_EOL_SUBSTRING_LENGHT", -6);
}
/**
 * Defines the author name
 */
define ("AUTHOR_NAME","Rosario Carvello");

/**
 * Defines the author email
 */
define ("AUTHOR_EMAIL","rosario.carvello@gmail.com");

/**
 * Defines the package name
 */
define ("PACKAGE_NAME","models/bean");

/**
 * Defines the package version
 */
define ("PACKAGE_VERSION","v1.0.0");

/**
 * Defines the class parent for the generated classes
 */
define ("CLASS_PARENT","MySqlRecord");

/**
 * Defines the interface that a generated class implements
 */
define ("CLASS_IMPLEMENTS","Bean");

/**
 *  Inludes
 */
include_once("mysqlreflection/MVCMySqlSchemaReflection.php");
include_once("mysqlreflection/MVCMySqlTableReflection.php");
include_once("mysqlreflection/MVCMySqlFieldToAttributeReflection.php");
include_once("mysqlreflection/MVCMySqlBeanBuilder.php");
include_once("mysqlreflection/MVCMySqlSimpleTemplate.php");
include_once("mysqlreflection/MVCMySqlPKAnalyzer.php");


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
