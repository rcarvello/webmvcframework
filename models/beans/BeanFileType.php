<?php
/**
 * Class BeanFileType
 * Bean class for object oriented management of the MySQL table file_type
 *
 * Comment of the managed table file_type: Not specified.
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
 * @filesource BeanFileType.php
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

class BeanFileType extends MySqlRecord implements Bean
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
     * Class attribute for mapping the primary key file_type_id of table file_type
     *
     * Comment for field file_type_id: Not specified<br>
     * @var int $fileTypeId
     */
    private $fileTypeId;

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
     * Class attribute for storing the SQL DDL of table file_type
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBmaWxlX3R5cGVgICgKICBgZmlsZV90eXBlX2lkYCBpbnQoMTEpIE5PVCBOVUxMLAogIGBuYW1lYCB2YXJjaGFyKDQ1KSBERUZBVUxUIE5VTEwsCiAgUFJJTUFSWSBLRVkgKGBmaWxlX3R5cGVfaWRgKQopIEVOR0lORT1Jbm5vREIgREVGQVVMVCBDSEFSU0VUPXV0Zjg=";

    /**
     * setFileTypeId Sets the class attribute fileTypeId with a given value
     *
     * The attribute fileTypeId maps the field file_type_id defined as int(11).<br>
     * Comment for field file_type_id: Not specified.<br>
     * @param int $fileTypeId
     * @category Modifier
     */
    public function setFileTypeId($fileTypeId)
    {
        $this->fileTypeId = (int)$fileTypeId;
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
     * getFileTypeId gets the class attribute fileTypeId value
     *
     * The attribute fileTypeId maps the field file_type_id defined as int(11).<br>
     * Comment for field file_type_id: Not specified.
     * @return int $fileTypeId
     * @category Accessor of $fileTypeId
     */
    public function getFileTypeId()
    {
        return $this->fileTypeId;
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
     * Gets DDL SQL code of the table file_type
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
        return "file_type";
    }

    /**
     * The BeanFileType constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $fileTypeId is given.
     *  - with a fetched data row from the table file_type having file_type_id=$fileTypeId
     * @param int $fileTypeId. If omitted an empty (not fetched) instance is created.
     * @return BeanFileType Object
     */
    public function __construct($fileTypeId = null)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($fileTypeId)) {
            $this->select($fileTypeId);
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
     * Fetchs a table row of file_type into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $fileTypeId the primary key file_type_id value of table file_type which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($fileTypeId)
    {
        $sql =  "SELECT * FROM file_type WHERE file_type_id={$this->parseValue($fileTypeId,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->fileTypeId = (integer)$rowObject->file_type_id;
            @$this->name = $this->replaceAposBackSlash($rowObject->name);
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table file_type
     * @param int $fileTypeId the primary key file_type_id value of table file_type which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($fileTypeId)
    {
        $sql = "DELETE FROM file_type WHERE file_type_id={$this->parseValue($fileTypeId,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of file_type
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->fileTypeId = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO file_type
            (file_type_id,name)
            VALUES({$this->parseValue($this->fileTypeId)},
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
                $this->fileTypeId = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table file_type with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $fileTypeId the primary key file_type_id value of table file_type which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($fileTypeId)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                file_type
            SET 
				name={$this->parseValue($this->name,'notNumber')}
            WHERE
                file_type_id={$this->parseValue($fileTypeId,'int')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($fileTypeId);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a row of file_type previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @category DML Helper
     * @return mixed MySQLi update result
     */
    public function updateCurrent()
    {
        if ($this->fileTypeId != "") {
            return $this->update($this->fileTypeId);
        } else {
            return false;
        }
    }

}
?>
