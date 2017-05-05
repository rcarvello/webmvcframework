<?php
/**
 * Class BeanStore
 * Bean class for object oriented management of the MySQL table store
 *
 * Comment of the managed table store: Not specified.
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
 * @filesource BeanStore.php
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

class BeanStore extends MySqlRecord implements Bean
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
     * Class attribute for mapping the primary key store_code of table store
     *
     * Comment for field store_code: Not specified<br>
     * @var int $storeCode
     */
    private $storeCode;

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
     * Class attribute for storing the SQL DDL of table store
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBzdG9yZWAgKAogIGBzdG9yZV9jb2RlYCBpbnQoMTEpIE5PVCBOVUxMLAogIGBuYW1lYCB2YXJjaGFyKDQ1KSBERUZBVUxUIE5VTEwsCiAgUFJJTUFSWSBLRVkgKGBzdG9yZV9jb2RlYCkKKSBFTkdJTkU9SW5ub0RCIERFRkFVTFQgQ0hBUlNFVD11dGY4";

    /**
     * setStoreCode Sets the class attribute storeCode with a given value
     *
     * The attribute storeCode maps the field store_code defined as int(11).<br>
     * Comment for field store_code: Not specified.<br>
     * @param int $storeCode
     * @category Modifier
     */
    public function setStoreCode($storeCode)
    {
        $this->storeCode = (int)$storeCode;
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
     * getStoreCode gets the class attribute storeCode value
     *
     * The attribute storeCode maps the field store_code defined as int(11).<br>
     * Comment for field store_code: Not specified.
     * @return int $storeCode
     * @category Accessor of $storeCode
     */
    public function getStoreCode()
    {
        return $this->storeCode;
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
     * Gets DDL SQL code of the table store
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
        return "store";
    }

    /**
     * The BeanStore constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $storeCode is given.
     *  - with a fetched data row from the table store having store_code=$storeCode
     * @param int $storeCode. If omitted an empty (not fetched) instance is created.
     * @return BeanStore Object
     */
    public function __construct($storeCode = null)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($storeCode)) {
            $this->select($storeCode);
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
     * Fetchs a table row of store into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $storeCode the primary key store_code value of table store which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($storeCode)
    {
        $sql =  "SELECT * FROM store WHERE store_code={$this->parseValue($storeCode,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->storeCode = (integer)$rowObject->store_code;
            @$this->name = $this->replaceAposBackSlash($rowObject->name);
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table store
     * @param int $storeCode the primary key store_code value of table store which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($storeCode)
    {
        $sql = "DELETE FROM store WHERE store_code={$this->parseValue($storeCode,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of store
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->storeCode = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO store
            (store_code,name)
            VALUES({$this->parseValue($this->storeCode)},
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
                $this->storeCode = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table store with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $storeCode the primary key store_code value of table store which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($storeCode)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                store
            SET 
				name={$this->parseValue($this->name,'notNumber')}
            WHERE
                store_code={$this->parseValue($storeCode,'int')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($storeCode);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a row of store previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @category DML Helper
     * @return mixed MySQLi update result
     */
    public function updateCurrent()
    {
        if ($this->storeCode != "") {
            return $this->update($this->storeCode);
        } else {
            return false;
        }
    }

}
?>
