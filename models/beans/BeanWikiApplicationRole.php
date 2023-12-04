<?php
/**
 * Class BeanWikiApplicationRole
 * Bean class for ORM management of the MySQL table wiki_application_role
 *
 * Comment of the managed table wiki_application_role: Not specified.
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
 * @filesource BeanWikiApplicationRole.php
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

class BeanWikiApplicationRole extends MySqlRecord implements Bean
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
     * Class attribute for mapping the primary key role_id of table wiki_application_role
     *
     * Comment for field role_id: Not specified<br>
     * @var int $roleId
     */
    private $roleId;

    /**
     * A class attribute for evaluating if the table has an autoincrement primary key
     * @var bool $isPkAutoIncrement
     */
    private $isPkAutoIncrement = true;

    /**
     * Class attribute for mapping table field role_name
     *
     * Comment for field role_name: Not specified.<br>
     * Field information:
     *  - Data type: varchar(45)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $roleName
     */
    private $roleName;

    /**
     * Class attribute for storing the SQL DDL of table wiki_application_role
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGB3aWtpX2FwcGxpY2F0aW9uX3JvbGVgICgKICBgcm9sZV9pZGAgaW50KDExKSBOT1QgTlVMTCBBVVRPX0lOQ1JFTUVOVCwKICBgcm9sZV9uYW1lYCB2YXJjaGFyKDQ1KSBERUZBVUxUIE5VTEwsCiAgUFJJTUFSWSBLRVkgKGByb2xlX2lkYCkKKSBFTkdJTkU9SW5ub0RCIEFVVE9fSU5DUkVNRU5UPTYgREVGQVVMVCBDSEFSU0VUPXV0Zjg=";

    /**
     * setRoleId Sets the class attribute roleId with a given value
     *
     * The attribute roleId maps the field role_id defined as int(11).<br>
     * Comment for field role_id: Not specified.<br>
     * @param int $roleId
     * @category Modifier
     */
    public function setRoleId($roleId)
    {
        $this->roleId = (int)$roleId;
    }

    /**
     * setRoleName Sets the class attribute roleName with a given value
     *
     * The attribute roleName maps the field role_name defined as varchar(45).<br>
     * Comment for field role_name: Not specified.<br>
     * @param string $roleName
     * @category Modifier
     */
    public function setRoleName($roleName)
    {
        $this->roleName = (string)$roleName;
    }

    /**
     * getRoleId gets the class attribute roleId value
     *
     * The attribute roleId maps the field role_id defined as int(11).<br>
     * Comment for field role_id: Not specified.
     * @return int $roleId
     * @category Accessor of $roleId
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * getRoleName gets the class attribute roleName value
     *
     * The attribute roleName maps the field role_name defined as varchar(45).<br>
     * Comment for field role_name: Not specified.
     * @return string $roleName
     * @category Accessor of $roleName
     */
    public function getRoleName()
    {
        return $this->roleName;
    }

    /**
     * Gets DDL SQL code of the table wiki_application_role
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
        return "wiki_application_role";
    }

    /**
     * The BeanWikiApplicationRole constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $roleId is given.
     *  - with a fetched data row from the table wiki_application_role having role_id=$roleId
     * @param int $roleId. If omitted an empty (not fetched) instance is created.
     * @return BeanWikiApplicationRole Object
     */
    public function __construct($roleId = null)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($roleId)) {
            $this->select($roleId);
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
     * Fetchs a table row of wiki_application_role into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $roleId the primary key role_id value of table wiki_application_role which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($roleId)
    {
        $sql =  "SELECT * FROM wiki_application_role WHERE role_id={$this->parseValue($roleId,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->roleId = (integer)$rowObject->role_id;
            @$this->roleName = $this->replaceAposBackSlash($rowObject->role_name);
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table wiki_application_role
     * @param int $roleId the primary key role_id value of table wiki_application_role which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($roleId)
    {
        $sql = "DELETE FROM wiki_application_role WHERE role_id={$this->parseValue($roleId,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of wiki_application_role
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->roleId = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO wiki_application_role
            (role_name)
            VALUES(
			{$this->parseValue($this->roleName,'notNumber')})
SQL;
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        } else {
            $this->allowUpdate = true;
            if ($this->isPkAutoIncrement) {
                $this->roleId = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table wiki_application_role with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $roleId the primary key role_id value of table wiki_application_role which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($roleId)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                wiki_application_role
            SET 
				role_name={$this->parseValue($this->roleName,'notNumber')}
            WHERE
                role_id={$this->parseValue($roleId,'int')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($roleId);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a row of wiki_application_role previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @category DML Helper
     * @return mixed MySQLi update result
     */
    public function updateCurrent()
    {
        if ($this->roleId != "") {
            return $this->update($this->roleId);
        } else {
            return false;
        }
    }

}
?>
