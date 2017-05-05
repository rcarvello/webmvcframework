<?php
/**
 * Class TemplateEditor
 *
 * {ControllerResponsability}
 *
 * @package controllers\builders
 * @category Application Controller
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace controllers\builders;

use framework\Controller;
use framework\Model;
use framework\View;
use models\builders\TemplateEditor as TemplateEditorModel;
use views\builders\TemplateEditor as TemplateEditorView;

class TemplateEditor extends Controller
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
        if ( isset($_SESSION["CurrentDesign"])){
            $currenDesign = stripslashes($_SESSION["CurrentDesign"]);
        } else {
            $currenDesign = file_get_contents(APP_TEMPLATES_PATH . "/builders/editor_default.html.tpl" );
        }
        $this->view->setVar("EditorDefaultHTML",htmlspecialchars($currenDesign,ENT_QUOTES));
    }

    /**
    * Inizialize the View by loading static design of /builders/template_editor.html.tpl
    * managed by views\builders\TemplateEditor class
    *
    */
    public function getView()
    {
        $view = new TemplateEditorView("/builders/template_editor");
        return $view;
    }

    /**
    * Inizialize the Model by loading models\builders\TemplateEditor class
    *
    */
    public function getModel()
    {
        $model = new TemplateEditorModel();
        return $model;
    }
}
