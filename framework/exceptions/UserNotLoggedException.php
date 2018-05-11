<?php
/**
 * Created by PhpStorm.
 * User: Saro
 * Date: 14/05/2017
 * Time: 17:48
 */

namespace framework\exceptions;


use Exception;

class UserNotLoggedException extends MVCException
{
    public function __construct($message, $code, Exception $previous,$controller)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        error_reporting(0);
        echo "Restricted access. User is not logged in <br />";
        echo 'Plese login ' . '<a href="' . SITEURL . '/' . DEFAULT_LOGIN_PAGE . '">here</a>.<br>';
        echo '<a href="' . $_SERVER['HTTP_REFERER'] . '">Back</a>';
        return "";
    }
}