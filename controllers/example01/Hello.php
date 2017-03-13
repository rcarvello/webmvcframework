<?php
namespace controllers\example01;

use framework\Controller;
use framework\Model;
use framework\View;
use views\example01\Hello as HelloView;
use models\example01\Hello as HelloModel;


class Hello extends Controller
{

    public function __construct(View $view=null, Model $model=null)
    {
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view,$this->model);
    }


    public function autorun($parameter = null)
    {
        $this->view->setMessage("{$this->model->getData()} {$this->getName()}");
        $this->view->setSiteUrl($this->getSiteURL());
    }

    public function getView()
    {
        $view = new HelloView();
        return $view;
    }

    public function getModel()
    {
        $model = new HelloModel();
        return $model;
    }

    protected function getSiteURL()
    {
        return str_replace("http://","",SITEURL);
    }

    public function simpleMethod()
    {

        $this->view->setMessage("{$this->model->getData()} {$this->getName()}->simpleMethod()");
        $this->view->setSiteUrl($this->getSiteURL());
        $this->render();
    }

    public function anotherMethod($parameter1,$parameter2=null)
    {
        $this->view->setMessage("{$this->model->getData()} {$this->getName()}->anotherMethod() with $parameter1 and $parameter2");
        $this->view->setSiteUrl($this->getSiteURL());
        $this->render();
    }


}