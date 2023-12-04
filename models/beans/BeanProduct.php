<?php
/**
 * Class BeanProduct
 * Bean class for ORM management of the MySQL table product
 *
 * Comment of the managed table product: Not specified.
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
 * @filesource BeanProduct.php
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

class BeanProduct extends MySqlRecord implements Bean
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
     * Class attribute for mapping the primary key product_id of table product
     *
     * Comment for field product_id: Not specified<br>
     * @var int $productId
     */
    private $productId;

    /**
     * A class attribute for evaluating if the table has an autoincrement primary key
     * @var bool $isPkAutoIncrement
     */
    private $isPkAutoIncrement = true;

    /**
     * Class attribute for mapping table field product_name
     *
     * Comment for field product_name: Not specified.<br>
     * Field information:
     *  - Data type: varchar(20)
     *  - Null : NO
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $productName
     */
    private $productName;

    /**
     * Class attribute for mapping table field category_id
     *
     * Comment for field category_id: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : YES
     *  - DB Index: MUL
     *  - Default: 
     *  - Extra:  
     * @var int $categoryId
     */
    private $categoryId;

    /**
     * Class attribute for mapping table field list_order
     *
     * Comment for field list_order: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : NO
     *  - DB Index: 
     *  - Default: 0
     *  - Extra:  
     * @var int $listOrder
     */
    private $listOrder;

    /**
     * Class attribute for storing the SQL DDL of table product
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBwcm9kdWN0YCAoCiAgYHByb2R1Y3RfaWRgIGludCgxMSkgTk9UIE5VTEwgQVVUT19JTkNSRU1FTlQsCiAgYHByb2R1Y3RfbmFtZWAgdmFyY2hhcigyMCkgTk9UIE5VTEwsCiAgYGNhdGVnb3J5X2lkYCBpbnQoMTEpIERFRkFVTFQgTlVMTCwKICBgbGlzdF9vcmRlcmAgaW50KDExKSBOT1QgTlVMTCBERUZBVUxUICcwJywKICBQUklNQVJZIEtFWSAoYHByb2R1Y3RfaWRgKSwKICBLRVkgYGNhdGVnb3J5X2lkYCAoYGNhdGVnb3J5X2lkYCksCiAgQ09OU1RSQUlOVCBgcHJvZHVjdF9ma19jYXRlZ29yeWAgRk9SRUlHTiBLRVkgKGBjYXRlZ29yeV9pZGApIFJFRkVSRU5DRVMgYGNhdGVnb3J5YCAoYGNhdGVnb3J5X2lkYCkKKSBFTkdJTkU9SW5ub0RCIEFVVE9fSU5DUkVNRU5UPTkgREVGQVVMVCBDSEFSU0VUPXV0ZjggUEFDS19LRVlTPTA=";

    /**
     * setProductId Sets the class attribute productId with a given value
     *
     * The attribute productId maps the field product_id defined as int(11).<br>
     * Comment for field product_id: Not specified.<br>
     * @param int $productId
     * @category Modifier
     */
    public function setProductId($productId)
    {
        $this->productId = (int)$productId;
    }

    /**
     * setProductName Sets the class attribute productName with a given value
     *
     * The attribute productName maps the field product_name defined as varchar(20).<br>
     * Comment for field product_name: Not specified.<br>
     * @param string $productName
     * @category Modifier
     */
    public function setProductName($productName)
    {
        $this->productName = (string)$productName;
    }

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
     * getProductId gets the class attribute productId value
     *
     * The attribute productId maps the field product_id defined as int(11).<br>
     * Comment for field product_id: Not specified.
     * @return int $productId
     * @category Accessor of $productId
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * getProductName gets the class attribute productName value
     *
     * The attribute productName maps the field product_name defined as varchar(20).<br>
     * Comment for field product_name: Not specified.
     * @return string $productName
     * @category Accessor of $productName
     */
    public function getProductName()
    {
        return $this->productName;
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
     * Gets DDL SQL code of the table product
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
        return "product";
    }

    /**
     * The BeanProduct constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $productId is given.
     *  - with a fetched data row from the table product having product_id=$productId
     * @param int $productId. If omitted an empty (not fetched) instance is created.
     * @return BeanProduct Object
     */
    public function __construct($productId = null)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($productId)) {
            $this->select($productId);
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
     * Fetchs a table row of product into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $productId the primary key product_id value of table product which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($productId)
    {
        $sql =  "SELECT * FROM product WHERE product_id={$this->parseValue($productId,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->productId = (integer)$rowObject->product_id;
            @$this->productName = $this->replaceAposBackSlash($rowObject->product_name);
            @$this->categoryId = (integer)$rowObject->category_id;
            @$this->listOrder = (integer)$rowObject->list_order;
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table product
     * @param int $productId the primary key product_id value of table product which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($productId)
    {
        $sql = "DELETE FROM product WHERE product_id={$this->parseValue($productId,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of product
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->productId = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO product
            (product_name,category_id,list_order)
            VALUES(
			{$this->parseValue($this->productName,'notNumber')},
			{$this->parseValue($this->categoryId)},
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
                $this->productId = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table product with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $productId the primary key product_id value of table product which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($productId)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                product
            SET 
				product_name={$this->parseValue($this->productName,'notNumber')},
				category_id={$this->parseValue($this->categoryId)},
				list_order={$this->parseValue($this->listOrder)}
            WHERE
                product_id={$this->parseValue($productId,'int')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($productId);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a row of product previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @category DML Helper
     * @return mixed MySQLi update result
     */
    public function updateCurrent()
    {
        if ($this->productId != "") {
            return $this->update($this->productId);
        } else {
            return false;
        }
    }

}
?>
