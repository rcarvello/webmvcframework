<?php
/**
 * Class Sorter
 *
 * @package framework
 * @filesource framework/components/Sorter.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework\components;
use framework\exceptions\TemplateNotFoundException;
use framework\exceptions\NotInitializedComponent;
use framework\exceptions\VariableNotFoundException;
use framework\Model;
use framework\View;

class Sorter extends Component
{
    /**
     * @var string The SQL order by clause
     */
    private $order = "";

    /**
     * @var string Sql without the order by clause
     */
    private $sqlBeforeOrderBy;

    /**
     * @var bool True if order is currently active
     */
    private $isActive = false;

    /**
     * @var string  Current order direction. May be ASC or DESC
     */
    private $currentDirection = "";

    /**
     * @var string Current sorting (field)
     */
    private $sorterDirectionCurrentValue = "";

    /**
     * @var string Switched sorter direction from current sorter direction.
     */
    private $sorterDirectionNextValue = "";

    /**
     * @var bool True if the component is initialized
     */
    private $isInitialized = false;

    /**
     * @var string Saves url parameters of sorter for field to sort
     */
    private $savedSorterUrlParameter;

    /**
     * @var string Saves url parameters of sorter for sort direction
     */
    private $savedSorterUrlDirectionParameter;

    /**
     * @var string The value to show for sorter caption
     */
    public $caption;

    /**
     * @var string The value to show for sorter direction when ASC
     */
    public $captionForDirectionUp   = "[a-z]";

    /**
     * @var string The value to show for sorter direction when DESC
     */
    public $captionForDirectionDown = "[z-a]";


    /**
     * @var string The value to show for sorter direction when is inactive
     */
    public $captionForDirectionInactive = "";

    /**
     * @var string The table field to sort
     */
    public $field;

    /**
     * @var string The SQL order by
     */
    private $sqlOrderBy = "";

    /**
     * @var string The url parameter name to act sorter action
     */
    public $sorterUrlParameterName = "sorter";

    /**
     * @var string The url parameter name to act sorter direction action
     */
    public $sorterDirectionUrlParameterName = "sorter_direction";

    /**
     * Construct a sorter object.
     *
     * @param View $view
     * @param Model $model
     * @throws TemplateNotFoundException
     */
    public function __construct(View $view = null, Model $model = null)
    {
        if ($view == null) {
            $tpl = "framework/resources/components/sorter";
            $view = new View();
            $view->loadCustomTemplate($tpl);
        }
        $this->computeOrderValues();
        parent::__construct($view,$model);
    }

    /**
     * Initializes the sorter component.
     *
     * Sorter component must be initialized after setting its attributes
     * value and before rending it.
     *
     * @param View $view The custom view for the component. If is null it uses a default
     * @param Model $model The model object to sort
     */
    public function init(Model $model=null, View $view=null)
    {
        $sorterUrlParameterName = $this->sorterUrlParameterName;
        if (isset($_GET[$sorterUrlParameterName])){
            $_GET[$sorterUrlParameterName] == $this->getName() ? $this->isActive = true  : $this->isActive =false;
            if ($this->isActive) {
                $this->model->sql = $model->sql;
                $this->setCompononentSql($model);
            }
        }
        parent::init();
        $this->isInitialized = true;
    }

    /**
     * Renders the sorter component.
     *
     * @return string The rendered component
     * @throws NotInitializedComponent
     * @throws VariableNotFoundException
     */
    public function render()
    {
        $sorterUrlParameterName = $this->sorterUrlParameterName;
        $sorterDirectionUrlParameterName = $this->sorterDirectionUrlParameterName;

        if (!$this->isInitialized)
            throw new NotInitializedComponent("Sorter component must be initialized before using it",102);

        if (isset($_GET[$sorterUrlParameterName])){
            $this->sorterDirectionCurrentValue  = $_GET[$sorterDirectionUrlParameterName];
            $this->computeOrderValues();
            $this->setCompononentSql($this->model);
        } else {
            $this->currentDirection = "";
            // $this->sql = "";
        }

        $self  =  parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

        // Gets application query string without sorters parameter
        $this->savedSorterUrlParameter = isset($_GET[$sorterUrlParameterName]) ? $_GET[$sorterUrlParameterName] : NULL ;
        $this->savedSorterUrlDirectionParameter = isset($_GET[$sorterDirectionUrlParameterName]) ? $_GET[$sorterDirectionUrlParameterName]: NULL;
        unset($_GET[$sorterUrlParameterName]);
        unset($_GET[$sorterDirectionUrlParameterName]);
        $queryString = http_build_query($_GET);
        $queryString = preg_replace('/&?getState=[^&]*/', '', $queryString);

        // Format application query string enabling the dynamic addition of sorter parameters
        if ($queryString != "") {
            $queryString = "?". $queryString . "&";
        } else {
            $queryString = "?";
        }

        // Parsing view variables
        $this->view->setVar("SorterLink", $self . $queryString . $sorterUrlParameterName ."=" . $this->getName() ."&". $sorterDirectionUrlParameterName. "=" . $this->sorterDirectionNextValue);
        $this->view->setVar("SorterCaption", $this->caption);
        if ($this->isActive==true) {
            $this->view->setVar("SorterDirection", $this->currentDirection);
        } else {
            $this->view->setVar("SorterDirection", $this->captionForDirectionInactive);
        }

        // Restores $_GET for ann external access or use
        if ($this->isActive) {
            $_GET[$sorterUrlParameterName] = $this->getName();
            $_GET[$sorterDirectionUrlParameterName] = $this->sorterDirectionCurrentValue;
        } else {
            if (!empty($this->savedSorterUrlParameter)){
                $_GET[$sorterUrlParameterName] = $this->savedSorterUrlParameter;
            }
            if (!empty($this->savedSorterUrlDirectionParameter)){
                $_GET[$sorterDirectionUrlParameterName] = $this->savedSorterUrlDirectionParameter;
            }
        }

        return $this->view->parse();

    }

    /**
     * Sets some attributes value concerning sql, sql order and component
     * model.
     *
     * @param Model $model The model from witch obtain SQL
     */
    private function setCompononentSql(Model $model)
    {
        if ($this->isActive) {
            $this->sqlBeforeOrderBy = $this->model->sql;
            $this->sqlOrderBy = " ORDER BY " . $this->field . " " . $this->order;
            $this->model->sql = $this->sqlBeforeOrderBy . $this->sqlOrderBy;
            $model->sql = $this->model->sql;
        }
    }

    /**
     *  Sets some components direction attributes value when direction is
     *  active into the url query string
     */
    private function computeOrderValues()
    {
        $sorterDirectionUrlParameterName = $this->sorterDirectionUrlParameterName;

        // Inizialize Sorter direction parameter
        if (!isset($_GET[$sorterDirectionUrlParameterName])) {
            $_GET[$sorterDirectionUrlParameterName]="DESC";
        }

        if ($_GET[$sorterDirectionUrlParameterName] == "ASC") {
            $this->order = "ASC";
            $this->currentDirection = $this->captionForDirectionUp;
            $this->sorterDirectionNextValue = "DESC";
        } else {
            $this->order = "DESC";
            $this->currentDirection = $this->captionForDirectionDown;
            $this->sorterDirectionNextValue = "ASC";
        }
    }

}