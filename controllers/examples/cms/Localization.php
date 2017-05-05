<?php
/**
 * Class Localization
 *
 * {ControllerResponsability}
 *
 * @package controllers\examples\cms
 * @category Application Controller
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace controllers\examples\cms;

use framework\classes\Locale;
use framework\Controller;
use framework\Model;
use framework\View;
use models\examples\cms\Localization as LocalizationModel;
use views\examples\cms\Localization as LocalizationView;

class Localization extends Controller
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
        $body = $this->model->getBody($_SESSION["CurrentLocale"]);
        $this->view->setVarBodyMessage($body);
    }

    /**
    * Inizialize the View by loading static design of /examples/cms/localization.html.tpl
    * managed by views\examples\cms\Localization class
    *
    */
    public function getView()
    {
        $view = new LocalizationView("/examples/cms/localization");
        return $view;
    }

    /**
    * Inizialize the Model by loading models\examples\cms\Localization class
    *
    */
    public function getModel()
    {
        $model = new LocalizationModel();
        return $model;
    }
}
