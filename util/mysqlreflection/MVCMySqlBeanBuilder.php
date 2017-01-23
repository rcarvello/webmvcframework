<?php
/**
 * Class MVCMySqlBeanBuilder
 * Provides functions for building the class source code to manage a mysql table.
 * Responsability:
 *
 *  - Implements the core services of the generation engine of PHP source code
 *  - The generation process is based on parsing and processing of a template file, MVCMySqlBeanClass.php.tpl
 *  - For the template management is used the class MVCMySqlSimpleTemplate
 *
 * @filesource MVCMySqlBeanBuilder.php
 * @category Framework Utility
 * @package util\mysqlreflection
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version CVS: v1.0.0
 * @uses class MVCMySqlSimpleTemplate
 * @note This class is extracted from my personal MVC Framework.
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved .  See License.txt file
 * @license BSD
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD Public License.
 */


class MVCMySqlBeanBuilder
{
    /**
     * @var string The table name
     */
    private $tableName = "";

    /**
     * @var string The PK
     */
    private $tablePkName = "";

    /**
     * @var string The table DDL
     */
    private $tableDdl = "";

    /**
     * @var string The table comment
     */
    private $tableComment = "";

    /**
     * @var string The class name
     */
    private $className = "";

    /**
     * @var string Parent class of the generated class
     */
    private $classParent = "mysqli";

    /**
     * @var string The file name for the generated class
     */
    private $classFileName = "";

    /**
     * @var string The package name of the generated class
     */
    private $classPackageName = "";

    /**
     * @var float Version number to assign to the generated class
     */
    private $classVersion = "";

    /**
     * @var string The author name to assign to the generated class
     */
    private $authorName = "";

    /**
     * @var string The author email to assign to the generated class
     */
    private $authorEmail = "";

    /**
     * @var MVCMySqlSimpleTemplate The template engine used by the builder for managing the generated source code
     */
    private $source;

    /**
     * Sets class ddl attribute which store the ddl sql for the table.
     * @param string $tableDdl The table ddl
     */
    public function setTableDdl($tableDdl)
    {
        $this->tableDdl = base64_encode($tableDdl);
    }

    /**
     * Sets class ddl attribute which store the ddl sql for the table.
     * @param string $tableDdl The table ddl
     */
    public function setTableComment($comment)
    {
        $this->tableComment = $comment;
    }

    /**
     * Sets the parent class used by the generated class
     * @param string $classParent
     */
    public function setClassParent($classParent)
    {
        $this->classParent = $classParent;
    }

    /**
     * Sets the filename for the generated class
     * @param string $classFileName
     */
    public function setClassFileName($classFileName)
    {
        $this->classFileName = $classFileName;
    }

    /**
     * Sets the package name for the generated class
     * @param string $classPackageName
     */
    public function setClassPackageName($classPackageName)
    {
        $this->classPackageName = $classPackageName;
    }

    /**
     * Sets the version number for the generated class
     * @param float $classVersion
     */
    public function setClassVersion($classVersion)
    {
        $this->classVersion = $classVersion;
    }

    /**
     * Sets the author name for the generated class
     * @param string $authorName
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * Sets the author email for the generated class
     * @param string $authorEmail
     */
    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;
    }

    /**
     * Gets the table name managed by the generated class
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * Gets the PK (single field)
     * @return string
     */
    public function getTablePkName()
    {
        return $this->tablePkName;
    }

    /**
     * Gets the table DDL
     * @return string
     */
    public function getTableDdl()
    {
        return $this->tableDdl;
    }

    /**
     * Gets the table comment
     * @return string
     */
    public function getTableComment()
    {
        return empty($this->tableComment)?"Not specified":$this->tableComment;
    }

    /**
     * Gets the class name
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Gets the parent class of the generated class
     * @return string
     */
    public function getClassParent()
    {
        return $this->classParent;
    }

    /**
     * Gets the file name for the generated class source code
     * @return string
     */
    public function getClassFileName()
    {
        return $this->classFileName;
    }

    /**
     * Gets the package name
     * @return string
     */
    public function getClassPackageName()
    {
        return $this->classPackageName;
    }

    /**
     * Gets the version number assigned to the generated class
     * @return float
     */
    public function getClassVersion()
    {
        return $this->classVersion;
    }

    /**
     * Gets the author name assigned to the generated class
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Gets the author email assigned to the generated class
     * @return string
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    /**
     * Gets the PHP source code of the generated class
     * @return string
     */
    public function getSource()
    {
        return $this->source->get();
    }

    /**
     * Constructor.
     * @param string $tableName the mysql table managed by the generated class
     * @param string $pkName the table PK (single field)
     * @param string $className the class name for to the generated class
     */
    public function __construct($tableName, $pkName, $className)
    {
        $this->tableName = $tableName;
        $this->tablePkName = $pkName;
        $this->className = $className;
        $this->setClassFileName($this->getClassName() . ".php");
        $this->source = new MVCMySqlSimpleTemplate("mysqlreflection/MVCMySqlBeanClass.php.tpl");
    }

    /**
     * Builds a section of the source code defined into the PhpHeader block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     */
    public function buildPhpHeader()
    {
        $this->source->setBlock("PhpHeader");
        $this->source->setVar("ClassParent", $this->getClassParent());
	    $this->source->setVar("ClassImplements", CLASS_IMPLEMENTS);
        $this->source->setVar("ClassName", $this->getClassName());
        $this->source->setVar("ClassFileName", $this->getClassFileName());
        $this->source->setVar("TableName", $this->getTableName());
        $this->source->setVar("ClassPackageName", $this->getClassPackageName());
        $this->source->setVar("AuthorName", $this->getAuthorName());
        $this->source->setVar("AuthorEmail", $this->getAuthorEmail());
        $this->source->setVar("ClassVersion", $this->getClassVersion());
        $this->source->setVar("TableComment", $this->getTableComment());
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the PkAttribute block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     * @param MVCMySqlFieldToAttributeReflection $attribute the attribute object
     */
    public function buildPkAttribute(MVCMySqlFieldToAttributeReflection $attribute)
    {
        $this->source->setBlock("PkAttribute");
        $this->source->setVar("TablePkName", $this->getTablePkName());
        $this->source->setVar("ClassPkAttributeType", $attribute->getTypeForPHPDoc());
        $this->source->setVar("ClassPkAttributeName", $attribute->getName());
        $this->source->setVar("Comment", $attribute->comment);
        $this->source->setVar("TableName", $this->getTableName());
        if ($attribute->getExtraInfo() == "auto_increment"){
            $this->source->setVar("AutoIncrement", "true");
        } else {
            $this->source->setVar("AutoIncrement", "false");
        }
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the Attributes block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     * @param MVCMySqlFieldToAttributeReflection $attribute the attribute object
     */
    public function buildAttribute(MVCMySqlFieldToAttributeReflection $attribute)
    {
        $this->source->setBlock("Attributes");
        $this->source->setVar("TablePkName", $this->getTablePkName());
        $this->source->setVar("TableFieldName", $attribute->name);
        $this->source->setVar("TableFieldTypeAndLenght", $attribute->getTypeAndLenght());
        $this->source->setVar("TableFieldNullable", $attribute->getNullableInfo());
        $this->source->setVar("TableFieldIndex", $attribute->getIndexInfo());
        $this->source->setVar("TableFieldDefault", $attribute->getDefaultValueInfo());
        $this->source->setVar("TableFieldExtra", $attribute->getExtraInfo());
        $this->source->setVar("Comment", $attribute->comment);
        $this->setAttributeValues($attribute);
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the DdlAttribute block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     */
    public function buildDdlAttribute()
    {
        $this->source->setBlock("DdlAttribute");
        $this->source->setVar("TableName", $this->getTableName());
        $this->source->setVar("Ddl", $this->getTableDdl());
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the buildConstructor block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     * @param string $classPkAttributeName the name of attribute for the PK
     * @param string $classPkAttributeType the data type of attribute for the PK
     */
    public function buildConstructor($classPkAttributeName, $classPkAttributeType)
    {
        $this->source->setBlock("Constructor");
        $this->source->setVar("ClassName", $this->getClassName());
        $this->setPkAttributeValues($classPkAttributeName,$classPkAttributeType);
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the buildConstructorForMultiplePk block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     * @param MVCMySqlPKAnalyzer $analyzer
     */
    public function buildConstructorForMultiplePk(MVCMySqlPKAnalyzer $analyzer)
    {
        $this->source->setBlock("ConstructorForMultiplePK");
        $this->source->setVar("ClassName", $this->getClassName());
        $this->source->setVar("PKDMLFunctionParametersIsNotNull", $analyzer->getPKDMLFunctionParametersIsNotNull());
        $this->source->setVar("PKDMLFunctionParametersNullDefault", $analyzer->getPKDMLFunctionParametersDefaultNull());
        $this->source->setVar("PKDMLFunctionParameters", $analyzer->getPKDMLFunctionParameters());
        $this->source->setVar("PKParametersDocumentation", $analyzer->getPKParametersDocumentation());
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the Setters block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     * @param MVCMySqlFieldToAttributeReflection $attribute the attribute object
     */
    public function buildSetter(MVCMySqlFieldToAttributeReflection $attribute)
    {
        $this->source->setBlock("Setters");
        $this->setAttributeValues($attribute);
        $this->source->setVar("SetterMethod", $attribute->getSetterName());
        $this->source->setVar("Cast", $attribute->getCast());
        $this->source->setVar("TableFieldName", $attribute->name);
        $this->source->setVar("TableFieldTypeAndLenght", $attribute->getTypeAndLenght());
        $this->source->setVar("Comment", $attribute->comment);
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the Getters block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     * @param MVCMySqlFieldToAttributeReflection $attribute the attribute object
     */
    public function buildGetter(MVCMySqlFieldToAttributeReflection $attribute)
    {
        $this->source->setBlock("Getters");
        $this->setAttributeValues($attribute);
        $this->source->setVar("GetterMethod", $attribute->getGetterName());
        $this->source->setVar("TableFieldName", $attribute->name);
        $this->source->setVar("TableFieldTypeAndLenght", $attribute->getTypeAndLenght());
        $this->source->setVar("Comment", $attribute->comment);
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the DdlGetter block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     */
    public function buildDdlGetter()
    {
        $this->source->setBlock("DdlGetter");
        $this->source->setVar("TableName", $this->tableName);
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the TableGetter block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     */
    public function buildTableGetter()
    {
        $this->source->setBlock("TableGetter");
        $this->source->setVar("TableName", $this->tableName);
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the Select block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     * @param string $classPkAttributeName the name of attribute for the PK
     * @param string $classPkAttributeType the data type of attribute for the PK
     * @param mysqli_result $fieldsResultSet  The result set containing table fields
     */
    public function buildSelectMethod($classPkAttributeName,$classPkAttributeType,$fieldsResultSet)
    {
        // Loop for initializing attributes
        $this->source->setBlock("Select");

        // Gets the sub-block template
        $initFieldsTemplateBlock = $this->source->getInnerBlock("InitFields");
        $initFields = "";
        // Makes many replacement by calling initField for each element of the set
        while ($dbObject = $fieldsResultSet->fetch_object()) {
            $initFields = $initFields . $this->initField($dbObject,$initFieldsTemplateBlock);
        }
        $this->source->setBlock("Select");
        // Replaces the sub-block template content with a the placeholder LoopInitFields
        $this->source->setInnerBlock("InitFields","LoopInitFields");

        // Now replaces the placeholder LoopInitFields with content stored in $initFields
        $this->source->setVar("LoopInitFields",$initFields);
        $this->setPkAttributeValues($classPkAttributeName,$classPkAttributeType);
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the SelectForMultiplePK block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     * @param mysqli_result $fieldsResultSet The result set containing table fields
     * @param MVCMySqlPKAnalyzer $analyzer
     */
    public function buildSelectMethodForMultiplePk($fieldsResultSet,MVCMySqlPKAnalyzer $analyzer)
    {
        // Loop for initializing attributes
        $this->source->setBlock("SelectForMultiplePK");

        // Gets the sub-block template
        $initFieldsTemplateBlock = $this->source->getInnerBlock("InitFields");
        $initFields = "";
        // Makes many replacement by calling initField for each element of the set
        while ($dbObject = $fieldsResultSet->fetch_object()) {
            $initFields = $initFields . $this->initField($dbObject,$initFieldsTemplateBlock);
        }

        $this->source->setBlock("SelectForMultiplePK");
        // Replaces the sub-block template content with a the placeholder LoopInitFields
        $this->source->setInnerBlock("InitFields","LoopInitFields");
        // Now replaces the placeholder LoopInitFields with content stored in $initFields
        $this->source->setVar("LoopInitFields",$initFields);
        // Replaces the others placeholders
        $this->source->setVar("ClassName", $this->getClassName());
        $this->source->setVar("PKDMLFunctionParameters", $analyzer->getPKDMLFunctionParameters());
        $this->source->setVar("PKParametersDocumentation", $analyzer->getPKParametersDocumentation());
        $this->source->setVar("PKWhereCondition", $analyzer->getPKWhereCondition());
        $this->source->setVar("TableName",$this->tableName);
        $this->source->parse();

    }

    /**
     * Sets the attributes initialization. Builds a section of the source code defined into the InitFields block
     * of the used template
     * See the template for details of the generated code
     * @param object $dbObject msqli fetched object
     * @param string $template template to processing
     * @return string  the result of template processing
     */
    private function initField($dbObject,$template)
    {
        $cast = "";
        $StartreplaceApos= "";
        $EndreplaceApos = "";
        if (preg_match('/int/',$dbObject->Type))
            $cast = "(integer)";
        if (preg_match('/decimal/',$dbObject->Type))
            $cast = "(float)";
        if (preg_match('/float/',$dbObject->Type))
            $cast = "(float)";
        if (preg_match('/double/',$dbObject->Type))
            $cast = "(double)";
        if (preg_match('/real/',$dbObject->Type))
            $cast = "(real)";
        if (preg_match('/fixed/',$dbObject->Type))
            $cast = "(float)";
        if (preg_match('/numeric/',$dbObject->Type))
            $cast = "(float)";

        if (preg_match('/char/',$dbObject->Type)) {
            $StartreplaceApos= "$"."this->replaceAposBackSlash(";
            $EndreplaceApos = ")";
        }

        if (preg_match('/text/',$dbObject->Type)) {
            $StartreplaceApos= "$"."this->replaceAposBackSlash(";
            $EndreplaceApos = ")";
        }

        $this->source->setBlock($template,true);
        $this->source->setVar("Attribute",MVCMySqlFieldToAttributeReflection::underscoreToCamelCase($dbObject->Field));
        $this->source->setVar("Cast",$cast);

        $this->source->setVar("StartreplaceApos",$StartreplaceApos);
        $this->source->setVar("EndreplaceApos",$EndreplaceApos);

        // if (preg_match('/date/',$dbObject->Type)) {
        if ($dbObject->Type == "date") {
            // $this->source->setVar("StartCaseDateField", 'date("'. FETCHED_DATE_FORMAT.'",strtotime(');
            // $this->source->setVar("StartCaseDateField", 'date(' . "FETCHED_DATE_FORMAT" . ',strtotime(');
            $this->source->setVar("StartCaseDateField", 'empty(' . '$' . 'rowObject->' . $dbObject->Field .') ? null : date(' . "FETCHED_DATE_FORMAT" . ',strtotime(');
            $this->source->setVar("EndCaseDateField", '))');

        } else if ($dbObject->Type == "datetime") {
            // $this->source->setVar("StartCaseDateField", 'date(' . "FETCHED_DATETIME_FORMAT" . ',strtotime(');
            $this->source->setVar("StartCaseDateField", 'empty(' . '$' . 'rowObject->' . $dbObject->Field .') ? null : date(' . "FETCHED_DATETIME_FORMAT" . ',strtotime(');
            $this->source->setVar("EndCaseDateField", '))');
        } else {
            $this->source->setVar("StartCaseDateField", "");
            $this->source->setVar("EndCaseDateField", "");
        }
        $this->source->setVar("Field", $dbObject->Field);
        return $this->source->get(true);
    }

    /**
     * Builds a section of the source code defined into the Delete block of the used template
     * See the template for details of the generated code
     * @param string $classPkAttributeName the name of attribute for the PK
     * @param string $classPkAttributeType the data type of attribute for the PK
     */
    public function buildDeleteMethod($classPkAttributeName,$classPkAttributeType)
    {
        $this->source->setBlock("Delete");
        $this->setPkAttributeValues($classPkAttributeName,$classPkAttributeType);
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the DeleteForMultiplePK block of the used template
     * See the template for details of the generated code
     * @param MVCMySqlPKAnalyzer $analyzer
     */
    public function buildDeleteMethodForMultiplePk(MVCMySqlPKAnalyzer $analyzer)
    {
        $this->source->setBlock("DeleteForMultiplePK");
        $this->source->setVar("ClassName", $this->getClassName());
        $this->source->setVar("PKDMLFunctionParameters", $analyzer->getPKDMLFunctionParameters());
        $this->source->setVar("PKParametersDocumentation", $analyzer->getPKParametersDocumentation());
        $this->source->setVar("PKWhereCondition", $analyzer->getPKWhereCondition());
        $this->source->setVar("TableName",$this->tableName);
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the Insert block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     * @param string $classPkAttributeName the name of attribute for the PK
     * @param string $classPkAttributeType the data type of attribute for the PK
     * @param string $fields  a string containing table fields for the INSERT sql statement
     * @param string $values  a string containing table values for the INSERT sql statement
     */
    public function buildInsertMethod($classPkAttributeName,$classPkAttributeType,$fields,$values)
    {
        $this->source->setBlock("Insert");
        $this->setPkAttributeValues($classPkAttributeName,$classPkAttributeType);
        $this->source->setVar("TableName",$this->tableName);
        $this->source->setVar("Fields",$fields);
        $this->source->setVar("Values",$values);
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the InsertForMultiplePK block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     * @param string $fields A string containing table fields for the INSERT sql statement
     * @param string $values A string containing table values for the INSERT sql statement
     * @param MVCMySqlPKAnalyzer $analyzer
     */
    public function buildInsertMethodForMultiplePk($fields,$values, MVCMySqlPKAnalyzer $analyzer)
    {
        $this->source->setBlock("InsertForMultiplePK");
        $this->source->setVar("TableName",$this->tableName);
        $this->source->setVar("Fields",$fields);
        $this->source->setVar("Values",$values);
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the Update block of the used template
     * See the template for details of the generated code
     * @param string $classPkAttributeName the name of attribute for the PK
     * @param string $classPkAttributeType the data type of attribute for the PK
     * @param string $fieldsEqualValues  a string containing the expression Field=Value for the UPDATE sql statement
     */
    public function buildUdateMethod($classPkAttributeName,$classPkAttributeType,$fieldsEqualValues)
    {
        $this->source->setBlock("Update");
        $this->setPkAttributeValues($classPkAttributeName,$classPkAttributeType);
        $this->source->setVar("FileldsEqualValues",$fieldsEqualValues);
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the UpdateForMultiplePK block of the used template
     * See the template for details of the generated code
     * @param string $fieldsEqualValues  a string containing the expression Field=Value for the UPDATE sql statement
     * @param MVCMySqlPKAnalyzer $analyzer
     */
    public function buildUdateMethodForMultiplePk($fieldsEqualValues,MVCMySqlPKAnalyzer $analyzer)
    {
        $this->source->setBlock("UpdateForMultiplePK");
        $this->source->setVar("ClassName", $this->getClassName());
        $this->source->setVar("PKDMLFunctionParameters", $analyzer->getPKDMLFunctionParameters());
        $this->source->setVar("PKParametersDocumentation", $analyzer->getPKParametersDocumentation());
        $this->source->setVar("PKWhereCondition", $analyzer->getPKWhereCondition());
        $this->source->setVar("TableName",$this->tableName);
        $this->source->setVar("FileldsEqualValues",$fieldsEqualValues);
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the UpdateCurrent block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     * @param string $classPkAttributeName the name of attribute for the PK
     * @param string $tableName The table tame
     */
    public function buildUpdateCurrentMethod($classPkAttributeName,$tableName)
    {
        $this->source->setBlock("UpdateCurrent");
        $this->source->setVar("ClassPkAttributeName",$classPkAttributeName);
        $this->source->setVar("TableName",$tableName);
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the UpdateCurrentForMultiplePK block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     * @param string $tableName The table tame
     * @param MVCMySqlPKAnalyzer $analyzer
     */
    public function buildUpdateCurrentMethodForMultiplePk($tableName,MVCMySqlPKAnalyzer $analyzer)
    {
        $this->source->setBlock("UpdateCurrentForMultiplePK");
        $this->source->setVar("TableName",$tableName);
        $this->source->setVar("PKAttributeIsNotNull",$analyzer->getPKAttributeIsNotNull());
        $this->source->setVar("PKForUpdateCurrent",$analyzer->getPKForUpdateCurrent());
        $this->source->parse();
    }

    /**
     * Builds a section of the source code defined into the DeleteCurrent block of the used template
     * See the template for details of the generated code
     * @param string $classPkAttributeName the name of attribute for the PK
     * @param string $tableName the table tame
     */
    public function buildDeleteCurrentMethod($classPkAttributeName,$tableName)
    {
        $this->source->setBlock("DeleteCurrent");
        $this->source->setVar("ClassPkAttributeName",$classPkAttributeName);
        $this->source->setVar("TableName",$tableName);
        $this->source->parse();
    }


    /**
     * Builds a section of the source code defined into the buildPhpFooter block of the used template
     * See the template file MVCMySqlBeanClass.php.tpl for details of the generated code
     */
    public function buildPhpFooter()
    {
        $this->source->setBlock("PhpFooter");
        $this->source->parse();
    }

    /**
     * Builds a section of the source code common to more blocks of the used template.
     * The generated source code maps the PK of the managed table
     * @param string $classPkAttributeName the name of attribute for the PK
     * @param string $classPkAttributeType the data type of attribute for the PK
     */
    private function setPkAttributeValues($classPkAttributeName,$classPkAttributeType)
    {
        $this->source->setVar("ClassPkAttributeType",$classPkAttributeType);
        $this->source->setVar("ClassPkAttributeName", $classPkAttributeName);
        $this->source->setVar("TablePkName", $this->getTablePkName());
        $this->source->setVar("TableName", $this->getTableName());
    }

    /**
     * Builds a section of the source code common to more blocks of the used template
     * The generated source code maps a generic field of the managed table
     * @param MVCMySqlFieldToAttributeReflection $attribute the attribute object
     */
    private function setAttributeValues(MVCMySqlFieldToAttributeReflection $attribute)
    {
        $this->source->setVar("ClassAttributeType", $attribute->getTypeForPHPDoc());
        $this->source->setVar("ClassAttributeName", $attribute->getName());
    }

}