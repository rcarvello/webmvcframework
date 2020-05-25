<?php
/**
 * Class  Model
 *
 * @package framework
 * @filesource framework/Model.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License.
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework;
use framework\exceptions\MVCException;
use \mysqli;
use \Exception;

class Model extends mysqli
{
    public $sql;
    protected $resultSet;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        @parent::__construct(DBHOST,DBUSER,DBPASSWORD,DBNAME);
        $this->throwIfDBError();
        $this->autorun();
    }

    /**
     * Hook for auto running custom code.
     */
    protected function autorun()
    {

    }

    /**
     * Set model resultset.
     *
     * @param  $mysqliResult
     */
    public function setResultSet($mysqliResult)
    {
        $this->resultSet = $mysqliResult;
    }

    /**
     * Gets model resultset.
     *
     * @return mixed
     */
    public function getResultSet()
    {
        return $this->resultSet;
    }

    /**
     *  Runs current model SQL query string and update its
     *  resultset with query results.
     */
    public function updateResultSet()
    {
        $result = $this->query($this->sql);
        $this->throwIfDBError();
        $this->setResultSet($result);
    }

    /**
     * Throws any db errors.
     *
     * @throws MVCException
     */
    private function throwIfDBError()
    {
        If ($this->connect_error) {
            throw new MVCException($this->connect_error);
        }
        if ($this->error) {
            throw new MVCException($this->error);
        }
    }

    /**
     * Envelops Model sql string  for Searcher compatibility.
     */
    public function envelopeSql()
    {
        $this->sql = "SELECT mvc_sql_evelop.* FROM (" . $this->sql. ") mvc_sql_evelop";
    }


}
