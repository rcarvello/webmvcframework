<?php
/**
 * Class BeanOrderMacroActivity
 * Bean class for object oriented management of the MySQL table order_macro_activity
 *
 * Comment of the managed table order_macro_activity: Not specified.
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
 * @filesource BeanOrderMacroActivity.php
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

class BeanOrderMacroActivity extends MySqlRecord implements Bean
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
     * Class attribute for mapping the primary key activity_id of table order_macro_activity
     *
     * Comment for field activity_id: Not specified<br>
     * @var int $activityId
     */
    private $activityId;

    /**
     * A class attribute for evaluating if the table has an autoincrement primary key
     * @var bool $isPkAutoIncrement
     */
    private $isPkAutoIncrement = true;

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
     * Class attribute for mapping table field activity_name
     *
     * Comment for field activity_name: Not specified.<br>
     * Field information:
     *  - Data type: varchar(200)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $activityName
     */
    private $activityName;

    /**
     * Class attribute for mapping table field cost
     *
     * Comment for field cost: Not specified.<br>
     * Field information:
     *  - Data type: decimal(11,2)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var float $cost
     */
    private $cost;

    /**
     * Class attribute for mapping table field start_time
     *
     * Comment for field start_time: Not specified.<br>
     * Field information:
     *  - Data type: string|date
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $startTime
     */
    private $startTime;

    /**
     * Class attribute for mapping table field end_time
     *
     * Comment for field end_time: Not specified.<br>
     * Field information:
     *  - Data type: string|date
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $endTime
     */
    private $endTime;

    /**
     * Class attribute for storing the SQL DDL of table order_macro_activity
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBvcmRlcl9tYWNyb19hY3Rpdml0eWAgKAogIGBhY3Rpdml0eV9pZGAgaW50KDExKSBOT1QgTlVMTCBBVVRPX0lOQ1JFTUVOVCwKICBgb3JkZXJfaWRgIGludCgxMSkgTk9UIE5VTEwsCiAgYGFjdGl2aXR5X25hbWVgIHZhcmNoYXIoMjAwKSBERUZBVUxUIE5VTEwsCiAgYGNvc3RgIGRlY2ltYWwoMTEsMikgREVGQVVMVCBOVUxMLAogIGBzdGFydF90aW1lYCBkYXRlIERFRkFVTFQgTlVMTCwKICBgZW5kX3RpbWVgIGRhdGUgREVGQVVMVCBOVUxMLAogIFBSSU1BUlkgS0VZIChgYWN0aXZpdHlfaWRgKSwKICBLRVkgYGZrX29yZGVyX21hY3JvX2FjdGl2aXR5X29yZGVyMV9pZHhgIChgb3JkZXJfaWRgKSwKICBDT05TVFJBSU5UIGBma19vcmRlcl9tYWNyb19hY3Rpdml0eV9vcmRlcjFgIEZPUkVJR04gS0VZIChgb3JkZXJfaWRgKSBSRUZFUkVOQ0VTIGBjdXN0b21lcl9vcmRlcmAgKGBvcmRlcl9pZGApIE9OIERFTEVURSBOTyBBQ1RJT04gT04gVVBEQVRFIE5PIEFDVElPTgopIEVOR0lORT1Jbm5vREIgREVGQVVMVCBDSEFSU0VUPXV0Zjg=";

    /**
     * setActivityId Sets the class attribute activityId with a given value
     *
     * The attribute activityId maps the field activity_id defined as int(11).<br>
     * Comment for field activity_id: Not specified.<br>
     * @param int $activityId
     * @category Modifier
     */
    public function setActivityId($activityId)
    {
        $this->activityId = (int)$activityId;
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
     * setActivityName Sets the class attribute activityName with a given value
     *
     * The attribute activityName maps the field activity_name defined as varchar(200).<br>
     * Comment for field activity_name: Not specified.<br>
     * @param string $activityName
     * @category Modifier
     */
    public function setActivityName($activityName)
    {
        $this->activityName = (string)$activityName;
    }

    /**
     * setCost Sets the class attribute cost with a given value
     *
     * The attribute cost maps the field cost defined as decimal(11,2).<br>
     * Comment for field cost: Not specified.<br>
     * @param float $cost
     * @category Modifier
     */
    public function setCost($cost)
    {
        $this->cost = (float)$cost;
    }

    /**
     * setStartTime Sets the class attribute startTime with a given value
     *
     * The attribute startTime maps the field start_time defined as string|date.<br>
     * Comment for field start_time: Not specified.<br>
     * @param string $startTime
     * @category Modifier
     */
    public function setStartTime($startTime)
    {
        $this->startTime = (string)$startTime;
    }

    /**
     * setEndTime Sets the class attribute endTime with a given value
     *
     * The attribute endTime maps the field end_time defined as string|date.<br>
     * Comment for field end_time: Not specified.<br>
     * @param string $endTime
     * @category Modifier
     */
    public function setEndTime($endTime)
    {
        $this->endTime = (string)$endTime;
    }

    /**
     * getActivityId gets the class attribute activityId value
     *
     * The attribute activityId maps the field activity_id defined as int(11).<br>
     * Comment for field activity_id: Not specified.
     * @return int $activityId
     * @category Accessor of $activityId
     */
    public function getActivityId()
    {
        return $this->activityId;
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
     * getActivityName gets the class attribute activityName value
     *
     * The attribute activityName maps the field activity_name defined as varchar(200).<br>
     * Comment for field activity_name: Not specified.
     * @return string $activityName
     * @category Accessor of $activityName
     */
    public function getActivityName()
    {
        return $this->activityName;
    }

    /**
     * getCost gets the class attribute cost value
     *
     * The attribute cost maps the field cost defined as decimal(11,2).<br>
     * Comment for field cost: Not specified.
     * @return float $cost
     * @category Accessor of $cost
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * getStartTime gets the class attribute startTime value
     *
     * The attribute startTime maps the field start_time defined as string|date.<br>
     * Comment for field start_time: Not specified.
     * @return string $startTime
     * @category Accessor of $startTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * getEndTime gets the class attribute endTime value
     *
     * The attribute endTime maps the field end_time defined as string|date.<br>
     * Comment for field end_time: Not specified.
     * @return string $endTime
     * @category Accessor of $endTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Gets DDL SQL code of the table order_macro_activity
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
        return "order_macro_activity";
    }

    /**
     * The BeanOrderMacroActivity constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $activityId is given.
     *  - with a fetched data row from the table order_macro_activity having activity_id=$activityId
     * @param int $activityId. If omitted an empty (not fetched) instance is created.
     * @return BeanOrderMacroActivity Object
     */
    public function __construct($activityId = null)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($activityId)) {
            $this->select($activityId);
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
     * Fetchs a table row of order_macro_activity into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $activityId the primary key activity_id value of table order_macro_activity which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($activityId)
    {
        $sql =  "SELECT * FROM order_macro_activity WHERE activity_id={$this->parseValue($activityId,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->activityId = (integer)$rowObject->activity_id;
            @$this->orderId = (integer)$rowObject->order_id;
            @$this->activityName = $this->replaceAposBackSlash($rowObject->activity_name);
            @$this->cost = (float)$rowObject->cost;
            @$this->startTime = empty($rowObject->start_time) ? null : date(FETCHED_DATE_FORMAT,strtotime($rowObject->start_time));
            @$this->endTime = empty($rowObject->end_time) ? null : date(FETCHED_DATE_FORMAT,strtotime($rowObject->end_time));
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table order_macro_activity
     * @param int $activityId the primary key activity_id value of table order_macro_activity which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($activityId)
    {
        $sql = "DELETE FROM order_macro_activity WHERE activity_id={$this->parseValue($activityId,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of order_macro_activity
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->activityId = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO order_macro_activity
            (order_id,activity_name,cost,start_time,end_time)
            VALUES(
			{$this->parseValue($this->orderId)},
			{$this->parseValue($this->activityName,'notNumber')},
			{$this->parseValue($this->cost)},
			{$this->parseValue($this->startTime,'date')},
			{$this->parseValue($this->endTime,'date')})
SQL;
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        } else {
            $this->allowUpdate = true;
            if ($this->isPkAutoIncrement) {
                $this->activityId = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table order_macro_activity with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $activityId the primary key activity_id value of table order_macro_activity which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($activityId)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                order_macro_activity
            SET 
				order_id={$this->parseValue($this->orderId)},
				activity_name={$this->parseValue($this->activityName,'notNumber')},
				cost={$this->parseValue($this->cost)},
				start_time={$this->parseValue($this->startTime,'date')},
				end_time={$this->parseValue($this->endTime,'date')}
            WHERE
                activity_id={$this->parseValue($activityId,'int')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($activityId);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a row of order_macro_activity previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @category DML Helper
     * @return mixed MySQLi update result
     */
    public function updateCurrent()
    {
        if ($this->activityId != "") {
            return $this->update($this->activityId);
        } else {
            return false;
        }
    }

}
?>
