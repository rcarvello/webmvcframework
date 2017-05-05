<?php
/**
 * Class BeanPart
 * Bean class for object oriented management of the MySQL table part
 *
 * Comment of the managed table part: Inventory parts.
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
 * @filesource BeanPart.php
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

class BeanPart extends MySqlRecord implements Bean
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
     * Class attribute for mapping the primary key part_code of table part
     *
     * Comment for field part_code: Not specified<br>
     * @var string $partCode
     */
    private $partCode;

    /**
     * A class attribute for evaluating if the table has an autoincrement primary key
     * @var bool $isPkAutoIncrement
     */
    private $isPkAutoIncrement = false;

    /**
     * Class attribute for mapping table field description
     *
     * Comment for field description: Not specified.<br>
     * Field information:
     *  - Data type: varchar(45)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $description
     */
    private $description;

    /**
     * Class attribute for mapping table field source
     *
     * Comment for field source: Make or Buy.<br>
     * Field information:
     *  - Data type: enum('MAKE','BUY')
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $source
     */
    private $source;

    /**
     * Class attribute for mapping table field source_lead_time
     *
     * Comment for field source_lead_time: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var int $sourceLeadTime
     */
    private $sourceLeadTime;

    /**
     * Class attribute for mapping table field measurement_unit_code
     *
     * Comment for field measurement_unit_code: Not specified.<br>
     * Field information:
     *  - Data type: varchar(10)
     *  - Null : NO
     *  - DB Index: MUL
     *  - Default: 
     *  - Extra:  
     * @var string $measurementUnitCode
     */
    private $measurementUnitCode;

    /**
     * Class attribute for mapping table field part_type_code
     *
     * Comment for field part_type_code: Product, Assembly, Component,Raw.<br>
     * Field information:
     *  - Data type: varchar(20)
     *  - Null : NO
     *  - DB Index: MUL
     *  - Default: 
     *  - Extra:  
     * @var string $partTypeCode
     */
    private $partTypeCode;

    /**
     * Class attribute for mapping table field part_category_code
     *
     * Comment for field part_category_code: Market class.<br>
     * Field information:
     *  - Data type: varchar(20)
     *  - Null : NO
     *  - DB Index: MUL
     *  - Default: 
     *  - Extra:  
     * @var string $partCategoryCode
     */
    private $partCategoryCode;

    /**
     * Class attribute for mapping table field wastage
     *
     * Comment for field wastage: Waste ratio.<br>
     * Field information:
     *  - Data type: float
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var float $wastage
     */
    private $wastage;

    /**
     * Class attribute for mapping table field bom_levels
     *
     * Comment for field bom_levels: Hierarchy depth of its BOM.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var int $bomLevels
     */
    private $bomLevels;

    /**
     * Class attribute for storing the SQL DDL of table part
     * @var string base64 encoded $ddl
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBwYXJ0YCAoCiAgYHBhcnRfY29kZWAgdmFyY2hhcig0MCkgTk9UIE5VTEwsCiAgYGRlc2NyaXB0aW9uYCB2YXJjaGFyKDQ1KSBERUZBVUxUIE5VTEwsCiAgYHNvdXJjZWAgZW51bSgnTUFLRScsJ0JVWScpIERFRkFVTFQgTlVMTCBDT01NRU5UICdNYWtlIG9yIEJ1eScsCiAgYHNvdXJjZV9sZWFkX3RpbWVgIGludCgxMSkgREVGQVVMVCBOVUxMLAogIGBtZWFzdXJlbWVudF91bml0X2NvZGVgIHZhcmNoYXIoMTApIE5PVCBOVUxMLAogIGBwYXJ0X3R5cGVfY29kZWAgdmFyY2hhcigyMCkgTk9UIE5VTEwgQ09NTUVOVCAnUHJvZHVjdCwgQXNzZW1ibHksIENvbXBvbmVudCxSYXcnLAogIGBwYXJ0X2NhdGVnb3J5X2NvZGVgIHZhcmNoYXIoMjApIE5PVCBOVUxMIENPTU1FTlQgJ01hcmtldCBjbGFzcycsCiAgYHdhc3RhZ2VgIGZsb2F0IERFRkFVTFQgTlVMTCBDT01NRU5UICdXYXN0ZSByYXRpbycsCiAgYGJvbV9sZXZlbHNgIGludCgxMSkgREVGQVVMVCBOVUxMIENPTU1FTlQgJ0hpZXJhcmNoeSBkZXB0aCBvZiBpdHMgQk9NJywKICBQUklNQVJZIEtFWSAoYHBhcnRfY29kZWApLAogIEtFWSBgZmtfcGFydF9wYXJ0X3R5cGUxX2lkeGAgKGBwYXJ0X3R5cGVfY29kZWApLAogIEtFWSBgZmtfcGFydF9wYXJ0X2NhdGVnb3J5MV9pZHhgIChgcGFydF9jYXRlZ29yeV9jb2RlYCksCiAgS0VZIGBma19wYXJ0X3BhcnRfdW5pdF90eXBlMV9pZHhgIChgbWVhc3VyZW1lbnRfdW5pdF9jb2RlYCksCiAgQ09OU1RSQUlOVCBgZmtfcGFydF9wYXJ0X2NhdGVnb3J5MWAgRk9SRUlHTiBLRVkgKGBwYXJ0X2NhdGVnb3J5X2NvZGVgKSBSRUZFUkVOQ0VTIGBwYXJ0X2NhdGVnb3J5YCAoYHBhcnRfY2F0ZWdvcnlfY29kZWApIE9OIERFTEVURSBOTyBBQ1RJT04gT04gVVBEQVRFIE5PIEFDVElPTiwKICBDT05TVFJBSU5UIGBma19wYXJ0X3BhcnRfdHlwZTFgIEZPUkVJR04gS0VZIChgcGFydF90eXBlX2NvZGVgKSBSRUZFUkVOQ0VTIGBwYXJ0X3R5cGVgIChgcGFydF90eXBlX2NvZGVgKSBPTiBERUxFVEUgTk8gQUNUSU9OIE9OIFVQREFURSBOTyBBQ1RJT04sCiAgQ09OU1RSQUlOVCBgZmtfcGFydF9wYXJ0X3VuaXRfdHlwZTFgIEZPUkVJR04gS0VZIChgbWVhc3VyZW1lbnRfdW5pdF9jb2RlYCkgUkVGRVJFTkNFUyBgbWVhc3VyZW1lbnRfdW5pdGAgKGBtZWFzdXJlbWVudF91bml0X2NvZGVgKSBPTiBERUxFVEUgTk8gQUNUSU9OIE9OIFVQREFURSBOTyBBQ1RJT04KKSBFTkdJTkU9SW5ub0RCIERFRkFVTFQgQ0hBUlNFVD11dGY4IENPTU1FTlQ9J0ludmVudG9yeSBwYXJ0cyc=";

    /**
     * setPartCode Sets the class attribute partCode with a given value
     *
     * The attribute partCode maps the field part_code defined as varchar(40).<br>
     * Comment for field part_code: Not specified.<br>
     * @param string $partCode
     * @category Modifier
     */
    public function setPartCode($partCode)
    {
        $this->partCode = (string)$partCode;
    }

    /**
     * setDescription Sets the class attribute description with a given value
     *
     * The attribute description maps the field description defined as varchar(45).<br>
     * Comment for field description: Not specified.<br>
     * @param string $description
     * @category Modifier
     */
    public function setDescription($description)
    {
        $this->description = (string)$description;
    }

    /**
     * setSource Sets the class attribute source with a given value
     *
     * The attribute source maps the field source defined as enum('MAKE','BUY').<br>
     * Comment for field source: Make or Buy.<br>
     * @param string $source
     * @category Modifier
     */
    public function setSource($source)
    {
        $this->source = (string)$source;
    }

    /**
     * setSourceLeadTime Sets the class attribute sourceLeadTime with a given value
     *
     * The attribute sourceLeadTime maps the field source_lead_time defined as int(11).<br>
     * Comment for field source_lead_time: Not specified.<br>
     * @param int $sourceLeadTime
     * @category Modifier
     */
    public function setSourceLeadTime($sourceLeadTime)
    {
        $this->sourceLeadTime = (int)$sourceLeadTime;
    }

    /**
     * setMeasurementUnitCode Sets the class attribute measurementUnitCode with a given value
     *
     * The attribute measurementUnitCode maps the field measurement_unit_code defined as varchar(10).<br>
     * Comment for field measurement_unit_code: Not specified.<br>
     * @param string $measurementUnitCode
     * @category Modifier
     */
    public function setMeasurementUnitCode($measurementUnitCode)
    {
        $this->measurementUnitCode = (string)$measurementUnitCode;
    }

    /**
     * setPartTypeCode Sets the class attribute partTypeCode with a given value
     *
     * The attribute partTypeCode maps the field part_type_code defined as varchar(20).<br>
     * Comment for field part_type_code: Product, Assembly, Component,Raw.<br>
     * @param string $partTypeCode
     * @category Modifier
     */
    public function setPartTypeCode($partTypeCode)
    {
        $this->partTypeCode = (string)$partTypeCode;
    }

    /**
     * setPartCategoryCode Sets the class attribute partCategoryCode with a given value
     *
     * The attribute partCategoryCode maps the field part_category_code defined as varchar(20).<br>
     * Comment for field part_category_code: Market class.<br>
     * @param string $partCategoryCode
     * @category Modifier
     */
    public function setPartCategoryCode($partCategoryCode)
    {
        $this->partCategoryCode = (string)$partCategoryCode;
    }

    /**
     * setWastage Sets the class attribute wastage with a given value
     *
     * The attribute wastage maps the field wastage defined as float.<br>
     * Comment for field wastage: Waste ratio.<br>
     * @param float $wastage
     * @category Modifier
     */
    public function setWastage($wastage)
    {
        $this->wastage = (float)$wastage;
    }

    /**
     * setBomLevels Sets the class attribute bomLevels with a given value
     *
     * The attribute bomLevels maps the field bom_levels defined as int(11).<br>
     * Comment for field bom_levels: Hierarchy depth of its BOM.<br>
     * @param int $bomLevels
     * @category Modifier
     */
    public function setBomLevels($bomLevels)
    {
        $this->bomLevels = (int)$bomLevels;
    }

    /**
     * getPartCode gets the class attribute partCode value
     *
     * The attribute partCode maps the field part_code defined as varchar(40).<br>
     * Comment for field part_code: Not specified.
     * @return string $partCode
     * @category Accessor of $partCode
     */
    public function getPartCode()
    {
        return $this->partCode;
    }

    /**
     * getDescription gets the class attribute description value
     *
     * The attribute description maps the field description defined as varchar(45).<br>
     * Comment for field description: Not specified.
     * @return string $description
     * @category Accessor of $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * getSource gets the class attribute source value
     *
     * The attribute source maps the field source defined as enum('MAKE','BUY').<br>
     * Comment for field source: Make or Buy.
     * @return string $source
     * @category Accessor of $source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * getSourceLeadTime gets the class attribute sourceLeadTime value
     *
     * The attribute sourceLeadTime maps the field source_lead_time defined as int(11).<br>
     * Comment for field source_lead_time: Not specified.
     * @return int $sourceLeadTime
     * @category Accessor of $sourceLeadTime
     */
    public function getSourceLeadTime()
    {
        return $this->sourceLeadTime;
    }

    /**
     * getMeasurementUnitCode gets the class attribute measurementUnitCode value
     *
     * The attribute measurementUnitCode maps the field measurement_unit_code defined as varchar(10).<br>
     * Comment for field measurement_unit_code: Not specified.
     * @return string $measurementUnitCode
     * @category Accessor of $measurementUnitCode
     */
    public function getMeasurementUnitCode()
    {
        return $this->measurementUnitCode;
    }

    /**
     * getPartTypeCode gets the class attribute partTypeCode value
     *
     * The attribute partTypeCode maps the field part_type_code defined as varchar(20).<br>
     * Comment for field part_type_code: Product, Assembly, Component,Raw.
     * @return string $partTypeCode
     * @category Accessor of $partTypeCode
     */
    public function getPartTypeCode()
    {
        return $this->partTypeCode;
    }

    /**
     * getPartCategoryCode gets the class attribute partCategoryCode value
     *
     * The attribute partCategoryCode maps the field part_category_code defined as varchar(20).<br>
     * Comment for field part_category_code: Market class.
     * @return string $partCategoryCode
     * @category Accessor of $partCategoryCode
     */
    public function getPartCategoryCode()
    {
        return $this->partCategoryCode;
    }

    /**
     * getWastage gets the class attribute wastage value
     *
     * The attribute wastage maps the field wastage defined as float.<br>
     * Comment for field wastage: Waste ratio.
     * @return float $wastage
     * @category Accessor of $wastage
     */
    public function getWastage()
    {
        return $this->wastage;
    }

    /**
     * getBomLevels gets the class attribute bomLevels value
     *
     * The attribute bomLevels maps the field bom_levels defined as int(11).<br>
     * Comment for field bom_levels: Hierarchy depth of its BOM.
     * @return int $bomLevels
     * @category Accessor of $bomLevels
     */
    public function getBomLevels()
    {
        return $this->bomLevels;
    }

    /**
     * Gets DDL SQL code of the table part
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
        return "part";
    }

    /**
     * The BeanPart constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $partCode is given.
     *  - with a fetched data row from the table part having part_code=$partCode
     * @param string $partCode. If omitted an empty (not fetched) instance is created.
     * @return BeanPart Object
     */
    public function __construct($partCode = null)
    {
        // $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        parent::__construct();
        if (!empty($partCode)) {
            $this->select($partCode);
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
     * Fetchs a table row of part into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param string $partCode the primary key part_code value of table part which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($partCode)
    {
        $sql =  "SELECT * FROM part WHERE part_code={$this->parseValue($partCode,'string')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->partCode = $this->replaceAposBackSlash($rowObject->part_code);
            @$this->description = $this->replaceAposBackSlash($rowObject->description);
            @$this->source = $rowObject->source;
            @$this->sourceLeadTime = (integer)$rowObject->source_lead_time;
            @$this->measurementUnitCode = $this->replaceAposBackSlash($rowObject->measurement_unit_code);
            @$this->partTypeCode = $this->replaceAposBackSlash($rowObject->part_type_code);
            @$this->partCategoryCode = $this->replaceAposBackSlash($rowObject->part_category_code);
            @$this->wastage = (float)$rowObject->wastage;
            @$this->bomLevels = (integer)$rowObject->bom_levels;
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table part
     * @param string $partCode the primary key part_code value of table part which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($partCode)
    {
        $sql = "DELETE FROM part WHERE part_code={$this->parseValue($partCode,'string')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of part
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->partCode = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO part
            (part_code,description,source,source_lead_time,measurement_unit_code,part_type_code,part_category_code,wastage,bom_levels)
            VALUES({$this->parseValue($this->partCode,'notNumber')},
			{$this->parseValue($this->description,'notNumber')},
			{$this->parseValue($this->source,'notNumber')},
			{$this->parseValue($this->sourceLeadTime)},
			{$this->parseValue($this->measurementUnitCode,'notNumber')},
			{$this->parseValue($this->partTypeCode,'notNumber')},
			{$this->parseValue($this->partCategoryCode,'notNumber')},
			{$this->parseValue($this->wastage)},
			{$this->parseValue($this->bomLevels)})
SQL;
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        } else {
            $this->allowUpdate = true;
            if ($this->isPkAutoIncrement) {
                $this->partCode = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table part with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param string $partCode the primary key part_code value of table part which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($partCode)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                part
            SET 
				description={$this->parseValue($this->description,'notNumber')},
				source={$this->parseValue($this->source,'notNumber')},
				source_lead_time={$this->parseValue($this->sourceLeadTime)},
				measurement_unit_code={$this->parseValue($this->measurementUnitCode,'notNumber')},
				part_type_code={$this->parseValue($this->partTypeCode,'notNumber')},
				part_category_code={$this->parseValue($this->partCategoryCode,'notNumber')},
				wastage={$this->parseValue($this->wastage)},
				bom_levels={$this->parseValue($this->bomLevels)}
            WHERE
                part_code={$this->parseValue($partCode,'string')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($partCode);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a row of part previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @category DML Helper
     * @return mixed MySQLi update result
     */
    public function updateCurrent()
    {
        if ($this->partCode != "") {
            return $this->update($this->partCode);
        } else {
            return false;
        }
    }

}
?>
