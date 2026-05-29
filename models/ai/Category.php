<?php
/**
 * Class Category
 *
 * WebMVC assembly model for listing categories.
 *
 * @package models\ai
 * @category Application Model
 */

namespace models\ai;

use framework\Model;

class Category extends Model
{
    /**
     * Gets the category list.
     *
     * @return \mysqli_result|bool
     */
    public function getCategories()
    {
        $this->sql = <<<SQL
        SELECT
            category_id,
            category_name,
            list_order
        FROM category
        ORDER BY list_order, category_name, category_id
SQL;

        $this->updateResultSet();
        return $this->getResultSet();
    }

    /**
     * Builds a server-side DataTables response for category rows.
     *
     * @param array $request
     * @return array<string,mixed>
     */
    public function getCategoriesDataTableResponse(array $request)
    {
        $draw = isset($request['draw']) ? (int)$request['draw'] : 0;
        $start = isset($request['start']) ? max(0, (int)$request['start']) : 0;
        $length = isset($request['length']) ? (int)$request['length'] : 25;
        $length = $length <= 0 ? 25 : $length;
        $search = '';

        if (isset($request['search']) && is_array($request['search']) && isset($request['search']['value'])) {
            $search = trim((string)$request['search']['value']);
        }

        $orderClause = $this->buildOrderClause($request);
        $whereClause = $this->buildWhereClause($search);

        $recordsTotal = $this->getScalarValue('SELECT COUNT(*) AS total FROM category');
        $recordsFiltered = $recordsTotal;
        if ($whereClause !== '') {
            $recordsFiltered = $this->getScalarValue('SELECT COUNT(*) AS total FROM category ' . $whereClause);
        }

        $sql = <<<SQL
        SELECT
            category_id,
            category_name,
            list_order
        FROM category
        {$whereClause}
        {$orderClause}
        LIMIT {$start}, {$length}
SQL;

        $result = $this->query($sql);
        $data = array();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = array(
                    'category_id' => (int)$row['category_id'],
                    'category_name' => $row['category_name'],
                    'list_order' => is_null($row['list_order']) ? null : (int)$row['list_order'],
                );
            }
        }

        return array(
            'draw' => $draw,
            'recordsTotal' => (int)$recordsTotal,
            'recordsFiltered' => (int)$recordsFiltered,
            'data' => $data,
        );
    }

    /**
     * Builds the ORDER BY clause for DataTables.
     *
     * @param array $request
     * @return string
     */
    private function buildOrderClause(array $request)
    {
        $columns = array(
            2 => 'category_id',
            3 => 'category_name',
            4 => 'list_order',
        );

        $columnIndex = 4;
        $direction = 'ASC';

        if (isset($request['order'][0]['column'])) {
            $requestedIndex = (int)$request['order'][0]['column'];
            if (isset($columns[$requestedIndex])) {
                $columnIndex = $requestedIndex;
            }
        }

        if (isset($request['order'][0]['dir']) && strtolower((string)$request['order'][0]['dir']) === 'desc') {
            $direction = 'DESC';
        }

        return 'ORDER BY ' . $columns[$columnIndex] . ' ' . $direction . ', category_name ASC, category_id ASC';
    }

    /**
     * Builds the WHERE clause for global search.
     *
     * @param string $search
     * @return string
     */
    private function buildWhereClause($search)
    {
        if ($search === '') {
            return '';
        }

        $escapedSearch = $this->real_escape_string($search);
        $numericSearch = is_numeric($search) ? (int)$search : null;

        $conditions = array(
            "category_name LIKE '%{$escapedSearch}%'",
        );

        if ($numericSearch !== null) {
            $conditions[] = 'category_id = ' . $numericSearch;
            $conditions[] = 'list_order = ' . $numericSearch;
        }

        return 'WHERE ' . implode(' OR ', $conditions);
    }

    /**
     * Returns the first column of the first row from a scalar query.
     *
     * @param string $sql
     * @return int
     */
    private function getScalarValue($sql)
    {
        $result = $this->query($sql);
        if (!$result) {
            return 0;
        }

        $row = $result->fetch_row();
        if (!$row) {
            return 0;
        }

        return (int)$row[0];
    }

    /**
     * Updates list_order values for a set of category rows.
     *
     * @param array $post
     * @return array<string,mixed>
     */
    public function updateCategoryListOrder(array $post)
    {
        $updates = (isset($post['updates']) && is_array($post['updates'])) ? $post['updates'] : array();

        foreach ($updates as $item) {
            $categoryId = (int)@$item['category_id'];
            $listOrder = (int)@$item['list_order'];

            if ($categoryId <= 0) {
                continue;
            }

            $this->query("UPDATE category SET list_order = {$listOrder} WHERE category_id = {$categoryId}");
        }

        return array('success' => true);
    }
}