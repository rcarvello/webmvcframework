<?php

namespace views\example01;

use framework\View;

class FirstPage extends View
{

    public function __construct($tplName = null)
    {
        $tplName = empty($tplName) ? $tplName = "example01/first_page": $tplName;
        parent::__construct($tplName);
    }

    public function setControllerNamePlaceHolder($controllerName)
    {
        $this->setVar("ControllerNamePlaceHolder",$controllerName);
    }

    public function setSimpleDataPlaceHolder($data)
    {
        $this->setVar("SimpleDataPlaceHolder",$data);
    }

    public function setUsersBlock($list)
    {
        $this->openBlock("Users");
        foreach($list as $user){
            $this->setVar("NamePlaceHolder",$user["NamePlaceHolder"]);
            $this->setVar("RolePlaceHolder",$user["RolePlaceHolder"]);
            $this->parseCurrentBlock();
        }
        $this->setBlock();
    }
}