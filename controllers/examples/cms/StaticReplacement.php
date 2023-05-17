<?php
/**
 * Class StaticReplacement
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
use models\examples\cms\StaticReplacement as StaticReplacementModel;
use views\examples\cms\StaticReplacement as StaticReplacementView;

class StaticReplacement extends Controller
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
    * Inizialize the View by loading static design of /examples/cms/static_replacement.html.tpl
    * managed by views\examples\cms\StaticReplacement class
    *
    */
    public function getView()
    {
        $view = new StaticReplacementView("/examples/cms/static_replacement");
        return $view;
    }

    /**
    * Inizialize the Model by loading models\examples\cms\StaticReplacement class
    *
    */
    public function getModel()
    {
        $model = new StaticReplacementModel();
        return $model;
    }
}
