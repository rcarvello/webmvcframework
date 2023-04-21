<?php
/**
 * Class HelloBlock
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
use models\examples\cms\HelloBlock as HelloBlockModel;
use views\examples\cms\HelloBlock as HelloBlockView;
use framework\components\DataRepeater;

class HelloBlock extends Controller
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
        $this->view->setVarWelcomeMessage("Hello World with block");
        $users = $this->model->getUsers();

        $this->view->openBlockUsers();
        foreach ($users as $user){
            $this->view->setBlockVarUsersName($user['Name']);
            $this->view->setBlockVarUsersLocation($user['Location']);
            $this->view->parseCurrentBlock();
        }
        $this->view->setBlock();

        /*
        $d = new DataRepeater($this->view,null,"Users",$users);
        $d->render();
        */
    }

    /**
    * Inizialize the View by loading static design of /examples/cms/hello_block.html.tpl
    * managed by views\examples\cms\HelloBlock class
    *
    */
    public function getView()
    {
        $view = new HelloBlockView("/examples/cms/hello_block");
        return $view;
    }

    /**
    * Inizialize the Model by loading models\examples\cms\HelloBlock class
    *
    */
    public function getModel()
    {
        $model = new HelloBlockModel();
        return $model;
    }
}
