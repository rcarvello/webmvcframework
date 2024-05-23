<?php
/**
 * Class BeanCategory
 * Bean class for ORM management of the MySQL table category
 *
 * Comment of the managed table category: Not specified.
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
 * @filesource BeanCategory.php
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

class BeanCategory extends MySqlRecord implements Bean
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
     * Class attribute for mapping the primary key category_id of table category
     *
     * Comment for field category_id: Not specified<br>
     * @var int $categoryId
     */
    private $categoryId;

    /**
     * A class attribute for evaluating if the table has an autoincrement primary key
     * @var bool $isPkAutoIncrement
     */
    private $isPkAutoIncrement = true;

    /**
     * Class attribute for mapping table field category_name
     *
     * Comment for field category_name: Not specified.<br>
     * Field information:
     *  - Data type: varchar(20)
     *  - Null : NO
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $categoryName
     */
    private $categoryName;

    /**
     * Class attribute for mapping table field list_order
     *
     * Comment for field list_order: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 0
     *  - Extra:  
     * @var int $listOrder
     */
    private $listOrder;

    /**
     * Class attribute for storing the SQL DDL of table category
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBjYXRlZ29yeWAgKAogIGBjYXRlZ29yeV9pZGAgaW50KDExKSBOT1QgTlVMTCBBVVRPX0lOQ1JFTUVOVCwKICBgY2F0ZWdvcnlfbmFtZWAgdmFyY2hhcigyMCkgTk9UIE5VTEwsCiAgYGxpc3Rfb3JkZXJgIGludCgxMSkgREVGQVVMVCAnMCcsCiAgUFJJTUFSWSBLRVkgKGBjYXRlZ29yeV9pZGApCikgRU5HSU5FPUlubm9EQiBBVVRPX0lOQ1JFTUVOVD0xOSBERUZBVUxUIENIQVJTRVQ9dXRmOCBQQUNLX0tFWVM9MA==";

    /**
     * setCategoryId Sets the class attribute categoryId with a given value
     *
     * The attribute categoryId maps the field category_id defined as int(11).<br>
     * Comment for field category_id: Not specified.<br>
     * @param int $categoryId
     * @category Modifier
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = (int)$categoryId;
    }

    /**
     * setCategoryName Sets the class attribute categoryName with a given value
     *
     * The attribute categoryName maps the field category_name defined as varchar(20).<br>
     * Comment for field category_name: Not specified.<br>
     * @param string $categoryName
     * @category Modifier
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = (string)$categoryName;
    }

    /**
     * setListOrder Sets the class attribute listOrder with a given value
     *
     * The attribute listOrder maps the field list_order defined as int(11).<br>
     * Comment for field list_order: Not specified.<br>
     * @param int $listOrder
     * @category Modifier
     */
    public function setListOrder($listOrder)
    {
        $this->listOrder = (int)$listOrder;
    }

    /**
     * getCategoryId gets the class attribute categoryId value
     *
     * The attribute categoryId maps the field category_id defined as int(11).<br>
     * Comment for field category_id: Not specified.
     * @return int $categoryId
     * @category Accessor of $categoryId
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * getCategoryName gets the class attribute categoryName value
     *
     * The attribute categoryName maps the field category_name defined as varchar(20).<br>
     * Comment for field category_name: Not specified.
     * @return string $categoryName
     * @category Accessor of $categoryName
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * getListOrder gets the class attribute listOrder value
     *
     * The attribute listOrder maps the field list_order defined as int(11).<br>
     * Comment for field list_order: Not specified.
     * @return int $listOrder
     * @category Accessor of $listOrder
     */
    public function getListOrder()
    {
        return $this->listOrder;
    }

    /**
     * Gets DDL SQL code of the table category
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
        return "category";
    }

    /**
     * The BeanCategory constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $categoryId is given.
     *  - with a fetched data row from the table category having category_id=$categoryId
     * @param int $categoryId. If omitted an empty (not fetched) instance is created.
     * @return BeanCategory Object
     */
    public function __construct($categoryId = null)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($categoryId)) {
            $this->select($categoryId);
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
     * Fetchs a table row of category into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $categoryId the primary key category_id value of table category which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($categoryId)
    {
        $sql =  "SELECT * FROM category WHERE category_id={$this->parseValue($categoryId,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->categoryId = (integer)$rowObject->category_id;
            @$this->categoryName = $this->replaceAposBackSlash($rowObject->category_name);
            @$this->listOrder = (integer)$rowObject->list_order;
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table category
     * @param int $categoryId the primary key category_id value of table category which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($categoryId)
    {
        $sql = "DELETE FROM category WHERE category_id={$this->parseValue($categoryId,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of category
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->categoryId = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO category
            (category_name,list_order)
            VALUES(
			{$this->parseValue($this->categoryName,'notNumber')},
			{$this->parseValue($this->listOrder)})
SQL;
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        } else {
            $this->allowUpdate = true;
            if ($this->isPkAutoIncrement) {
                $this->categoryId = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table category with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $categoryId the primary key category_id value of table category which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($categoryId)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                category
            SET 
				category_name={$this->parseValue($this->categoryName,'notNumber')},
				list_order={$this->parseValue($this->listOrder)}
            WHERE
                category_id={$this->parseValue($categoryId,'int')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($categoryId);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a row of category previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @category DML Helper
     * @return mixed MySQLi update result
     */
    public function updateCurrent()
    {
        if ($this->categoryId != "") {
            return $this->update($this->categoryId);
        } else {
            return false;
        }
    }

}
?>
