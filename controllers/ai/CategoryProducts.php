<?php
/**
 * Class CategoryProducts
 *
 * WebMVC assembly controller for editing categories with product details.
 *
 * @package controllers\ai
 * @category Application Controller
 */

namespace controllers\ai;

use framework\Controller;
use framework\Model;
use framework\View;
use models\ai\CategoryProducts as CategoryProductsModel;
use views\ai\CategoryProducts as CategoryProductsView;

/**
 * @property CategoryProductsModel $model
 * @property CategoryProductsView $view
 */
class CategoryProducts extends Controller
{
    /** @var CategoryProductsView */
    protected $view;
    /** @var CategoryProductsModel */
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
     * @return bool
     */
    protected function autorun($parameters = null)
    {
        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
        if ($categoryId <= 0) {
            header('location:' . SITEURL . '/ai/category');
            return false;
        }

        $errors = array();

        if (isset($_POST['operation_save'])) {
            $errors = $this->model->saveCategoryWithProducts($categoryId, $_POST);
            if (empty($errors)) {
                header('location:' . SITEURL . '/ai/category_products/open/' . $categoryId);
                return false;
            }
        }

        $category = $this->model->getCategoryById($categoryId);
        if ($category === null) {
            header('location:' . SITEURL . '/ai/category');
            return false;
        }

        $products = $this->model->getProductsByCategoryId($categoryId);

        $this->view->setCategoryAndProducts($category, $products, $_POST);
        if (empty($errors)) {
            $this->view->hide('ValidationErrors');
        } else {
            $this->view->parseErrors($errors);
        }

        return true;
    }

    /**
     * Opens the category/products form for an existing category.
     *
     * @param int|string $pk
     */
    public function open($pk)
    {
        $_GET['category_id'] = $pk;
        if ($this->autorun()) {
            $this->render();
        }
    }

    /**
     * Initialize the view.
     *
     * @return CategoryProductsView
     */
    public function getView()
    {
        $view = new CategoryProductsView('/ai/category_products');
        return $view;
    }

    /**
     * Initialize the model.
     *
     * @return CategoryProductsModel
     */
    public function getModel()
    {
        $model = new CategoryProductsModel();
        return $model;
    }
}
