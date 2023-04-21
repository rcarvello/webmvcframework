<?php
/**
 * Class TreeDemo
 *
 * {ModelResponsability}
 *
 * @package models\examples\cms
 * @category Application Model
 * @author  {AuthorName} - {AuthorEmail}
 */

namespace models\examples\cms;

use framework\Model;

class TreeDemo extends Model
{
    /**
     * Object constructor.
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->autorun();
    }

    /**
     * Autorun method. Put your code here for running it after object creation.
     * @param mixed|array|null $parameters Additional parameters to manage
     *
     */
    protected function autorun($parameters = null)
    {
        $rows = array(
            array(
                'id' => 1,
                'parent_id' => 0,
                'description' => 'Item 1',
            ),
            array(
                'id' => 2,
                'parent_id' => 1,
                'description' => 'Item 2',
            ),
            array(
                'id' => 3,
                'parent_id' => 1,
                'description' => 'Item 3',
            ),
            array(
                'id' => 4,
                'parent_id' => 3,
                'description' => $this->getItemDescription(4),
                'link' => '{GLOBAL:SITEURL}/examples/',
            ),
            array(
                'id' => 5,
                'parent_id' => 3,
            ),
            array(
                'id' => 6,
                'parent_id' => 3,
            ),
            array(
                'id' => 7,
                'parent_id' => 2,
            ),
            array(
                'id' => 8,
                'parent_id' => 2,
            ),
            array(
                'id' => 9,
                'parent_id' => 6,
            ),
            array(
                'id' => 10,
                'parent_id' => 6,
                'description' => $this->getItemDescription(10),
                'link' => 'tree_demo/link_click',

            ),
        );
        $this->setResultSet($rows);
    }

    public function getItemDescription($itemId)
    {
        $locale = (empty(@$_GET["locale"])) ? $_SESSION["CurrentLocale"] : $_GET["locale"];
        $descriptions = array();
        $descriptions[4]["it-it"] = "Item 4 (link all'indice degli esempi)";
        $descriptions[4]["en"] = "Item 4 (has a link to example index)";
        $descriptions[10]["it-it"] = "Item 10 (link al metodo linkClick del Controller corrente)";
        $descriptions[10]["en"] = "Item 10 (has a link to method linkClick of current Controller)";
        return $descriptions[$itemId][$locale];
    }
}
