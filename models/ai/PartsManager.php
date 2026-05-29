<?php
/**
 * Class PartsManager
 *
 * PartsManager WebMVC assembly model for listing parts.
 *
 * @package models\ai
 * @category Application Model
 */

namespace models\ai;

use framework\Model;

class PartsManager extends Model
{
    /**
     * Gets the list of parts.
     *
     * @return \mysqli_result|bool
     */
    public function getParts()
    {
        $this->sql = <<<SQL
        SELECT
            part_code,
            description,
            source,
            source_lead_time,
            measurement_unit_code,
            part_type_code,
            part_category_code,
            wastage,
            bom_levels
        FROM part
        ORDER BY part_code
SQL;

        $this->updateResultSet();
        return $this->getResultSet();
    }

    /**
     * Builds a server-side DataTables response for part rows.
     *
     * @param array $request
     * @return array<string,mixed>
     */
    public function getPartsManagerDataTableResponse(array $request)
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

        $recordsTotal = $this->getScalarValue('SELECT COUNT(*) AS total FROM part');
        $recordsFiltered = $recordsTotal;
        if ($whereClause !== '') {
            $recordsFiltered = $this->getScalarValue('SELECT COUNT(*) AS total FROM part ' . $whereClause);
        }

        $sql = <<<SQL
        SELECT
            part_code,
            description,
            source,
            source_lead_time,
            measurement_unit_code,
            part_type_code,
            part_category_code,
            wastage,
            bom_levels
        FROM part
        {$whereClause}
        {$orderClause}
        LIMIT {$start}, {$length}
SQL;

        $result = $this->query($sql);
        $data = array();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = array(
                    'part_code' => $row['part_code'],
                    'description' => $row['description'],
                    'source' => $row['source'],
                    'source_lead_time' => is_null($row['source_lead_time']) ? null : (int)$row['source_lead_time'],
                    'measurement_unit_code' => $row['measurement_unit_code'],
                    'part_type_code' => $row['part_type_code'],
                    'part_category_code' => $row['part_category_code'],
                    'wastage' => is_null($row['wastage']) ? null : (float)$row['wastage'],
                    'bom_levels' => is_null($row['bom_levels']) ? null : (int)$row['bom_levels'],
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
            0 => 'part_code',
            1 => 'description',
            2 => 'source',
            3 => 'source_lead_time',
            4 => 'measurement_unit_code',
            5 => 'part_type_code',
            6 => 'part_category_code',
            7 => 'wastage',
            8 => 'bom_levels',
        );

        $columnIndex = 0;
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

        return 'ORDER BY ' . $columns[$columnIndex] . ' ' . $direction . ', part_code ASC';
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
        $numericSearch = is_numeric($search) ? $search + 0 : null;

        $conditions = array(
            "part_code LIKE '%{$escapedSearch}%'",
            "description LIKE '%{$escapedSearch}%'",
            "source LIKE '%{$escapedSearch}%'",
            "measurement_unit_code LIKE '%{$escapedSearch}%'",
            "part_type_code LIKE '%{$escapedSearch}%'",
            "part_category_code LIKE '%{$escapedSearch}%'",
        );

        if ($numericSearch !== null) {
            $conditions[] = 'source_lead_time = ' . (int)$numericSearch;
            $conditions[] = 'wastage = ' . (float)$numericSearch;
            $conditions[] = 'bom_levels = ' . (int)$numericSearch;
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