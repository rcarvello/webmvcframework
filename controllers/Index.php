<?php
/**
 * Class Index
 *
 * {ControllerResponsability}
 *
 * @package controllers
 * @category Application Controller
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace controllers;

use framework\Controller;
use framework\Model;
use framework\View;
use models\Index as IndexModel;
use views\Index as IndexView;

class Index extends Controller
{
    protected $view;
    protected $model;

    /**
    * Object constructor.
    *
    * @param View $view
    * @param Model $mode
    */
    public function __construct(View $view=null, Model $model=null)
    {
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view,$this->model);
    }

    /**
    * Autorun method. Put your code here for running it after object creation.
    * @param mixed|null $parameters Parameters to manage
    *
    */
    protected function autorun($parameters = null)
    {

    }

    /**
    * Inizialize the View by loading static design of /index.html.tpl
    * managed by views\Index class
    *
    */
    public function getView()
    {
        $view = new IndexView("/index");
        return $view;
    }

    /**
    * Inizialize the Model by loading models\Index class
    *
    */
    public function getModel()
    {
        $model = new IndexModel();
        return $model;
    }
}
