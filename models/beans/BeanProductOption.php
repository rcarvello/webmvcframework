<?php
/**
 * Class BeanProductOption
 * Bean class for ORM management of the MySQL table product_option
 *
 * Comment of the managed table product_option: Not specified.
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
 * @filesource BeanProductOption.php
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

class BeanProductOption extends MySqlRecord implements Bean
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
     * Class attribute for mapping the primary key product_option_id of table product_option
     *
     * Comment for field product_option_id: Not specified<br>
     * @var int $productOptionId
     */
    private $productOptionId;

    /**
     * A class attribute for evaluating if the table has an autoincrement primary key
     * @var bool $isPkAutoIncrement
     */
    private $isPkAutoIncrement = true;

    /**
     * Class attribute for mapping table field option_name
     *
     * Comment for field option_name: Not specified.<br>
     * Field information:
     *  - Data type: varchar(30)
     *  - Null : NO
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $optionName
     */
    private $optionName;

    /**
     * Class attribute for mapping table field product_id
     *
     * Comment for field product_id: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : YES
     *  - DB Index: MUL
     *  - Default: 
     *  - Extra:  
     * @var int $productId
     */
    private $productId;

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
     * Class attribute for storing the SQL DDL of table product_option
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBwcm9kdWN0X29wdGlvbmAgKAogIGBwcm9kdWN0X29wdGlvbl9pZGAgaW50KDExKSBOT1QgTlVMTCBBVVRPX0lOQ1JFTUVOVCwKICBgb3B0aW9uX25hbWVgIHZhcmNoYXIoMzApIE5PVCBOVUxMLAogIGBwcm9kdWN0X2lkYCBpbnQoMTEpIERFRkFVTFQgTlVMTCwKICBgbGlzdF9vcmRlcmAgaW50KDExKSBOT1QgTlVMTCBERUZBVUxUICcwJywKICBQUklNQVJZIEtFWSAoYHByb2R1Y3Rfb3B0aW9uX2lkYCksCiAgS0VZIGBwcm9kdWN0X2lkYCAoYHByb2R1Y3RfaWRgKSwKICBDT05TVFJBSU5UIGBwcm9kdWN0X29wdGlvbl9ma2AgRk9SRUlHTiBLRVkgKGBwcm9kdWN0X2lkYCkgUkVGRVJFTkNFUyBgcHJvZHVjdGAgKGBwcm9kdWN0X2lkYCkKKSBFTkdJTkU9SW5ub0RCIEFVVE9fSU5DUkVNRU5UPTE1IERFRkFVTFQgQ0hBUlNFVD11dGY4IFBBQ0tfS0VZUz0w";

    /**
     * setProductOptionId Sets the class attribute productOptionId with a given value
     *
     * The attribute productOptionId maps the field product_option_id defined as int(11).<br>
     * Comment for field product_option_id: Not specified.<br>
     * @param int $productOptionId
     * @category Modifier
     */
    public function setProductOptionId($productOptionId)
    {
        $this->productOptionId = (int)$productOptionId;
    }

    /**
     * setOptionName Sets the class attribute optionName with a given value
     *
     * The attribute optionName maps the field option_name defined as varchar(30).<br>
     * Comment for field option_name: Not specified.<br>
     * @param string $optionName
     * @category Modifier
     */
    public function setOptionName($optionName)
    {
        $this->optionName = (string)$optionName;
    }

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
     * getProductOptionId gets the class attribute productOptionId value
     *
     * The attribute productOptionId maps the field product_option_id defined as int(11).<br>
     * Comment for field product_option_id: Not specified.
     * @return int $productOptionId
     * @category Accessor of $productOptionId
     */
    public function getProductOptionId()
    {
        return $this->productOptionId;
    }

    /**
     * getOptionName gets the class attribute optionName value
     *
     * The attribute optionName maps the field option_name defined as varchar(30).<br>
     * Comment for field option_name: Not specified.
     * @return string $optionName
     * @category Accessor of $optionName
     */
    public function getOptionName()
    {
        return $this->optionName;
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
     * Gets DDL SQL code of the table product_option
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
        return "product_option";
    }

    /**
     * The BeanProductOption constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $productOptionId is given.
     *  - with a fetched data row from the table product_option having product_option_id=$productOptionId
     * @param int $productOptionId. If omitted an empty (not fetched) instance is created.
     * @return BeanProductOption Object
     */
    public function __construct($productOptionId = null)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($productOptionId)) {
            $this->select($productOptionId);
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
     * Fetchs a table row of product_option into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $productOptionId the primary key product_option_id value of table product_option which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($productOptionId)
    {
        $sql =  "SELECT * FROM product_option WHERE product_option_id={$this->parseValue($productOptionId,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->productOptionId = (integer)$rowObject->product_option_id;
            @$this->optionName = $this->replaceAposBackSlash($rowObject->option_name);
            @$this->productId = (integer)$rowObject->product_id;
            @$this->listOrder = (integer)$rowObject->list_order;
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table product_option
     * @param int $productOptionId the primary key product_option_id value of table product_option which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($productOptionId)
    {
        $sql = "DELETE FROM product_option WHERE product_option_id={$this->parseValue($productOptionId,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of product_option
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->productOptionId = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO product_option
            (option_name,product_id,list_order)
            VALUES(
			{$this->parseValue($this->optionName,'notNumber')},
			{$this->parseValue($this->productId)},
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
                $this->productOptionId = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table product_option with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $productOptionId the primary key product_option_id value of table product_option which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($productOptionId)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                product_option
            SET 
				option_name={$this->parseValue($this->optionName,'notNumber')},
				product_id={$this->parseValue($this->productId)},
				list_order={$this->parseValue($this->listOrder)}
            WHERE
                product_option_id={$this->parseValue($productOptionId,'int')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($productOptionId);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a row of product_option previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @category DML Helper
     * @return mixed MySQLi update result
     */
    public function updateCurrent()
    {
        if ($this->productOptionId != "") {
            return $this->update($this->productOptionId);
        } else {
            return false;
        }
    }

}
?>
