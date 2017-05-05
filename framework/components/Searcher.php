<?php
/**
 * Class Searcher
 *
 * @package framework
 * @filesource framework/components/Searcher.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework\components;

use framework\Model;
use framework\View;

class Searcher extends Component
{
    private $filters = array();
    private $booleanOperator = "AND";
    private $submitButton = "search_submit";
    private $resetButton = "search_reset";
    private $formName = "search_form";


    public function addFilter($name,$parameter,$operator="=",$type="string")
    {
        $this->filters[$name]=array("parameter"=>$parameter,"operator"=>$operator,"type"=>$type);
    }

    public function removeFilter($name)
    {
        unset($this->filters[$name]);
    }

    public function init(Model $model=null, View $view=null)
    {
        $sql = "";
        $_GET = array_merge($_GET,$_POST);
        $doReset = false;

        if (isset($_GET[$this->resetButton]) || isset($_POST[$this->resetButton])) {
            $doReset = true;
            $location = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
            header("location: $location");
        }

        foreach ($this->filters as $key=>$value) {
            $p = $this->filters[$key];

            if ($doReset == true) {
                unset($_GET[$p["parameter"]]);
                unset($_POST[$p["parameter"]]);
            }

            if (isset($_GET[$p["parameter"]]) && !empty( $_GET[$p["parameter"]])){
                if ( $p["type"] == "string" && $p["operator"]== "=") {
                    $parameter = $this->model->real_escape_string($_GET[$p["parameter"]]);
                    $sql = $sql . $key . $p["operator"] . "'" . $parameter . "' " . $this->booleanOperator . " ";
                } elseif ( $p["type"] == "string" && $p["operator"]== "LIKE") {
                    $parameter = $this->model->real_escape_string($_GET[$p["parameter"]]);
                    $sql = $sql . $key . " " . $p["operator"] . " '%" . $parameter . "%' " . $this->booleanOperator . " ";
                } else {
                    $parameter = $this->model->real_escape_string($_GET[$p["parameter"]]);
                    $sql = $sql . $key . $p["operator"] . $_GET[$p["parameter"]] . " " .$this->booleanOperator . " " ;
                    // $sql = $sql . $key . $p["operator"] . $parameter . " " .$this->booleanOperator . " " ;
                }
                $view->setVar($p["parameter"], $_GET[$p["parameter"]]);
            } else {
                $view->setVar($p["parameter"], "");
            }

        }

        if (isset($_GET[$this->resetButton]) || isset($_POST[$this->resetButton]) ) {
            unset($_GET[$this->resetButton]);
            unset($_POST[$this->resetButton]);
        }

        $sql = substr($sql,0,-5);
        if ($sql && strlen($sql)>0 )
            $sql = " WHERE " . $sql;
        $model->sql = $model->sql . $sql;
    }

    public function setResetButton($var,$value) {
        $this->view->setVar($var, $value );
        $this->resetButton = $value;
    }

    public function setSubmitButton($var,$value) {
        $this->view->setVar($var, $value );
        $this->submitButton = $value;
    }

    public function setFormName($var, $value) {
        $this->view->setVar($var, $value );
        $this->formName = $value;
    }

}