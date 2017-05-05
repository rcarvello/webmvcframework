<?php

namespace views\examples\db;

use framework\View;

class PartList extends View
{
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/examples/db/part_list";
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
}
