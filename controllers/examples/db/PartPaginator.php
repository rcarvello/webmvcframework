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

class PartPaginator extends Controller
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

        $paginator = new PaginatorBootstrap();

        $paginator->setName("Bottom");
        $paginator->resultPerPage = 5;
        $paginator->setModel($this->model);
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
        $view = new PartListView("/examples/db/part_paginator");
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
