<?php
/**
 * Class BeanCustomer
 * Bean class for ORM management of the MySQL table customer
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
 * @copyright (c) 2016-2023 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
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
     * Class attribute for mapping table field email
     *
     * Comment for field email: Not specified.<br>
     * Field information:
     *  - Data type: varchar(100)
     *  - Null : NO
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $email
     */
    private $email;

    /**
     * Class attribute for mapping table field nationality
     *
     * Comment for field nationality: Not specified.<br>
     * Field information:
     *  - Data type: varchar(4)
     *  - Null : NO
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $nationality
     */
    private $nationality;

    /**
     * Class attribute for mapping table field assurance
     *
     * Comment for field assurance: Not specified.<br>
     * Field information:
     *  - Data type: int(1)
     *  - Null : NO
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var int $assurance
     */
    private $assurance;

    /**
     * Class attribute for storing the SQL DDL of table customer
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBjdXN0b21lcmAgKAogIGBjdXN0b21lcl9pZGAgaW50KDExKSBOT1QgTlVMTCBBVVRPX0lOQ1JFTUVOVCwKICBgbmFtZWAgdmFyY2hhcig0NSkgREVGQVVMVCBOVUxMLAogIGBlbWFpbGAgdmFyY2hhcigxMDApIE5PVCBOVUxMLAogIGBuYXRpb25hbGl0eWAgdmFyY2hhcig0KSBOT1QgTlVMTCwKICBgYXNzdXJhbmNlYCBpbnQoMSkgTk9UIE5VTEwsCiAgUFJJTUFSWSBLRVkgKGBjdXN0b21lcl9pZGApCikgRU5HSU5FPUlubm9EQiBBVVRPX0lOQ1JFTUVOVD0zIERFRkFVTFQgQ0hBUlNFVD11dGY4";

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
     * setEmail Sets the class attribute email with a given value
     *
     * The attribute email maps the field email defined as varchar(100).<br>
     * Comment for field email: Not specified.<br>
     * @param string $email
     * @category Modifier
     */
    public function setEmail($email)
    {
        $this->email = (string)$email;
    }

    /**
     * setNationality Sets the class attribute nationality with a given value
     *
     * The attribute nationality maps the field nationality defined as varchar(4).<br>
     * Comment for field nationality: Not specified.<br>
     * @param string $nationality
     * @category Modifier
     */
    public function setNationality($nationality)
    {
        $this->nationality = (string)$nationality;
    }

    /**
     * setAssurance Sets the class attribute assurance with a given value
     *
     * The attribute assurance maps the field assurance defined as int(1).<br>
     * Comment for field assurance: Not specified.<br>
     * @param int $assurance
     * @category Modifier
     */
    public function setAssurance($assurance)
    {
        $this->assurance = (int)$assurance;
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
     * getEmail gets the class attribute email value
     *
     * The attribute email maps the field email defined as varchar(100).<br>
     * Comment for field email: Not specified.
     * @return string $email
     * @category Accessor of $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * getNationality gets the class attribute nationality value
     *
     * The attribute nationality maps the field nationality defined as varchar(4).<br>
     * Comment for field nationality: Not specified.
     * @return string $nationality
     * @category Accessor of $nationality
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * getAssurance gets the class attribute assurance value
     *
     * The attribute assurance maps the field assurance defined as int(1).<br>
     * Comment for field assurance: Not specified.
     * @return int $assurance
     * @category Accessor of $assurance
     */
    public function getAssurance()
    {
        return $this->assurance;
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
        // unset($this);
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
            @$this->name = $this->replaceAposBackSlash($rowObject->name);
            @$this->email = $this->replaceAposBackSlash($rowObject->email);
            @$this->nationality = $this->replaceAposBackSlash($rowObject->nationality);
            @$this->assurance = (integer)$rowObject->assurance;
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
            (name,email,nationality,assurance)
            VALUES(
			{$this->parseValue($this->name,'notNumber')},
			{$this->parseValue($this->email,'notNumber')},
			{$this->parseValue($this->nationality,'notNumber')},
			{$this->parseValue($this->assurance)})
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
				name={$this->parseValue($this->name,'notNumber')},
				email={$this->parseValue($this->email,'notNumber')},
				nationality={$this->parseValue($this->nationality,'notNumber')},
				assurance={$this->parseValue($this->assurance)}
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
