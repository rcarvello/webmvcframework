<?php
/**
 * Class MVCException
 *
 * MVC generic exception. Handles exceptions and show message.
 *
 * @package framework/exceptions
 * @filesource framework/exception/MVCException.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework\exceptions;
use framework\classes\Locale;
class MVCException extends \Exception

{
    public function __toString()
    {
        error_reporting(0);
        $message  =  get_class($this). ": [{$this->code}]: <br/> {$this->message} <br/>";
        $message .=  str_replace("#","<br>#",$this->getTraceAsString()) . "<br>";
        echo $message;
        echo '<br><a href="' . $_SERVER['HTTP_REFERER'] . '">Back</a>';
        return "";
    }
}