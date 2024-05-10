<?php

namespace framework\classes;

class Common
{
    public static function PathToRoot()
    {

        return realpath(dirname(__FILE__));
    }
}
