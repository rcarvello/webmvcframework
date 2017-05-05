<?php
/**
 * Class BeanOrderFile
 * Bean class for object oriented management of the MySQL table order_file
 *
 * Comment of the managed table order_file: Not specified.
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
 * @filesource BeanOrderFile.php
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

class BeanOrderFile extends MySqlRecord implements Bean
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
     * Class attribute for mapping the primary key order_file_id of table order_file
     *
     * Comment for field order_file_id: Not specified<br>
     * @var int $orderFileId
     */
    private $orderFileId;

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
     * Class attribute for mapping table field path
     *
     * Comment for field path: Not specified.<br>
     * Field information:
     *  - Data type: varchar(45)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $path
     */
    private $path;

    /**
     * Class attribute for mapping table field order_id
     *
     * Comment for field order_id: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : NO
     *  - DB Index: MUL
     *  - Default: 
     *  - Extra:  
     * @var int $orderId
     */
    private $orderId;

    /**
     * Class attribute for mapping table field file_type_id
     *
     * Comment for field file_type_id: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : NO
     *  - DB Index: MUL
     *  - Default: 
     *  - Extra:  
     * @var int $fileTypeId
     */
    private $fileTypeId;

    /**
     * Class attribute for mapping table field revision_n
     *
     * Comment for field revision_n: Not specified.<br>
     * Field information:
     *  - Data type: varchar(10)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $revisionN
     */
    private $revisionN;

    /**
     * Class attribute for mapping table field revision_date
     *
     * Comment for field revision_date: Not specified.<br>
     * Field information:
     *  - Data type: string|date
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $revisionDate
     */
    private $revisionDate;

    /**
     * Class attribute for storing the SQL DDL of table order_file
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBvcmRlcl9maWxlYCAoCiAgYG9yZGVyX2ZpbGVfaWRgIGludCgxMSkgTk9UIE5VTEwsCiAgYG5hbWVgIHZhcmNoYXIoNDUpIERFRkFVTFQgTlVMTCwKICBgcGF0aGAgdmFyY2hhcig0NSkgREVGQVVMVCBOVUxMLAogIGBvcmRlcl9pZGAgaW50KDExKSBOT1QgTlVMTCwKICBgZmlsZV90eXBlX2lkYCBpbnQoMTEpIE5PVCBOVUxMLAogIGByZXZpc2lvbl9uYCB2YXJjaGFyKDEwKSBERUZBVUxUIE5VTEwsCiAgYHJldmlzaW9uX2RhdGVgIGRhdGUgREVGQVVMVCBOVUxMLAogIFBSSU1BUlkgS0VZIChgb3JkZXJfZmlsZV9pZGApLAogIEtFWSBgZmtfb3JkZXJfZmlsZV9vcmRlcjFfaWR4YCAoYG9yZGVyX2lkYCksCiAgS0VZIGBma19vcmRlcl9maWxlX2ZpbGVfdHlwZTFfaWR4YCAoYGZpbGVfdHlwZV9pZGApLAogIENPTlNUUkFJTlQgYGZrX29yZGVyX2ZpbGVfZmlsZV90eXBlMWAgRk9SRUlHTiBLRVkgKGBmaWxlX3R5cGVfaWRgKSBSRUZFUkVOQ0VTIGBmaWxlX3R5cGVgIChgZmlsZV90eXBlX2lkYCkgT04gREVMRVRFIE5PIEFDVElPTiBPTiBVUERBVEUgTk8gQUNUSU9OLAogIENPTlNUUkFJTlQgYGZrX29yZGVyX2ZpbGVfb3JkZXIxYCBGT1JFSUdOIEtFWSAoYG9yZGVyX2lkYCkgUkVGRVJFTkNFUyBgY3VzdG9tZXJfb3JkZXJgIChgb3JkZXJfaWRgKSBPTiBERUxFVEUgTk8gQUNUSU9OIE9OIFVQREFURSBOTyBBQ1RJT04KKSBFTkdJTkU9SW5ub0RCIERFRkFVTFQgQ0hBUlNFVD11dGY4";

    /**
     * setOrderFileId Sets the class attribute orderFileId with a given value
     *
     * The attribute orderFileId maps the field order_file_id defined as int(11).<br>
     * Comment for field order_file_id: Not specified.<br>
     * @param int $orderFileId
     * @category Modifier
     */
    public function setOrderFileId($orderFileId)
    {
        $this->orderFileId = (int)$orderFileId;
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
     * setPath Sets the class attribute path with a given value
     *
     * The attribute path maps the field path defined as varchar(45).<br>
     * Comment for field path: Not specified.<br>
     * @param string $path
     * @category Modifier
     */
    public function setPath($path)
    {
        $this->path = (string)$path;
    }

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
     * setFileTypeId Sets the class attribute fileTypeId with a given value
     *
     * The attribute fileTypeId maps the field file_type_id defined as int(11).<br>
     * Comment for field file_type_id: Not specified.<br>
     * @param int $fileTypeId
     * @category Modifier
     */
    public function setFileTypeId($fileTypeId)
    {
        $this->fileTypeId = (int)$fileTypeId;
    }

    /**
     * setRevisionN Sets the class attribute revisionN with a given value
     *
     * The attribute revisionN maps the field revision_n defined as varchar(10).<br>
     * Comment for field revision_n: Not specified.<br>
     * @param string $revisionN
     * @category Modifier
     */
    public function setRevisionN($revisionN)
    {
        $this->revisionN = (string)$revisionN;
    }

    /**
     * setRevisionDate Sets the class attribute revisionDate with a given value
     *
     * The attribute revisionDate maps the field revision_date defined as string|date.<br>
     * Comment for field revision_date: Not specified.<br>
     * @param string $revisionDate
     * @category Modifier
     */
    public function setRevisionDate($revisionDate)
    {
        $this->revisionDate = (string)$revisionDate;
    }

    /**
     * getOrderFileId gets the class attribute orderFileId value
     *
     * The attribute orderFileId maps the field order_file_id defined as int(11).<br>
     * Comment for field order_file_id: Not specified.
     * @return int $orderFileId
     * @category Accessor of $orderFileId
     */
    public function getOrderFileId()
    {
        return $this->orderFileId;
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
     * getPath gets the class attribute path value
     *
     * The attribute path maps the field path defined as varchar(45).<br>
     * Comment for field path: Not specified.
     * @return string $path
     * @category Accessor of $path
     */
    public function getPath()
    {
        return $this->path;
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
     * getFileTypeId gets the class attribute fileTypeId value
     *
     * The attribute fileTypeId maps the field file_type_id defined as int(11).<br>
     * Comment for field file_type_id: Not specified.
     * @return int $fileTypeId
     * @category Accessor of $fileTypeId
     */
    public function getFileTypeId()
    {
        return $this->fileTypeId;
    }

    /**
     * getRevisionN gets the class attribute revisionN value
     *
     * The attribute revisionN maps the field revision_n defined as varchar(10).<br>
     * Comment for field revision_n: Not specified.
     * @return string $revisionN
     * @category Accessor of $revisionN
     */
    public function getRevisionN()
    {
        return $this->revisionN;
    }

    /**
     * getRevisionDate gets the class attribute revisionDate value
     *
     * The attribute revisionDate maps the field revision_date defined as string|date.<br>
     * Comment for field revision_date: Not specified.
     * @return string $revisionDate
     * @category Accessor of $revisionDate
     */
    public function getRevisionDate()
    {
        return $this->revisionDate;
    }

    /**
     * Gets DDL SQL code of the table order_file
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
        return "order_file";
    }

    /**
     * The BeanOrderFile constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $orderFileId is given.
     *  - with a fetched data row from the table order_file having order_file_id=$orderFileId
     * @param int $orderFileId. If omitted an empty (not fetched) instance is created.
     * @return BeanOrderFile Object
     */
    public function __construct($orderFileId = null)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($orderFileId)) {
            $this->select($orderFileId);
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
     * Fetchs a table row of order_file into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $orderFileId the primary key order_file_id value of table order_file which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($orderFileId)
    {
        $sql =  "SELECT * FROM order_file WHERE order_file_id={$this->parseValue($orderFileId,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->orderFileId = (integer)$rowObject->order_file_id;
            @$this->name = $this->replaceAposBackSlash($rowObject->name);
            @$this->path = $this->replaceAposBackSlash($rowObject->path);
            @$this->orderId = (integer)$rowObject->order_id;
            @$this->fileTypeId = (integer)$rowObject->file_type_id;
            @$this->revisionN = $this->replaceAposBackSlash($rowObject->revision_n);
            @$this->revisionDate = empty($rowObject->revision_date) ? null : date(FETCHED_DATE_FORMAT,strtotime($rowObject->revision_date));
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table order_file
     * @param int $orderFileId the primary key order_file_id value of table order_file which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($orderFileId)
    {
        $sql = "DELETE FROM order_file WHERE order_file_id={$this->parseValue($orderFileId,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of order_file
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->orderFileId = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO order_file
            (order_file_id,name,path,order_id,file_type_id,revision_n,revision_date)
            VALUES({$this->parseValue($this->orderFileId)},
			{$this->parseValue($this->name,'notNumber')},
			{$this->parseValue($this->path,'notNumber')},
			{$this->parseValue($this->orderId)},
			{$this->parseValue($this->fileTypeId)},
			{$this->parseValue($this->revisionN,'notNumber')},
			{$this->parseValue($this->revisionDate,'date')})
SQL;
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        } else {
            $this->allowUpdate = true;
            if ($this->isPkAutoIncrement) {
                $this->orderFileId = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table order_file with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $orderFileId the primary key order_file_id value of table order_file which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($orderFileId)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                order_file
            SET 
				name={$this->parseValue($this->name,'notNumber')},
				path={$this->parseValue($this->path,'notNumber')},
				order_id={$this->parseValue($this->orderId)},
				file_type_id={$this->parseValue($this->fileTypeId)},
				revision_n={$this->parseValue($this->revisionN,'notNumber')},
				revision_date={$this->parseValue($this->revisionDate,'date')}
            WHERE
                order_file_id={$this->parseValue($orderFileId,'int')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($orderFileId);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a row of order_file previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @category DML Helper
     * @return mixed MySQLi update result
     */
    public function updateCurrent()
    {
        if ($this->orderFileId != "") {
            return $this->update($this->orderFileId);
        } else {
            return false;
        }
    }

}
?>
