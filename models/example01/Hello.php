<?php

namespace models\example01;
use framework\Model;

class Hello extends Model
{

    private $data= "Welcome";

    public function __construct()
    {
        parent::__construct();
    }

    public function getData()
    {
        return $this->data;
    }

}