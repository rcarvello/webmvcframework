<?php

namespace views\builders;
include_once(RELATIVE_PATH . "util/templatereflection/TemplateReflection.php");

use framework\View;
use TemplateReflection;


class SkeletonBuider extends View
{
    private $phpControllerSrc;
    private $phpModelSrc;
    private $phpViewSrc;
    private $htmlTemplateSrc;


    /**
     * Get the controller skeleton source code.
     * @return string
     */
    public function getPhpControllerSrc()
    {
        return $this->phpControllerSrc;
    }

    /**
     * Gets the model skeleton source code.
     *
     * @return string
     */
    public function getPhpModelSrc()
    {
        return $this->phpModelSrc;
    }

    /**
     * Gets the view skeleton source code.
     *
     *
     * @return string
     */
    public function getPhpViewSrc()
    {
        return $this->phpViewSrc;
    }

    /**
     * Gets the template skeleton source code.
     *
     * @return string
     */
    public function getHtmlTemplateSrc()
    {
        return $this->htmlTemplateSrc;
    }


    public function __construct($tplName= null)
    {
        parent::__construct("builders/skeleton_builder");
    }

    /**
     * Set message for information dialog.
     *
     * @param null|string  $message
     * @param bool $danger Tru if error message
     */
    public function setInfoMessage($message=null, $danger=false)
    {
        if (empty($message)) {
            $this->hide("ActionMessage");
        } else {
            $this->setVar("Message",$message);
            $alertType  = ($danger == true) ? "danger" : "success";
            $this->setVar("AlertType", $alertType);
        }
    }

    public function setDesignStatus($statusMessage)
    {
        $this->setVar("DesignStatus",$statusMessage);

    }
    /**
     *  Builds skeletons sources
     * @param string $basePath
     * @param string $className
     * @param string $templateBasePath
     */
    public function buildSources($basePath,$templateBasePath,$className,$TemplateSrc=null){

        $view = new View("builders/classes_template");
        $view->setVar("controllers",APP_CONTROLLERS_PATH);
        $view->setVar("models",APP_MODELS_PATH);
        $view->setVar("views",APP_VIEWS_PATH);
        $view->setVar("namespace",$basePath);
        $view->setVar("classname",$className);
        $view->setVar("template_path",$templateBasePath);
        $view->setVar("template_file",$this->camelCaseToUnderscore($className));

        $view->openBlock("Controller");
        $this->phpControllerSrc = $view->parseCurrentBlock();

        $view->openBlock("Model");
        $this->phpModelSrc = $view->parseCurrentBlock();

        $view->openBlock("View");
        $this->phpViewSrc = $view->parseCurrentBlock();

        $view->openBlock("Template");
        $this->htmlTemplateSrc = empty($TemplateSrc) ? $view->parseCurrentBlock() : $TemplateSrc;

        $view->openBlock("FUNCTION_OPEN_BLOCK");
        $tplFunctionOpenBlock = $view->parseCurrentBlock();

        $view->openBlock("FUNCTION_SET_VAR");
        $tplFunctionSetVar = $view->parseCurrentBlock();

        $view->openBlock("FUNCTION_SET_BLOCK_VAR");
        $tplFunctionSetBlockVar = $view->parseCurrentBlock();

        $tplReflection = new TemplateReflection($this->htmlTemplateSrc,true);

        $tplBlocks = $tplReflection->getBlocks();

        $renderedTplFunctionOpenBlock = "";
        $renderedTplFunctionSetVar = "";
        $renderedTplFunctionSetBlockVar = "";

        foreach ($tplBlocks as $tplBlock){
            $blockName = $tplBlock["name"];

            if ($blockName != "Main") {
                $renderedTplFunctionOpenBlock  = $renderedTplFunctionOpenBlock . $tplFunctionOpenBlock;
                $renderedTplFunctionOpenBlock  = str_replace("{BLOCK}",$blockName,$renderedTplFunctionOpenBlock);
            }
            foreach ($tplBlock["placeHolders"] as $placeHolder){
                if ($blockName != "Main"){
                    $renderedTplFunctionSetBlockVar  = $renderedTplFunctionSetBlockVar . $tplFunctionSetBlockVar;
                    $renderedTplFunctionSetBlockVar  = str_replace("{BLOCK}",$blockName,$renderedTplFunctionSetBlockVar);
                    $renderedTplFunctionSetBlockVar  = str_replace("{PLACEHOLDER}",$placeHolder,$renderedTplFunctionSetBlockVar);
                } else {
                    $renderedTplFunctionSetVar  = $renderedTplFunctionSetVar .$tplFunctionSetVar;
                    $renderedTplFunctionSetVar  = str_replace("{BLOCK}",$blockName,$renderedTplFunctionSetVar);
                    $renderedTplFunctionSetVar  = str_replace("{PLACEHOLDER}",$placeHolder,$renderedTplFunctionSetVar);
                }
            }
        }

        $allRenderedFunctionsSrc = $renderedTplFunctionSetVar . $renderedTplFunctionOpenBlock . $renderedTplFunctionSetBlockVar;
        $this->phpViewSrc = str_replace("{views_functions}",$allRenderedFunctionsSrc, $this->phpViewSrc);
    }


    /**
     * Converts underscored strings into Pascal/Camel Case.
     * @param $string
     * @param bool $pascalCase. Default true. If false use CamelCase
     * @return mixed
     */
    public function underscoreToCamelCase($string, $pascalCase = true)
    {
        if( $pascalCase == true ) {
            $string[0] = strtoupper($string[0]);
        }
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/_([a-z])/', $func, $string);
    }

    /**
     * Convert camelCase/PascalCase to under_score notation.
     *
     * @param string $string The string to convert
     * @return string
     */
    public function camelCaseToUnderscore($string)
    {
        $string = lcfirst($string);
        return strtolower(preg_replace('/([A-Z]+)/', "_$1", $string));
    }

}