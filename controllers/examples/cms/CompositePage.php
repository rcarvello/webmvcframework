<?php
/**
 * Class CompositePage
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
use models\examples\cms\CompositePage as CompositePageModel;
use views\examples\cms\CompositePage as CompositePageView;
use controllers\examples\cms\NavigationBar;

class CompositePage extends Controller
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
        $navigation = new NavigationBar();
        $this->bindController($navigation);
    }

    /**
    * Inizialize the View by loading static design of /examples/cms/composite_page.html.tpl
    * managed by views\examples\cms\CompositePage class
    *
    */
    public function getView()
    {
        $view = new CompositePageView("/examples/cms/composite_page");
        return $view;
    }

    /**
    * Inizialize the Model by loading models\examples\cms\CompositePage class
    *
    */
    public function getModel()
    {
        $model = new CompositePageModel();
        return $model;
    }
}
