<?php
/**
 * Class Example
 *
 * {ControllerResponsability}
 *
 * @package controllers\examples\about
 * @category Application Controller
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace controllers\examples\about;

use framework\components\Component;
use framework\Controller;
use framework\Model;
use framework\View;
use models\examples\about\Example as ExampleModel;
use views\examples\about\Example as ExampleView;

class Example extends Controller
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
        $controller = highlight_file('controllers/examples/cms/HelloWorld.php',true);
        $model      = highlight_file('models/examples/cms/HelloWorld.php',true);
        $view       = highlight_file('views/examples/cms/HelloWorld.php',true);
        $tpl        = highlight_file('templates/examples/cms/hello_world.html.tpl',true);
        $this->view->setVarExample("Hello Word");
        $this->view->setVarController($controller);
        $this->view->setVarModel($model);
        $this->view->setVarView($view);
        $this->view->setVarTemplate($tpl);
    }

    /**
    * Inizialize the View by loading static design of /examples/about/example.html.tpl
    * managed by views\examples\about\Example class
    *
    */
    public function getView()
    {
        $view = new ExampleView("/examples/about/example");
        return $view;
    }

    /**
    * Inizialize the Model by loading models\examples\about\Example class
    *
    */
    public function getModel()
    {
        $model = new ExampleModel();
        return $model;
    }

    private function showSource($namespace,$controller=null,$model=null,$view, $template)
    {
      $controller = (empty($controller)) ? "controllers/". $namespace ."php": $controller . "php";
      $model= (empty($model)) ? "models/". $namespace ."php": $model ."php";
      $view = (empty($view)) ? "views/". $namespace ."php": $view ."php";
      $template= (empty($template)) ? "templates/". $this->camelCaseToUnderscore($namespace) ."html.tpl": $this->camelCaseToUnderscore($template) ."html.tpl";
    }
    public function helloWorld(){
        $controller = highlight_file('controllers/examples/cms/HelloWorld.php',true);
        $model      = highlight_file('models/examples/cms/HelloWorld.php',true);
        $view       = highlight_file('views/examples/cms/HelloWorld.php',true);
        $tpl        = htmlentities(file_get_contents('templates/examples/cms/hello_world.html.tpl',true));
        $this->view->setVarExample("Hello Word");
        $this->view->setVarController($controller);
        $this->view->setVarControllerFile("controllers/examples/cms/HelloWorld.php");
        $this->view->setVarModel($model);
        $this->view->setVarModelFile("models/examples/cms/HelloWorld.php");
        $this->view->setVarView($view);
        $this->view->setVarViewFile("views/examples/cms/HelloWorld.php");
        $this->view->setVarTemplate($tpl);
        $this->view->setVarTemplateFile("templates/examples/cms/hellp_world.html.tpl");
        $this->render();
    }

    /**
     * Convert camelCase/PascalCase to under_score notation.
     *
     * @param string $string The string to convert
     * @return string
     */
    private function camelCaseToUnderscore($string)
    {
        $string = lcfirst($string);
        return strtolower(preg_replace('/([A-Z]+)/', "_$1", $string));
    }

}
