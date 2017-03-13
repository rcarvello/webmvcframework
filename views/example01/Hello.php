<?php

namespace views\example01;
use framework\View;

class Hello extends View
{

    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "example01/hello";
        parent::__construct($tplName);
    }

    public function setMessage($message=null)
    {
        $this->setVar("Message", $message);
    }

    public function setSiteUrl($url)
    {
        $this->setVar("siteurl",$url);
    }

}