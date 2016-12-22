<?php

namespace views\example02;
use framework\View;

class Demo extends View
{
    public function __construct()
    {
        parent::__construct("example02/demo");
    }

    public function setMessage($message=null)
    {
        $this->setVar("Message", $message);
    }


    public function setList()
    {
        $listItems = array("item 1", "item 2", "item 3");
        $this->openBlock("ListItems");
        foreach($listItems as $key=>$value){
            $this->setVar("Item",$value);
            $this->parseCurrentBlock();
        }
        $this->setBlock();
    }

}