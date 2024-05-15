<?php
/**
 * ErrorHandler class
 *
 * @package framework/classes
 * @filesource framework/classes/ErrorHandler.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2024 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

namespace framework\classes;

class ErrorHandler
{

    /**
     * $errors
     *
     * @var array holds all the errors
     **/
    protected $errors = [];

    /**
     * addError
     *
     * @param string $error error message
     * @param string $key key to hold the error message
     **/
    public function addError($error, $key = null)
    {

        if (!is_null($key)) {
            $this->errors[$key][] = $error;
        } else {
            $this->errors[] = $error;
        }
    }

    /**
     * first
     *
     * @param string $key key for the error
     * @return string error message
     **/
    public function first($key)
    {

        return isset($this->all()[$key][0]) ? $this->all()[$key][0] : '';
    }

    /**
     * all
     *
     * @param string $key for the error
     * @return mixed all error messages in array or single error message if $key is given
     **/
    public function all($key = null)
    {

        return $this->errors[$key] ?? $this->errors;
    }

    /**
     * hasErrors
     *
     * @return boolean true if error else false
     **/
    public function hasErrors($key = null)
    {
        return is_null($key) ? (bool)count($this->all($key)) : isset($this->errors[$key]);
    }
}