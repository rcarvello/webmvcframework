<?php
/**
 * Class BeanWikiUser
 * Bean class for ORM management of the MySQL table wiki_user
 *
 * Comment of the managed table wiki_user: Not specified.
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
 * @filesource BeanWikiUser.php
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

class BeanWikiUser extends MySqlRecord implements Bean
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
     * Class attribute for mapping the primary key user_id of table wiki_user
     *
     * Comment for field user_id: Not specified<br>
     * @var int $userId
     */
    private $userId;

    /**
     * A class attribute for evaluating if the table has an autoincrement primary key
     * @var bool $isPkAutoIncrement
     */
    private $isPkAutoIncrement = true;

    /**
     * Class attribute for mapping table field user_name
     *
     * Comment for field user_name: Not specified.<br>
     * Field information:
     *  - Data type: varchar(45)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $userName
     */
    private $userName;

    /**
     * Class attribute for mapping table field user_email
     *
     * Comment for field user_email: Not specified.<br>
     * Field information:
     *  - Data type: varchar(100)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $userEmail
     */
    private $userEmail;

    /**
     * Class attribute for storing the SQL DDL of table wiki_user
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGB3aWtpX3VzZXJgICgKICBgdXNlcl9pZGAgaW50KDExKSBOT1QgTlVMTCBBVVRPX0lOQ1JFTUVOVCwKICBgdXNlcl9uYW1lYCB2YXJjaGFyKDQ1KSBERUZBVUxUIE5VTEwsCiAgYHVzZXJfZW1haWxgIHZhcmNoYXIoMTAwKSBERUZBVUxUIE5VTEwsCiAgUFJJTUFSWSBLRVkgKGB1c2VyX2lkYCkKKSBFTkdJTkU9SW5ub0RCIEFVVE9fSU5DUkVNRU5UPTQgREVGQVVMVCBDSEFSU0VUPXV0Zjg=";

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
     * setUserName Sets the class attribute userName with a given value
     *
     * The attribute userName maps the field user_name defined as varchar(45).<br>
     * Comment for field user_name: Not specified.<br>
     * @param string $userName
     * @category Modifier
     */
    public function setUserName($userName)
    {
        $this->userName = (string)$userName;
    }

    /**
     * setUserEmail Sets the class attribute userEmail with a given value
     *
     * The attribute userEmail maps the field user_email defined as varchar(100).<br>
     * Comment for field user_email: Not specified.<br>
     * @param string $userEmail
     * @category Modifier
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = (string)$userEmail;
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
     * getUserName gets the class attribute userName value
     *
     * The attribute userName maps the field user_name defined as varchar(45).<br>
     * Comment for field user_name: Not specified.
     * @return string $userName
     * @category Accessor of $userName
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * getUserEmail gets the class attribute userEmail value
     *
     * The attribute userEmail maps the field user_email defined as varchar(100).<br>
     * Comment for field user_email: Not specified.
     * @return string $userEmail
     * @category Accessor of $userEmail
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Gets DDL SQL code of the table wiki_user
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
        return "wiki_user";
    }

    /**
     * The BeanWikiUser constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $userId is given.
     *  - with a fetched data row from the table wiki_user having user_id=$userId
     * @param int $userId. If omitted an empty (not fetched) instance is created.
     * @return BeanWikiUser Object
     */
    public function __construct($userId = null)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($userId)) {
            $this->select($userId);
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
     * Fetchs a table row of wiki_user into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $userId the primary key user_id value of table wiki_user which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($userId)
    {
        $sql =  "SELECT * FROM wiki_user WHERE user_id={$this->parseValue($userId,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->userId = (integer)$rowObject->user_id;
            @$this->userName = $this->replaceAposBackSlash($rowObject->user_name);
            @$this->userEmail = $this->replaceAposBackSlash($rowObject->user_email);
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table wiki_user
     * @param int $userId the primary key user_id value of table wiki_user which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($userId)
    {
        $sql = "DELETE FROM wiki_user WHERE user_id={$this->parseValue($userId,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of wiki_user
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->userId = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO wiki_user
            (user_name,user_email)
            VALUES(
			{$this->parseValue($this->userName,'notNumber')},
			{$this->parseValue($this->userEmail,'notNumber')})
SQL;
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        } else {
            $this->allowUpdate = true;
            if ($this->isPkAutoIncrement) {
                $this->userId = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table wiki_user with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $userId the primary key user_id value of table wiki_user which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($userId)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                wiki_user
            SET 
				user_name={$this->parseValue($this->userName,'notNumber')},
				user_email={$this->parseValue($this->userEmail,'notNumber')}
            WHERE
                user_id={$this->parseValue($userId,'int')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($userId);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a row of wiki_user previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @category DML Helper
     * @return mixed MySQLi update result
     */
    public function updateCurrent()
    {
        if ($this->userId != "") {
            return $this->update($this->userId);
        } else {
            return false;
        }
    }

}
?>
