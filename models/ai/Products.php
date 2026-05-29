<?php
/**
 * Class Products
 *
 * WebMVC assembly model for browsing products.
 *
 * @package models\ai
 * @category Application Model
 */

namespace models\ai;

use framework\Model;

class Products extends Model
{
    /**
     * Builds a server-side DataTables response for product rows.
     *
     * @param array $request
     * @return array<string,mixed>
     */
    public function getProductsDataTableResponse(array $request)
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

        $recordsTotal = $this->getScalarValue('SELECT COUNT(*) AS total FROM product');
        $recordsFiltered = $recordsTotal;
        if ($whereClause !== '') {
            $recordsFiltered = $this->getScalarValue(
                'SELECT COUNT(*) AS total FROM product p LEFT JOIN category c ON c.category_id = p.category_id ' . $whereClause
            );
        }

        $sql = <<<SQL
        SELECT
            p.product_id,
            p.product_name,
            p.category_id,
            c.category_name,
            p.list_order
        FROM product p
        LEFT JOIN category c ON c.category_id = p.category_id
        {$whereClause}
        {$orderClause}
        LIMIT {$start}, {$length}
SQL;

        $result = $this->query($sql);
        $data = array();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = array(
                    'product_id' => (int)$row['product_id'],
                    'product_name' => $row['product_name'],
                    'category_id' => is_null($row['category_id']) ? null : (int)$row['category_id'],
                    'category_name' => is_null($row['category_name']) ? '' : $row['category_name'],
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
            0 => 'p.product_id',
            1 => 'p.product_name',
            2 => 'c.category_name',
            3 => 'p.list_order',
        );

        $columnIndex = 3;
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

        return 'ORDER BY ' . $columns[$columnIndex] . ' ' . $direction . ', p.product_name ASC, p.product_id ASC';
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
            "p.product_name LIKE '%{$escapedSearch}%'",
            "c.category_name LIKE '%{$escapedSearch}%'",
        );

        if ($numericSearch !== null) {
            $conditions[] = 'p.product_id = ' . $numericSearch;
            $conditions[] = 'p.category_id = ' . $numericSearch;
            $conditions[] = 'p.list_order = ' . $numericSearch;
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
}
