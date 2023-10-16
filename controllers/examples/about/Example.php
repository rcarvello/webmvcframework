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

    public function helloWorldSecond(){
        $controller = highlight_file('controllers/examples/cms/HelloWorldSecond.php',true);
        $model      = highlight_file('models/examples/cms/HelloWorld.php',true);
        $view       = highlight_file('views/examples/cms/HelloWorld.php',true);
        $tpl        = htmlentities(file_get_contents('templates/examples/cms/hello_world_second.html.tpl',true));
        $this->view->setVarExample("Hello Word Second");
        $this->view->setVarController($controller);
        $this->view->setVarControllerFile("controllers/examples/cms/HelloWorldSecond.php");
        $this->view->setVarModel($model);
        $this->view->setVarModelFile("models/examples/cms/HelloWorld.php (Shared)");
        $this->view->setVarView($view);
        $this->view->setVarViewFile("views/examples/cms/HelloWorld.php (Shared)");
        $this->view->setVarTemplate($tpl);
        $this->view->setVarTemplateFile("templates/examples/cms/hello_world_second.html.tpl");
        $this->render();
    }


    public function block(){
        $controller = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'controllers/examples/cms/Block.php',true);
        $model      = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'models/examples/cms/Block.php',true);
        $view       = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'views/examples/cms/Block.php',true);
        $tpl        = htmlentities(file_get_contents(SECURING_OUTSIDE_HTTP_FOLDER .'templates/examples/cms/block.html.tpl',true));
        $this->view->setVarExample("Block");
        $this->view->setVarController($controller);
        $this->view->setVarControllerFile("controllers/examples/cms/Block.php");
        $this->view->setVarModel($model);
        $this->view->setVarModelFile("models/examples/cms/Block.php");
        $this->view->setVarView($view);
        $this->view->setVarViewFile("views/examples/cms/Block.php");
        $this->view->setVarTemplate($tpl);
        $this->view->setVarTemplateFile("templates/examples/cms/block.html.tpl");
        $this->render();
    }

    public function captcha(){
        $controller = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'controllers/examples/cms/CaptchaComponent.php',true);
        $model      = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'models/examples/cms/CaptchaComponent.php',true);
        $view       = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'views/examples/cms/CaptchaComponent.php',true);
        $tpl        = htmlentities(file_get_contents(SECURING_OUTSIDE_HTTP_FOLDER .'templates/examples/cms/captcha_component.html.tpl',true));
        $this->view->setVarExample("CaptchaComponent");
        $this->view->setVarController($controller);
        $this->view->setVarControllerFile("controllers/examples/cms/CaptchaComponent.php");
        $this->view->setVarModel($model);
        $this->view->setVarModelFile("models/examples/cms/CaptchaComponent.php");
        $this->view->setVarView($view);
        $this->view->setVarViewFile("views/examples/cms/CaptchaComponent.php");
        $this->view->setVarTemplate($tpl);
        $this->view->setVarTemplateFile("templates/examples/cms/captcha_component.html.tpl");
        $this->render();
    }

    public function myrest(){
        $controller = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'controllers/MyRest.php',true);
        $model      = "";
        $view       = "";
        $tpl        = htmlentities(file_get_contents(SECURING_OUTSIDE_HTTP_FOLDER .'my_rest_gui.html',true));
        $this->view->setVarExample("REST Service Demo");
        $this->view->setVarController($controller);
        $this->view->setVarControllerFile("MyRest.php");
        $this->view->setVarModel($model);
        $this->view->setVarModelFile("none");
        $this->view->setVarView($view);
        $this->view->setVarViewFile("none");
        $this->view->setVarTemplate($tpl);
        $this->view->setVarTemplateFile("my_rest_gui.html");
        $this->render();
    }

    public function restService(){
        $controller = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'framework/RestService.php',true);
        $model      = "";
        $view       = "";
        $tpl        = "<b>None</b>";
        $this->view->setVarExample("RestService Controller");
        $this->view->setVarController($controller);
        $this->view->setVarControllerFile("RestService.php");
        $this->view->setVarModel($model);
        $this->view->setVarModelFile("None");
        $this->view->setVarView($view);
        $this->view->setVarViewFile("None");
        $this->view->setVarTemplate($tpl);
        $this->view->setVarTemplateFile("");
        $this->render();
    }
    public function innerBlocks(){
        $controller = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'controllers/examples/cms/InnerBlocks.php',true);
        $model      = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'models/examples/cms/InnerBlocks.php',true);
        $view       = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'views/examples/cms/InnerBlocks.php',true);
        $tpl        = htmlentities(file_get_contents(SECURING_OUTSIDE_HTTP_FOLDER .'templates/examples/cms/inner_blocks.html.tpl',true));
        $this->view->setVarExample("Inner blocks");
        $this->view->setVarController($controller);
        $this->view->setVarControllerFile("controllers/examples/cms/InnerBlocks.php");
        $this->view->setVarModel($model);
        $this->view->setVarModelFile("models/examples/cms/InnerBlocks.php");
        $this->view->setVarView($view);
        $this->view->setVarViewFile("views/examples/cms/InnerBlocks.php");
        $this->view->setVarTemplate($tpl);
        $this->view->setVarTemplateFile("templates/examples/cms/inner_blocks.html.tpl");
        $this->render();
    }

    public function blockExtended(){
        $controller = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'controllers/examples/cms/BlockExtended.php',true);
        $modelMore      = "BlockExentend inerhit from controller\\examples\cms\Block its Model<br>";
        $viewMore       = "BlockExentend inerhit from controller\\examples\cms\Block its View<br>";
        $model      = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'models/examples/cms/Block.php',true);
        $view       = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'views/examples/cms/Block.php',true);
        $tpl        = htmlentities(file_get_contents(SECURING_OUTSIDE_HTTP_FOLDER .'templates/examples/cms/block_extended.html.tpl',true));
        $this->view->setVarExample("Inner blocks");
        $this->view->setVarController($controller);
        $this->view->setVarControllerFile("controllers/examples/cms/BlockExtended.php");
        $this->view->setVarModel($model);
        $this->view->setVarModelFile($modelMore . "models/examples/cms/Blocks.php");
        $this->view->setVarView($view);
        $this->view->setVarViewFile($viewMore . "views/examples/cms/Blocks.php");
        $this->view->setVarTemplate($tpl);
        $this->view->setVarTemplateFile("templates/examples/cms/block_extended.html.tpl");
        $this->render();
    }

    public function localization(){
        $controller = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'controllers/examples/cms/Localization.php',true);
        $model      = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'models/examples/cms/Localization.php',true);
        $view       = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'views/examples/cms/Localization.php',true);
        $tpl        = htmlentities(file_get_contents(SECURING_OUTSIDE_HTTP_FOLDER .'templates/examples/cms/localization.html.tpl',true));
        $this->view->setVarExample("Inner blocks");
        $this->view->setVarController($controller);
        $this->view->setVarControllerFile("controllers/examples/cms/Localization.php");
        $this->view->setVarModel($model);
        $this->view->setVarModelFile("models/examples/cms/Localization.php");
        $this->view->setVarView($view);
        $this->view->setVarViewFile("views/examples/cms/Localization.php");
        $this->view->setVarTemplate($tpl);
        $this->view->setVarTemplateFile("templates/examples/cms/localization.html.tpl");
        $this->render();
    }

    public function helloBlock(){
        $controller = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'controllers/examples/cms/HelloBlock.php',true);
        $model      = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'models/examples/cms/HelloBlock.php',true);
        $view       = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'views/examples/cms/HelloBlock.php',true);
        $tpl        = htmlentities(file_get_contents(SECURING_OUTSIDE_HTTP_FOLDER .'templates/examples/cms/hello_block.html.tpl',true));
        $this->view->setVarExample("Hello World with block");
        $this->view->setVarController($controller);
        $this->view->setVarControllerFile("controllers/examples/cms/HelloBlock.php");
        $this->view->setVarModel($model);
        $this->view->setVarModelFile("models/examples/cms/HelloBlock.php");
        $this->view->setVarView($view);
        $this->view->setVarViewFile("views/examples/cms/HelloBlock.php");
        $this->view->setVarTemplate($tpl);
        $this->view->setVarTemplateFile("templates/examples/cms/hello_block.html.tpl");
        $this->render();
    }

    public function treeDemo(){
        $controller = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'controllers/examples/cms/TreeDemo.php',true);
        $model      = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'models/examples/cms/TreeDemo.php',true);
        $view       = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'views/examples/cms/TreeDemo.php',true);
        $tpl        = htmlentities(file_get_contents(SECURING_OUTSIDE_HTTP_FOLDER .'templates/examples/cms/tree_demo.html.tpl',true));
        $this->view->setVarExample("TreeDemo MVC Assembly source Code");
        $this->view->setVarController($controller);
        $this->view->setVarControllerFile("controllers/examples/cms/TreeDemo.php");
        $this->view->setVarModel($model);
        $this->view->setVarModelFile("models/examples/cms/TreeDemo.php");
        $this->view->setVarView($view);
        $this->view->setVarViewFile("views/examples/cms/TreeDemo.php");
        $this->view->setVarTemplate($tpl);
        $this->view->setVarTemplateFile("templates/examples/cms/tree_demo.html.tpl");
        $this->render();
    }

    public function partList(){
        $controller = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'controllers/examples/db/PartList.php',true);
        $model      = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'models/examples/db/PartList.php',true);
        $view       = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'views/examples/db/PartList.php',true);
        $tpl        = htmlentities(file_get_contents(SECURING_OUTSIDE_HTTP_FOLDER .'templates/examples/db/part_list.html.tpl',true));
        $this->view->setVarExample("PartList MVC Assembly source Code");
        $this->view->setVarController($controller);
        $this->view->setVarControllerFile("controllers/examples/db/PartList.php");
        $this->view->setVarModel($model);
        $this->view->setVarModelFile("models/examples/db/PartList.php");
        $this->view->setVarView($view);
        $this->view->setVarViewFile("views/examples/db/PartList.php");
        $this->view->setVarTemplate($tpl);
        $this->view->setVarTemplateFile("templates/examples/db/part_list.html.tpl");
        $this->render();
    }

    public function partPaginator(){
        $controller = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'controllers/examples/db/PartPaginator.php',true);
        $model      = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'models/examples/db/PartPaginator.php',true);
        $view       = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'views/examples/db/PartPaginator.php',true);
        $tpl        = htmlentities(file_get_contents(SECURING_OUTSIDE_HTTP_FOLDER .'templates/examples/db/part_paginator.html.tpl',true));
        $this->view->setVarExample("PartPaginator MVC Assembly source Code");
        $this->view->setVarController($controller);
        $this->view->setVarControllerFile("controllers/examples/db/PartPaginator.php");
        $this->view->setVarModel($model);
        $this->view->setVarModelFile("models/examples/db/PartPaginator.php");
        $this->view->setVarView($view);
        $this->view->setVarViewFile("views/examples/db/PartPaginator.php");
        $this->view->setVarTemplate($tpl);
        $this->view->setVarTemplateFile("templates/examples/db/part_paginator.html.tpl");
        $this->render();
    }
    public function partListManager(){
        $controller = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'controllers/examples/db/PartListManager.php',true);
        $model      = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'models/examples/db/PartListManager.php',true);
        $view       = highlight_file(SECURING_OUTSIDE_HTTP_FOLDER .'views/examples/db/PartListManager.php',true);
        $tpl        = htmlentities(file_get_contents(SECURING_OUTSIDE_HTTP_FOLDER .'templates/examples/db/part_list_manager.html.tpl',true));
        $this->view->setVarExample("PartListManager MVC Assembly source Code");
        $this->view->setVarController($controller);
        $this->view->setVarControllerFile("controllers/examples/db/PartListManager.php");
        $this->view->setVarModel($model);
        $this->view->setVarModelFile("models/examples/db/PartListManager.php");
        $this->view->setVarView($view);
        $this->view->setVarViewFile("views/examples/db/PartListManager.php");
        $this->view->setVarTemplate($tpl);
        $this->view->setVarTemplateFile("templates/examples/db/part_list_manager.html.tpl");
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
