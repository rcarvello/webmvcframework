<?php
/**
 * Class PartListManager
 *
 * {ModelResponsability}
 *
 * @package models\examples\db
 * @category Application Model
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace models\examples\db;

use framework\Model;

/**
 * Class PartListManager
 * Part List Manager Model
 *
 * @package models\examples\db
 */
class PartListManager extends Model
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
        // Also you can use a statement like this:
        // $this->sql = "SELECT t.* FROM part t";
        //
        // Warning:
        // Do not use "SELECT * FROM part" because frameworks components
        // and SQL itself cannot build SQL subquery that use the same table
        $this->updateResultSet();
    }
}
