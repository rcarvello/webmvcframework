<?php

namespace views\example01;
use framework\View;

class Hello extends View
{
    public function __construct()
    {
        parent::__construct("example01/hello");
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