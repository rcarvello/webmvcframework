<?php

namespace models\example01;

use framework\Model;

class FirstPage extends Model
{
    /**
     * Gets simple data
     * @return string A simple data
     */
    public function getSimpleData()
    {
        return "This is a simple data from ". get_class($this);
    }

    /**
     * Gets a simple list
     * @return array
     */
    public function getSimpleList()
    {
        $list = array();
        $item = array("NamePlaceHolder" => "Bob", "RolePlaceHolder" => "Developer");
        $list[] = $item;
        $item = array("NamePlaceHolder" => "Elen", "RolePlaceHolder" => "Designer");
        $list[] = $item;
        $item = array("NamePlaceHolder" => "Frank", "RolePlaceHolder" => "Analyst");
        $list[] = $item;
        return $list;
    }

}