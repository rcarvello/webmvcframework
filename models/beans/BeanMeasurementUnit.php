<?php
/**
 * Class BeanMeasurementUnit
 * Bean class for object oriented management of the MySQL table measurement_unit
 *
 * Comment of the managed table measurement_unit: Unit of measurament.
 *
 * Responsibility:
 *
 *  - provides instance constructors for both managing of a fetched table or for a new row
 *  - provides destructor to automatically close database connection
 *  - defines a set of attributes corresponding to the table fields
 *  - provides setter and getter methods for each attribute
 *  - provides OO methods for simplify DML select, insert, update and delete operations.
 *  - provides a facility for quickly updating a previously fetched row
 *  - provides useful methods to obtain table DDL and the last executed SQL statement
 *  - provides error handling of SQL statement
 *  - uses Camel/Pascal case naming convention for Attributes/Class used for mapping of Fields/Table
 *  - provides useful PHPDOC information about the table, fields, class, attributes and methods.
 *
 * @extends MySqlRecord
 * @implements Bean
 * @filesource BeanMeasurementUnit.php
 * @category MySql Database Bean Class
 * @package models/bean
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @note  This is an auto generated PHP class builded with MVCMySqlReflection, a small code generation engine extracted from the author's personal MVC Framework.
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD Public License.
*/
namespace models\beans;
use framework\MySqlRecord;
use framework\Bean;

class BeanMeasurementUnit extends MySqlRecord implements Bean
{
    /**
     * A control attribute for the update operation.
     * @note An instance fetched from db is allowed to run the update operation.
     *       A new instance (not fetched from db) is allowed only to run the insert operation but,
     *       after running insertion, the instance is automatically allowed to run update operation.
     * @var bool
     */
    private $allowUpdate = false;

    /**
     * Class attribute for mapping the primary key measurement_unit_code of table measurement_unit
     *
     * Comment for field measurement_unit_code: Not specified<br>
     * @var string $measurementUnitCode
     */
    private $measurementUnitCode;

    /**
     * A class attribute for evaluating if the table has an autoincrement primary key
     * @var bool $isPkAutoIncrement
     */
    private $isPkAutoIncrement = false;

    /**
     * Class attribute for mapping table field name
     *
     * Comment for field name: Not specified.<br>
     * Field information:
     *  - Data type: varchar(45)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $name
     */
    private $name;

    /**
     * Class attribute for storing the SQL DDL of table measurement_unit
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBtZWFzdXJlbWVudF91bml0YCAoCiAgYG1lYXN1cmVtZW50X3VuaXRfY29kZWAgdmFyY2hhcigxMCkgTk9UIE5VTEwsCiAgYG5hbWVgIHZhcmNoYXIoNDUpIERFRkFVTFQgTlVMTCwKICBQUklNQVJZIEtFWSAoYG1lYXN1cmVtZW50X3VuaXRfY29kZWApCikgRU5HSU5FPUlubm9EQiBERUZBVUxUIENIQVJTRVQ9dXRmOCBDT01NRU5UPSdVbml0IG9mIG1lYXN1cmFtZW50Jw==";

    /**
     * setMeasurementUnitCode Sets the class attribute measurementUnitCode with a given value
     *
     * The attribute measurementUnitCode maps the field measurement_unit_code defined as varchar(10).<br>
     * Comment for field measurement_unit_code: Not specified.<br>
     * @param string $measurementUnitCode
     * @category Modifier
     */
    public function setMeasurementUnitCode($measurementUnitCode)
    {
        $this->measurementUnitCode = (string)$measurementUnitCode;
    }

    /**
     * setName Sets the class attribute name with a given value
     *
     * The attribute name maps the field name defined as varchar(45).<br>
     * Comment for field name: Not specified.<br>
     * @param string $name
     * @category Modifier
     */
    public function setName($name)
    {
        $this->name = (string)$name;
    }

    /**
     * getMeasurementUnitCode gets the class attribute measurementUnitCode value
     *
     * The attribute measurementUnitCode maps the field measurement_unit_code defined as varchar(10).<br>
     * Comment for field measurement_unit_code: Not specified.
     * @return string $measurementUnitCode
     * @category Accessor of $measurementUnitCode
     */
    public function getMeasurementUnitCode()
    {
        return $this->measurementUnitCode;
    }

    /**
     * getName gets the class attribute name value
     *
     * The attribute name maps the field name defined as varchar(45).<br>
     * Comment for field name: Not specified.
     * @return string $name
     * @category Accessor of $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets DDL SQL code of the table measurement_unit
     * @return string
     * @category Accessor
     */
    public function getDdl()
    {
        return base64_decode($this->ddl);
    }

    /**
    * Gets the name of the managed table
    * @return string
    * @category Accessor
    */
    public function getTableName()
    {
        return "measurement_unit";
    }

    /**
     * The BeanMeasurementUnit constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $measurementUnitCode is given.
     *  - with a fetched data row from the table measurement_unit having measurement_unit_code=$measurementUnitCode
     * @param string $measurementUnitCode. If omitted an empty (not fetched) instance is created.
     * @return BeanMeasurementUnit Object
     */
    public function __construct($measurementUnitCode = null)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($measurementUnitCode)) {
            $this->select($measurementUnitCode);
        }
    }

    /**
     * The implicit destructor
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * Explicit destructor. It calls the implicit destructor automatically.
     */
    public function close()
    {
        unset($this);
    }

    /**
     * Fetchs a table row of measurement_unit into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param string $measurementUnitCode the primary key measurement_unit_code value of table measurement_unit which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($measurementUnitCode)
    {
        $sql =  "SELECT * FROM measurement_unit WHERE measurement_unit_code={$this->parseValue($measurementUnitCode,'string')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->measurementUnitCode = $this->replaceAposBackSlash($rowObject->measurement_unit_code);
            @$this->name = $this->replaceAposBackSlash($rowObject->name);
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table measurement_unit
     * @param string $measurementUnitCode the primary key measurement_unit_code value of table measurement_unit which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($measurementUnitCode)
    {
        $sql = "DELETE FROM measurement_unit WHERE measurement_unit_code={$this->parseValue($measurementUnitCode,'string')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of measurement_unit
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->measurementUnitCode = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO measurement_unit
            (measurement_unit_code,name)
            VALUES({$this->parseValue($this->measurementUnitCode,'notNumber')},
			{$this->parseValue($this->name,'notNumber')})
SQL;
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        } else {
            $this->allowUpdate = true;
            if ($this->isPkAutoIncrement) {
                $this->measurementUnitCode = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table measurement_unit with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param string $measurementUnitCode the primary key measurement_unit_code value of table measurement_unit which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($measurementUnitCode)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                measurement_unit
            SET 
				name={$this->parseValue($this->name,'notNumber')}
            WHERE
                measurement_unit_code={$this->parseValue($measurementUnitCode,'string')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($measurementUnitCode);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a row of measurement_unit previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @category DML Helper
     * @return mixed MySQLi update result
     */
    public function updateCurrent()
    {
        if ($this->measurementUnitCode != "") {
            return $this->update($this->measurementUnitCode);
        } else {
            return false;
        }
    }

}
?>
