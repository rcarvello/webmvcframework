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
     * Returns all non-view tables from the schema.
     * @return array
     */
    public function getTablesFromSchema()
    {
        $tables = array();
        $sql = "show full tables where Table_Type != 'VIEW'";
        $result = $this->query($sql);

        if ($result) {
            while ($row = $result->fetch_row()) {
                $tables[] = $row[0];
            }
        }

        $this->totalTables = count($tables);
        return $tables;
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

    /**
     * Generates the PHP Classes for only the selected tables.
     * @param array $tables Selected table names
     * @param null $path Output for the generated classes
     * @return bool
     */
    public function generateClassesFromSelectedTables($tables, $path = null)
    {
        if (!is_array($tables) || count($tables) === 0) {
            echo "<script>aggiornaTextArea('No tables selected.')</script>";
            return false;
        }

        $this->totalTables = count($tables);
        echo "<script>setNumberOfTables(" . $this->totalTables . ")</script>";

        $done = 0;

        foreach ($tables as $table) {
            if (empty($table)) {
                continue;
            }

            if ($path !== null && !file_exists($path)) {
                $msg = "<br> <b>Destination path error!</b> Unable to create classes. <br> Check if your destination path: <b>$path</b> really exists.";
                $msgjs = strip_tags($msg);
                $msgjs = str_replace("\\", "\\\\", $msgjs);
                echo "<script>aggiornaTextArea('" . $msgjs . "')</script>";
                return false;
            }

            $reflection = new MVCMySqlTableReflection($table);
            $source = $reflection->generateClass();
            $class = $reflection->saveClass($source, $path);

            if ($class) {
                $msg = "<br> Class <b>$class</b> was generated for table <b>$table</b>";
                $msgjs = strip_tags($msg);
                $msgjs = str_replace("\\", "\\\\", $msgjs);
            } else {
                $msg = "<br> <b>Unknow error!</b> Unable to generate class for table <b>$table</b>.";
                $msgjs = strip_tags($msg);
                $msgjs = str_replace("\\", "\\\\", $msgjs);
                echo "<script>aggiornaTextArea('" . $msgjs . "')</script>";
                return false;
            }

            $done++;
            echo "<script>aggiornaTextArea('" . $msgjs . "')</script>";
            echo "<script>aggiornaProgressBar(" . ($done >= $this->totalTables ? "true" : "false") . ");</script>";

            @flush();
            @ob_flush();
        }

        return true;
    }

    /**
     * generateClassFromTable()
     * Generates the PHP Class for a single table.
     * @param string $table Table name
     * @param null $path Output for the generated class
     */
    public function generateClassFromTable($table, $path = null)
    {
        if (empty($table)) {
            echo "<script>aggiornaTextArea('Table name is empty')</script>";
            return false;
        }

        if ($path !== null && !file_exists($path)) {
            $msg = "<br> <b>Destination path error!</b> Unable to create class. <br> Check if your destination path: <b>$path</b> really exists.";
            $msgjs = strip_tags($msg);
            $msgjs = str_replace("\\", "\\\\", $msgjs);
            echo "<script>aggiornaTextArea('" . $msgjs . "')</script>";
            return false;
        }

        $reflection = new MVCMySqlTableReflection($table);
        $source = $reflection->generateClass();
        $class = $reflection->saveClass($source, $path);

        if ($class) {
            $msg = "<br> Class <b>$class</b> was generated for table <b>$table</b>";
            $msgjs = strip_tags($msg);
            $msgjs = str_replace("\\", "\\\\", $msgjs);

            echo "<script>setNumberOfTables(1)</script>";
            echo "<script>aggiornaTextArea('" . $msgjs . "')</script>";
            echo "<script>aggiornaProgressBar();</script>";

            @flush();
            @ob_flush();
            return true;
        }

        $msg = "<br> <b>Unknow error!</b> Unable to generate class for table <b>$table</b>.";
        $msgjs = strip_tags($msg);
        $msgjs = str_replace("\\", "\\\\", $msgjs);
        echo "<script>aggiornaTextArea('" . $msgjs . "')</script>";
        return false;
    }
}