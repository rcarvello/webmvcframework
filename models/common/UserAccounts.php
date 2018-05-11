<?php
/**
 * Class UserAccounts
 *
 * Users Account Model
 *
 * @package models\common
 * @category Application Model
 * @author  Rosario Carvello - rosario.carvello@gmail.com
*/
namespace models\common;

use framework\Model;

class UserAccounts extends Model
{
    /**
    * Object constructor.
    *
    */
    public function __construct()
    {
        parent::__construct();
        $this->getUserAccounts();
    }


    /**
     * Sets users model
     */
    protected function getUserAccounts()
    {
        $this->sql =<<<SQL
        SELECT
          `user`.`id_user` AS `id_user`,
          `user`.`full_name` AS `full_name`,
          `user`.`email` AS `email`,
          `user`.`enabled` AS `enabled`,
          `access_level`.`name` AS `access_level_name`
        FROM
          (`user` LEFT JOIN `access_level` ON 
          ((`access_level`.`id_access_level` = `user`.`id_access_level`)))
        ORDER BY 
          `user`.`full_name` ASC 
SQL;
        $this->updateResultSet();
    }

}
