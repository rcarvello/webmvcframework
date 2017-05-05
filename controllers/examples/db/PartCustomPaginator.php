<?php

namespace controllers\examples\db;

use framework\Controller;
use framework\Model;
use framework\View;
use models\examples\db\PartPaginator as PartPaginatorModel;
use views\examples\db\PartList as PartListView;
use controllers\examples\cms\NavigationBar;
use framework\components\DataRepeater;
use framework\components\Paginator;

class PartCustomPaginator extends Controller
{
    /**
    * Object constructor.
    *
    * @param View $view
    * @param Model $mode
    */
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
        $paginator = new Paginator();
        // Customizing component view
        $paginator->setView(new View("examples/db/custom_paginator"));
        $paginator->setName("Bottom");
        $paginator->resultPerPage = 4;
        $paginator->setModel($this->model);


        // Custom values
        $paginator->first="{RES:First}";
        $paginator->last="{RES:Last}";
        $paginator->previous = "{RES:Previous}";
        $paginator->next ="{RES:Next}";
        $paginator->activeFlag = "selected";
        $paginator->notActiveFlag = "";
        $paginator->paginationSize=10;

        $paginator->buildPagination();

        $this->model->sql = $paginator->query;

        $parts = new  DataRepeater($this->view,$this->model,"Parts",null);

        $this->bindComponent($paginator);
        $this->bindComponent($parts);
    }

    /**
    * Inizialize the View by loading static design of /examples/db/part_paginator.html.tpl
    * managed by views\examples\db\PartPaginator class
    *
    */
    public function getView()
    {
        $view = new PartListView("/examples/db/part_custom_paginator");
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
