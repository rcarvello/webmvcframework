<?php
namespace controllers\examples\db;

// Basic Framework classes usage
use framework\Controller;
use framework\Model;
use framework\View;

// Use related applications View and Model
use views\examples\db\PartListManager as PartListManagerView;
use models\examples\db\PartListManager as PartListManagerModel;

// Using some common and shared application controllers
use controllers\examples\cms\NavigationBar;

// Using some framework components
use framework\components\bootstrap\PaginatorBootstrap;
use framework\components\Searcher;
use framework\components\DataRepeater;
use framework\components\bootstrap\SorterBootstrap;

/**
 * Class PartListManager
 * Manages Parts.
 *
 * @package controllers\examples\db
 */
class PartListManager extends Controller
{

    public function __construct(View $view=null, Model $model=null)
    {
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view,$this->model);
    }

    /**
     * Helper method to associate View
     * @return PartListManagerView
     */
    public function getView()
    {
        $view = new PartListManagerView();
        return $view;
    }

    /**
     * Helper Method to associate Model
     * @return PartListManagerModel
     */
    public function getModel()
    {
        $model = new PartListManagerModel();
        return $model;
    }


    public function autorun($parameters = null)
    {
        parent::autorun($parameters);

        // Builds child controller
        $navigation = $this->makeNavigation();

        // Build components making care to use the following
        // components creation order:
        // 1st Searcher
        // 2nd Sorters
        // 3rd Pagination
        // 4th Selection
        // (Note: order is similar to SQL query procesor execution order)

        $searcher = $this->makeSearcher();

        $sorterPartCode = $this->view->makeSoterPartCode($this->model);
        $sorterDescription = $this->view->makeSoterDescription($this->model);
        $sorterSource = $this->view->makeSoterSource($this->model);
        $sorterSourceLeadTime = $this->view->makeSoterSourceLeadTime($this->model);
        $sorterPartTypeCode =$this->view->makeSoterPartTypeCode($this->model);
        $soterMeasurementUnitCode = $this->view->makeSoterMeasurementUnitCode($this->model);
        $sorterPartCategoryCode = $this->view->makeSoterPartCategoryCode($this->model);
        $sorterWastage = $this->view->makeSoterWastage($this->model);
        $sorterBomLevels = $this->view->makeSoterBomLevels($this->model);

        $pagination = $this->makePagination();
        $parts = $this->makePartsWithDataRepeater();

        // Binding child controller and components instances to the main View
        $this->bindController($navigation);

        // Binding components instances to the main View (by
        // using the same creation order)
        $this->bindComponent($searcher,false);

        $this->bindComponent($sorterPartCode);
        $this->bindComponent($sorterDescription);
        $this->bindComponent($sorterSource);
        $this->bindComponent($sorterSourceLeadTime);
        $this->bindComponent($sorterPartTypeCode);
        $this->bindComponent($soterMeasurementUnitCode);
        $this->bindComponent($sorterPartCategoryCode);
        $this->bindComponent($sorterWastage);
        $this->bindComponent($sorterBomLevels);

        $this->bindComponent($pagination);

        $this->bindComponent($parts);
    }

    /**
     * Makes a Searcher Component
     * The componponent uses new View witch uses itself
     * an external template design (part_search_form.html.tpl).
     *
     * @return Searcher We can use it to binding it {Searcher:ricerca}
     *                  placeholder of the main View
     */
    protected function makeSearcher()
    {
        // Creates a searcher by using a new View and an external template
        // for its search form HTML design.
        $view = new View("examples/db/part_search_form");
        $searcher = new Searcher($view, $this->model);

        // Set component name
        $searcher->setName("ricerca");

        // Creates filters:
        // parameters: table field, form input, operators into query, data type
        $searcher->addFilter("part_code","s_part_code","=","string");
        $searcher->addFilter("description","s_description","LIKE","string");
        $searcher->addFilter("source","s_source","=","string");

        // Sets form name (tpl variable)
        $searcher->setFormName("search_form", $searcher->getName());

        // Sets component submit and reset inputs name (tpl variables)
        $searcher->setResetButton("search_reset", "Reset");
        $searcher->setSubmitButton("search_submit","Cerca");

        // Init component ( do the search job for you if :) )
        $searcher->init($this->model,$view);
        return $searcher;
    }


    /**
     * Makes pagination by using PaginatorBootstrap component
     * @return PaginatorBootstrap
     */
    protected function makePagination(){
        $paginator = new PaginatorBootstrap();
        $paginator->setName("Bottom");
        $paginator->resultPerPage = 4;
        $paginator->setModel($this->model);
        $paginator->buildPagination();
        $this->model->sql = $paginator->query;
        return $paginator;
    }

    /**
     * Makes part list by using a DataRepeater
     * @return DataRepeater The DataRepeater to use form binging it
     *                      to Parts Block of the main View
     */
    protected function makePartsWithDataRepeater()
    {
        $parts = new  DataRepeater($this->view,$this->model,"Parts",null);
        return $parts;

    }

    /**
     * Makes the navigation bars by using a shared application controller
     * @return NavigationBar The navigation bar
     */
    protected function makeNavigation(){
        $navigation = new NavigationBar();
        return $navigation;
    }

}