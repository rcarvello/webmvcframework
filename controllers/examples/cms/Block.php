<?php
/**
 * Class Block
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
use models\examples\cms\Block as BlockModel;
use views\examples\cms\Block as BlockView;

class Block extends Controller
{

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
        $message = $this->model->getMessage();
        $users = $this->getModel()->getUsers();

        $this->view->setMessage($message);
        $this->view->setUsers($users);
    }

    /**
    * Inizialize the View by loading static design of /examples/cms/block.html.tpl
    * managed by views\examples\cms\Block class
    *
    */
    public function getView()
    {
        $view = new BlockView("/examples/cms/block");
        return $view;
    }

    /**
    * Inizialize the Model by loading models\examples\cms\Block class
    *
    */
    public function getModel()
    {
        $model = new BlockModel();
        return $model;
    }
}
