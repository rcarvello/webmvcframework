<?php
/**
 * Class BeanUser
 * Bean class for object oriented management of the MySQL table user
 *
 * Comment of the managed table user: Users credentials.
 *
 * Responsibility:
 *
 *  - provides instance constructor for both managing of a fetched table or for a new row
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
 * @filesource BeanUser.php
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

class BeanUser extends MySqlRecord implements Bean
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
     * Class attribute for mapping the primary key id_user of table user
     *
     * Comment for field id_user: Not specified<br>
     * @var int $idUser
     */
    private $idUser;

    /**
     * A class attribute for evaluating if the table has an autoincrement primary key
     * @var bool $isPkAutoIncrement
     */
    private $isPkAutoIncrement = true;

    /**
     * Class attribute for mapping table field id_access_level
     *
     * Comment for field id_access_level: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : NO
     *  - DB Index: MUL
     *  - Default:
     *  - Extra:
     * @var int $idAccessLevel
     */
    private $idAccessLevel;

    /**
     * Class attribute for mapping table field full_name
     *
     * Comment for field full_name: Not specified.<br>
     * Field information:
     *  - Data type: varchar(45)
     *  - Null : NO
     *  - DB Index: MUL
     *  - Default:
     *  - Extra:
     * @var string $fullName
     */
    private $fullName;

    /**
     * Class attribute for mapping table field email
     *
     * Comment for field email: Not specified.<br>
     * Field information:
     *  - Data type: varchar(100)
     *  - Null : NO
     *  - DB Index: UNI
     *  - Default:
     *  - Extra:
     * @var string $email
     */
    private $email;

    /**
     * Class attribute for mapping table field password
     *
     * Comment for field password: Not specified.<br>
     * Field information:
     *  - Data type: varchar(200)
     *  - Null : NO
     *  - DB Index:
     *  - Default:
     *  - Extra:
     * @var string $password
     */
    private $password;

    /**
     * Class attribute for mapping table field salt
     *
     * Comment for field salt: Not specified.<br>
     * Field information:
     *  - Data type: varchar(200)
     *  - Null : NO
     *  - DB Index:
     *  - Default:
     *  - Extra:
     * @var string $salt
     */
    private $salt;

    /**
     * Class attribute for mapping table field enabled
     *
     * Comment for field enabled: Not specified.<br>
     * Field information:
     *  - Data type: int(1)
     *  - Null : NO
     *  - DB Index:
     *  - Default: 1
     *  - Extra:
     * @var int $enabled
     */
    private $enabled;

    /**
     * Class attribute for storing the SQL DDL of table user
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGB1c2VyYCAoCiAgYGlkX3VzZXJgIGludCgxMSkgTk9UIE5VTEwgQVVUT19JTkNSRU1FTlQsCiAgYGlkX2FjY2Vzc19sZXZlbGAgaW50KDExKSBOT1QgTlVMTCwKICBgZnVsbF9uYW1lYCB2YXJjaGFyKDQ1KSBOT1QgTlVMTCwKICBgZW1haWxgIHZhcmNoYXIoMTAwKSBOT1QgTlVMTCwKICBgcGFzc3dvcmRgIHZhcmNoYXIoMjAwKSBOT1QgTlVMTCwKICBgc2FsdGAgdmFyY2hhcigyMDApIE5PVCBOVUxMLAogIGBlbmFibGVkYCBpbnQoMSkgTk9UIE5VTEwgREVGQVVMVCAnMScsCiAgUFJJTUFSWSBLRVkgKGBpZF91c2VyYCksCiAgVU5JUVVFIEtFWSBgdW5pcXVlX2VtYWlsYCAoYGVtYWlsYCksCiAgS0VZIGBma191c2VyX2FjY2Vzc19sZXZlbF9pZHhgIChgaWRfYWNjZXNzX2xldmVsYCksCiAgS0VZIGBpZHhfZnVsbF9uYW1lYCAoYGZ1bGxfbmFtZWApLAogIENPTlNUUkFJTlQgYGZrX3VzZXJfYWNjZXNzX2xldmVsMWAgRk9SRUlHTiBLRVkgKGBpZF9hY2Nlc3NfbGV2ZWxgKSBSRUZFUkVOQ0VTIGBhY2Nlc3NfbGV2ZWxgIChgaWRfYWNjZXNzX2xldmVsYCkgT04gREVMRVRFIE5PIEFDVElPTiBPTiBVUERBVEUgTk8gQUNUSU9OCikgRU5HSU5FPUlubm9EQiBBVVRPX0lOQ1JFTUVOVD02IERFRkFVTFQgQ0hBUlNFVD11dGY4IENPTU1FTlQ9J1VzZXJzIGNyZWRlbnRpYWxzJw==";

    /**
     * Class attribute for storing the JSON result of a user selected row
     * @var string jsonResults
     */
    private $jsonResults = array();

    /**
     * Get JSON results
     * # @note You need to call select method before getting updated data
     * @return array JSON results
     */
    public function getJsonResults()
    {
        return $this->jsonResults;
    }

    /**
     * setIdUser Sets the class attribute idUser with a given value
     *
     * The attribute idUser maps the field id_user defined as int(11).<br>
     * Comment for field id_user: Not specified.<br>
     * @param int $idUser
     * @category Modifier
     */
    public function setIdUser($idUser)
    {
        // $this->idUser = (int)$idUser;
        $this->idUser = (int)$this->real_escape_string($idUser);
    }

    /**
     * setIdAccessLevel Sets the class attribute idAccessLevel with a given value
     *
     * The attribute idAccessLevel maps the field id_access_level defined as int(11).<br>
     * Comment for field id_access_level: Not specified.<br>
     * @param int $idAccessLevel
     * @category Modifier
     */
    public function setIdAccessLevel($idAccessLevel)
    {
        // $this->idAccessLevel = (int)$idAccessLevel;
        $this->idAccessLevel = (int)$this->real_escape_string($idAccessLevel);
    }

    /**
     * setFullName Sets the class attribute fullName with a given value
     *
     * The attribute fullName maps the field full_name defined as varchar(45).<br>
     * Comment for field full_name: Not specified.<br>
     * @param string $fullName
     * @category Modifier
     */
    public function setFullName($fullName)
    {
        // $this->fullName = (string)$fullName;
        $this->fullName = (string)$this->real_escape_string($fullName);
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
        // $this->email = (string)$email;
        $this->email = (string)$this->real_escape_string($email);
    }

    /**
     * setPassword Sets the class attribute password with a given value
     *
     * The attribute password maps the field password defined as varchar(200).<br>
     * Comment for field password: Not specified.<br>
     * @param string $password
     * @category Modifier
     */
    public function setPassword($password)
    {
        // $this->password = (string)$password;
        $this->password = (string)$this->real_escape_string($password);
    }

    /**
     * setSalt Sets the class attribute salt with a given value
     *
     * The attribute salt maps the field salt defined as varchar(200).<br>
     * Comment for field salt: Not specified.<br>
     * @param string $salt
     * @category Modifier
     */
    public function setSalt($salt)
    {
        // $this->salt = (string)$salt;
        $this->salt = (string)$this->real_escape_string($salt);
    }

    /**
     * setEnabled Sets the class attribute enabled with a given value
     *
     * The attribute enabled maps the field enabled defined as int(1).<br>
     * Comment for field enabled: Not specified.<br>
     * @param int $enabled
     * @category Modifier
     */
    public function setEnabled($enabled)
    {
        // $this->enabled = (int)$enabled;
        $this->enabled = (int)$this->real_escape_string($enabled);
    }

    /**
     * getIdUser gets the class attribute idUser value
     *
     * The attribute idUser maps the field id_user defined as int(11).<br>
     * Comment for field id_user: Not specified.
     * @return int $idUser
     * @category Accessor of $idUser
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * getIdAccessLevel gets the class attribute idAccessLevel value
     *
     * The attribute idAccessLevel maps the field id_access_level defined as int(11).<br>
     * Comment for field id_access_level: Not specified.
     * @return int $idAccessLevel
     * @category Accessor of $idAccessLevel
     */
    public function getIdAccessLevel()
    {
        return $this->idAccessLevel;
    }

    /**
     * getFullName gets the class attribute fullName value
     *
     * The attribute fullName maps the field full_name defined as varchar(45).<br>
     * Comment for field full_name: Not specified.
     * @return string $fullName
     * @category Accessor of $fullName
     */
    public function getFullName()
    {
        return $this->fullName;
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
     * getPassword gets the class attribute password value
     *
     * The attribute password maps the field password defined as varchar(200).<br>
     * Comment for field password: Not specified.
     * @return string $password
     * @category Accessor of $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * getSalt gets the class attribute salt value
     *
     * The attribute salt maps the field salt defined as varchar(200).<br>
     * Comment for field salt: Not specified.
     * @return string $salt
     * @category Accessor of $salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * getEnabled gets the class attribute enabled value
     *
     * The attribute enabled maps the field enabled defined as int(1).<br>
     * Comment for field enabled: Not specified.
     * @return int $enabled
     * @category Accessor of $enabled
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Gets DDL SQL code of the table user
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
        return "user";
    }

    /**
     * The BeanUser constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $idUser is given.
     *  - with a fetched data row from the table user having id_user=$idUser
     * @param int $idUser. If omitted an empty (not fetched) instance is created.
     * @return BeanUser Object
     */
    public function __construct($idUser = null)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($idUser)) {
            $this->select($idUser);
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
     * Fetchs a table row of user into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $idUser the primary key id_user value of table user which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($idUser)
    {
        $sql =  "SELECT * FROM user WHERE id_user={$this->parseValue($idUser,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->idUser = (integer)$rowObject->id_user;
            @$this->idAccessLevel = (integer)$rowObject->id_access_level;
            @$this->fullName = $this->replaceAposBackSlash($rowObject->full_name);
            @$this->email = $this->replaceAposBackSlash($rowObject->email);
            @$this->password = $this->replaceAposBackSlash($rowObject->password);
            @$this->salt = $this->replaceAposBackSlash($rowObject->salt);
            @$this->enabled = (integer)$rowObject->enabled;
            $this->allowUpdate = true;
            $resultArray = $this->query($sql);
            while ($row = $resultArray->fetch_array(MYSQLI_ASSOC)) {
                $resultsArray[] = $row;
            }
            if (!empty($resultsArray))
                $this->jsonResults = json_encode($resultsArray);
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table user
     * @param int $idUser the primary key id_user value of table user which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($idUser)
    {
        $sql = "DELETE FROM user WHERE id_user={$this->parseValue($idUser,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of user
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->idUser = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO user
            (id_access_level,full_name,email,password,salt,enabled)
            VALUES(
			{$this->parseValue($this->idAccessLevel)},
			{$this->parseValue($this->fullName,'notNumber')},
			{$this->parseValue($this->email,'notNumber')},
			{$this->parseValue($this->password,'notNumber')},
			{$this->parseValue($this->salt,'notNumber')},
			{$this->parseValue($this->enabled)})
SQL;
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        } else {
            $this->allowUpdate = true;
            if ($this->isPkAutoIncrement) {
                $this->idUser = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table user with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $idUser the primary key id_user value of table user which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($idUser)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                user
            SET 
				id_access_level={$this->parseValue($this->idAccessLevel)},
				full_name={$this->parseValue($this->fullName,'notNumber')},
				email={$this->parseValue($this->email,'notNumber')},
				password={$this->parseValue($this->password,'notNumber')},
				salt={$this->parseValue($this->salt,'notNumber')},
				enabled={$this->parseValue($this->enabled)}
            WHERE
                id_user={$this->parseValue($idUser,'int')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($idUser);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a rows of user previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @return mixed MySQLi update result
     *@category DML Helper
     */
    public function updateCurrent()
    {
        if ($this->idUser != "") {
            return $this->update($this->idUser);
        } else {
            return false;
        }
    }

}
?>
