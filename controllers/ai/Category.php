<?php
/**
 * Class Category
 *
 * WebMVC assembly controller for listing categories.
 *
 * @package controllers\ai
 * @category Application Controller
 */

namespace controllers\ai;

use framework\Controller;
use framework\Model;
use framework\View;
use models\ai\Category as CategoryModel;
use views\ai\Category as CategoryView;

class Category extends Controller
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
     * Autorun method.
     *
     * @param mixed|null $parameters Parameters to manage
     */
    protected function autorun($parameters = null)
    {
        /** @var CategoryView $view */
        $view = $this->view;
        $view->setAjaxDataUrl(SITEURL . '/ai/data_table/category');
        $view->setCategoryFormBaseUrl(SITEURL . '/ai/category_form/open/');
        $view->setCategoryProductsBaseUrl(SITEURL . '/ai/category_products/open/');
        $view->setCategoryOrderUrl(SITEURL . '/ai/data_table/category_order');
    }

    /**
     * Initialize the view.
     *
     * @return CategoryView
     */
    public function getView()
    {
        $view = new CategoryView('/ai/category');
        return $view;
    }

    /**
     * Initialize the model.
     *
     * @return CategoryModel
     */
    public function getModel()
    {
        $model = new CategoryModel();
        return $model;
    }
}