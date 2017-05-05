<?php
/**
 * Class BeanBom
 * Bean class for object oriented management of the MySQL table bom
 *
 * Comment of the managed table bom: Bills of matirials.
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
 * @filesource BeanBom.php
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


class BeanBom extends MySqlRecord 
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
     * Class attribute for mapping table field parent_part_code
     *
     * Comment for field parent_part_code: Not specified.<br>
     * Field information:
     *  - Data type: varchar(40)
     *  - Null : NO
     *  - DB Index: PRI
     *  - Default: 
     *  - Extra:  
     * @var string $parentPartCode
     */
    private $parentPartCode;

    /**
     * Class attribute for mapping table field child_part_code
     *
     * Comment for field child_part_code: Not specified.<br>
     * Field information:
     *  - Data type: varchar(40)
     *  - Null : NO
     *  - DB Index: PRI
     *  - Default: 
     *  - Extra:  
     * @var string $childPartCode
     */
    private $childPartCode;

    /**
     * Class attribute for mapping table field quantity
     *
     * Comment for field quantity: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var int $quantity
     */
    private $quantity;

    /**
     * Class attribute for storing the SQL DDL of table bom
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBib21gICgKICBgcGFyZW50X3BhcnRfY29kZWAgdmFyY2hhcig0MCkgTk9UIE5VTEwsCiAgYGNoaWxkX3BhcnRfY29kZWAgdmFyY2hhcig0MCkgTk9UIE5VTEwsCiAgYHF1YW50aXR5YCBpbnQoMTEpIERFRkFVTFQgTlVMTCwKICBQUklNQVJZIEtFWSAoYHBhcmVudF9wYXJ0X2NvZGVgLGBjaGlsZF9wYXJ0X2NvZGVgKSwKICBLRVkgYGZrX2JvbV9wYXJ0MV9pZHhgIChgY2hpbGRfcGFydF9jb2RlYCksCiAgQ09OU1RSQUlOVCBgZmtfYm9tX3BhcnRgIEZPUkVJR04gS0VZIChgcGFyZW50X3BhcnRfY29kZWApIFJFRkVSRU5DRVMgYHBhcnRgIChgcGFydF9jb2RlYCkgT04gREVMRVRFIE5PIEFDVElPTiBPTiBVUERBVEUgTk8gQUNUSU9OLAogIENPTlNUUkFJTlQgYGZrX2JvbV9wYXJ0MWAgRk9SRUlHTiBLRVkgKGBjaGlsZF9wYXJ0X2NvZGVgKSBSRUZFUkVOQ0VTIGBwYXJ0YCAoYHBhcnRfY29kZWApIE9OIERFTEVURSBOTyBBQ1RJT04gT04gVVBEQVRFIE5PIEFDVElPTgopIEVOR0lORT1Jbm5vREIgREVGQVVMVCBDSEFSU0VUPXV0ZjggQ09NTUVOVD0nQmlsbHMgb2YgbWF0aXJpYWxzJw==";

    /**
     * setParentPartCode Sets the class attribute parentPartCode with a given value
     *
     * The attribute parentPartCode maps the field parent_part_code defined as varchar(40).<br>
     * Comment for field parent_part_code: Not specified.<br>
     * @param string $parentPartCode
     * @category Modifier
     */
    public function setParentPartCode($parentPartCode)
    {
        $this->parentPartCode = (string)$parentPartCode;
    }

    /**
     * setChildPartCode Sets the class attribute childPartCode with a given value
     *
     * The attribute childPartCode maps the field child_part_code defined as varchar(40).<br>
     * Comment for field child_part_code: Not specified.<br>
     * @param string $childPartCode
     * @category Modifier
     */
    public function setChildPartCode($childPartCode)
    {
        $this->childPartCode = (string)$childPartCode;
    }

    /**
     * setQuantity Sets the class attribute quantity with a given value
     *
     * The attribute quantity maps the field quantity defined as int(11).<br>
     * Comment for field quantity: Not specified.<br>
     * @param int $quantity
     * @category Modifier
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int)$quantity;
    }

    /**
     * getParentPartCode gets the class attribute parentPartCode value
     *
     * The attribute parentPartCode maps the field parent_part_code defined as varchar(40).<br>
     * Comment for field parent_part_code: Not specified.
     * @return string $parentPartCode
     * @category Accessor of $parentPartCode
     */
    public function getParentPartCode()
    {
        return $this->parentPartCode;
    }

    /**
     * getChildPartCode gets the class attribute childPartCode value
     *
     * The attribute childPartCode maps the field child_part_code defined as varchar(40).<br>
     * Comment for field child_part_code: Not specified.
     * @return string $childPartCode
     * @category Accessor of $childPartCode
     */
    public function getChildPartCode()
    {
        return $this->childPartCode;
    }

    /**
     * getQuantity gets the class attribute quantity value
     *
     * The attribute quantity maps the field quantity defined as int(11).<br>
     * Comment for field quantity: Not specified.
     * @return int $quantity
     * @category Accessor of $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Gets DDL SQL code of the table bom
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
        return "bom";
    }

    /**
    * The BeanBom constructor
    *
    * It creates and initializes an object in two way:
    *  - with null (not fetched) data if none ${ClassPkAttributeName} is given.
    *  - with a fetched data row from the table {TableName} having {TablePkName}=${ClassPkAttributeName}
	* @param string $parentPartCode
	* @param string $childPartCode
    * @return BeanBom Object
    */
    public function __construct($parentPartCode=NULL,$childPartCode=NULL)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($parentPartCode) && !empty($childPartCode)) {
            $this->select($parentPartCode,$childPartCode);
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
    * Fetchs a table row of bom into the object.
    *
    * Fetched table fields values are assigned to class attributes and they can be managed by using
    * the accessors/modifiers methods of the class.
	* @param string $parentPartCode
	* @param string $childPartCode
    * @return int affected selected row
    * @category DML
    */
    public function select($parentPartCode,$childPartCode)
    {
        $sql =  "SELECT * FROM bom WHERE parent_part_code={$this->parseValue($parentPartCode,'string')} AND child_part_code={$this->parseValue($childPartCode,'string')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->parentPartCode = $this->replaceAposBackSlash($rowObject->parent_part_code);
            @$this->childPartCode = $this->replaceAposBackSlash($rowObject->child_part_code);
            @$this->quantity = (integer)$rowObject->quantity;
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
    return $this->affected_rows;
    }

    /**
    * Deletes a specific row from the table bom
	* @param string $parentPartCode
	* @param string $childPartCode
    * @return int affected deleted row
    * @category DML
    */
    public function delete($parentPartCode,$childPartCode)
    {
        $sql = "DELETE FROM bom WHERE parent_part_code={$this->parseValue($parentPartCode,'string')} AND child_part_code={$this->parseValue($childPartCode,'string')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
    * Insert the current object into a new table row of bom
    *
    * All class attributes values defined for mapping all table fields are automatically used during inserting
    * @return mixed MySQL insert result
    * @category DML
    */
    public function insert()
    {
        // $constants = get_defined_constants();
        $sql = <<< SQL
        INSERT INTO bom
        (parent_part_code,child_part_code,quantity)
        VALUES({$this->parseValue($this->parentPartCode,'notNumber')},
			{$this->parseValue($this->childPartCode,'notNumber')},
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
    * Updates a specific row from the table bom with the values of the current object.
    *
    * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
    * Null values are used for all attributes not previously setted.
	* @param string $parentPartCode
	* @param string $childPartCode
    * @return mixed MySQL update result
    * @category DML
    */
    public function update($parentPartCode,$childPartCode)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                bom
                SET 
				quantity={$this->parseValue($this->quantity)}
            WHERE
                parent_part_code={$this->parseValue($parentPartCode,'string')} AND child_part_code={$this->parseValue($childPartCode,'string')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            }   else {
                $this->select($parentPartCode,$childPartCode);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
    * Facility for updating a row of bom previously loaded.
    *
    * All class attribute values defined for mapping all table fields are automatically used during updating.
    * @category DML Helper
    * @return mixed MySQLi update result
    */
    public function updateCurrent()
    {
        if (!empty($this->parentPartCode) && !empty($this->childPartCode)) {
           return $this->update($this->parentPartCode,$this->childPartCode);
        } else {
            return false;
        }
    }

}
?>
