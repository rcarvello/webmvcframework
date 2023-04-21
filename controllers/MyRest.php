<?php
namespace controllers;
use framework\RestService;
use models\beans\BeanCustomer;
use models\beans\BeanPart;


class MyRest extends RestService
{
    public $bean;

    public function __construct()
    {
        // $this->restrictToAuthentication();
        parent::__construct();
        $this->allowMethod("customer");
        $this->addCORS("http://www.tin.it");
        $this->bean = new BeanPart();

    }

    public function bean($name, $args=1)
    {
        echo $name . "-" . $args;
    }

    public function httpGetRequest($method, $args)
    {
        /*
        echo "HTTP GET method raised \n";
        echo "User method raised: ". $method . "\n";
        echo "Method parameters:";
        print_r($args);
        */
        if (! empty($method) && !empty($args) )
            $this->bean->select($args[0]);
        return array("custom" => $this->bean->getDescription());
        //return array("custom" => json_encode(html_entity_decode($args[1])));

    }
    public function httpPostRequest($method, $args)
    {
        /*
        echo "HTTP GET method raised \n";
        echo "User method raised: ". $method . "\n";
        echo "Method parameters:";

        */
        $this->bean->select($args[0]);
        return array("custom" => $this->bean->getPartTypeCode());

    }

}