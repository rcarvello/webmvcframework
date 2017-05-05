<?php
/**
 * Class BeanStock
 * Bean class for object oriented management of the MySQL table stock
 *
 * Comment of the managed table stock: Not specified.
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
 * @implements none
 * @filesource BeanStock.php
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


class BeanStock extends MySqlRecord 
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
     * Class attribute for mapping table field store_code
     *
     * Comment for field store_code: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : NO
     *  - DB Index: PRI
     *  - Default: 
     *  - Extra:  
     * @var int $storeCode
     */
    private $storeCode;

    /**
     * Class attribute for mapping table field part_code
     *
     * Comment for field part_code: Not specified.<br>
     * Field information:
     *  - Data type: varchar(40)
     *  - Null : NO
     *  - DB Index: PRI
     *  - Default: 
     *  - Extra:  
     * @var string $partCode
     */
    private $partCode;

    /**
     * Class attribute for mapping table field quantity
     *
     * Comment for field quantity: Not specified.<br>
     * Field information:
     *  - Data type: decimal(11,2)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var float $quantity
     */
    private $quantity;

    /**
     * Class attribute for storing the SQL DDL of table stock
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBzdG9ja2AgKAogIGBzdG9yZV9jb2RlYCBpbnQoMTEpIE5PVCBOVUxMLAogIGBwYXJ0X2NvZGVgIHZhcmNoYXIoNDApIE5PVCBOVUxMLAogIGBxdWFudGl0eWAgZGVjaW1hbCgxMSwyKSBERUZBVUxUIE5VTEwsCiAgUFJJTUFSWSBLRVkgKGBzdG9yZV9jb2RlYCxgcGFydF9jb2RlYCksCiAgS0VZIGBma19zdG9ja19wYXJ0MV9pZHhgIChgcGFydF9jb2RlYCksCiAgS0VZIGBma19zdG9ja19zdG9yZTFfaWR4YCAoYHN0b3JlX2NvZGVgKSwKICBDT05TVFJBSU5UIGBma19zdG9ja19wYXJ0MWAgRk9SRUlHTiBLRVkgKGBwYXJ0X2NvZGVgKSBSRUZFUkVOQ0VTIGBwYXJ0YCAoYHBhcnRfY29kZWApIE9OIERFTEVURSBOTyBBQ1RJT04gT04gVVBEQVRFIE5PIEFDVElPTiwKICBDT05TVFJBSU5UIGBma19zdG9ja19zdG9yZTFgIEZPUkVJR04gS0VZIChgc3RvcmVfY29kZWApIFJFRkVSRU5DRVMgYHN0b3JlYCAoYHN0b3JlX2NvZGVgKSBPTiBERUxFVEUgTk8gQUNUSU9OIE9OIFVQREFURSBOTyBBQ1RJT04KKSBFTkdJTkU9SW5ub0RCIERFRkFVTFQgQ0hBUlNFVD11dGY4";

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
     * setPartCode Sets the class attribute partCode with a given value
     *
     * The attribute partCode maps the field part_code defined as varchar(40).<br>
     * Comment for field part_code: Not specified.<br>
     * @param string $partCode
     * @category Modifier
     */
    public function setPartCode($partCode)
    {
        $this->partCode = (string)$partCode;
    }

    /**
     * setQuantity Sets the class attribute quantity with a given value
     *
     * The attribute quantity maps the field quantity defined as decimal(11,2).<br>
     * Comment for field quantity: Not specified.<br>
     * @param float $quantity
     * @category Modifier
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (float)$quantity;
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
     * getPartCode gets the class attribute partCode value
     *
     * The attribute partCode maps the field part_code defined as varchar(40).<br>
     * Comment for field part_code: Not specified.
     * @return string $partCode
     * @category Accessor of $partCode
     */
    public function getPartCode()
    {
        return $this->partCode;
    }

    /**
     * getQuantity gets the class attribute quantity value
     *
     * The attribute quantity maps the field quantity defined as decimal(11,2).<br>
     * Comment for field quantity: Not specified.
     * @return float $quantity
     * @category Accessor of $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Gets DDL SQL code of the table stock
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
        return "stock";
    }

    /**
    * The BeanStock constructor
    *
    * It creates and initializes an object in two way:
    *  - with null (not fetched) data if none ${ClassPkAttributeName} is given.
    *  - with a fetched data row from the table {TableName} having {TablePkName}=${ClassPkAttributeName}
	* @param int $storeCode
	* @param string $partCode
    * @return BeanStock Object
    */
    public function __construct($storeCode=NULL,$partCode=NULL)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($storeCode) && !empty($partCode)) {
            $this->select($storeCode,$partCode);
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
    * Fetchs a table row of stock into the object.
    *
    * Fetched table fields values are assigned to class attributes and they can be managed by using
    * the accessors/modifiers methods of the class.
	* @param int $storeCode
	* @param string $partCode
    * @return int affected selected row
    * @category DML
    */
    public function select($storeCode,$partCode)
    {
        $sql =  "SELECT * FROM stock WHERE store_code={$this->parseValue($storeCode,'int')} AND part_code={$this->parseValue($partCode,'string')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->storeCode = (integer)$rowObject->store_code;
            @$this->partCode = $this->replaceAposBackSlash($rowObject->part_code);
            @$this->quantity = (float)$rowObject->quantity;
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
    return $this->affected_rows;
    }

    /**
    * Deletes a specific row from the table stock
	* @param int $storeCode
	* @param string $partCode
    * @return int affected deleted row
    * @category DML
    */
    public function delete($storeCode,$partCode)
    {
        $sql = "DELETE FROM stock WHERE store_code={$this->parseValue($storeCode,'int')} AND part_code={$this->parseValue($partCode,'string')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
    * Insert the current object into a new table row of stock
    *
    * All class attributes values defined for mapping all table fields are automatically used during inserting
    * @return mixed MySQL insert result
    * @category DML
    */
    public function insert()
    {
        // $constants = get_defined_constants();
        $sql = <<< SQL
        INSERT INTO stock
        (store_code,part_code,quantity)
        VALUES({$this->parseValue($this->storeCode)},
			{$this->parseValue($this->partCode,'notNumber')},
			{$this->parseValue($this->quantity)})
SQL;
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        } else {
            $this->allowUpdate = true;
        }
        return $result;
    }

    /**
    * Updates a specific row from the table stock with the values of the current object.
    *
    * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
    * Null values are used for all attributes not previously setted.
	* @param int $storeCode
	* @param string $partCode
    * @return mixed MySQL update result
    * @category DML
    */
    public function update($storeCode,$partCode)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                stock
                SET 
				quantity={$this->parseValue($this->quantity)}
            WHERE
                store_code={$this->parseValue($storeCode,'int')} AND part_code={$this->parseValue($partCode,'string')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            }   else {
                $this->select($storeCode,$partCode);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
    * Facility for updating a row of stock previously loaded.
    *
    * All class attribute values defined for mapping all table fields are automatically used during updating.
    * @category DML Helper
    * @return mixed MySQLi update result
    */
    public function updateCurrent()
    {
        if (!empty($this->storeCode) && !empty($this->partCode)) {
           return $this->update($this->storeCode,$this->partCode);
        } else {
            return false;
        }
    }

}
?>
