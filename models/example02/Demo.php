<?php

namespace models\example02;
use framework\Model;
use framework\classes\Locale;

class Demo extends Model
{

    public  $currentLocale;

    public function __construct()
    {
        parent::__construct();
        $locale = new Locale();
        $this->currentLocale = $locale->getCurrenLocale();
    }

    public function getData()
    {
        if ($this->currentLocale == "en") {
            return "Hello";
        } else if($this->currentLocale == "it-it"){
            return "Salve";
        }
    }

    public function getItemsList()
    {
        $itemsEN = array (
            array ("Item" => "Mary"),
            array ("Item" => "Jenny"),
            array ("Item" => "Carol")
        );
        $itemsIT = array (
            array ("Item" => "Maria"),
            array ("Item" => "Giovanna"),
            array ("Item" => "Carolina")
        );

        if ($this->currentLocale == "en") {
            return $itemsEN;
        } else if($this->currentLocale == "it-it"){
            return $itemsIT;
        }

    }

}