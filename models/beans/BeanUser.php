<?php
/**
 * Class BeanUser
 * Bean class for ORM management of the MySQL table user
 *
 * Comment of the managed table user: Users credentials.
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
 * @filesource BeanUser.php
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
     * Comment for field id_user: User ID<br>
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
     * Comment for field id_access_level: User Ascce Level.<br>
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
     * Comment for field full_name: User full Name.<br>
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
     * Comment for field email: User email.<br>
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
     * Comment for field password: User encrypted password.<br>
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
     * Comment for field salt: User encryption salt.<br>
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
     * Class attribute for mapping table field token
     *
     * Comment for field token: User access token.<br>
     * Field information:
     *  - Data type: varchar(200)
     *  - Null : YES
     *  - DB Index:
     *  - Default:
     *  - Extra:
     * @var string $token
     */
    private $token;

    /**
     * Class attribute for mapping table field token_timestamp
     *
     * Comment for field token_timestamp: Token timestamp validation check.<br>
     * Field information:
     *  - Data type: timestamp
     *  - Null : YES
     *  - DB Index:
     *  - Default:
     *  - Extra:  on update CURRENT_TIMESTAMP
     * @var string $tokenTimestamp
     */
    private $tokenTimestamp;

    /**
     * Class attribute for mapping table field enabled
     *
     * Comment for field enabled: User enabled flag.<br>
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
     * Class attribute for mapping table field last_login
     *
     * Comment for field last_login: Use last login date.<br>
     * Field information:
     *  - Data type: datetime
     *  - Null : YES
     *  - DB Index:
     *  - Default:
     *  - Extra:
     * @var string $lastLogin
     */
    private $lastLogin;

    /**
     * Class attribute for storing the SQL DDL of table user
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGB1c2VyYCAoCiAgYGlkX3VzZXJgIGludCgxMSkgTk9UIE5VTEwgQVVUT19JTkNSRU1FTlQgQ09NTUVOVCAnVXNlciBJRCcsCiAgYGlkX2FjY2Vzc19sZXZlbGAgaW50KDExKSBOT1QgTlVMTCBDT01NRU5UICdVc2VyIEFzY2NlIExldmVsJywKICBgZnVsbF9uYW1lYCB2YXJjaGFyKDQ1KSBOT1QgTlVMTCBDT01NRU5UICdVc2VyIGZ1bGwgTmFtZScsCiAgYGVtYWlsYCB2YXJjaGFyKDEwMCkgTk9UIE5VTEwgQ09NTUVOVCAnVXNlciBlbWFpbCcsCiAgYHBhc3N3b3JkYCB2YXJjaGFyKDIwMCkgTk9UIE5VTEwgQ09NTUVOVCAnVXNlciBlbmNyeXB0ZWQgcGFzc3dvcmQnLAogIGBzYWx0YCB2YXJjaGFyKDIwMCkgTk9UIE5VTEwgQ09NTUVOVCAnVXNlciBlbmNyeXB0aW9uIHNhbHQnLAogIGB0b2tlbmAgdmFyY2hhcigyMDApIERFRkFVTFQgTlVMTCBDT01NRU5UICdVc2VyIGFjY2VzcyB0b2tlbicsCiAgYHRva2VuX3RpbWVzdGFtcGAgdGltZXN0YW1wIE5VTEwgREVGQVVMVCBOVUxMIE9OIFVQREFURSBDVVJSRU5UX1RJTUVTVEFNUCBDT01NRU5UICdUb2tlbiB0aW1lc3RhbXAgdmFsaWRhdGlvbiBjaGVjaycsCiAgYGVuYWJsZWRgIGludCgxKSBOT1QgTlVMTCBERUZBVUxUICcxJyBDT01NRU5UICdVc2VyIGVuYWJsZWQgZmxhZycsCiAgYGxhc3RfbG9naW5gIGRhdGV0aW1lIERFRkFVTFQgTlVMTCBDT01NRU5UICdVc2UgbGFzdCBsb2dpbiBkYXRlJywKICBQUklNQVJZIEtFWSAoYGlkX3VzZXJgKSwKICBVTklRVUUgS0VZIGB1bmlxdWVfZW1haWxgIChgZW1haWxgKSwKICBLRVkgYGZrX3VzZXJfYWNjZXNzX2xldmVsX2lkeGAgKGBpZF9hY2Nlc3NfbGV2ZWxgKSwKICBLRVkgYGlkeF9mdWxsX25hbWVgIChgZnVsbF9uYW1lYCksCiAgQ09OU1RSQUlOVCBgZmtfdXNlcl9hY2Nlc3NfbGV2ZWwxYCBGT1JFSUdOIEtFWSAoYGlkX2FjY2Vzc19sZXZlbGApIFJFRkVSRU5DRVMgYGFjY2Vzc19sZXZlbGAgKGBpZF9hY2Nlc3NfbGV2ZWxgKSBPTiBERUxFVEUgTk8gQUNUSU9OIE9OIFVQREFURSBOTyBBQ1RJT04KKSBFTkdJTkU9SW5ub0RCIEFVVE9fSU5DUkVNRU5UPTYgREVGQVVMVCBDSEFSU0VUPXV0ZjggQ09NTUVOVD0nVXNlcnMgY3JlZGVudGlhbHMn";

    /**
     * setIdUser Sets the class attribute idUser with a given value
     *
     * The attribute idUser maps the field id_user defined as int(11).<br>
     * Comment for field id_user: User ID.<br>
     * @param int $idUser
     * @category Modifier
     */
    public function setIdUser($idUser)
    {
        $this->idUser = (int)$idUser;
    }

    /**
     * setIdAccessLevel Sets the class attribute idAccessLevel with a given value
     *
     * The attribute idAccessLevel maps the field id_access_level defined as int(11).<br>
     * Comment for field id_access_level: User Ascce Level.<br>
     * @param int $idAccessLevel
     * @category Modifier
     */
    public function setIdAccessLevel($idAccessLevel)
    {
        $this->idAccessLevel = (int)$idAccessLevel;
    }

    /**
     * setFullName Sets the class attribute fullName with a given value
     *
     * The attribute fullName maps the field full_name defined as varchar(45).<br>
     * Comment for field full_name: User full Name.<br>
     * @param string $fullName
     * @category Modifier
     */
    public function setFullName($fullName)
    {
        $this->fullName = (string)$fullName;
    }

    /**
     * setEmail Sets the class attribute email with a given value
     *
     * The attribute email maps the field email defined as varchar(100).<br>
     * Comment for field email: User email.<br>
     * @param string $email
     * @category Modifier
     */
    public function setEmail($email)
    {
        $this->email = (string)$email;
    }

    /**
     * setPassword Sets the class attribute password with a given value
     *
     * The attribute password maps the field password defined as varchar(200).<br>
     * Comment for field password: User encrypted password.<br>
     * @param string $password
     * @category Modifier
     */
    public function setPassword($password)
    {
        $this->password = (string)$password;
    }

    /**
     * setSalt Sets the class attribute salt with a given value
     *
     * The attribute salt maps the field salt defined as varchar(200).<br>
     * Comment for field salt: User encryption salt.<br>
     * @param string $salt
     * @category Modifier
     */
    public function setSalt($salt)
    {
        $this->salt = (string)$salt;
    }

    /**
     * setToken Sets the class attribute token with a given value
     *
     * The attribute token maps the field token defined as varchar(200).<br>
     * Comment for field token: User access token.<br>
     * @param string $token
     * @category Modifier
     */
    public function setToken($token)
    {
        $this->token = (string)$token;
    }

    /**
     * setTokenTimestamp Sets the class attribute tokenTimestamp with a given value
     *
     * The attribute tokenTimestamp maps the field token_timestamp defined as timestamp.<br>
     * Comment for field token_timestamp: Token timestamp validation check.<br>
     * @param string $tokenTimestamp
     * @category Modifier
     */
    public function setTokenTimestamp($tokenTimestamp)
    {
        $this->tokenTimestamp = (string)$tokenTimestamp;
    }

    /**
     * setEnabled Sets the class attribute enabled with a given value
     *
     * The attribute enabled maps the field enabled defined as int(1).<br>
     * Comment for field enabled: User enabled flag.<br>
     * @param int $enabled
     * @category Modifier
     */
    public function setEnabled($enabled)
    {
        $this->enabled = (int)$enabled;
    }

    /**
     * setLastLogin Sets the class attribute lastLogin with a given value
     *
     * The attribute lastLogin maps the field last_login defined as datetime.<br>
     * Comment for field last_login: Use last login date.<br>
     * @param string $lastLogin
     * @category Modifier
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = (string)$lastLogin;
    }

    /**
     * getIdUser gets the class attribute idUser value
     *
     * The attribute idUser maps the field id_user defined as int(11).<br>
     * Comment for field id_user: User ID.
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
     * Comment for field id_access_level: User Ascce Level.
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
     * Comment for field full_name: User full Name.
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
     * Comment for field email: User email.
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
     * Comment for field password: User encrypted password.
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
     * Comment for field salt: User encryption salt.
     * @return string $salt
     * @category Accessor of $salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * getToken gets the class attribute token value
     *
     * The attribute token maps the field token defined as varchar(200).<br>
     * Comment for field token: User access token.
     * @return string $token
     * @category Accessor of $token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * getTokenTimestamp gets the class attribute tokenTimestamp value
     *
     * The attribute tokenTimestamp maps the field token_timestamp defined as timestamp.<br>
     * Comment for field token_timestamp: Token timestamp validation check.
     * @return string $tokenTimestamp
     * @category Accessor of $tokenTimestamp
     */
    public function getTokenTimestamp()
    {
        return $this->tokenTimestamp;
    }

    /**
     * getEnabled gets the class attribute enabled value
     *
     * The attribute enabled maps the field enabled defined as int(1).<br>
     * Comment for field enabled: User enabled flag.
     * @return int $enabled
     * @category Accessor of $enabled
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * getLastLogin gets the class attribute lastLogin value
     *
     * The attribute lastLogin maps the field last_login defined as datetime.<br>
     * Comment for field last_login: Use last login date.
     * @return string $lastLogin
     * @category Accessor of $lastLogin
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
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
            @$this->token = $this->replaceAposBackSlash($rowObject->token);
            @$this->tokenTimestamp = $rowObject->token_timestamp;
            @$this->enabled = (integer)$rowObject->enabled;
            @$this->lastLogin = empty($rowObject->last_login) ? null : date(FETCHED_DATETIME_FORMAT, strtotime($rowObject->last_login));
            $this->allowUpdate = true;
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
            (id_access_level,full_name,email,password,salt,token,token_timestamp,enabled,last_login)
            VALUES(
			{$this->parseValue($this->idAccessLevel)},
			{$this->parseValue($this->fullName,'notNumber')},
			{$this->parseValue($this->email,'notNumber')},
			{$this->parseValue($this->password,'notNumber')},
			{$this->parseValue($this->salt,'notNumber')},
			{$this->parseValue($this->token, 'notNumber')},
			{$this->parseValue($this->tokenTimestamp, 'notNumber')},
			{$this->parseValue($this->enabled)},
			{$this->parseValue($this->lastLogin, 'datetime')})
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
				token={$this->parseValue($this->token, 'notNumber')},
				token_timestamp={$this->parseValue($this->tokenTimestamp, 'notNumber')},
				enabled={$this->parseValue($this->enabled)},
				last_login={$this->parseValue($this->lastLogin, 'datetime')}
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
     * Facility for updating a row of user previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @return mixed MySQLi update result
     * @category DML Helper
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
