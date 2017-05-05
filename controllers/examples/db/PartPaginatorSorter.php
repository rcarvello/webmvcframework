<?php
/**
 * Class PartPaginator
 *
 * {ControllerResponsability}
 *
 * @package controllers\examples\db
 * @category Application Controller
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace controllers\examples\db;

use framework\Controller;
use framework\Model;
use framework\View;
use models\examples\db\PartPaginator as PartPaginatorModel;
use views\examples\db\PartList as PartListView;
use controllers\examples\cms\NavigationBar;
use framework\components\DataRepeater;
use framework\components\bootstrap\PaginatorBootstrap;
use framework\components\bootstrap\SorterBootstrap;

class PartPaginatorSorter extends Controller
{
    /**
    * Object constructor.
    *
    * @param View $view
    * @param Model $mode
    */

    // We optionally can remove constructor (and also getModel method)
    // simply by using inheritance and declaring :
    // -> class PartPaginatorSorter extends PartPaginator
    public function __construct()
    {
        $this->model = $this->getModel();
        $this->view = $this->getView();
        parent::__construct($this->view,$this->model);
        $navigation = new NavigationBar();
        $this->bindController($navigation);
    }


    protected function autorun($parameters = null)
    {
        // Note:
        // By using multiple db components play attention to instantiate
        // them in the following order: Sorters,Paginators, DataRepeater
        // (same order of db query processor)

        // Sort
        $sorterPartCode = $this->makeSoterPartCode();
        $sorterDescription = $this->makeSoterDescription();
        $sorterSource = $this->makeSoterSource();
        $sorterSourceLeadTime = $this->makeSoterSourceLeadTime();
        $sorterPartTypeCode =$this->makeSoterPartTypeCode();
        $soterMeasurementUnitCode = $this->makeSoterMeasurementUnitCode();
        $sorterPartCategoryCode = $this->makeSoterPartCategoryCode();
        $sorterWastage = $this->makeSoterWastage();
        $sorterBomLevels = $this->makeSoterBomLevels();

        // Paginate
        $paginator = $this->makePaginator();
        $this->model->sql = $paginator->query;

        // List
        $parts = $this->makeDataRepeater();

        // Finally binding
        // Sortes components
        $this->bindComponent($sorterPartCode);
        $this->bindComponent($sorterDescription);
        $this->bindComponent($sorterSource);
        $this->bindComponent($sorterSourceLeadTime);
        $this->bindComponent($sorterPartTypeCode);
        $this->bindComponent($soterMeasurementUnitCode);
        $this->bindComponent($sorterPartCategoryCode);
        $this->bindComponent($sorterWastage);
        $this->bindComponent($sorterBomLevels);

        // Paginator component
        $this->bindComponent($paginator);

        // Paginator components
        $this->bindComponent($parts);
    }

    /**
     * Makes the paginator.
     * @return PaginatorBootstrap
     */
    protected function makePaginator()
    {
        $paginator = new PaginatorBootstrap();
        $paginator->setName("Bottom");
        $paginator->resultPerPage = 10;
        $paginator->setModel($this->model);
        $paginator->buildPagination();
        return $paginator;
    }

    /**
     * Makes the data list
     * @return DataRepeater
     */
    protected function makeDataRepeater()
    {
        $parts = new  DataRepeater($this->view,$this->model,"Parts",null);
        return $parts;
    }

    /**
     * Makes sorter for part_code field
     * @return SorterBootstrap
     */
    protected function makeSoterPartCode()
    {
        $sorterPartCode = new SorterBootstrap();
        $sorterPartCode->setName("part_code");
        $sorterPartCode->field = "part_code";
        $sorterPartCode->caption = "{RES:part_code}";
        $sorterPartCode->init($this->model);
        return $sorterPartCode;
    }

    /**
     * Make sorter for description field
     * @return SorterBootstrap
     */
    protected function makeSoterDescription()
    {
        $sorterDescription = new SorterBootstrap();
        $sorterDescription->setName("description");
        $sorterDescription->field = "description";
        $sorterDescription->caption = "{RES:description}";
        $sorterDescription->init($this->model);
        return $sorterDescription;
    }

    /**
     * Make sorter for source field
     * @return SorterBootstrap
     */
    protected function makeSoterSource()
    {
        $sorterSource = new SorterBootstrap();
        $sorterSource->setName("source");
        $sorterSource->field = "source";
        $sorterSource->caption = "{RES:source}";
        $sorterSource->init($this->model);
        return $sorterSource;
    }

    /**
     * Make sorte for source_lead_time field
     * @return SorterBootstrap
     */
    protected function makeSoterSourceLeadTime()
    {
        $sorterSourceLeadTime = new SorterBootstrap();
        $sorterSourceLeadTime->setName("source_lead_time");
        $sorterSourceLeadTime->field = "source_lead_time";
        $sorterSourceLeadTime->caption = "{RES:source_lead_time}";
        $sorterSourceLeadTime->init($this->model);
        return $sorterSourceLeadTime;
    }

    /**
     * Make sorte for measurement_unit_code field
     * @return SorterBootstrap
     */
    protected function makeSoterMeasurementUnitCode()
    {
        $sorterMeasurementUnitCode = new SorterBootstrap();
        $sorterMeasurementUnitCode->setName("measurement_unit_code");
        $sorterMeasurementUnitCode->field = "measurement_unit_code";
        $sorterMeasurementUnitCode->caption = "{RES:measurement_unit_code}";
        $sorterMeasurementUnitCode->init($this->model);
        return $sorterMeasurementUnitCode;
    }

    /**
     * Make sorte for part_type_code field
     * @return SorterBootstrap
     */
    protected function makeSoterPartTypeCode()
    {
        $sorterPartTypeCode = new SorterBootstrap();
        $sorterPartTypeCode->setName("part_type_code");
        $sorterPartTypeCode->field = "part_type_code";
        $sorterPartTypeCode->caption = "{RES:part_type_code}";
        $sorterPartTypeCode->init($this->model);
        return $sorterPartTypeCode;
    }

    /**
     * Make sorte for part_category_code field
     * @return SorterBootstrap
     */
    protected function makeSoterPartCategoryCode()
    {
        $sorterPartCategoryCode = new SorterBootstrap();
        $sorterPartCategoryCode->setName("part_category_code");
        $sorterPartCategoryCode->field = "part_category_code";
        $sorterPartCategoryCode->caption = "{RES:part_category_code}";
        $sorterPartCategoryCode->init($this->model);
        return $sorterPartCategoryCode;
    }

    /**
     * Make sorte for wastage field
     * @return SorterBootstrap
     */
    protected function makeSoterWastage()
    {
        $sorterWastage = new SorterBootstrap();
        $sorterWastage->setName("wastage");
        $sorterWastage->field = "wastage";
        $sorterWastage->caption = "{RES:wastage}";
        $sorterWastage->init($this->model);
        return $sorterWastage;
    }

    /**
     * Make sorte for bom_levels field
     * @return SorterBootstrap
     */
    protected function makeSoterBomLevels()
    {
        $sorterBomLevels = new SorterBootstrap();
        $sorterBomLevels->setName("bom_levels");
        $sorterBomLevels->field = "bom_levels";
        $sorterBomLevels->caption = "{RES:bom_levels}";
        $sorterBomLevels->init($this->model);
        return $sorterBomLevels;
    }

    /**
    * Inizialize the View by loading static design of /examples/db/part_paginator.html.tpl
    * managed by views\examples\db\PartPaginator class
    *
    */
    public function getView()
    {
        $view = new PartListView("/examples/db/part_paginator_sorter");
        return $view;
    }

    /**
    * Inizialize the Model by loading models\examples\db\PartPaginator class
    *
    */
    public function getModel()
    {
        $model = new PartPaginatorModel();
        return $model;
    }
}
