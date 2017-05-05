<?php
/**
 * Class BeanAdapter
 *
 * This MVC component is an adapter for all MySQL Bean generated from the provided utility.
 * It implements methods of Bean interface. The interface standardizes the operations
 * consumed by the Record Component.
 * A Record object uses BeanAdapter object through its Bean interface.
 * A Record object handles the submit action of an HTML form designed to execute some
 * DML operations against a MySQL table. After the form submission the Record object
 * intercepts the request and uses BeanAdapter object to execute its DML operation
 * that satisfy user request. The BeanAdpter itself uses a MySQL Bean Class which manage
 * a single MySQL table and provide all necessary services to execute SQL operations.
 *
 * @package framework
 * @filesource framework/BeanAdapter.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @note none
 * @see framework/Bean, util/app_create_bean.php
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

namespace framework;

class BeanAdapter extends Model implements Bean
{
    private $bean;

    /**
     * BeanAdapter constructor.
     * @param mixed $bean MySQL Database Bean
     */
    public function __construct($bean)
    {
        parent::__construct();
        $this->bean = $bean;
    }

    public function getBean()
    {
        return $this->bean;
    }

    public function select($pk)
    {
        if (is_array($pk)) {
            return call_user_func_array(array($this->bean, "select"), $pk);
        } else {
            return call_user_func(array($this->bean, "select"), $pk);
        }
    }

    public function insert()
    {
        return call_user_func(array($this->bean, "insert"));
    }

    public function delete($pk)
    {

        if (is_array($pk)) {
            return call_user_func_array(array($this->bean, "delete"), $pk);
        } else {
            return call_user_func(array($this->bean, "delete"), $pk);
        }

    }

    public function update($pk)
    {
        if (is_array($pk)) {
            return call_user_func_array(array($this->bean, "update"), $pk);
        } else {
            return call_user_func(array($this->bean, "update"), $pk);
        }
    }

    public function updateCurrent()
    {
        return call_user_func(array($this->bean, "updateCurrent"));
    }

    public function isSqlError()
    {
        return call_user_func(array($this->bean, "isSqlError"));
    }

    public function lastSqlError()
    {
        return call_user_func(array($this->bean, "lastSqlError"));
    }

}