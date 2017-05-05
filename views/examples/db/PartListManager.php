<?php

namespace views\examples\db;

use framework\View;
use framework\components\bootstrap\SorterBootstrap;
use models\examples\db\PartListManager as PartListManagerModel;

/**
 * Class PartListManager
 * Part List Manager View
 *
 * @package views\examples\db
 */
class PartListManager extends View
{
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/examples/db/part_list_manager";
        parent::__construct($tplName);
    }

    public function setBlockParts(\mysqli_result $resultset){
        $this->openBlock("Parts");
        while ($part = $resultset->fetch_object()) {
            $this->setVar("part_code",$part->part_code);
            $this->setVar("description",$part->description);
            $this->setVar("source",$part->source);
            $this->setVar("source_lead_time",$part->source_lead_time);
            $this->setVar("measurement_unit_code",$part->measurement_unit_code);
            $this->setVar("part_type_code",$part->part_type_code);
            $this->setVar("part_category_code",$part->part_category_code);
            $this->setVar("wastage",$part->wastage);
            $this->setVar("bom_levels",$part->bom_levels);
            $this->parseCurrentBlock();
        }
        $this->setBlock();
    }

    /**
     * Makes sorter for part_code field
     * @return SorterBootstrap
     */
    public function makeSoterPartCode(PartListManagerModel $model)
    {

        $sorterPartCode = new SorterBootstrap();
        $sorterPartCode->setName("part_code");
        $sorterPartCode->field = "part_code";
        $sorterPartCode->caption = "{RES:part_code}";
        $sorterPartCode->init($model);
        return $sorterPartCode;
    }

    /**
     * Make sorter for description field
     * @return SorterBootstrap
     */
    public function makeSoterDescription(PartListManagerModel $model)
    {
        $sorterDescription = new SorterBootstrap();
        $sorterDescription->setName("description");
        $sorterDescription->field = "description";
        $sorterDescription->caption = "{RES:description}";
        $sorterDescription->init($model);
        return $sorterDescription;
    }

    /**
     * Make sorter for source field
     * @return SorterBootstrap
     */
    public function makeSoterSource(PartListManagerModel $model)
    {
        $sorterSource = new SorterBootstrap();
        $sorterSource->setName("source");
        $sorterSource->field = "source";
        $sorterSource->caption = "{RES:source}";
        $sorterSource->init($model);
        return $sorterSource;
    }

    /**
     * Make sorte for source_lead_time field
     * @return SorterBootstrap
     */
    public function makeSoterSourceLeadTime(PartListManagerModel $model)
    {
        $sorterSourceLeadTime = new SorterBootstrap();
        $sorterSourceLeadTime->setName("source_lead_time");
        $sorterSourceLeadTime->field = "source_lead_time";
        $sorterSourceLeadTime->caption = "{RES:source_lead_time}";
        $sorterSourceLeadTime->init($model);
        return $sorterSourceLeadTime;
    }

    /**
     * Make sorte for part_type_code field
     * @return SorterBootstrap
     */
    public function makeSoterPartTypeCode(PartListManagerModel $model)
    {
        $sorterPartTypeCode = new SorterBootstrap();
        $sorterPartTypeCode->setName("part_type_code");
        $sorterPartTypeCode->field = "part_type_code";
        $sorterPartTypeCode->caption = "{RES:part_type_code}";
        $sorterPartTypeCode->init($model);
        return $sorterPartTypeCode;
    }

    /**
     * Make sorte for measurement_unit_code field
     * @return SorterBootstrap
     */
    public function makeSoterMeasurementUnitCode(PartListManagerModel $model)
    {
        $sorterMeasurementUnitCode = new SorterBootstrap();
        $sorterMeasurementUnitCode->setName("measurement_unit_code");
        $sorterMeasurementUnitCode->field = "measurement_unit_code";
        $sorterMeasurementUnitCode->caption = "{RES:measurement_unit_code}";
        $sorterMeasurementUnitCode->init($model);
        return $sorterMeasurementUnitCode;
    }

    /**
     * Make sorte for part_category_code field
     * @return SorterBootstrap
     */
    public function makeSoterPartCategoryCode(PartListManagerModel $model)
    {
        $sorterPartCategoryCode = new SorterBootstrap();
        $sorterPartCategoryCode->setName("part_category_code");
        $sorterPartCategoryCode->field = "part_category_code";
        $sorterPartCategoryCode->caption = "{RES:part_category_code}";
        $sorterPartCategoryCode->init($model);
        return $sorterPartCategoryCode;
    }

    /**
     * Make sorte for wastage field
     * @return SorterBootstrap
     */
    public function makeSoterWastage(PartListManagerModel $model)
    {
        $sorterWastage = new SorterBootstrap();
        $sorterWastage->setName("wastage");
        $sorterWastage->field = "wastage";
        $sorterWastage->caption = "{RES:wastage}";
        $sorterWastage->init($model);
        return $sorterWastage;
    }

    /**
     * Make sorte for bom_levels field
     * @return SorterBootstrap
     */
    public function makeSoterBomLevels(PartListManagerModel $model)
    {
        $sorterBomLevels = new SorterBootstrap();
        $sorterBomLevels->setName("bom_levels");
        $sorterBomLevels->field = "bom_levels";
        $sorterBomLevels->caption = "{RES:bom_levels}";
        $sorterBomLevels->init($model);
        return $sorterBomLevels;
    }

}
