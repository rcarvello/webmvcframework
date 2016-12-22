<?php
/**
 * Class MySqlRecord
 *
 * @package framework
 * @filesource framework/MySqlRecord.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework;
class MySqlRecord extends Model
{
    /**
     * A control attribute for storing the last executed SQL statement.
     * @var string
     */
    protected $lastSql = null;

    /**
     * A control attribute for storing the last SQL error.
     * @var string
     */
    protected $lastSqlError = null;

    /**
     * lastSql Gets the last executed SQL statement
     * @return string
     */
    public function lastSql()
    {
        return $this->lastSql;
    }

    /**
     * lastSqlError Gets the last occurred SQL error
     * @return string
     */
    public function lastSqlError()
    {
        return $this->lastSqlError;
    }

    /**
     * isSqlError Gets if an Sql error occurred
     * @return bool
     */
    public function isSqlError()
    {
        if ($this->lastSqlError() != "") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * resetLastSqlError Reset the SQL error information
     */
    protected function resetLastSqlError()
    {
        $this->lastSqlError = "";
    }

    /**
     * parseValue Parses the value and returns NULL if null occurred
     *
     * For a not null value, depending on data type, adjusts
     * the correct quotation by returning a quoted or not escaped string to be used during SQL statements.
     * @param mixed $value The value to evaluate
     * @param string $type The data type of first parameter, default is number (int/float) value
     * @return null|string|int|float quoted or not value
     */
    protected function parseValue($value=null,$type="number")
    {
        $constants = get_defined_constants();

        if ( $type=="int" || $type=="float" || $type=="real" || $type=="double") {
            $type = "number";
        }
        if ($value==null) {
            return "NULL";
        } else if ($value !=null && $type!="number" && $type!="date" && $type!="datetime") {
            return "'" . $this->real_escape_string($value) . "'";
        } else if ($value !=null && $type!="number" && $type=="date") {
            return    "STR_TO_DATE('" . $this->real_escape_string($value) . "','" . $constants['STORED_DATE_FORMAT'] . "')";
        } else if ($value !=null && $type!="number" && $type=="datetime") {
            return    "STR_TO_DATE('" . $this->real_escape_string($value) . "','" . $constants['STORED_DATETIME_FORMAT'] . "')";
        } else if ($value !=null && $type=="number" && is_numeric($value)){
            return $value;
        } else {
            return "NULL";
        }
    }

    /**
     * Replaces backslash present into MySQL strings which containing apostrophes.
     *
     * @param  string $field The field to replace
     * @return string the field without backslash for the aphos
     */
    protected function replaceAposBackSlash($field){
        $r1 =  str_replace("\'","'",$field);
        $r2 =  str_replace("\\\\","\\",$r1);
        return $r2;
    }

}