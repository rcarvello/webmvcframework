<?php
/**
 * Class MySqlRecordSet
 *
 * @todo Class Implemetation
 * @package framework
 * @filesource framework/MySqlRecordSet.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework;
class MySqlRecordSet extends Model
{
    public $sql;
    public $where;
    public $orderBy;
    public $groupBy;

    public function __construct($sql)
    {
        $this->sql=$sql;
        parent::__construct();
    }

    public function autorun()
    {
        $result = $this->query($this->sql);
        $this->resultSet= $result;
    }

    /*
    private function setSql()
    {
        (!empty($this->where) ? $this->sql .= " WHERE " . $this->where:$this->sql);
        (!empty($this->orderBy) ? $this->sql .= " ORDER BY " . $this->orderBy:$this->sql);
        (!empty($this->groupBy) ? $this->sql .= " GROUP BY " . $this->groupBy:$this->sql);
    }
    */
}