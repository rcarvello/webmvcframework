<?php
/**
 * Created by PhpStorm.
 * User: Saro
 * Date: 14/02/2017
 * Time: 17:03
 */

namespace controllers\example01;
use framework\Controller;
use framework\Model;
use framework\View;

use models\example01\FirstPage as FirstPageModel;
use views\example01\FirstPage as FirstPageView;
use controllers\example02\Demo;

class FirstPage extends Controller
{
    public function __construct(View $view=null, Model $model=null)
    {
        $this->view = empty($view) ? $this->initView() : $view;
        $this->model = empty($model) ? $this->initModel() : $model;

        $this->view->setControllerNamePlaceHolder($this->getName());

        $data = $this->model->getSimpleData();
        $this->view->setSimpleDataPlaceHolder($data);

        $userList =$this->model->getSimpleList();
        $this->view->setUsersBlock($userList);

        $this->bindController(new Demo());
        parent::__construct($this->view,$this->model);
    }


    protected function initView()
    {
        $view = new FirstPageView();
        return $view;
    }

    protected function initModel()
    {
        $model = new FirstPageModel();
        return $model;
    }
}