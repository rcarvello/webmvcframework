<?php

namespace models\example01;
use framework\Model;

class Hello extends Model
{

    private $data= "Welcome";
    private $elements;

    public function __construct()
    {
        parent::__construct();
        $this->initElements();
    }

    private function initElements()
    {
        $this->elements = array("item a", "item b", "item c");
    }

    public function getData()
    {
        return $this->data;
    }

    public function getElements()
    {
        return $this->elements;
    }

}