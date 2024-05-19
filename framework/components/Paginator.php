<?php

/**
 * Class Paginator
 * Generates pagination from a database result set
 * *
 * @package framework
 * @filesource framework/Paginator.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.1
 * @note none
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework\components;

use framework\exceptions\TemplateNotFoundException;
use framework\Model;
use framework\View;

class Paginator extends Component
{

    private $fullResult;         // MySQL result from query
    private $totalResult;        // Total number of rows
    private $resultPage;     // MySQL Result from each page
    private $pages;         // Total number of pages from (totalResult/resulPerPge)
    private $openPage = 1;       // Currently opened page

    /**
     * @var string The SQL query to paginate
     */
    public $query;

    /**
     * @var int The size (in rows) of a page. Default=10
     */
    public $resultPerPage = 10;  // Total records of rows each pages

    /**
     * @var string GUI Caption/String for First button/link. Default = "First"
     */
    public $first = "First";

    /**
     * @var string GUI Caption/String for Previous button/link. Default = "Prev."
     */
    public $previous = "Prev.";

    /**
     * @var string Caption/String for Next button/link. Default = "Next"
     */
    public $next = "Next";

    /**
     * @var string GUI Caption/String for Last button/link. Default = "Last"
     */
    public $last = "Last";

    /**
     * @var string|null Value to apply for setting to hide or disable First,Previous,Next and Last into template.
     */
    public $offValue = "";

    /**
     * @var bool Mode: hide (default) or disable First,Previous,Next and Last into template.
     */
    public $offModeHidden = true;


    /**
     * @var bool Default true=On. On/Off presentation for GUI pages links/selection
     */
    public $showPagesLinks = true;

    /**
     * @var bool Default true=On. On/Off presentation for the current page
     */
    public $showActivePage = true;

    /**
     * @var bool Default true=On. On/Off presentation for total record
     */
    public $showTotalRecord = true;

    /**
     * @var string Default="disabled". GUI string to use for deactivation purpose of current page.
     *
     * You can use this value into your custom html to deactivate selection
     * of the current active pages (eg. class="disabled" or class="active").
     *
     */
    public $activeFlag = "disabled";

    /**
     * @var string Default=null. GUI string to use for the activation/selection purpose of pages.
     *
     * You can use this value into your custom html to activate selection
     * of a page.
     */
    public $notActiveFlag = "";

    /**
     * @var string Default="page". Url parameter name for paging
     */
    public $urlPageParameterName = "page";

    /**
     * @var int The max number of pagination links.
     */
    public $paginationSize = 10;

    /**
     * Constructs paginator object.
     *
     * @param View|null $view The component view. If null use its basic view
     * @param Model|null $model The component view. If null use a new model instance
     * @throws TemplateNotFoundException
     */
    public function __construct(View $view = null, Model $model = null)
    {
        if ($view == null) {
            $tpl = "framework/resources/components/paginator";
            $view = new View();
            $view->loadCustomTemplate($tpl);
        }
        parent::__construct($view, $model);

        // mysqli_query("SET SESSION sql_mode = 'TRADITIONAL'");
        $this->autorun();

    }

    /**
     * Build the pagination.
     *
     * @param string|null  The sql query to paginate. If null use the model SQL property.
     */
    public function buildPagination($query = null)
    {
        !empty($query) ? $this->query = $query : $this->query = $this->model->sql;

        if (!MYSQL_MODE_FULL_GROUP_BY) {
            // Add limit 0,0 for obtaing all records, Then counting
            $addLimit = " LIMIT,0,0";
        } else {
            // Used in  MySQL num_rows
            $addLimit = "";
        }

        $urlPageParameterName = $this->urlPageParameterName;
        $this->fullResult = $this->model->query($this->query . $addLimit);
        $this->model->setResultSet($this->fullResult);

        if (!MYSQL_MODE_FULL_GROUP_BY) {
            // We don't MySQL num_rows because by selecting a large recordset
            // it consumes a long time. But it is possible only when FULL_GROUP_BY
            // is not active,
            $countingSQL = str_ireplace("SELECT", "SELECT COUNT(*) as num_rows , ", $this->query);
            // echo $countingSQL;
            $countingResult = $this->model->query($countingSQL);
            $countingObject = $countingResult->fetch_object();
            $counting = $countingObject->num_rows;
            $this->totalResult = $counting;
        } else {
            // Using num_rows (slowest)
            $this->totalResult = $this->fullResult->num_rows;
        }


        $this->pages = $this->getPages($this->totalResult, $this->resultPerPage);
        if (isset($_GET[$urlPageParameterName]) && $_GET[$urlPageParameterName] > 0) {
            $this->openPage = $_GET["$urlPageParameterName"];
            if ($this->openPage > $this->pages) {
                $this->openPage = 1;
            }
            $start = $this->openPage * $this->resultPerPage - $this->resultPerPage;
            $end = $this->resultPerPage;
            $this->query .= " LIMIT $start,$end";
        } elseif (isset($_GET["$urlPageParameterName"]) && $_GET["$urlPageParameterName"] > $this->pages) {
            $start = $this->pages;
            $end = $this->resultPerPage;
            $this->query .= " LIMIT $start,$end";
        } else {
            $this->openPage = 1;
            $this->query .= " LIMIT 0,$this->resultPerPage";
        }


        $this->resultPage = $this->model->query($this->query);
        $this->model->setResultSet($this->resultPage);

    }

    /**
     * Calculates the total number of pages.
     *
     * @param int $total Total number of records
     * @param int $perpage Record per page
     * @return int Total number of pages
     */
    private function getPages($total, $perpage)
    {
        $pages = intval($total / $perpage);
        if ($total % $perpage > 0) $pages++;
        return $pages;
    }

    /**
     *  Display the pagination.
     */
    public function render()
    {
        if ($this->totalResult == 0) {
            $this->view->setVar("Page_Number", "{RES:NoRecordFound}");
            $this->view->setVar("Page_URL", "#");;
            $this->view->setVar("is_active", $this->activeFlag);
        }
        // $self=$_SERVER['PHP_SELF'];
        $self = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $urlPageParameterName = $this->urlPageParameterName;

        if ($this->openPage <= 0) {
            $next = 2;
        } else {
            $next = $this->openPage + 1;
        }

        $prev = $this->openPage - 1;
        $last = $this->pages;

        // Gets application query string without page parameter
        @$currentPage = $_GET[$urlPageParameterName];
        unset($_GET[$urlPageParameterName]);
        $queryString = http_build_query($_GET);
        $queryString = str_replace("getState", "off", $queryString);

        // Format application query string enabling the dynamic addition of page parameter
        if ($queryString != "") {
            $queryString = "?" . $queryString . "&";
        } else {
            $queryString = "?";
        }

        // Total records
        if ($this->showTotalRecord == true) {
            $this->view->openBlock("Total");
            $this->view->setVar("TotalRecords", $this->totalResult);
            $this->view->parseCurrentBlock();
            $this->view->setBlock();
        }

        // First and previous page rendering
        if ($this->openPage > 1) {
            // First
            $this->view->openBlock("First");
            $this->view->setVar("First_URL", $self . $queryString . $urlPageParameterName . "=1");
            $this->view->setVar("First_On", $this->first);
            $this->view->setVar("First_Off", "");
            $this->view->parseCurrentBlock();
            $this->view->setBlock();

            // Prev
            $this->view->openBlock("Prev");
            $this->view->setVar("Prev_URL", $self . $queryString . $urlPageParameterName . "=" . $prev);
            $this->view->setVar("Prev_On", $this->previous);
            $this->view->setVar("Prev_Off", "");
            $this->view->parseCurrentBlock();
            $this->view->setBlock();

        } else {
            // Apply OFF Value to First and Previous by preventing link action
            // Set First_On to null and First_Off to offValue
            $this->view->openBlock("First");
            $this->view->setVar("First_URL", $self . $queryString . $urlPageParameterName . "=1");
            if ($this->offModeHidden == true) {
                $this->view->setVar("First_On", "");
            } else {
                $this->view->setVar("First_On", $this->first);
            }
            $this->view->setVar("First_Off", $this->offValue);
            $this->view->parseCurrentBlock();
            $this->view->setBlock();

            // Set Prev_On to null and Prev_Off to offValue
            $this->view->openBlock("Prev");
            $this->view->setVar("Prev_URL", $self . $queryString . $urlPageParameterName . "=" . $prev);
            if ($this->offModeHidden == true) {
                $this->view->setVar("Prev_On", "");
            } else {
                $this->view->setVar("Prev_On", $this->previous);
            }
            $this->view->setVar("Prev_Off", $this->offValue);
            $this->view->parseCurrentBlock();
            $this->view->setBlock();
        }

        // Pages and active page rendering
        $this->view->openBlock("Pages");

        //  Computing start/end pages for paginator based on current page and pagination sisze
        if ($this->paginationSize > $this->pages)
            $this->paginationSize = $this->pages;

        $currentPage + $this->paginationSize < $this->pages ? $start_i_value = $currentPage : $start_i_value = $currentPage - ($this->paginationSize - 1);
        $currentPage + ($this->paginationSize - 1) < $this->pages ? $end_i_value = $currentPage + ($this->paginationSize - 1) : $end_i_value = $this->pages;

        if (($currentPage + $this->paginationSize) == $this->pages) {
            $val_exceded = ($currentPage + $this->paginationSize) - $this->pages;
            $start_i_value = ($currentPage - $val_exceded) + 0;
        }

        if (($currentPage + $this->paginationSize) > $this->pages) {
            $val_exceded = ($currentPage + $this->paginationSize) - $this->pages;
            $start_i_value = ($currentPage - $val_exceded) + 1;
        }

        $start_i = $currentPage <= $this->paginationSize ? 1 : $start_i_value;
        $end_i = $currentPage <= $this->paginationSize ? $this->paginationSize : $end_i_value;
        // End computing start/end pages

        // for($i=1;$i<=$this->pages;$i++) {
        for ($i = $start_i; $i <= $end_i; $i++) {
            if ($i == $this->openPage && $this->showActivePage == true) {
                // Disable link of the current page
                $this->view->setVar("Page_URL", "#");
                $this->view->setVar("Page_Number", $i);
                $this->view->setVar("is_active", $this->activeFlag);
                $this->view->parseCurrentBlock();
            } else if ($this->showPagesLinks == true) {
                // Standards pagination links
                $this->view->setVar("Page_URL", $self . $queryString . $urlPageParameterName . "=" . $i);
                $this->view->setVar("Page_Number", $i);
                $this->view->setVar("is_active", $this->notActiveFlag);
                $this->view->parseCurrentBlock();
            }

        }

        $this->view->setBlock();

        // Next and Last page rendering
        if ($this->openPage < $this->pages) {
            // Next
            $this->view->openBlock("Next");
            $this->view->setVar("Next_URL", $self . $queryString . $urlPageParameterName . "=" . $next);
            $this->view->setVar("Next_On", $this->next);
            $this->view->setVar("Next_Off", "");
            $this->view->parseCurrentBlock();
            $this->view->setBlock();
            // Last
            $this->view->openBlock("Last");
            $this->view->setVar("Last_URL", $self . $queryString . $urlPageParameterName . "=" . $last);
            $this->view->setVar("Last_On", $this->last);
            $this->view->setVar("Last_Off", "");
            $this->view->parseCurrentBlock();
            $this->view->setBlock();
        } else {
            // Apply OFF Value to Next and Last by  preventing link action
            // Set Next_On to null and Next_Off to offValue
            $this->view->openBlock("Next");
            $this->view->setVar("Next_URL", $self . $queryString . $urlPageParameterName . "=" . $next);
            if ($this->offModeHidden == true) {
                $this->view->setVar("Next_On", "");
            } else {
                $this->view->setVar("Next_On", $this->next);
            }
            $this->view->setVar("Next_Off", $this->offValue);
            $this->view->parseCurrentBlock();
            $this->view->setBlock();

            // Set Last_On to null and Last_Off to offValue
            $this->view->openBlock("Last");
            $this->view->setVar("Last_URL", $self . $queryString . $urlPageParameterName . "=" . $last);
            if ($this->offModeHidden == true) {
                $this->view->setVar("Last_On", "");
            } else {
                $this->view->setVar("Last_On", $this->last);
            }
            $this->view->setVar("Last_Off", $this->offValue);
            $this->view->parseCurrentBlock();
            $this->view->setBlock();
        }

        // Restores $_GET for external access and use
        $_GET[$urlPageParameterName] = $this->openPage;

        // Rendering
        return $this->view->parse();
    }
}

?>
