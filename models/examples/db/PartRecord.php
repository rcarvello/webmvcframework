<?php
/**
 * Class PartRecord
 *
 * {ModelResponsability}
 *
 * @package models\examples\db
 * @category Application Model
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace models\examples\db;

use framework\Model;
use views\examples\db\PartRecord as PartRecordView;
use framework\components\DataRepeater;
use models\beans\BeanPart;

class PartRecord extends Model
{

    /**
    * Object constructor.
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Autorun method. Put your code here for running it after object creation.
    * @param mixed|array|null $parameters Additional parameters to manage
    *
    */
    protected function autorun($parameters = null)
    {

    }

    /**
     * Build select list values for Measurament Code by using a DataRepeater
     *
     * @param PartRecordView $view
     */
    public function makeMeausurementUnitCodeList(PartRecordView $view)
    {
        $measuramentList = new Model();
        $measuramentList->sql= "SELECT measurement_unit_code, name FROM measurement_unit";
        $measuramentList->updateResultSet();
        $list = new DataRepeater($view,$measuramentList,"measurament_unit_code_list",null);
        $list->render();
    }

    /**
     * Build select list values for Measurament Code by using a DataRepeater
     *
     * @param PartRecordView $view
     */
    public function makePartTypeCodeList(PartRecordView $view)
    {
        $partTypeList = new Model();
        $partTypeList->sql= "SELECT part_type_code, name FROM part_type";
        $partTypeList->updateResultSet();
        $list = new DataRepeater($view,$partTypeList,"part_type_code_list",null);
        $list->render();
    }

    /**
     * Build select list values for Measurament Code by using a DataRepeater
     *
     * @param PartRecordView $view
     */
    public function makePartCategoryCodeList(PartRecordView $view)
    {
        $partCategoryList = new Model();
        $partCategoryList->sql= "SELECT part_category_code, name FROM part_category";
        $partCategoryList->updateResultSet();
        $list = new DataRepeater($view,$partCategoryList,"part_category_code_list",null);
        $list->render();
    }

    /**
     * Update Table by using bean
     * @param BeanPart $bean
     */
    public function setBeanWithPostedData(BeanPart $bean)
    {
        $bean->setPartCode($_POST["part_code"]);
        $bean->setDescription($_POST["description"]);
        $bean->setSource($_POST["source"]);
        $bean->setSourceLeadTime($_POST["source_lead_time"]);
        $bean->setMeasurementUnitCode($_POST["measurement_unit_code"]);
        $bean->setPartTypeCode($_POST["part_type_code"]);
        $bean->setPartCategoryCode($_POST["part_category_code"]);
        $bean->setWastage($_POST["wastage"]);
        $bean->setBomLevels($_POST["bom_levels"]);
    }
}
