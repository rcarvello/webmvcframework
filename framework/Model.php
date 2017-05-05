<?php
/**
 * Class Model
 *
 * @package framework
 * @filesource framework/Model.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework;
use framework\exceptions\MVCException;
use \mysqli;
use \Exception;

class Model extends mysqli
{
    public $sql;
    // protected $resultArray;
    protected $resultSet;
    // protected $resultRecord;

    public function __construct()
    {
        @parent::__construct(DBHOST,DBUSER,DBPASSWORD,DBNAME);
        $this->throwIfDBError();
        $this->autorun();
    }

    protected function autorun()
    {

    }

    public function setResultSet($mysqliResult)
    {
        $this->resultSet = $mysqliResult;
    }


    public function getResultSet()
    {
        return $this->resultSet;
    }

    public function updateResultSet()
    {
        $result = $this->query($this->sql);
        $this->throwIfDBError();
        $this->setResultSet($result);
    }

    private function throwIfDBError()
    {

        If ($this->connect_error) {
            throw new MVCException($this->connect_error);
        }
        if ($this->error) {
            throw new MVCException($this->error);
        }

    }
}