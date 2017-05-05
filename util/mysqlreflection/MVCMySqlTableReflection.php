<?php

/**
 * MVCMySqlTableReflection
 * Reflection class for a given MySQL database table.
 * Responsability:
 *
 *  - reflects all information about the input given table by using them to build the class PHP source code
 *  - uses MVCMySqlFieldToAttributeReflection class to map the table fields into an appropriate object
 *  - uses MVCMySqlBeanBuilder as builder engine of PHP source code by passing to it the retrieved information about the
 *  - uses MVCMySqlPKAnalyzer to inspetc PK
 *    table and the MVCMySqlFieldToAttributeReflection object
 *  - builds some strings containing SQL well formatted statements to be consumed by MVCMySqlBeanBuilder object
 *
 * @extends mysqli
 * @filesource MVCMySqlTableReflection.php
 * @category Framework Utility
 * @package util\mysqlreflection
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version CVS: v1.0.0
 * @uses file mysql_connection_inc.php
 * @uses class MVCMySqlBeanBuilder
 * @uses class MVCMySqlFieldToAttributeReflection
 * @uses class MVCMySqlPKAnalyzer
 * @note This class is extracted from my personal MVC Framework.
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved .  See License.txt file
 * @license BSD
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD Public License.
 */
class MVCMySqlTableReflection extends mysqli
{
    /**
     * Stores mysqli result of table fields
     * @var mixed
     */
    private $fieldsResultSet;

    /**
     * Stores the sql statement to retrieve table fields
     * @var string
     */
    private $sqlTableFields;

    /**
     * Stores the table name
     * @var string
     */
    private $table;
    /**
     * Stores the table PK, only the first, multiple PKs are not supported
     * @var string
     */
    private $tablePkName;

    /**
     * Stores the data type of PK
     * @var string
     */
    private $tablePkType;

    /**
     * Stores comment about the table
     * @var string
     */
    private $tableComment;

    /**
     * Defines if PK is an autoincrement integer
     * @var bool
     */
    private $isPkAutoIncrement;

    /**
     * Reference to MVCMySqlBeanBuilder object
     * @var MVCMySqlBeanBuilder
     * @see class MVCMySqlBeanBuilder
     */
    private $builder;

    /**
     * Stores the class name
     * @var string
     */
    private $className;

    /**
     * Reference to MVCMySqlPKAnalyzer object to inspect PK
     * @var MVCMySqlPKAnalyzer
     * @see class MVCMySqlPKAnalyzer
     */
    private $analyzer;


    /**
     * Constructor
     * @param string $tableName The mysql table to process for generating a PHP class.
     */
    public function __construct($tableName)
    {
        $this->connect(DBHOST,DBUSER,DBPASSWORD,DBNAME,DBPORT);
        $sqlFields = "SHOW FULL COLUMNS FROM $tableName";
        $sqlTableComment = "SELECT TABLE_COMMENT FROM information_schema.tables WHERE table_schema = DATABASE() AND TABLE_NAME='$tableName'";
        // $sqlPk = "SHOW KEYS FROM $tableName WHERE Key_name = 'PRIMARY'";
        $sqlDdl = "SHOW CREATE TABLE $tableName";
        $this->sqlTableFields = $sqlFields;

        // Set the table name
        $this->table = $tableName;

        // Set DDL
        $rsDdl = $this->query($sqlDdl);
        if ($rsDdl) {
            $row = $rsDdl->fetch_row();
            $ddl = $row[1];
        }
        // Set table comment
        $rsComment = $this->query($sqlTableComment);
        $row = $rsComment->fetch_row();
        $comment = $row[0];

        // Create PK Analyzer Object
        $PKAnalyzer = new MVCMySqlPKAnalyzer();
        $PKAnalyzer->analyze($tableName);
        $this->analyzer = $PKAnalyzer;

        // Set table primary key and type if single PK
        if (! $PKAnalyzer->hasCompositePK()) {
            $this->setTablePkNameAndType();
        }

        // Set the name for yhe generated Class
        $className = "Bean" . MVCMySqlFieldToAttributeReflection::underscoreToCamelCase($tableName, true);
        $this->className = $className;

        // Initializes the builder for the current table
        $this->builder = new MVCMySqlBeanBuilder($tableName, $this->tablePkName, $className);

        // Sets some builder patameters
        $this->builder->setAuthorName(AUTHOR_NAME);
        $this->builder->setAuthorEmail(AUTHOR_EMAIL);
        $this->builder->setClassPackageName(PACKAGE_NAME);
        $this->builder->setClassVersion(PACKAGE_VERSION);
        $this->builder->setTableDdl($ddl);
        $this->builder->setTableComment($comment);
        $this->builder->setClassParent(CLASS_PARENT);
    }

    /**
     * generateClass
     * Builds and gets the PHP class source code
     * @return string The source code of generated PHP Class
     */
    public function generateClass()
    {

        if (!$this->analyzer->hasCompositePK()){
            // Call class methods to generate the code for a table with a single field PK
            $this->generateHeader();
            $this->generateAttributes();
            $this->generateDdlAttribute();
            $this->generateSetters();
            $this->generateGetters();
            $this->generateDdlGetter();
            $this->generateTableGetter();
            $this->generateConstructor();
            $this->generateSelectMethod();
            $this->generateDeleteMethod();
            $this->generateInsertMethod();
            $this->generateUpdateMethod();
            $this->generateUpdateCurrentMethod();
            // $this->generateDeleteCurrentMethod();
            $this->generatePhpFooter();
            return $this->getSource();
        } else {
            // Call class methods to generate the code for a table with a multiple fields
            // and composite PK
            $this->generateHeader();
            $this->generateAttributesForMultiplePk();
            $this->generateDdlAttribute();
            $this->generateSetters();
            $this->generateGetters();
            $this->generateDdlGetter();
            $this->generateTableGetter();
            $this->generateConstructorForMultiplePK($this->analyzer);
            $this->generateSelectMethodForMultiplePK($this->analyzer);
            $this->generateDeleteMethodForMultiplePK($this->analyzer);
            $this->generateInsertMethodForMultiplePK($this->analyzer);
            $this->generateUpdateMethodForMultiplePK($this->analyzer);
            $this->generateUpdateCurrentMethodForMultiplePK($this->analyzer);
            // $this->generateDeleteCurrentMethod();
            $this->generatePhpFooter();

            // Sanitize generated code by removing all reference to the interface implementation
            // (Interface's contract of delete,update and select methods requires only one parameter)
            $source = @str_replace("@implements ". CLASS_IMPLEMENTS,"@implements none",$this->getSource());
            $source = @str_replace("use framework\\" . CLASS_IMPLEMENTS .";","",$source);
            return @str_replace("implements ". CLASS_IMPLEMENTS,"",$source);
        }
    }

    /**
     * Saves the class source code into a php file named with a pascal case notation of managed table name.
     * The php file is saved into the given directory.
     * @param string $classSourceCode The generated source code
     * @param string|null $path Path where generated class is saved. If is null the current path is used.
     * @return bool|string
     */
    public function saveClass($classSourceCode, $path = null)
    {
        $classFileName = $this->className . ".php";
        $ouputFile = $path . $classFileName;
        @file_put_contents($ouputFile,$classSourceCode);
        if (@file_exists($ouputFile)){
            return $ouputFile;
        }   else {
            return false;
        }
    }

    /**
     * Gets the PHP class source code
     * @return string
     */
    public function getSource()
    {
        return $this->builder->getSource();
    }

    /**
     * Generates the class header
     */
    public function generateHeader()
    {
        $this->builder->buildPhpHeader();
    }

    /**
     * Generates the class attributes.
     */
    public function generateAttributes()
    {
        $this->rewindFieldsResultSet();
        while ($object = $this->fieldsResultSet->fetch_object()) {
            $attribute = $this->parseAttributeWithObject($object);
            if ($attribute->isPkField()){
                $this->builder->buildPkAttribute($attribute);
            } else {
                $this->builder->buildAttribute($attribute);
            }
        }
    }

    /**
     * Generates the class attributes for a composite PK of multiple fields-
     */
    public function generateAttributesForMultiplePk()
    {
        $this->rewindFieldsResultSet();
        while ($object = $this->fieldsResultSet->fetch_object()) {
            $attribute = $this->parseAttributeWithObject($object);
            $this->builder->buildAttribute($attribute);
        }
    }

    /**
     * Generates a special class attribute: ddl.
     * It contains SQL for the DDL of the table.
     */
    public function generateDdlAttribute()
    {
        $this->builder->buildDdlAttribute();
    }

    /**
     * generateConstructor
     * Generates the class constructor.
     */
    public function generateConstructor()
    {
        // $this->setTablePkNameAndType();
        $classPkAttributeName = MVCMySqlFieldToAttributeReflection::underscoreToCamelCase($this->tablePkName);
        $tablePKFieldTypeAndLenght = $this->tablePkType;
        $this->builder->buildConstructor($classPkAttributeName,$tablePKFieldTypeAndLenght);
    }

    /**
     * Generate constructor for a composite PK of multiple fields
     * @param MVCMySqlPKAnalyzer $analyzer
     */
    public function generateConstructorForMultiplePK(MVCMySqlPKAnalyzer $analyzer)
    {
        $this->builder->buildConstructorForMultiplePk($analyzer);
    }

    /**
     * Generates the class setter methods
     */
    public function generateSetters(){
        $this->rewindFieldsResultSet();
        while ($object = $this->fieldsResultSet->fetch_object()) {
            $attribute = $this->parseAttributeWithObject($object);
            $this->builder->buildSetter($attribute);
        }
    }

    /**
     * Generates the class getters methods
     */
    public function generateGetters(){
        $this->rewindFieldsResultSet();
        while ($object = $this->fieldsResultSet->fetch_object()) {
            $attribute = $this->parseAttributeWithObject($object);
            $this->builder->buildGetter($attribute);
        }
    }

    /**
     * Generates the class DDL getter method
     */
    public function generateDdlGetter()
    {
        $this->builder->buildDdlGetter();
    }

    /**
     * Generates a method named getManagedTableName to retrieve the table name managed by the class
     */
    public function generateTableGetter()
    {
        $this->builder->buildTableGetter();
    }

    /**
     * Generates the class select method.
     */
    public function generateSelectMethod()
    {
        $classPkAttributeName = MVCMySqlFieldToAttributeReflection::underscoreToCamelCase($this->tablePkName);
        $classPkAttributeType = $this->tablePkType;
        $this->rewindFieldsResultSet();
        $this->builder->buildSelectMethod($classPkAttributeName,$classPkAttributeType,$this->fieldsResultSet);
    }

    /**
     * enerates the class select method for a composite PK of multiple fields.
     * @param MVCMySqlPKAnalyzer $analyzer
     */
    public function generateSelectMethodForMultiplePK(MVCMySqlPKAnalyzer $analyzer)
    {
        $this->rewindFieldsResultSet();
        $this->builder->buildSelectMethodForMultiplePk($this->fieldsResultSet,$analyzer);
    }

    /**
     * Generates the class delete method.
     */
    public function generateDeleteMethod()
    {
        $classPkAttributeName = MVCMySqlFieldToAttributeReflection::underscoreToCamelCase($this->tablePkName);
        $classPkAttributeType = $this->tablePkType;
        $this->builder->buildDeleteMethod($classPkAttributeName,$classPkAttributeType,$this->fieldsResultSet);
    }

    /**
     * Generates the class delete method for a composite PK of multiple fields.
     * @param MVCMySqlPKAnalyzer $analyzer
     */
    public function generateDeleteMethodForMultiplePK(MVCMySqlPKAnalyzer $analyzer)
    {
        $this->builder->buildDeleteMethodForMultiplePK($analyzer);
    }
    
    /**
     * Generates the class insert method.
     */
    public function generateInsertMethod()
    {
        $classPkAttributeName = MVCMySqlFieldToAttributeReflection::underscoreToCamelCase($this->tablePkName);
        $classPkAttributeType = $this->tablePkType;
        $fields = $this->buildInsertFields();
        $values = $this->buildInsertValues();
        $this->builder->buildInsertMethod($classPkAttributeName,$classPkAttributeType,$fields,$values);
    }

    /**
     * Generates the class insert method for a composite PK of multiple fields.
     * @param MVCMySqlPKAnalyzer $analyzer
     */
    public function generateInsertMethodForMultiplePK(MVCMySqlPKAnalyzer $analyzer)
    {
        $fields = $this->buildInsertFields();
        $values = $this->buildInsertValues();
        $this->builder->buildInsertMethodForMultiplePk($fields,$values,$analyzer);
    }

    /**
     * Generates the class update method.
     */
    public function generateUpdateMethod()
    {
        $classPkAttributeName = MVCMySqlFieldToAttributeReflection::underscoreToCamelCase($this->tablePkName);
        $classPkAttributeType = $this->tablePkType;
        $fieldsEqualValues = $this->buildUptateFileldsEqualValues();
        $this->builder->buildUdateMethod($classPkAttributeName, $classPkAttributeType, $fieldsEqualValues);
    }

    /**
     * Generates the class update method for a composite PK of multiple fields.
     * @param MVCMySqlPKAnalyzer $analyzer
     */
    public function generateUpdateMethodForMultiplePK(MVCMySqlPKAnalyzer $analyzer)
    {
        $fieldsEqualValues = $this->buildUptateFileldsEqualValues();
        $this->builder->buildUdateMethodForMultiplePk($fieldsEqualValues, $analyzer);
    }

    /**
     * Generates the class updateCurrent method.
     */
    public function generateUpdateCurrentMethod()
    {
        $classPkAttributeName = MVCMySqlFieldToAttributeReflection::underscoreToCamelCase($this->tablePkName);
        $tableName = $this->table;
        $this->builder->buildUpdateCurrentMethod($classPkAttributeName, $tableName);
    }

    /**
     * Generates the class updateCurrent method for a composite PK of multiple fields.
     * @param MVCMySqlPKAnalyzer $analyzer
     */
    public function generateUpdateCurrentMethodForMultiplePK(MVCMySqlPKAnalyzer $analyzer)
    {
        $tableName = $this->table;
        $this->builder->buildUpdateCurrentMethodForMultiplePk($tableName,$analyzer);
    }

    /**
     * Generates the class deleteCurrent method.
     */
    public function generateDeleteCurrentMethod()
    {
        $classPkAttributeName = MVCMySqlFieldToAttributeReflection::underscoreToCamelCase($this->tablePkName);
        $tableName = $this->table;
        $this->builder->buildDeleteCurrentMethod($classPkAttributeName, $tableName);
    }

    /**
     * Generates the class footer
     */
    public function generatePhpFooter()
    {
        $this->builder->buildPhpFooter();
    }

    /**
     * Builds a class attribute object using values from a row object of mysqli result
     * @param $object mysqli fetched object
     * @return MVCMySqlTableReflection The class attribute object
     */
    private function parseAttributeWithObject($object)
    {
        $attribute = new MVCMySqlFieldToAttributeReflection();
        $attribute->name = $object->Field;
        $setType = $object->Type;
        if ($setType == "date" || $setType == "time" )
            $setType = "string|" . $object->Type;
        $attribute->type = $setType;
        $attribute->null = $object->Null;
        $attribute->key = $object->Key;
        $attribute->default = $object->Default;
        $attribute->extra = $object->Extra;
        $attribute->comment = empty($object->Comment)?"Not specified":$object->Comment;
        return $attribute;
    }

    /**
     * Rewinds result set of table columns
     */
    private function rewindFieldsResultSet(){
        $this->fieldsResultSet = $this->query($this->sqlTableFields);
    }

    /**
     * Inspects for table PK and its data type for a single field PK
     */
    private function setTablePkNameAndType()
    {
        $this->rewindFieldsResultSet();
        while ($object = $this->fieldsResultSet->fetch_object()) {
            if ($object->Key == "PRI"){
                $attribute = new MVCMySqlFieldToAttributeReflection();
                $attribute->name = $object->Field;
                $attribute->type = $object->Type;
                $this->tablePkName = $object->Field;
                $this->tablePkType = $attribute->getType();
                if ($attribute->getExtraInfo()=="auto_increment") {
                    $this->isPkAutoIncrement = true;
                }
                break;
            }
        }
    }

    /**
     * Build insert fields used into SQL insert statement
     * @return string A string containing the table fields of insert statement
     */
    private function buildInsertFields()
    {
        $this->rewindFieldsResultSet();
        $fields = "";
        while ($object = $this->fieldsResultSet->fetch_object()) {
            if ($object->Extra != "auto_increment") {
                $fields = $fields . $object->Field . ",";
            }
        }
        return substr($fields,0,-1);
    }

    /**
     * Builds values used into SQL insert statement
     * @return string A string containing the the values of insert statement
     * @note the returned string has may lines break, one for each field to improve code readability of the generated class
     */
    private function buildInsertValues()
    {
        $this->rewindFieldsResultSet();
        $fields = "";
        while ($object = $this->fieldsResultSet->fetch_object()) {
            if ($object->Extra != "auto_increment") {
                $attribute = new MVCMySqlFieldToAttributeReflection();
                $attribute->name = $object->Field;
                $attribute->type = $object->Type;
                $fields = $fields . $attribute->getSqlFormattedValue();
            }
            $fields = $fields . PHP_EOL . "\t" . "\t" . "\t";
        }
        return substr($fields,0,PHP_EOL_SUBSTRING_LENGHT+1);
    }

    /**
     * Builds field and values used into SQL update statement
     * @return string A string containing the fields and values of update statement
     * @note the returned string has may lines break, one for each field to improve code readability of the generated class
     */
    private function buildUptateFileldsEqualValues()
    {
        $this->rewindFieldsResultSet();
        $fieldsEqualValues = "" . PHP_EOL . "\t" . "\t" . "\t" . "\t" ;
        while ($object = $this->fieldsResultSet->fetch_object()) {
            if ($object->Key != "PRI") {
                $attribute = new MVCMySqlFieldToAttributeReflection();
                $attribute->name = $object->Field;
                $attribute->type = $object->Type;
                $tableFieldName = $attribute->name;
                $fieldsEqualValues = $fieldsEqualValues . $tableFieldName . "=" .$attribute->getSqlFormattedValue();

                $fieldsEqualValues = $fieldsEqualValues . PHP_EOL . "\t" . "\t" . "\t" . "\t";
             }
        }
        // echo $fieldsEqualValues;
        return substr($fieldsEqualValues,0,PHP_EOL_SUBSTRING_LENGHT);
        // return $fieldsEqualValues;
    }

}

