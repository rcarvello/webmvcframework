<?php
/**
 * Class PartRecord
 *
 * {ViewResponsability}
 *
 * @package controllers\examples\db
 * @category Application View
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace views\examples\db;

use framework\View;
use models\beans\BeanPart;

class PartRecord extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/examples/db/part_record";
        parent::__construct($tplName);
    }

    /**
     * Update fiellds with bean data
     * @param BeanPart $bean
     */
    public function setFieldsWithBeanData(BeanPart $bean)
    {
        // Switch form mode
        if ($bean->getPartCode() == null) {
            $this->setVar("FormTitle", "{RES:New_Record}");
            $this->setVar("readonly","");
        }else  {
            $this->setVar("FormTitle", "{RES:Edit_Record}: ". $bean->getPartCode());
            $this->setVar("readonly","readonly");
        }

        $this->setVar("part_code",$bean->getPartCode());
        $this->setVar("description",$bean->getDescription());
        $this->setVar("source",$bean->getSource());
        $this->setVar("source_lead_time",$bean->getSourceLeadTime());
        $this->setVar("measurement_unit_code",$bean->getMeasurementUnitCode());
        $this->setVar("part_type_code",$bean->getPartTypeCode());
        $this->setVar("part_category_code",$bean->getPartCategoryCode());
        $this->setVar("wastage",$bean->getWastage());
        $this->setVar("bom_levels",$bean->getBomLevels());
    }



}
