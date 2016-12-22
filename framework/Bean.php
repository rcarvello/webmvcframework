<?php
/**
 * Interface Bean
 *
 * The interface designs a contract by defining some public methods that BeanAdpter implements.
 * BeanAdapter, by implementing these methods, provides the interoperability between a Record
 * object and the DML SQL actions, those physically implemented by a generic MySQL database
 * Bean object.
 * So a Record object uses BeanAdapter object through this Bean interface.
 * A Record object handles the submitted actions by an HTML form designed to execute some DML
 * operations against a MySQL table. After the form submission the Record object intercepts
 * the request and routes actions to a BeanAdapter. The BeanAdpter calls the methods of a MySQL
 * Bean Class which manage a single MySQL table and provides all necessary services to execute
 * SQL operations.
 *
 * @package framework
 * @filesource framework/Bean.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @see framework/Record
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework;

interface Bean
{
    /**
     * Selects a record from table matching the given primary key.
     *
     * @param mixed|array $pk
     * @return mixed
     */
    public function select($pk);

    /**
     * Inserts a new record by setting fields with attributes value.
     *
     * @return mixed
     */
    public function insert();

    /**
     * Deletes a record from table matching the given primary key.
     *
     * @param mixed|array $pk
     * @return mixed
     */
    public function delete($pk);

    /**
     * Updates a record from table matching the given primary key.
     *
     * @param mixed|array $pk
     * @return mixed
     */
    public function update($pk);

    /**
     * Updates a record with the current instance.
     *
     * @return mixed
     */
    public function updateCurrent();

    /**
     * Verifies if an sql error occurs during sql dml operations.
     * @return mixed|boolean
     */
    public function isSqlError();

    /**
     * Gets information about last SQL error.
     *
     * @return string
     */
    public function lastSqlError();
}