<?php

/**
 * Class MVCMySqlPKAnalyzer
 * Provides functions for analyze table primary key
 *
 * @extends mysqli
 * @filesource MVCMySqlBeanBuilder.php
 * @category Framework Utility
 * @package util\mysqlreflection
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version CVS: v1.0.0
 * @uses class MVCMySqlSimpleTemplate
 * @note This class is extracted from my personal MVC Framework.
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved .  See License.txt file
 * @license BSD
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD Public License.
 */


class MVCMySqlPKAnalyzer extends mysqli
{
    private $PKeys = array();
    private $PKDMLFunctionParameters;
    private $PKDMLFunctionParametersDefaultNull;
    private $PKDMLFunctionParametersIsNotNull;
    private $PKAttributeIsNotNull;
    private $PKForUpdateCurrent;
    private $PKParametersDocumentation;
    private $PKWhereCondition;
    private $tableName;

    public function __construct()
    {
        $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        if ($this->connect_errno) {
            printf("Connection failed. Modify MySQL connection settings into <b>mysql_connection.inc.php</b> file.");
            exit();
        }
    }

    /**
     * @return mixed
     */
    public function getPKWhereCondition()
    {
        return substr($this->PKWhereCondition,0,-5);
    }

    /**
     * @return mixed
     */
    public function getPKDMLFunctionParameters()
    {
        return substr($this->PKDMLFunctionParameters,0,-1);
    }


    public function getPKDMLFunctionParametersDefaultNull()
    {
        return substr($this->PKDMLFunctionParametersDefaultNull,0,-1);
    }


    public function getPKDMLFunctionParametersIsNotNull()
    {
        return substr($this->PKDMLFunctionParametersIsNotNull,0,-4);
    }

    public function getPKParametersDocumentation()
    {
        return substr($this->PKParametersDocumentation,0,-1);
    }

    public function getPKAttributeIsNotNull()
    {
        return substr($this->PKAttributeIsNotNull,0,-4);
    }

    public function getPKForUpdateCurrent()
    {
        return substr($this->PKForUpdateCurrent,0,-1);
    }
    /**
     * @return array
     */
    public function getPKeys()
    {
        return $this->PKeys;
    }

    public function getTableName() {
        return $this->tableName;
    }

    public function analyze($tableName)
    {
        $this->tableName = $tableName;
        $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);

        $sqlFields = "SHOW FULL COLUMNS FROM $tableName";
        $sqlPk = "SHOW KEYS FROM $tableName WHERE Key_name = 'PRIMARY'";

        $result = $this->query($sqlPk);
        if ($result){
            while ($row = $result->fetch_object()) {

                $pk = $row->Column_name;
                $resultType= $this->query($sqlFields);
                $pkType = "int";
                $pkComment = "";
                while ($rowTypeInfo = $resultType->fetch_object()) {
                    $fieldName = $rowTypeInfo->Field;
                    if ($fieldName == $pk){
                        $pkType = $this->getType($rowTypeInfo->Type);
                        $pkComment = $this->getType($rowTypeInfo->Comment);
                        break;
                    } else {
                        $pkType =  "";
                        $pkComment = "";
                    }
                }
                $this->PKeys[$pk] = $pkType;
                $this->buildPKDMLFunctionParameters($pk,$pkType,$pkComment);
                $this->buildPKWhereCondition($pk,$pkType);
            }
        }
    }

    public function hasCompositePK()
    {
        return count($this->PKeys)==1 ? false:true;
    }

    public function buildPKDMLFunctionParameters($pk,$pkType,$pkComment)
    {
        $this->PKDMLFunctionParameters .= "\$" . $this->underscoreToCamelCase($pk) . ",";
        $this->PKDMLFunctionParametersDefaultNull .= "\$" . $this->underscoreToCamelCase($pk) . "=NULL,";
        $this->PKDMLFunctionParametersIsNotNull .= "!empty(\$" . $this->underscoreToCamelCase($pk) . ") && ";
        $this->PKParametersDocumentation .= "\t* @param " . $this->getType($pkType) . " \$" .  $this->underscoreToCamelCase($pk) . "\n";
        $this->PKAttributeIsNotNull .= "!empty(\$this->" . $this->underscoreToCamelCase($pk) . ") && ";
        $this->PKForUpdateCurrent .= "\$this->" . $this->underscoreToCamelCase($pk) . ",";
    }

    public function buildPKWhereCondition($pk,$pkType)
    {
        /*
        if ($pkType == "date") {
            $template = "$pk=STR_TO_DATE({\$this->parseValue(\$$pk,'date')},'{\$constants['STORED_DATE_FORMAT']}') \nAND ";
        } elseif ($pkType == "datetime") {
            $template   = "$pk= STR_TO_DATE({\$this->parseValue(\$$pk,'date')},'{\$constants['STORED_DATETIME_FORMAT']}') \nAND ";
        } else {
            $template = "$pk={\$this->parseValue(\$$pk,'$pkType') \nAND ";
        }
        */
        $pkAttribute = $this->underscoreToCamelCase($pk);
        $template = "$pk={\$this->parseValue(\$$pkAttribute,'$pkType')} AND ";
        $this->PKWhereCondition .= $template;
    }

    /**
     * underscoreToCamelCase
     * Covert lower_underscored mysql notation into Camel/Pascal case notation
     * @param $string string to convert into Camel/Pascal case notation
     * @param bool $pascalCase If true the result is PascalCase
     * @return string
     */
    public static function underscoreToCamelCase($string, $pascalCase = false)
    {
        $string = strtolower($string);

        if( $pascalCase == true )
        {
            $string[0] = strtoupper($string[0]);
        }
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/_([a-z])/', $func, $string);
    }

    /**
     * getType
     * Gets the attribute type to be used by the generated class.
     * @note Supported data types:
     *  - int, tinyint, smallint, mediumint, bigint
     *  - decimal, double, float, real, fixed, numeric
     *  - varchar, char, text, tinytext, mediumtext, longtext
     *  - date, datetime, time
     *  - set, enum
     * @return string
     */
    public function getType($type)
    {
        $result = "";
        if (preg_match('/int/',$type))
            $result =  "int";

        if (preg_match('/year/',$type))
            $result =  "int";

        if (preg_match('/integer/',$type))
            $result =  "int";

        if (preg_match('/tynyint/',$type))
            $result =  "int";

        if (preg_match('/smallint/',$type))
            $result =  "int";

        if (preg_match('/mediumint/',$type))
            $result =  "int";

        if (preg_match('/bigint/',$type))
            $result =  "int";

        if (preg_match('/varchar/',$type))
            $result = "string";

        if (preg_match('/char/',$type))
            $result = "string";

        if (preg_match('/text/',$type))
            $result = "string";

        if (preg_match('/tyntext/',$type))
            $result = "string";

        if (preg_match('/mediumtext/',$type))
            $result = "string";

        if (preg_match('/longtext/',$type))
            $result = "string";

        if (preg_match('/char/',$type))
            $result = "string";

        if (preg_match('/enum/',$type))
            $result = "enum";

        if (preg_match('/set/',$type))
            $result = "string";

        if (preg_match('/date/',$type))
            $result = "date";

        if (preg_match('/time/',$type))
            $result = "time";

        if (preg_match('/datetime/',$type))
            $result = "datetime";

        if (preg_match('/decimal/',$type))
            $result = "float";

        if (preg_match('/float/',$type))
            $result = "float";

        if (preg_match('/double/',$type))
            $result = "double";

        if (preg_match('/real/',$type))
            $result = "real";

        if (preg_match('/fixed/',$type))
            $result = "float";

        if (preg_match('/numeric/',$type))
            $result = "float";

        if (empty($result)){
            // $result = $this->type;
            $result = "string";
        }

        // TODO EVALUATES BIT, TIMESTAMP, VARBINARY, BLOB MySQL data types
        return $result;
    }



}