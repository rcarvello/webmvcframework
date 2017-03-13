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
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view,$this->model);
    }
    
    public function autorun($parameters = null)
    {
        $this->view->setControllerNamePlaceHolder($this->getName());

        $data = $this->model->getSimpleData();
        $this->view->setSimpleDataPlaceHolder($data);

        $userList =$this->model->getSimpleList();
        $this->view->setUsersBlock($userList);

        $this->bindController(new Demo());
    }

    public function getView()
    {
        $view = new FirstPageView();
        return $view;
    }

    public function getModel()
    {
        $model = new FirstPageModel();
        return $model;
    }
}