<?php
/**
 * Class HTMLFormatter
 * Simple HTML5 Class for formatting some HTML submitted input values.
 *
 * @package framework/classes
 * @filesource framework/classes/HTMLFormatter.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @note none
 * @see framework/Bean
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License.
 */
namespace framework\classes;

class HTMLFormatter
{
    /**
     * Converts a submitted HTML5 input type="datetime-local" to a MySQL compatible datetime
     * string.
     * Eg: (HTML) 2016-10-01T12:00 => (MySQL) 2016-10-01 12:00:00
     * The result is also stored to $_GET and $_POST with a key corresponding
     * to the input name.
     *
     * @param string $fieldDateTime The value of the HTML input type="datetime-local"
     * @return string The formatted value.
     */
    public static function dateTimeHTMLToDB($fieldDateTime)
    {
        $dateTime = "";
        if (isset($_REQUEST[$fieldDateTime])) {
            $dateTime = $_REQUEST[$fieldDateTime];
            $dateTime = str_replace("T", " ", $dateTime) . ":00";
            if (isset($_POST[$fieldDateTime]))
                $_POST[$fieldDateTime] = $dateTime;
            if (isset($_GET[$fieldDateTime]))
                $_GET[$fieldDateTime] = $dateTime;
        }
        return $dateTime;
    }

    /**
     * Converts a MySQL datatime string having "AAAA-MM-DD HH:MM:SS" format into HTML5
     * input type="datatime-local" having "AAAA-MM-DDTHH:MM" format.
     * Eg: (MySQL) 2016-10-01 12:00:00 => (HTML) 2016-10-01T12:00
     *
     * @param string $dateTime value fetched for MySQL db in the format "AAAA-MM-DD HH:MM:SS"
     * @return string The formatted value.
     */
    public static function dateTimeDBToHTML($dateTime)
    {
        return substr(str_replace(" ", "T", $dateTime), 0, -3);
    }
}