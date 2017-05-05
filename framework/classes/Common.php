<?php

/**
 * Created by PhpStorm.
 * User: Saro
 * Date: 04/05/2017
 * Time: 08:55
 */
namespace framework\classes;

class Common
{
    public static function PathToRoot()
    {

        return realpath(dirname(__FILE__));
    }
}