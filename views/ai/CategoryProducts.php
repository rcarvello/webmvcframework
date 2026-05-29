<?php
/**
 * Class CategoryProducts
 *
 * WebMVC assembly view for category master-detail editing.
 *
 * @package views\ai
 * @category Application View
 */

namespace views\ai;

use framework\View;
use models\beans\BeanCategory;

class CategoryProducts extends View
{
    /**
     * Object constructor.
     *
     * @param string|null $tplName The html template containing the static design.
     */
    public function __construct($tplName = null)
    {
        if (empty($tplName)) {
            $tplName = '/ai/category_products';
        }

        parent::__construct($tplName);
    }

    /**
     * Sets category and products form data.
     *
     * @param BeanCategory $category
     * @param array<int,array<string,mixed>> $products
     * @param array $post
     */
    public function setCategoryAndProducts(BeanCategory $category, array $products, array $post = array())
    {
        $categoryId = isset($post['category_id']) ? (int)$post['category_id'] : (int)$category->getCategoryId();
        $categoryName = isset($post['category_name']) ? (string)$post['category_name'] : (string)$category->getCategoryName();
        $listOrder = isset($post['list_order']) ? (string)$post['list_order'] : (string)$category->getListOrder();

        $this->setVar('FormTitle', 'Category Products: ' . $categoryName);
        $this->setVar('category_id', $categoryId);
        $this->setVar('category_name', $categoryName);
        $this->setVar('list_order', $listOrder);
        $this->setVar('BackUrl', SITEURL . '/ai/category');

        $postedRows = $this->buildPostedRows($post);
        $rows = !empty($postedRows) ? $postedRows : $products;

        if (empty($rows)) {
            $this->hide('ProductsRows');
            return;
        }

        $this->openBlock('ProductsRows');
        foreach ($rows as $row) {
            $this->setVar('product_id', isset($row['product_id']) ? (int)$row['product_id'] : 0);
            $this->setVar('product_name', isset($row['product_name']) ? (string)$row['product_name'] : '');
            $this->setVar('product_list_order', isset($row['list_order']) ? (int)$row['list_order'] : 0);
            $this->parseCurrentBlock();
        }
        $this->setBlock();
    }

    /**
     * Builds detail rows from posted arrays.
     *
     * @param array $post
     * @return array<int,array<string,mixed>>
     */
    private function buildPostedRows(array $post)
    {
        $ids = (isset($post['product_id']) && is_array($post['product_id'])) ? $post['product_id'] : array();
        $names = (isset($post['product_name']) && is_array($post['product_name'])) ? $post['product_name'] : array();
        $orders = (isset($post['product_list_order']) && is_array($post['product_list_order'])) ? $post['product_list_order'] : array();

        $rowsCount = max(count($ids), count($names), count($orders));
        $rows = array();

        for ($i = 0; $i < $rowsCount; $i++) {
            $rows[] = array(
                'product_id' => isset($ids[$i]) && $ids[$i] !== '' ? (int)$ids[$i] : 0,
                'product_name' => isset($names[$i]) ? (string)$names[$i] : '',
                'list_order' => isset($orders[$i]) && $orders[$i] !== '' ? (int)$orders[$i] : 0,
            );
        }

        return $rows;
    }
}
