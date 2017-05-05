<?php

namespace controllers\builders;

use framework\Controller;

use models\builders\SkeletonBuilder as SkeletonBuilderModel;
use views\builders\SkeletonBuider as SkeletonBuilderView;
use framework\View;
use framework\Model;
use framework\components\DataRepeater;

class SkeletonBuilder extends Controller
{
    private $subsystemName;
    private $controllerName;
    private $basePath;
    private $buildTranslation = false;
    private $templateHTMLcode;
    private $infoMessage = "";
    private $error = false;

    public function __construct(View $view=null, Model $model=null)
    {
        $this->view = empty($view)  ? new SkeletonBuilderView():$view;
        $this->model= empty($model) ? new SkeletonBuilderModel(): $model;
        parent::__construct($this->view, $this->model);
    }

    public function autorun($parameters = null)
    {

        if (isset($_GET["ResetDesign"])) {
            unset($_SESSION["CurrentDesign"]);
            header("location: skeleton_builder");
        }

        $this->initDesign();
        $this->checkFordBuildSkeletonRequest();
        $this->checkFordBuildSubSystemRequest();
        $this->view->setVarTemplatePath();
        $this->view->setInfoMessage($this->infoMessage,$this->error);

        $repeater = new DataRepeater($this->view,null,"Controllers",$this->model->getControllers());
        $repeater->render();

        $subSystemsRepeater = new DataRepeater($this->view,null,"SubSystems",$this->model->getSubsystems());
        $subSystemsRepeater->render();
        $subSystemsRepeater->setContentToBlock("ModalSubSystems");
        $subSystemsRepeater->render();

        // $this->setAsObserver();
    }

    /**
     * Primary form processing.
     *
     */
    private function checkFordBuildSkeletonRequest()
    {
        if (isset($_POST["controller"]) && isset($_POST["subsystem"])){
            $this->initPost();
            if ($this->buildMVCSkeletons()){
                $mvc = APP_MODELS_PATH . "/" . APP_VIEWS_PATH . "/". APP_CONTROLLERS_PATH  ;
                $this->infoMessage = "MVC Classes (" . $mvc . ")" . $this->basePath . "\\" .$this->controllerName . ".php and Template were successful created.";

            } else {
                $this->error = true;
                $this->infoMessage = "Error whlie creating skeletons for MVC and Template " . $this->controllerName;
            }
            // $this->printMe();
        }
    }

    /**
     * Modal dialog form processing.
     */
    private function checkFordBuildSubSystemRequest()
    {
        if (isset($_POST["parentSubSystem"]) && isset($_POST["childSubSystem"])){
            $subSystem = trim(str_replace("\\\\","\\",$_POST["parentSubSystem"])) . DIRECTORY_SEPARATOR . trim(str_replace(" ","",$_POST["childSubSystem"]));
            $subSystem = strtolower(str_replace("_","",$subSystem));
            $this->basePath = ltrim($subSystem,APP_CONTROLLERS_PATH);
            if ($this->isControllersSubDir($subSystem)){
                if ($this->model->createMVCFolders($this->basePath) ) {
                    $this->error = false;
                    $this->infoMessage = "Subsystem " . $subSystem . " was successful created.";
                } else {
                    $this->error = true;
                    $this->infoMessage = "Error while creating Subsystem " . $subSystem;
                }
             } else {
                $this->error = true;
                $this->infoMessage = "Cannot create Subsystem " . $subSystem . " outside " .APP_CONTROLLERS_PATH;
            }
         }
    }

    /**
     *  Builds MVC Skeleton Classes and Template
     */
    private function buildMVCSkeletons() {

        $className = $this->controllerName;
        $fullPathPhpFileName = $this->basePath . DIRECTORY_SEPARATOR . $className .".php";
        $fullPathTplFileName = $this->basePath . DIRECTORY_SEPARATOR . $this->view->camelCaseToUnderscore($className) . ".html.tpl";
        $templateBasePath = str_replace("\\","/",$this->basePath);

        $this->view->buildSources($this->basePath,$templateBasePath,$className,$this->templateHTMLcode);
        $phpControllerSrc = $this->view->getPhpControllerSrc();
        $phpModelSrc = $this->view->getPhpModelSrc();
        $phpViewSrc = $this->view->getPhpViewSrc();
        $htmlTemplateSrc = empty($this->templateHTMLcode) ? $this->view->getHtmlTemplateSrc() : $this->templateHTMLcode;

        $controllerCreation = $this->model->createSourceFile(APP_CONTROLLERS_PATH,$fullPathPhpFileName, $phpControllerSrc);
        $modelCreation = $this->model->createSourceFile(APP_MODELS_PATH,$fullPathPhpFileName, $phpModelSrc);
        $viewCreation = $this->model->createSourceFile(APP_VIEWS_PATH,$fullPathPhpFileName, $phpViewSrc);
        $tempalteCreation = $this->model->createSourceFile(APP_TEMPLATES_PATH,$fullPathTplFileName, $htmlTemplateSrc);

        if ($controllerCreation && $modelCreation && $viewCreation && $tempalteCreation){
            unset($_SESSION["CurrentDesign"]);
            return true;
        } else {
            return false;
        }
    }

    private function printMe()
    {
        echo "Subsystem: " . $this->subsystemName ."<br>";
        echo "BasePath: "  . $this->basePath ."<br>";
        echo "ControlerName: " . $this->controllerName ."<br>";
        echo "Build translations : " . $this->buildTranslation ."<br>";
        echo "Tpl code :. " . $this->templateHTMLcode ."<br>";
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        echo "<pre>";
        print_r($_FILES);
        echo "</pre>";
        var_dump($_SESSION);
        var_dump($this->templateHTMLcode);
    }

    /**
     * Main form actions. Create classes skeleton
     */
    private function initPost()
    {
        if (isset($_POST["subsystem"]))
            $this->subsystemName = str_replace("\\\\","\\",$_POST["subsystem"]);
        if (isset($_POST["controller"]))
            $this->controllerName = $_POST["controller"];
        if (isset($_POST["translate"]))
            $this->buildTranslation = true;
        if (isset($_FILES["template"])) {
            $type = $_FILES["template"]["type"];
            if ($type == "application/x-tpl" || $type == "text/html" ){
                $this->templateHTMLcode = file_get_contents($_FILES["template"]["tmp_name"]);
                                                    // var_dump($this->templateHTMLcode);
            }
        }
        // $app_controller_path = str_replace(RELATIVE_PATH,"",APP_CONTROLLERS_PATH);
        $this->basePath = ltrim($this->subsystemName,APP_CONTROLLERS_PATH);
        $this->controllerName= $this->view->underscoreToCamelCase(str_replace(" ","_",trim($this->controllerName)));
    }

    /**
     * Initialize design
     */
    public function initDesign()
    {
        if (isset($_POST["design"])) {
            $currenDesign = stripslashes($_POST["design"]);
            $_SESSION["CurrentDesign"] = $currenDesign;
        } else if (isset($_SESSION["CurrentDesign"])){
            $currenDesign = $_SESSION["CurrentDesign"];
        } else {
            $currenDesign = null;
        }

        $this->view->setVar("Design", $currenDesign);
        $this->templateHTMLcode = is_null($currenDesign)? NULL : stripslashes($currenDesign);
        $designStatus = isset($_SESSION["CurrentDesign"])? "HTML": "Empty";
        $this->view->setDesignStatus($designStatus);
    }

    /**
     * Checks if subsystem is into Controllers root.
     *
     * @param string $subSystem
     * @return bool
     */
    private function isControllersSubDir($subSystem){
        $lenRoot = strlen(APP_CONTROLLERS_PATH);
        $subSystemRoot = substr($subSystem, 0, $lenRoot);
        if ($subSystemRoot == APP_CONTROLLERS_PATH){
            return true;
        } else {
            return false;
        }
    }

}