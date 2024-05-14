<?php
/**
 * CSVExporter.
 * Exports \mysqli_result to CSV
 *
 * @package framework/classes
 * @filesource framework/classes/CSVExporter.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2024 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

namespace framework\classes;

class CSVExporter
{

    /**
     * @param \mysqli_result|null $result The given mysqli_result to export as CSV
     */
    public function __construct(\mysqli_result $result = null)
    {
        if (!$result)
            return false;
        $headers = $result->fetch_fields();
        foreach ($headers as $header) {
            $head[] = $header->name;
        }
        $fp = fopen('php://output', 'w');

        if ($fp && $result) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="csv_export.csv"');
            header('Pragma: no-cache');
            header('Expires: 0');
            fputcsv($fp, array_values($head));
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                fputcsv($fp, array_values($row));
            }
            die;
        }
    }
}