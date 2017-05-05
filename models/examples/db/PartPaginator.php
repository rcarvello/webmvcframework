<?php
/**
 * Class PartPaginator
 *
 * {ModelResponsability}
 *
 * @package models\examples\db
 * @category Application Model
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace models\examples\db;

use framework\Model;

class PartPaginator extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->sql =
<<<SQL
            SELECT  
              part_code, 
              description, 
              source, 
              source_lead_time, 
              measurement_unit_code, 
              part_type_code, 
              part_category_code, 
              wastage, 
              bom_levels 
            FROM 
              part
SQL;
        // Also this
        // $this->sql = "SELECT t.* FROM part t";
        $this->updateResultSet();
    }
}
