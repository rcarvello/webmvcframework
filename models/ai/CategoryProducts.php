<?php
/**
 * Class CategoryProducts
 *
 * WebMVC assembly model for category master-detail editing.
 *
 * @package models\ai
 * @category Application Model
 */

namespace models\ai;

use framework\Model;
use models\beans\BeanCategory;
use models\beans\BeanProduct;

class CategoryProducts extends Model
{
    /**
     * Gets a category bean by primary key.
     *
     * @param int $categoryId
     * @return BeanCategory|null
     */
    public function getCategoryById($categoryId)
    {
        $bean = new BeanCategory();
        $bean->select((int)$categoryId);

        if ((int)$bean->getCategoryId() <= 0) {
            return null;
        }

        return $bean;
    }

    /**
     * Gets products for a category.
     *
     * @param int $categoryId
     * @return array<int,array<string,mixed>>
     */
    public function getProductsByCategoryId($categoryId)
    {
        $categoryId = (int)$categoryId;

        $sql = <<<SQL
        SELECT
            product_id,
            product_name,
            list_order
        FROM product
        WHERE category_id = {$categoryId}
        ORDER BY list_order, product_name, product_id
SQL;

        $result = $this->query($sql);
        $products = array();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = array(
                    'product_id' => (int)$row['product_id'],
                    'product_name' => $row['product_name'],
                    'list_order' => (int)$row['list_order'],
                );
            }
        }

        return $products;
    }

    /**
     * Saves the category and its product details with custom SQL.
     *
     * @param int $categoryId
     * @param array $post
     * @return array<int,string>
     */
    public function saveCategoryWithProducts($categoryId, array $post)
    {
        $errors = array();
        $categoryId = (int)$categoryId;

        $categoryBean = $this->getCategoryById($categoryId);
        if ($categoryBean === null) {
            $errors[] = 'Categoria non trovata.';
            return $errors;
        }

        $categoryName = trim((string)@($post['category_name']));
        $categoryListOrderRaw = trim((string)@($post['list_order']));

        if ($categoryName === '') {
            $errors[] = 'Il nome categoria e obbligatorio.';
        }

        $categoryBean->setCategoryName($categoryName);
        $categoryBean->setListOrder($categoryListOrderRaw === '' ? 0 : (int)$categoryListOrderRaw);

        $normalizedProducts = $this->normalizePostedProducts($post, $categoryId, $errors);

        if (!empty($errors)) {
            return $errors;
        }

        try {
            $this->query('START TRANSACTION');

            $escapedCategoryName = $this->real_escape_string($categoryBean->getCategoryName());
            $categoryListOrder = (int)$categoryBean->getListOrder();

            $this->query(
                "UPDATE category SET category_name = '{$escapedCategoryName}', list_order = {$categoryListOrder} WHERE category_id = {$categoryId}"
            );

            $existingProductIds = array();


            foreach ($normalizedProducts as $productBean) {
                $productId = (int)$productBean->getProductId();
                $productName = $this->real_escape_string($productBean->getProductName());
                $productListOrder = (int)$productBean->getListOrder();

                if ($productId > 0) {
                    error_log('[saveCategoryWithProducts] Preparing to update product ID ' . $productId . ': ' . $productName);
                    $existingProductIds[] = $productId;
                    $this->query(
                        "UPDATE product SET product_name = '{$productName}', list_order = {$productListOrder}, category_id = {$categoryId} " .
                        "WHERE product_id = {$productId} AND category_id = {$categoryId}"
                    );
                } else {
                    error_log('[saveCategoryWithProducts] Preparing to insert new product: ' . $productName);
                    $insertSql = "INSERT INTO product (product_name, category_id, list_order) VALUES ('{$productName}', {$categoryId}, {$productListOrder})";
                    // Log current database
                    $dbName = '';
                    try {
                        $dbRes = $this->query('SELECT DATABASE()');
                        if ($dbRes && $row = $dbRes->fetch_row()) {
                            $dbName = $row[0];
                        }
                    } catch (\Exception $e) {
                        $dbName = 'ERROR: ' . $e->getMessage();
                    }
                    error_log('[saveCategoryWithProducts] DB: ' . $dbName);
                    error_log('[saveCategoryWithProducts] INSERT: ' . $insertSql);
                    try {
                        $res = $this->query($insertSql);
                        $last_id = $this->insert_id;
                        $existingProductIds[] = $last_id;
                        error_log('[saveCategoryWithProducts] Insert result: ' . ($res ? 'OK' : 'FAIL') . ', affected rows: ' . $this->affected_rows);

                    } catch (\mysqli_sql_exception $e) {
                        error_log('[saveCategoryWithProducts] SQL ERROR: ' . $e->getMessage());
                        $errors[] = $e->getMessage();
                    } catch (\Exception $e) {
                        error_log('[saveCategoryWithProducts] ERROR: ' . $e->getMessage());
                        $errors[] = $e->getMessage();
                    }
                }
            }

            if (!empty($existingProductIds)) {
                error_log('[saveCategoryWithProducts] Existing product IDs: ' . implode(', ', $existingProductIds));
                $idList = implode(',', array_map('intval', $existingProductIds));
                $this->query("DELETE FROM product WHERE category_id = {$categoryId} AND product_id NOT IN ({$idList})");
            } else {
                error_log('[saveCategoryWithProducts] No existing products, deleting all for category ID ' . $categoryId);
                $this->query("DELETE FROM product WHERE category_id = {$categoryId}");
            }

            $this->query('COMMIT');
            error_log('[saveCategoryWithProducts] COMMIT OK');
        } catch (\mysqli_sql_exception $e) {
            $this->query('ROLLBACK');
            error_log('[saveCategoryWithProducts] ROLLBACK: ' . $e->getMessage());
            $errors[] = $e->getMessage();
        } catch (\Exception $e) {
            $this->query('ROLLBACK');
            error_log('[saveCategoryWithProducts] ROLLBACK: ' . $e->getMessage());
            $errors[] = $e->getMessage();
        }

        return $errors;
    }

    /**
     * Normalizes product rows posted from the detail table.
     *
     * @param array $post
     * @param int $categoryId
     * @param array<int,string> $errors
     * @return array<int,BeanProduct>
     */
    private function normalizePostedProducts(array $post, $categoryId, array &$errors)
    {
        // DEBUG: log input arrays
        error_log('[normalizePostedProducts] product_id: ' . json_encode($post['product_id'] ?? null));
        error_log('[normalizePostedProducts] product_name: ' . json_encode($post['product_name'] ?? null));
        error_log('[normalizePostedProducts] product_list_order: ' . json_encode($post['product_list_order'] ?? null));

        $ids = (isset($post['product_id']) && is_array($post['product_id'])) ? $post['product_id'] : array();
        $names = (isset($post['product_name']) && is_array($post['product_name'])) ? $post['product_name'] : array();
        $orders = (isset($post['product_list_order']) && is_array($post['product_list_order'])) ? $post['product_list_order'] : array();

        $rowsCount = max(count($ids), count($names), count($orders));
        $products = array();

        for ($i = 0; $i < $rowsCount; $i++) {
            $idRaw = isset($ids[$i]) ? trim((string)$ids[$i]) : '';
            $nameRaw = isset($names[$i]) ? trim((string)$names[$i]) : '';
            $orderRaw = isset($orders[$i]) ? trim((string)$orders[$i]) : '';

            if ($idRaw === '' && $nameRaw === '' && $orderRaw === '') {
                continue;
            }

            if ($nameRaw === '') {
                $errors[] = 'Il nome prodotto e obbligatorio per ogni riga.';
                continue;
            }

            $productBean = new BeanProduct();
            $productBean->setProductId($idRaw === '' ? 0 : (int)$idRaw);
            $productBean->setProductName($nameRaw);
            $productBean->setCategoryId((int)$categoryId);
            $productBean->setListOrder($orderRaw === '' ? 0 : (int)$orderRaw);

            $products[] = $productBean;
        }

        // DEBUG: log normalized products
        $debugProducts = array();
        foreach ($products as $bean) {
            $debugProducts[] = [
                'product_id' => $bean->getProductId(),
                'product_name' => $bean->getProductName(),
                'category_id' => $bean->getCategoryId(),
                'list_order' => $bean->getListOrder(),
            ];
        }
        error_log('[normalizePostedProducts] normalized: ' . json_encode($debugProducts));

        return $products;
    }
}
