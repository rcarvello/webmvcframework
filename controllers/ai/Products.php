<?php
/**
 * Class Products
 *
 * WebMVC assembly controller for browsing product rows via DataTable.
 *
 * @package controllers\ai
 * @category Application Controller
 */

namespace controllers\ai;

use framework\Controller;
use framework\Model;
use framework\View;
use controllers\examples\cms\NavigationBar;
use models\ai\Products as ProductsModel;
use views\ai\Products as ProductsView;

class Products extends Controller
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
        $navigation = new NavigationBar();
        $navigation->view->loadCustomTemplate('templates/ai/navigation_bar_bs5');
        $this->bindController($navigation);

        /** @var ProductsView $view */
        $view = $this->view;
        $view->setAjaxDataUrl(SITEURL . '/ai/data_table/products');
        $view->setProductFormBaseUrl(SITEURL . '/ai/product/open/');
    }

    /**
     * Initialize the view.
     *
     * @return ProductsView
     */
    public function getView()
    {
        $view = new ProductsView('/ai/products');
        return $view;
    }

    /**
     * Initialize the model.
     *
     * @return ProductsModel
     */
    public function getModel()
    {
        $model = new ProductsModel();
        return $model;
    }
}