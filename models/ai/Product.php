<?php
/**
 * Class Product
 *
 * WebMVC assembly model for editing product records.
 *
 * @package models\ai
 * @category Application Model
 */

namespace models\ai;

use framework\Model;
use framework\components\DataRepeater;
use models\beans\BeanProduct;
use views\ai\Product as ProductView;

class Product extends Model
{
    /**
     * Builds select list values for category_id.
     *
     * @param ProductView $view
     */
    public function makeCategoryList(ProductView $view)
    {
        $categoryList = new Model();
        $categoryList->sql = 'SELECT category_id, category_name FROM category ORDER BY category_name, category_id';
        $categoryList->updateResultSet();
        $list = new DataRepeater($view, $categoryList, 'CategoryOptions', null);
        $list->render();
    }

    /**
     * Updates the bean with posted form data.
     *
     * @param BeanProduct $bean
     */
    public function setBeanWithPostedData(BeanProduct $bean)
    {
        if (isset($_POST['product_id']) && $_POST['product_id'] !== '') {
            $bean->setProductId($_POST['product_id']);
        }

        $bean->setProductName(@$_POST['product_name']);

        if (isset($_POST['category_id']) && $_POST['category_id'] !== '') {
            $bean->setCategoryId($_POST['category_id']);
        } else {
            $bean->setCategoryId(null);
        }

        $bean->setListOrder(@$_POST['list_order']);
    }
}
