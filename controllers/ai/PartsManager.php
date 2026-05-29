<?php
/**
 * Class PartsManager
 *
 * PartsManager WebMVC assembly controller for listing parts.
 *
 * @package controllers\ai
 * @category Application Controller
 */

namespace controllers\ai;

use framework\Controller;
use framework\Model;
use framework\View;
use models\ai\PartsManager as PartsManagerModel;
use views\ai\PartsManager as PartsManagerView;

class PartsManager extends Controller
{
    protected $view;
    protected $model;

    /**
     * Object constructor.
     *
     * @param View|null $view
     * @param Model|null $model
     */
    public function __construct(?View $view = null, ?Model $model = null)
    {
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view, $this->model);
    }

    /**
     * Autorun method. Put your code here for running it after object creation.
     *
     * @param mixed|null $parameters Parameters to manage
     */
    protected function autorun($parameters = null)
    {
        /** @var PartsManagerView $view */
        $view = $this->view;
        $view->setAjaxDataUrl(SITEURL . '/ai/data_table/parts_manager');
    }

    /**
     * Initialize the View by loading static design of /ai/parts_manager.html.tpl
     * managed by views\ai\PartsManager class.
     *
     * @return PartsManagerView
     */
    public function getView()
    {
        $view = new PartsManagerView('/ai/parts_manager');
        return $view;
    }

    /**
     * Initialize the Model by loading models\ai\PartsManager class.
     *
     * @return PartsManagerModel
     */
    public function getModel()
    {
        $model = new PartsManagerModel();
        return $model;
    }
}