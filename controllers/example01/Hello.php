<?php
namespace controllers\example01;

use framework\Controller;
use views\example01\Hello as HelloView;
use models\example01\Hello as HelloModel;


class Hello extends Controller
{

    protected $view;
    protected $model;

    public function autorun($parameter = null)
    {
        $view = $this->initView();
        $model = $this->initModel();
        $view->setMessage("{$model->getData()} {$this->getName()}");
        $view->setSiteUrl($this->getSiteURL());
    }

    protected function initView()
    {
        $view = new HelloView();
        $this->setView($view);
        return $view;
    }

    protected function initModel()
    {
        $model = new HelloModel();
        $this->setModel($model);
        return $model;
    }

    protected function getSiteURL()
    {
        return str_replace("http://","",SITEURL);
    }

    public function simpleMethod()
    {
        $view = $this->initView();
        $model = $this->initModel();
        $view->setMessage("{$model->getData()} {$this->getName()}->simpleMethod()");
        $view->setSiteUrl($this->getSiteURL());
        $this->render();
    }

    public function anotherMethod($parameter1,$parameter2=null)
    {
        $view = $this->initView();
        $model = $this->initModel();
        $view->setMessage("{$model->getData()} {$this->getName()}->anotherMethod() with $parameter1 and $parameter2");
        $view->setSiteUrl($this->getSiteURL());
        $this->render();
    }


}