<?php
/**
 * Class BeanCustomer
 * Bean class for object oriented management of the MySQL table customer
 *
 * Comment of the managed table customer: Not specified.
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
 * @filesource BeanCustomer.php
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

class BeanCustomer extends MySqlRecord implements Bean
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
     * Class attribute for mapping the primary key customer_id of table customer
     *
     * Comment for field customer_id: Not specified<br>
     * @var int $customerId
     */
    private $customerId;

    /**
     * A class attribute for evaluating if the table has an autoincrement primary key
     * @var bool $isPkAutoIncrement
     */
    private $isPkAutoIncrement = true;

    /**
     * Class attribute for mapping table field customer_name
     *
     * Comment for field customer_name: Not specified.<br>
     * Field information:
     *  - Data type: varchar(45)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $customerName
     */
    private $customerName;

    /**
     * Class attribute for storing the SQL DDL of table customer
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBjdXN0b21lcmAgKAogIGBjdXN0b21lcl9pZGAgaW50KDExKSBOT1QgTlVMTCBBVVRPX0lOQ1JFTUVOVCwKICBgY3VzdG9tZXJfbmFtZWAgdmFyY2hhcig0NSkgREVGQVVMVCBOVUxMLAogIFBSSU1BUlkgS0VZIChgY3VzdG9tZXJfaWRgKQopIEVOR0lORT1Jbm5vREIgREVGQVVMVCBDSEFSU0VUPXV0Zjg=";

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
     * setCustomerName Sets the class attribute customerName with a given value
     *
     * The attribute customerName maps the field customer_name defined as varchar(45).<br>
     * Comment for field customer_name: Not specified.<br>
     * @param string $customerName
     * @category Modifier
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = (string)$customerName;
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
     * getCustomerName gets the class attribute customerName value
     *
     * The attribute customerName maps the field customer_name defined as varchar(45).<br>
     * Comment for field customer_name: Not specified.
     * @return string $customerName
     * @category Accessor of $customerName
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Gets DDL SQL code of the table customer
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
        return "customer";
    }

    /**
     * The BeanCustomer constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $customerId is given.
     *  - with a fetched data row from the table customer having customer_id=$customerId
     * @param int $customerId. If omitted an empty (not fetched) instance is created.
     * @return BeanCustomer Object
     */
    public function __construct($customerId = null)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($customerId)) {
            $this->select($customerId);
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
     * Fetchs a table row of customer into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $customerId the primary key customer_id value of table customer which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($customerId)
    {
        $sql =  "SELECT * FROM customer WHERE customer_id={$this->parseValue($customerId,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->customerId = (integer)$rowObject->customer_id;
            @$this->customerName = $this->replaceAposBackSlash($rowObject->customer_name);
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table customer
     * @param int $customerId the primary key customer_id value of table customer which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($customerId)
    {
        $sql = "DELETE FROM customer WHERE customer_id={$this->parseValue($customerId,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of customer
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->customerId = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO customer
            (customer_name)
            VALUES(
			{$this->parseValue($this->customerName,'notNumber')})
SQL;
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        } else {
            $this->allowUpdate = true;
            if ($this->isPkAutoIncrement) {
                $this->customerId = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table customer with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $customerId the primary key customer_id value of table customer which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($customerId)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                customer
            SET 
				customer_name={$this->parseValue($this->customerName,'notNumber')}
            WHERE
                customer_id={$this->parseValue($customerId,'int')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($customerId);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a row of customer previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @category DML Helper
     * @return mixed MySQLi update result
     */
    public function updateCurrent()
    {
        if ($this->customerId != "") {
            return $this->update($this->customerId);
        } else {
            return false;
        }
    }

}
?>
