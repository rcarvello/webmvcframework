<?php
/**
 * Class BeanCustomerOrder
 * Bean class for object oriented management of the MySQL table customer_order
 *
 * Comment of the managed table customer_order: Not specified.
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
 * @filesource BeanCustomerOrder.php
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

class BeanCustomerOrder extends MySqlRecord implements Bean
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
     * Class attribute for mapping the primary key order_id of table customer_order
     *
     * Comment for field order_id: Not specified<br>
     * @var int $orderId
     */
    private $orderId;

    /**
     * A class attribute for evaluating if the table has an autoincrement primary key
     * @var bool $isPkAutoIncrement
     */
    private $isPkAutoIncrement = true;

    /**
     * Class attribute for mapping table field order_date
     *
     * Comment for field order_date: Not specified.<br>
     * Field information:
     *  - Data type: string|date
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $orderDate
     */
    private $orderDate;

    /**
     * Class attribute for mapping table field customer_id
     *
     * Comment for field customer_id: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : NO
     *  - DB Index: MUL
     *  - Default: 
     *  - Extra:  
     * @var int $customerId
     */
    private $customerId;

    /**
     * Class attribute for mapping table field order_status_id
     *
     * Comment for field order_status_id: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : NO
     *  - DB Index: MUL
     *  - Default: 
     *  - Extra:  
     * @var int $orderStatusId
     */
    private $orderStatusId;

    /**
     * Class attribute for storing the SQL DDL of table customer_order
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBjdXN0b21lcl9vcmRlcmAgKAogIGBvcmRlcl9pZGAgaW50KDExKSBOT1QgTlVMTCBBVVRPX0lOQ1JFTUVOVCwKICBgb3JkZXJfZGF0ZWAgZGF0ZSBERUZBVUxUIE5VTEwsCiAgYGN1c3RvbWVyX2lkYCBpbnQoMTEpIE5PVCBOVUxMLAogIGBvcmRlcl9zdGF0dXNfaWRgIGludCgxMSkgTk9UIE5VTEwsCiAgUFJJTUFSWSBLRVkgKGBvcmRlcl9pZGApLAogIEtFWSBgZmtfb3JkZXJfY3VzdG9tZXIxX2lkeGAgKGBjdXN0b21lcl9pZGApLAogIEtFWSBgZmtfb3JkZXJfb3JkZXJfc3RhdHVzMV9pZHhgIChgb3JkZXJfc3RhdHVzX2lkYCksCiAgQ09OU1RSQUlOVCBgZmtfb3JkZXJfY3VzdG9tZXIxYCBGT1JFSUdOIEtFWSAoYGN1c3RvbWVyX2lkYCkgUkVGRVJFTkNFUyBgY3VzdG9tZXJgIChgY3VzdG9tZXJfaWRgKSBPTiBERUxFVEUgTk8gQUNUSU9OIE9OIFVQREFURSBOTyBBQ1RJT04sCiAgQ09OU1RSQUlOVCBgZmtfb3JkZXJfb3JkZXJfc3RhdHVzMWAgRk9SRUlHTiBLRVkgKGBvcmRlcl9zdGF0dXNfaWRgKSBSRUZFUkVOQ0VTIGBvcmRlcl9zdGF0dXNgIChgb3JkZXJfc3RhdHVzX2lkYCkgT04gREVMRVRFIE5PIEFDVElPTiBPTiBVUERBVEUgTk8gQUNUSU9OCikgRU5HSU5FPUlubm9EQiBERUZBVUxUIENIQVJTRVQ9dXRmOA==";

    /**
     * setOrderId Sets the class attribute orderId with a given value
     *
     * The attribute orderId maps the field order_id defined as int(11).<br>
     * Comment for field order_id: Not specified.<br>
     * @param int $orderId
     * @category Modifier
     */
    public function setOrderId($orderId)
    {
        $this->orderId = (int)$orderId;
    }

    /**
     * setOrderDate Sets the class attribute orderDate with a given value
     *
     * The attribute orderDate maps the field order_date defined as string|date.<br>
     * Comment for field order_date: Not specified.<br>
     * @param string $orderDate
     * @category Modifier
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = (string)$orderDate;
    }

    /**
     * setCustomerId Sets the class attribute customerId with a given value
     *
     * The attribute customerId maps the field customer_id defined as int(11).<br>
     * Comment for field customer_id: Not specified.<br>
     * @param int $customerId
     * @category Modifier
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = (int)$customerId;
    }

    /**
     * setOrderStatusId Sets the class attribute orderStatusId with a given value
     *
     * The attribute orderStatusId maps the field order_status_id defined as int(11).<br>
     * Comment for field order_status_id: Not specified.<br>
     * @param int $orderStatusId
     * @category Modifier
     */
    public function setOrderStatusId($orderStatusId)
    {
        $this->orderStatusId = (int)$orderStatusId;
    }

    /**
     * getOrderId gets the class attribute orderId value
     *
     * The attribute orderId maps the field order_id defined as int(11).<br>
     * Comment for field order_id: Not specified.
     * @return int $orderId
     * @category Accessor of $orderId
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * getOrderDate gets the class attribute orderDate value
     *
     * The attribute orderDate maps the field order_date defined as string|date.<br>
     * Comment for field order_date: Not specified.
     * @return string $orderDate
     * @category Accessor of $orderDate
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * getCustomerId gets the class attribute customerId value
     *
     * The attribute customerId maps the field customer_id defined as int(11).<br>
     * Comment for field customer_id: Not specified.
     * @return int $customerId
     * @category Accessor of $customerId
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * getOrderStatusId gets the class attribute orderStatusId value
     *
     * The attribute orderStatusId maps the field order_status_id defined as int(11).<br>
     * Comment for field order_status_id: Not specified.
     * @return int $orderStatusId
     * @category Accessor of $orderStatusId
     */
    public function getOrderStatusId()
    {
        return $this->orderStatusId;
    }

    /**
     * Gets DDL SQL code of the table customer_order
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
        return "customer_order";
    }

    /**
     * The BeanCustomerOrder constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $orderId is given.
     *  - with a fetched data row from the table customer_order having order_id=$orderId
     * @param int $orderId. If omitted an empty (not fetched) instance is created.
     * @return BeanCustomerOrder Object
     */
    public function __construct($orderId = null)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($orderId)) {
            $this->select($orderId);
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
     * Fetchs a table row of customer_order into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $orderId the primary key order_id value of table customer_order which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($orderId)
    {
        $sql =  "SELECT * FROM customer_order WHERE order_id={$this->parseValue($orderId,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->orderId = (integer)$rowObject->order_id;
            @$this->orderDate = empty($rowObject->order_date) ? null : date(FETCHED_DATE_FORMAT,strtotime($rowObject->order_date));
            @$this->customerId = (integer)$rowObject->customer_id;
            @$this->orderStatusId = (integer)$rowObject->order_status_id;
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table customer_order
     * @param int $orderId the primary key order_id value of table customer_order which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($orderId)
    {
        $sql = "DELETE FROM customer_order WHERE order_id={$this->parseValue($orderId,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of customer_order
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->orderId = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO customer_order
            (order_date,customer_id,order_status_id)
            VALUES(
			{$this->parseValue($this->orderDate,'date')},
			{$this->parseValue($this->customerId)},
			{$this->parseValue($this->orderStatusId)})
SQL;
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        } else {
            $this->allowUpdate = true;
            if ($this->isPkAutoIncrement) {
                $this->orderId = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table customer_order with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $orderId the primary key order_id value of table customer_order which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($orderId)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                customer_order
            SET 
				order_date={$this->parseValue($this->orderDate,'date')},
				customer_id={$this->parseValue($this->customerId)},
				order_status_id={$this->parseValue($this->orderStatusId)}
            WHERE
                order_id={$this->parseValue($orderId,'int')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($orderId);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a row of customer_order previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @category DML Helper
     * @return mixed MySQLi update result
     */
    public function updateCurrent()
    {
        if ($this->orderId != "") {
            return $this->update($this->orderId);
        } else {
            return false;
        }
    }

}
?>
