<?php
/**
 * Class CustomersManager
 *
 * {ControllerResponsability}
 *
 * @package controllers
 * @category Application Controller
 * @author  {AuthorName} - {AuthorEmail}
 */

namespace controllers\wiki;

use framework\Controller;
use framework\Model;
use framework\View;
use models\wiki\CustomersManager as CustomersManagerModel;
use views\wiki\CustomersManager as CustomersManagerView;

class CustomersManager extends Controller
{
    protected $view;
    protected $model;

    /**
     * Object constructor.
     *
     * @param View $view
     * @param Model $mode
     */
    public function __construct(View $view = null, Model $model = null)
    {
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view, $this->model);
    }

    /**
     * Autorun method. Put your code here for running it after object creation.
     * @param mixed|null $parameters Parameters to manage
     *
     */
    protected function autorun($parameters = null)
    {
        $customers = $this->model->getCustomers();
        $this->view->setCustomersBlock($customers);
    }

    /**
     * Inizialize the View by loading static design of /customers_manager.html.tpl
     * managed by views\CustomersManager class
     *
     */
    public function getView()
    {
        $view = new CustomersManagerView("wiki/customers_manager");
        return $view;
    }

    /**
     * Inizialize the Model by loading models\CustomersManager class
     *
     */
    public function getModel()
    {
        $model = new CustomersManagerModel();
        return $model;
    }
}
