<?php
/**
 * Created by PhpStorm.
 * User: Saro
 * Date: 11/04/2017
 * Time: 17:17
 */

namespace controllers\examples\db;

use views\examples\db\PartList as PartListView;
use framework\components\Searcher;
class PartPaginatorSorterSearch extends PartPaginatorSorter
{

    public function autorun($parameters = null)
    {
        // First of all apply where by using a saercher
        // Order is: Search, Sort, Paginate then Fetch.
        $this->makeSearcher();
        parent::autorun($parameters);

    }

    /**
     * Builds searcher
     */
    protected function makeSearcher()
    {
        // Creates a searcher by sharing model and view
        $searcher = new Searcher($this->view, $this->model);

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
        $searcher->init($this->model,$this->view);
    }

    public function getView()
    {
        $view = new PartListView("/examples/db/part_paginator_sorter_search");
        return $view;
    }

}