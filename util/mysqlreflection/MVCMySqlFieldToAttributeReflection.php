<?php
/**
 * MVCMySqlFieldToAttributeReflection
 * Maps a table field information and its related values in a form of class attribute.
 * Responsability:
 *
 *  - Stores table field information
 *  - Gives a Camel Cases notation of field name
 *  - Gives data type conversion of the field from mysql to php
 *  - Gives more useful information about the field
 *
 * @filesource MVCMySqlFieldToAttributeReflection.php
 * @package util\mysqlreflection
 * @category Framework Utility
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version CVS: v1.0.0
 * @note This class is extracted from my personal MVC Framework.
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved .  See License.txt file
 * @license BSD
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD Public License.
 */
class MVCMySqlFieldToAttributeReflection
{
    /**
     * @var string Stores the mysql field name
     */
    public $name;

    /**
     * @var string Stores the mysql field data type
     */
    public $type;

    /**
     * @var string Stores the mysql NULL constraint
     */
    public $null;

    /**
     * @var string Stores if the mysql field has an index
     */
    public $key;

    /**
     * @var string Stores the mysql field default value
     */
    public $default;

    /**
     * @var string Stores the mysql field extra information
     */
    public $extra;

    /**
     * @var string Stores the mysql field comment information
     */
    public $comment;


    /**
     * getName
     * Gets the name of the attribute in a camelcase notation to be used by the generated class.
     * @return string
     */
    public function getName()
    {
        return self::underscoreToCamelCase($this->name);
    }

    /**
     * getSetterName
     * Gets the name of the setter method of attribute in a camelcase notation to be used by the generated class.
     * @return string
     */
    public function getSetterName()
    {
        return "set" . self::underscoreToCamelCase($this->name,true);
    }

    /**
     * getGetterName
     * Gets the name of the getter method of attribute in a camelcase notation to be used by the generated class.
     * @return string
     */
    public function getGetterName()
    {
        return "get" . self::underscoreToCamelCase($this->name,true);
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
    public function getType()
    {
        $result = "";
        if (preg_match('/int/',$this->type))
            $result =  "int";

        if (preg_match('/year/',$this->type))
            $result =  "int";

        if (preg_match('/integer/',$this->type))
            $result =  "int";

        if (preg_match('/tynyint/',$this->type))
            $result =  "int";

        if (preg_match('/smallint/',$this->type))
            $result =  "int";

        if (preg_match('/mediumint/',$this->type))
            $result =  "int";

        if (preg_match('/bigint/',$this->type))
            $result =  "int";

        if (preg_match('/varchar/',$this->type))
            $result = "string";

        if (preg_match('/char/',$this->type))
            $result = "string";

        if (preg_match('/text/',$this->type))
            $result = "string";

        if (preg_match('/tyntext/',$this->type))
            $result = "string";

        if (preg_match('/mediumtext/',$this->type))
            $result = "string";

        if (preg_match('/longtext/',$this->type))
            $result = "string";

        if (preg_match('/char/',$this->type))
            $result = "string";

        if (preg_match('/enum/',$this->type))
            $result = "enum";

        if (preg_match('/set/',$this->type))
            $result = "string";

        if (preg_match('/date/',$this->type))
            $result = "date";

        if (preg_match('/time/',$this->type))
            $result = "time";

        if (preg_match('/datetime/',$this->type))
            $result = "datetime";

        if (preg_match('/decimal/',$this->type))
            $result = "float";

        if (preg_match('/float/',$this->type))
            $result = "float";

        if (preg_match('/double/',$this->type))
            $result = "double";

        if (preg_match('/real/',$this->type))
            $result = "real";

        if (preg_match('/fixed/',$this->type))
            $result = "float";

        if (preg_match('/numeric/',$this->type))
            $result = "float";

        if (empty($result)){
            // $result = $this->type;
            $result = "string";
        }

        // TODO EVALUATES BIT, TIMESTAMP, VARBINARY, BLOB MySQL data types
        return $result;
    }

    public function getTypeForPHPDoc()
    {
        $result = "";
        if (preg_match('/int/',$this->type))
            $result =  "int";

        if (preg_match('/year/',$this->type))
            $result =  "int";

        if (preg_match('/integer/',$this->type))
            $result =  "int";

        if (preg_match('/tynyint/',$this->type))
            $result =  "int";

        if (preg_match('/smallint/',$this->type))
            $result =  "int";

        if (preg_match('/mediumint/',$this->type))
            $result =  "int";

        if (preg_match('/bigint/',$this->type))
            $result =  "int";

        if (preg_match('/varchar/',$this->type))
            $result = "string";

        if (preg_match('/char/',$this->type))
            $result = "string";

        if (preg_match('/text/',$this->type))
            $result = "string";

        if (preg_match('/tyntext/',$this->type))
            $result = "string";

        if (preg_match('/mediumtext/',$this->type))
            $result = "string";

        if (preg_match('/longtext/',$this->type))
            $result = "string";

        if (preg_match('/char/',$this->type))
            $result = "string";

        if (preg_match('/enum/',$this->type))
            $result = "string";

        if (preg_match('/set/',$this->type))
            $result = "string";

        if (preg_match('/date/',$this->type))
            $result = "string";

        if (preg_match('/time/',$this->type))
            $result = "string";

        if (preg_match('/datetime/',$this->type))
            $result = "string";

        if (preg_match('/decimal/',$this->type))
            $result = "float";

        if (preg_match('/float/',$this->type))
            $result = "float";

        if (preg_match('/double/',$this->type))
            $result = "float";

        if (preg_match('/real/',$this->type))
            $result = "float";

        if (preg_match('/fixed/',$this->type))
            $result = "float";

        if (preg_match('/numeric/',$this->type))
            $result = "int";

        if (empty($result)){
            // $result = $this->type;
            $result = "null";
        }

        // TODO EVALUATES BIT, TIMESTAMP, VARBINARY, BLOB MySQL data types
        return $result;
    }
    /**
     * getCast
     * Gets the casting string to be used by the generated class.
     * @return string
     */
    public function getCast()
    {
        $result = $this->getType();
        if ($result == "date")
            $result = "string";
        if ($result == "datetime")
            $result = "string";
        if ($result == "enum")
            $result = "string";
        if ($result == "time")
            $result = "string";
        // BIT, TIMESTAMP, VARBINARY, BLOB
        return "(" . $result . ")";
    }

    /**
     * getTypeAndLenght
     * Gets the type and lenght of mysql field
     * @return string
     */
    public function getTypeAndLenght()
    {
        return $this->type;
    }

    /**
     * getNullableInfo
     * Gets NULL information about mysql field
     * @return string
     */
    public function getNullableInfo()
    {
        return $this->null;
    }

    /**
     * getIndexInfo
     * Gets index information about mysql field
     * @return string
     */
    public function getIndexInfo()
    {
        return $this->key;
    }

    /**
     * getDefaultValueInfo
     * Gets default value information about mysql field
     * @return string
     */
    public function getDefaultValueInfo()
    {
        return $this->default;
    }

    /**
     * getExtraInfo
     * Gets extra information about mysql field
     * @return string
     */
    public function getExtraInfo()
    {
        return $this->extra;
    }

    /**
     * isPkField
     * Evaluates if is a a PK field
     * @return string
     */
    public function isPkField()
    {
        if ($this->key == "PRI"){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets a well formatted string containing SQL values of the attribute
     * @return string The string to be used as SQL value into the SQL statemet
     */
    public function getSqlFormattedValue()
    {
        if ($this->getType() == "string" || $this->getType() == "time" || $this->getType() == "enum") {
           return "{" ."$". "this->parseValue(". "$". "this->". $this->getName() .",'notNumber')},";
        } else if ($this->getType() == "date") {
            return "{" ."$". "this->parseValue(". "$". "this->". $this->getName() .",'date')},";
        } else if ($this->getType() == "datetime") {
            return "{" ."$". "this->parseValue(". "$". "this->". $this->getName() .",'datetime')},";;
        } else {
            return "{". "$". "this->parseValue(". "$". "this->". $this->getName().")},";
        }
        /*
         } else if ($this->getType() == "date_OLD") {
            return "STR_TO_DATE(". "{"."$". "this->parseValue(". "$". "this->". $this->getName().",'date')},"."'". "{"."$"."constants['STORED_DATE_FORMAT']}" ."'),";
         } else if ($this->getType() == "datetime_OLD") {
            return "STR_TO_DATE(". "{"."$". "this->parseValue(". "$". "this->". $this->getName().",'date')},"."'". "{"."$"."constants['STORED_DATETIME_FORMAT']}" ."'),";
        */

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
}