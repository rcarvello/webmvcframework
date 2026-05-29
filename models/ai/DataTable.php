<?php
/**
 * Class DataTable
 *
 * Model used by the AI DataTable REST service.
 *
 * @package models\ai
 * @category Application Model
 */

namespace models\ai;

use framework\Model;

class DataTable extends Model
{
    /**
     * Gets the DataTables response for category.
     *
     * @param array $request
     * @return array<string,mixed>
     */
    public function getCategoryDataTableResponse(array $request)
    {
        $model = new Category();
        return $model->getCategoriesDataTableResponse($request);
    }

    /**
     * Gets the DataTables response for products.
     *
     * @param array $request
     * @return array<string,mixed>
     */
    public function getProductsDataTableResponse(array $request)
    {
        $model = new Products();
        return $model->getProductsDataTableResponse($request);
    }

    /**
     * Gets the DataTables response for parts_manager/part.
     *
     * @param array $request
     * @return array<string,mixed>
     */
    public function getPartsManagerDataTableResponse(array $request)
    {
        $model = new PartsManager();
        return $model->getPartsManagerDataTableResponse($request);
    }

    /**
     * Saves the category list order.
     *
     * @param array $post
     * @return array<string,mixed>
     */
    public function saveCategoryListOrder(array $post)
    {
        $model = new Category();
        return $model->updateCategoryListOrder($post);
    }
}