<?php
/**
 * Interface Bean
 *
 * Defines public methods that a MySQL Database Bean class must implement.
 * A Database Bean class manages a single MySQL table. By implementing this contract
 * it provides all necessary services to execute SQL operations against the managed
 * table.
 * The interface is designed to guarantee interoperability of a Database Bean class
 * together with the Record class. A Record object uses a Database Bean object.
 * A Record object handles the submit action of an HTML form designed to execute some
 * DML operations against a MySQL table. After the form submit the Record object
 * intercepts the request and uses a Database Bean object to execute its DML operation
 * that satisfy user request.
 *
 * @package framework
 * @filesource framework/Bean.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @note none
 * @see framework/Record
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD Public License.
 */
namespace framework;

interface Bean
{
    /**
     * Selects a record from table matching give primary key
     *
     * @param mixed $pk
     * @return mixed
     *
     */
    public function select($pk);

    /**
     * Inserts a new record by setting fields with attributes value.
     *
     * @return mixed
     */
    public function insert();

    /**
     * Deletes a record from table matching give primary key.
     *
     * @param mixed $pk
     * @return mixed
     *
     */
    public function delete($pk);

    /**
     * Updates a record from table matching give primary key.
     *
     * @param mixed $pk
     * @return mixed
     *
     */
    public function update($pk);

    /**
     * Updates a record with current instance.
     *
     * @param mixed $pk
     * @return mixed
     *
     */
    public function updateCurrent();

    /**
     * Verifies if an sql error occurs during sql dml operations.
     * @return boolean
     */
    public function isSqlError();

    /**
     * Gets information about last sql error.
     *
     * @return string
     */
    public function lastSqlError();
}