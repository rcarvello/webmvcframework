<?php
/**
 * Created by PhpStorm.
 * User: Saro
 * Date: 21/11/2016
 * Time: 16:48
 */

namespace controllers\example02;

use framework\Controller;
use framework\Model;
use framework\View;
use framework\components\DataRepeater;
use views\example02\Demo as DemoView;
use models\example02\Demo as DemoModel;


class Demo extends Controller
{

    protected $view;
    protected $model;


    public function __construct(View $view=null, Model $model=null)
    {
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view,$this->model);
    }

    public function autorun($parameter = null)
    {
        $this->view->setMessage("{$this->model->getData()} MVC");
        $this->initRepeaterComponent($this->view,$this->model);
    }

    public function getView()
    {
        $view = new DemoView();
        $this->setView($view);
        return $view;
    }

    public function getModel()
    {
        $model = new DemoModel();
        $this->setModel($model);
        return $model;
    }

    protected function initRepeaterComponent(DemoView $view, DemoModel $model)
    {
        $repeater = new DataRepeater($view,$model);
        $repeater->setContentToBlock("ListItems");
        $repeater->setValuesFromArray($model->getItemsList());
        $this->bindComponent($repeater,true);
    }

    public function simpleMethod()
    {
        $view = $this->initView();
        $model = $this->initModel();
        $view->setMessage("{$model->getData()} simpleMethod()");
        $this->initRepeaterComponent($this->view,$this->model);
        $this->render();
    }

    public function anotherMethod($parameter1,$parameter2=null)
    {
        $view = $this->initView();
        $model = $this->initModel();
        if ($model->currentLocale == "en"){
            $with = "with";
        } else if ($model->currentLocale == "it-it"){
            $with = "con";
        }
        $view->setMessage("{$model->getData()} anotherMethod() $with $parameter1 and $parameter2");
        $this->initRepeaterComponent($this->view,$this->model);
        $this->render();
    }

}