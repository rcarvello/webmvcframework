<?php
/**
 * Class DynamicBinding
 *
 * {ControllerResponsability}
 *
 * @package controllers\examples\cms
 * @category Application Controller
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace controllers\examples\cms;

use framework\Controller;
use framework\Model;
use framework\View;
use models\examples\cms\DynamicBinding as DynamicBindingModel;
use views\examples\cms\DynamicBinding as DynamicBindingView;


class DynamicBinding extends Controller
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

    public function bindHello()
    {
        $this->hide("Info");
        $controller = new HelloWorld();
        $this->bindController( $controller, "whitchController");
        $this->render();
    }

    public function bindBlock()
    {
        $this->hide("Info");
        $controller = new Block();
        $this->bindController($controller, "whitchController",true);
        $this->render();
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
    * Inizialize the View by loading static design of /examples/cms/dynamic_binding.html.tpl
    * managed by views\examples\cms\DynamicBinding class
    *
    */
    public function getView()
    {
        $view = new DynamicBindingView("/examples/cms/dynamic_binding");
        return $view;
    }

    /**
    * Inizialize the Model by loading models\examples\cms\DynamicBinding class
    *
    */
    public function getModel()
    {
        $model = new DynamicBindingModel();
        return $model;
    }
}
