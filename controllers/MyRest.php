<?php
/**
 * Class MyRest.
 *
 * A basic REST service responding to client GET and POST requests by using methods overriding
 * of httpGetRequest and httpPostRequest from base class \framework\RestService
 *
 * @package controllers
 * @category Application Controller
 * @author  Rosario Carvello - rosario.carvello@gmail.com
 */
namespace controllers;

use framework\RestService;
use models\beans\BeanPart;
use models\beans\BeanPartCategory;

class MyRest extends RestService
{
    public $bean;

    public function __construct()
    {

        parent::__construct();
        // TODO
        // $this->grantRole(100);
        // $this->restrictToRBAC("common/login","my_rest","You are not allowed to access to this service");
        $this->allowMethod("part");
        $this->allowMethod("category");
        $this->addCORS("https://www.allowedomain.domain");
    }


    /**
     * @override httpGetRequest
     * @param $method
     * @param $args
     * @return array
     *
     */
    public function httpGetRequest($method, $args)
    {
        $custom = array();
        if (!empty($method) && !empty($args)) {
            switch ($method) {
                case "part":
                    $this->bean = new BeanPart();
                    $this->bean->select($args[0]);
                    $custom = array("custom" => $this->bean->getDescription());
                    break;
                case "category":
                    $this->bean = new BeanPartCategory();
                    $this->bean->select($args[0]);
                    $custom = array("custom" => $this->bean->getName());
            }
        }
        return $custom;
    }

    /**
     * override httpPostRequest
     * @param $method
     * @param $args
     * @return array|string[]
     */
    public function httpPostRequest($method, $args)
    {
        $custom = array();
        if (!empty($method) && !empty($args)) {
            switch ($method) {
                case "part":
                    $this->bean = new BeanPart();
                    $custom = array("custom" => "POST on table part");
                    break;
                case "category":
                    $this->bean = new BeanPartCategory();
                    $custom = array("custom" => "POST on table part_category");
                    break;
            }
        }
        return $custom;
    }

    /**
     * @param $method
     * @param $args
     * @return array
     */
    public function httpPutRequest($method, $args)
    {
        return parent::httpPutRequest($method, $args); // TODO
    }

    /**
     * @param $method
     * @param $args
     * @return array
     */
    public function httpDeleteRequest($method, $args)
    {
        return parent::httpDeleteRequest($method, $args); // TODO
    }


}