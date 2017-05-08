<?php
/**
 * Created by PhpStorm.
 * User: Saro
 * Date: 11/04/2017
 * Time: 17:17
 */

namespace controllers\examples\db;

use views\examples\db\PartList as PartListView;
use framework\View;
use framework\components\Searcher;

class PartPaginatorSorterSearchExternal extends PartPaginatorSorter
{

    public function autorun($parameters = null)
    {
        $searcher = $this->makeSearcher();
        parent::autorun($parameters);

        // We used an external design managed by the searcher component view.
        // So we have to bind it to a component placeholder located inside the
        // master view.
        $this->bindComponent($searcher,false);
    }

    /**
     * Builds a searcher component by using an external design
     * @return Searcher
     */
    protected function makeSearcher()
    {
        // Creates a searcher by using a view and an external template
        // for search form design.
        $view = new View("examples/db/part_search_form");
        $searcher = new Searcher($view, $this->model);

        // Set component name
        $searcher->setName("ricerca");

        // Creates filters: table field, form input, operators into query, type
        $searcher->addFilter("part_code","s_part_code","=","string");
        $searcher->addFilter("description","s_description","LIKE","string");
        $searcher->addFilter("source","s_source","=","string");

        // Sets form name (tpl variable)
        $searcher->setFormName("search_form", $searcher->getName());

        // Sets component submit and reset inputs name (tpl variables)
        $searcher->setResetButton("search_reset", "Reset");
        $searcher->setSubmitButton("search_submit","Cerca");

        // Init component
        $searcher->init($this->model,$view);
        return $searcher;
    }

    public function getView()
    {
        $view = new PartListView("/examples/db/part_paginator_sorter_search_external");
        return $view;
    }

}
