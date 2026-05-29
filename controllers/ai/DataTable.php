<?php
/**
 * Class DataTable
 *
 * REST service for AI DataTables served over POST.
 *
 * @package controllers\ai
 * @category Application Controller
 */

namespace controllers\ai;

use framework\RestService;
use models\ai\DataTable as DataTableModel;

class DataTable extends RestService
{
    /**
     * Object constructor.
     */
    public function __construct()
    {
        parent::__construct(null, new DataTableModel());
        $this->allowMethod('category');
        $this->allowMethod('products');
        $this->allowMethod('parts_manager');
        $this->allowMethod('partsManager'); // Supporta anche camelCase per compatibilità router
        $this->allowMethod('category_order');
        $this->allowMethod('categoryOrder'); // Supporta anche camelCase per compatibilità router
    }

    /**
     * Handles POST requests for DataTables payloads.
     *
     * @param string $method
     * @param array $args
     * @return array
     */
    public function httpPostRequest($method, $args)
    {
        /** @var DataTableModel $model */
        $model = $this->model;

        switch ($method) {
            case 'category':
                return $model->getCategoryDataTableResponse($_POST);
            case 'products':
                return $model->getProductsDataTableResponse($_POST);
            case 'parts_manager':
            case 'partsManager':
                return $model->getPartsManagerDataTableResponse($_POST);
            case 'category_order':
            case 'categoryOrder':
                return $model->saveCategoryListOrder($_POST);
            default:
                return array(
                    'draw' => isset($_POST['draw']) ? (int)$_POST['draw'] : 0,
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => array(),
                    'error' => 'Unsupported DataTable method'
                );
        }
    }
}