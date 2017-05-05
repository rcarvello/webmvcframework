<?php
/**
 * MVCMySqlSchemaReflection
 * Reflection class for a given MySQL database schema.
 * Responsability:
 *
 *  - fetch all tables from the given MySQL schema
 *  - process each table with MVCMySqlTableReflection to extract table information
 *
 * @extends mysqli
 * @filesource MVCMySqlSchemaReflection.php
 * @category Framework Utility
 * @package \MySqlBeanGenerationEngine
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version CVS: v1.0.0
 * @uses file mysql_connection_inc.php
 * @uses class MVCMySqlTableReflection
 * @example app_create_beans.php
 * @note This class is extracted from my personal MVC Framework.
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved .  See License.txt file
 * @license BSD
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD Public License.
 */
class MVCMySqlSchemaReflection extends  mysqli
{
    public $totalTables=0;
    /**
     * Constructor
     */
    public function __construct()
    {
        // $currentErrorLevel = error_reporting();
        // error_reporting(0);
        $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        if ($this->connect_errno) {
            printf("Connection failed. Modify MySQL connection settings into <b>mysql_connection.inc.php</b> file.");
            exit();
        }
        // error_reporting($currentErrorLevel);
    }

    /**
     * generateClassesFromSchema()
     * Generates the PHP Classes for managing all tables of the given MySql schema.
     * @param null $path Output for the generated classes
     */
    public function generateClassesFromSchema($path=null){
        $sql = "show full tables where Table_Type != 'VIEW'";
        $result = $this->query($sql);
        $this->totalTables = $result->num_rows;

        while ($row = $result->fetch_row()) {
            $table = $row[0];
            $reflection = new MVCMySqlTableReflection($table);
            $source = $reflection->generateClass();
            $class = $reflection->saveClass($source, $path);
            if ($class) {
               $msg = "<br> Class <b>$class</b> was generated for table <b>$table</b>";

               $msgjs= strip_tags($msg);
               $msgjs = str_replace("\\","\\\\",$msgjs);
               // echo $msg;
            } else if (!file_exists($path)) {
                $msg = "<br> <b>Destination path error!</b> Unable to create classes. <br> Check if your destination path: <b>$path</b> really exists.";
                $msgjs= strip_tags($msg);
                $msgjs = str_replace("\\","\\\\",$msgjs);
                // echo $msg;
                // echo "<script>$('#results').append('". $msgjs.  "&#xA;" . "');</script>";
                echo "<script>aggiornaTextArea('" . $msgjs ."')</script>";
                return false;
            } else {
                $msg = "<br> <b>Unknow error!</b> Unable to generate classes.";
                // echo $msg;
                $msgjs= strip_tags($msg);
                $msgjs = str_replace("\\","\\\\",$msgjs);
                // echo "<script>$('#results').append('". $msgjs.  "&#xA;" . "');</script>";
                echo "<script>aggiornaTextArea('" . $msgjs ."')</script>";
                return false;
            }
            // echo "<script>if (numberOfTables === 'undefined' || !numberOfTables) var numberOfTables=" .$this->totalTables ."; </script>";
            // echo "<script>$('#results').append('". $msgjs.  "&#xA;" . "');</script>";

            echo "<script>setNumberOfTables(" . $this->totalTables . ")</script>";
            echo "<script>aggiornaTextArea('" . $msgjs ."')</script>";
            echo "<script>aggiornaProgressBar();</script>";
            // echo "<script> window.scrollTo(0,document.body.scrollHeight);</script>";

            @flush();
            @ob_flush();
        }
        return true;
    }



}