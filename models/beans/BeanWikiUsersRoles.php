<?php
/**
 * Class BeanWikiUsersRoles
 * Bean class for ORM management of the MySQL table wiki_users_roles
 *
 * Comment of the managed table wiki_users_roles: Not specified.
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
 * @filesource BeanWikiUsersRoles.php
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


class BeanWikiUsersRoles extends MySqlRecord 
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
     * Class attribute for mapping table field user_id
     *
     * Comment for field user_id: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : NO
     *  - DB Index: PRI
     *  - Default: 
     *  - Extra:  
     * @var int $userId
     */
    private $userId;

    /**
     * Class attribute for mapping table field role_id
     *
     * Comment for field role_id: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : NO
     *  - DB Index: PRI
     *  - Default: 
     *  - Extra:  
     * @var int $roleId
     */
    private $roleId;

    /**
     * Class attribute for storing the SQL DDL of table wiki_users_roles
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGB3aWtpX3VzZXJzX3JvbGVzYCAoCiAgYHVzZXJfaWRgIGludCgxMSkgTk9UIE5VTEwsCiAgYHJvbGVfaWRgIGludCgxMSkgTk9UIE5VTEwsCiAgUFJJTUFSWSBLRVkgKGB1c2VyX2lkYCxgcm9sZV9pZGApLAogIEtFWSBgZmtfdXNlcl9oYXNfYXBwbGljYXRpb25fcm9sZV9hcHBsaWNhdGlvbl9yb2xlMV9pZHhgIChgcm9sZV9pZGApLAogIEtFWSBgZmtfdXNlcl9oYXNfYXBwbGljYXRpb25fcm9sZV91c2VyX2lkeGAgKGB1c2VyX2lkYCksCiAgQ09OU1RSQUlOVCBgZmtfdXNlcl9oYXNfYXBwbGljYXRpb25fcm9sZV9hcHBsaWNhdGlvbl9yb2xlYCBGT1JFSUdOIEtFWSAoYHJvbGVfaWRgKSBSRUZFUkVOQ0VTIGB3aWtpX2FwcGxpY2F0aW9uX3JvbGVgIChgcm9sZV9pZGApIE9OIERFTEVURSBOTyBBQ1RJT04gT04gVVBEQVRFIE5PIEFDVElPTiwKICBDT05TVFJBSU5UIGBma191c2VyX2hhc19hcHBsaWNhdGlvbl9yb2xlX3VzZXJgIEZPUkVJR04gS0VZIChgdXNlcl9pZGApIFJFRkVSRU5DRVMgYHdpa2lfdXNlcmAgKGB1c2VyX2lkYCkgT04gREVMRVRFIE5PIEFDVElPTiBPTiBVUERBVEUgTk8gQUNUSU9OCikgRU5HSU5FPUlubm9EQiBERUZBVUxUIENIQVJTRVQ9dXRmOA==";

    /**
     * setUserId Sets the class attribute userId with a given value
     *
     * The attribute userId maps the field user_id defined as int(11).<br>
     * Comment for field user_id: Not specified.<br>
     * @param int $userId
     * @category Modifier
     */
    public function setUserId($userId)
    {
        $this->userId = (int)$userId;
    }

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
     * getUserId gets the class attribute userId value
     *
     * The attribute userId maps the field user_id defined as int(11).<br>
     * Comment for field user_id: Not specified.
     * @return int $userId
     * @category Accessor of $userId
     */
    public function getUserId()
    {
        return $this->userId;
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
     * Gets DDL SQL code of the table wiki_users_roles
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
        return "wiki_users_roles";
    }

    /**
    * The BeanWikiUsersRoles constructor
    *
    * It creates and initializes an object in two way:
    *  - with null (not fetched) data if none ${ClassPkAttributeName} is given.
    *  - with a fetched data row from the table {TableName} having {TablePkName}=${ClassPkAttributeName}
	* @param int $userId
	* @param int $roleId
    * @return BeanWikiUsersRoles Object
    */
    public function __construct($userId=NULL,$roleId=NULL)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($userId) && !empty($roleId)) {
            $this->select($userId,$roleId);
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
    }

    /**
    * Fetchs a table row of wiki_users_roles into the object.
    *
    * Fetched table fields values are assigned to class attributes and they can be managed by using
    * the accessors/modifiers methods of the class.
	* @param int $userId
	* @param int $roleId
    * @return int affected selected row
    * @category DML
    */
    public function select($userId,$roleId)
    {
        $sql =  "SELECT * FROM wiki_users_roles WHERE user_id={$this->parseValue($userId,'int')} AND role_id={$this->parseValue($roleId,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->userId = (integer)$rowObject->user_id;
            @$this->roleId = (integer)$rowObject->role_id;
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
    return $this->affected_rows;
    }

    /**
    * Deletes a specific row from the table wiki_users_roles
	* @param int $userId
	* @param int $roleId
    * @return int affected deleted row
    * @category DML
    */
    public function delete($userId,$roleId)
    {
        $sql = "DELETE FROM wiki_users_roles WHERE user_id={$this->parseValue($userId,'int')} AND role_id={$this->parseValue($roleId,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
    * Insert the current object into a new table row of wiki_users_roles
    *
    * All class attributes values defined for mapping all table fields are automatically used during inserting
    * @return mixed MySQL insert result
    * @category DML
    */
    public function insert()
    {
        // $constants = get_defined_constants();
        $sql = <<< SQL
        INSERT INTO wiki_users_roles
        (user_id,role_id)
        VALUES({$this->parseValue($this->userId)},
			{$this->parseValue($this->roleId)})
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
    * Updates a specific row from the table wiki_users_roles with the values of the current object.
    *
    * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
    * Null values are used for all attributes not previously setted.
	* @param int $userId
	* @param int $roleId
    * @return mixed MySQL update result
    * @category DML
    */
    public function update($userId,$roleId)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                wiki_users_roles
                SET 
            WHERE
                user_id={$this->parseValue($userId,'int')} AND role_id={$this->parseValue($roleId,'int')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            }   else {
                $this->select($userId,$roleId);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
    * Facility for updating a row of wiki_users_roles previously loaded.
    *
    * All class attribute values defined for mapping all table fields are automatically used during updating.
    * @category DML Helper
    * @return mixed MySQLi update result
    */
    public function updateCurrent()
    {
        if (!empty($this->userId) && !empty($this->roleId)) {
           return $this->update($this->userId,$this->roleId);
        } else {
            return false;
        }
    }

}
?>
