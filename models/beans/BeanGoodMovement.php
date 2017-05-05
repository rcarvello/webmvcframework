<?php
/**
 * Class BeanGoodMovement
 * Bean class for object oriented management of the MySQL table good_movement
 *
 * Comment of the managed table good_movement: Not specified.
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
 * @filesource BeanGoodMovement.php
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

class BeanGoodMovement extends MySqlRecord implements Bean
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
     * Class attribute for mapping the primary key good_movement_id of table good_movement
     *
     * Comment for field good_movement_id: Not specified<br>
     * @var int $goodMovementId
     */
    private $goodMovementId;

    /**
     * A class attribute for evaluating if the table has an autoincrement primary key
     * @var bool $isPkAutoIncrement
     */
    private $isPkAutoIncrement = false;

    /**
     * Class attribute for mapping table field movement_date
     *
     * Comment for field movement_date: Not specified.<br>
     * Field information:
     *  - Data type: varchar(45)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $movementDate
     */
    private $movementDate;

    /**
     * Class attribute for mapping table field part_code
     *
     * Comment for field part_code: Not specified.<br>
     * Field information:
     *  - Data type: varchar(40)
     *  - Null : NO
     *  - DB Index: MUL
     *  - Default: 
     *  - Extra:  
     * @var string $partCode
     */
    private $partCode;

    /**
     * Class attribute for mapping table field store_code
     *
     * Comment for field store_code: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : NO
     *  - DB Index: MUL
     *  - Default: 
     *  - Extra:  
     * @var int $storeCode
     */
    private $storeCode;

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
     * Class attribute for storing the SQL DDL of table good_movement
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBnb29kX21vdmVtZW50YCAoCiAgYGdvb2RfbW92ZW1lbnRfaWRgIGludCgxMSkgTk9UIE5VTEwsCiAgYG1vdmVtZW50X2RhdGVgIHZhcmNoYXIoNDUpIERFRkFVTFQgTlVMTCwKICBgcGFydF9jb2RlYCB2YXJjaGFyKDQwKSBOT1QgTlVMTCwKICBgc3RvcmVfY29kZWAgaW50KDExKSBOT1QgTlVMTCwKICBgcXVhbnRpdHlgIGRlY2ltYWwoMTEsMikgREVGQVVMVCBOVUxMLAogIFBSSU1BUlkgS0VZIChgZ29vZF9tb3ZlbWVudF9pZGApLAogIEtFWSBgZmtfaW52ZW50b3J5X2xvZ19wYXJ0MV9pZHhgIChgcGFydF9jb2RlYCksCiAgS0VZIGBma19pbnZlbnRvcnlfbG9nX3N0b3JlMV9pZHhgIChgc3RvcmVfY29kZWApLAogIENPTlNUUkFJTlQgYGZrX2ludmVudG9yeV9sb2dfcGFydDFgIEZPUkVJR04gS0VZIChgcGFydF9jb2RlYCkgUkVGRVJFTkNFUyBgcGFydGAgKGBwYXJ0X2NvZGVgKSBPTiBERUxFVEUgTk8gQUNUSU9OIE9OIFVQREFURSBOTyBBQ1RJT04sCiAgQ09OU1RSQUlOVCBgZmtfaW52ZW50b3J5X2xvZ19zdG9yZTFgIEZPUkVJR04gS0VZIChgc3RvcmVfY29kZWApIFJFRkVSRU5DRVMgYHN0b3JlYCAoYHN0b3JlX2NvZGVgKSBPTiBERUxFVEUgTk8gQUNUSU9OIE9OIFVQREFURSBOTyBBQ1RJT04KKSBFTkdJTkU9SW5ub0RCIERFRkFVTFQgQ0hBUlNFVD11dGY4";

    /**
     * setGoodMovementId Sets the class attribute goodMovementId with a given value
     *
     * The attribute goodMovementId maps the field good_movement_id defined as int(11).<br>
     * Comment for field good_movement_id: Not specified.<br>
     * @param int $goodMovementId
     * @category Modifier
     */
    public function setGoodMovementId($goodMovementId)
    {
        $this->goodMovementId = (int)$goodMovementId;
    }

    /**
     * setMovementDate Sets the class attribute movementDate with a given value
     *
     * The attribute movementDate maps the field movement_date defined as varchar(45).<br>
     * Comment for field movement_date: Not specified.<br>
     * @param string $movementDate
     * @category Modifier
     */
    public function setMovementDate($movementDate)
    {
        $this->movementDate = (string)$movementDate;
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
     * getGoodMovementId gets the class attribute goodMovementId value
     *
     * The attribute goodMovementId maps the field good_movement_id defined as int(11).<br>
     * Comment for field good_movement_id: Not specified.
     * @return int $goodMovementId
     * @category Accessor of $goodMovementId
     */
    public function getGoodMovementId()
    {
        return $this->goodMovementId;
    }

    /**
     * getMovementDate gets the class attribute movementDate value
     *
     * The attribute movementDate maps the field movement_date defined as varchar(45).<br>
     * Comment for field movement_date: Not specified.
     * @return string $movementDate
     * @category Accessor of $movementDate
     */
    public function getMovementDate()
    {
        return $this->movementDate;
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
     * Gets DDL SQL code of the table good_movement
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
        return "good_movement";
    }

    /**
     * The BeanGoodMovement constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $goodMovementId is given.
     *  - with a fetched data row from the table good_movement having good_movement_id=$goodMovementId
     * @param int $goodMovementId. If omitted an empty (not fetched) instance is created.
     * @return BeanGoodMovement Object
     */
    public function __construct($goodMovementId = null)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($goodMovementId)) {
            $this->select($goodMovementId);
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
     * Fetchs a table row of good_movement into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $goodMovementId the primary key good_movement_id value of table good_movement which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($goodMovementId)
    {
        $sql =  "SELECT * FROM good_movement WHERE good_movement_id={$this->parseValue($goodMovementId,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->goodMovementId = (integer)$rowObject->good_movement_id;
            @$this->movementDate = $this->replaceAposBackSlash($rowObject->movement_date);
            @$this->partCode = $this->replaceAposBackSlash($rowObject->part_code);
            @$this->storeCode = (integer)$rowObject->store_code;
            @$this->quantity = (float)$rowObject->quantity;
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table good_movement
     * @param int $goodMovementId the primary key good_movement_id value of table good_movement which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($goodMovementId)
    {
        $sql = "DELETE FROM good_movement WHERE good_movement_id={$this->parseValue($goodMovementId,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of good_movement
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->goodMovementId = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO good_movement
            (good_movement_id,movement_date,part_code,store_code,quantity)
            VALUES({$this->parseValue($this->goodMovementId)},
			{$this->parseValue($this->movementDate,'notNumber')},
			{$this->parseValue($this->partCode,'notNumber')},
			{$this->parseValue($this->storeCode)},
			{$this->parseValue($this->quantity)})
SQL;
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        } else {
            $this->allowUpdate = true;
            if ($this->isPkAutoIncrement) {
                $this->goodMovementId = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table good_movement with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $goodMovementId the primary key good_movement_id value of table good_movement which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($goodMovementId)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                good_movement
            SET 
				movement_date={$this->parseValue($this->movementDate,'notNumber')},
				part_code={$this->parseValue($this->partCode,'notNumber')},
				store_code={$this->parseValue($this->storeCode)},
				quantity={$this->parseValue($this->quantity)}
            WHERE
                good_movement_id={$this->parseValue($goodMovementId,'int')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($goodMovementId);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a row of good_movement previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @category DML Helper
     * @return mixed MySQLi update result
     */
    public function updateCurrent()
    {
        if ($this->goodMovementId != "") {
            return $this->update($this->goodMovementId);
        } else {
            return false;
        }
    }

}
?>
