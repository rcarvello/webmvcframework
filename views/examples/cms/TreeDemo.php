<?php
/**
 * Class TreeDemo
 *
 * {ViewResponsability}
 *
 * @package controllers\examples\cms
 * @category Application View
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace views\examples\cms;

use framework\View;

class TreeDemo extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/examples/cms/tree_demo";
        parent::__construct($tplName);
    }
    
}
