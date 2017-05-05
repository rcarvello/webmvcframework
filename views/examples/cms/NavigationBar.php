<?php
/**
 * Class NavigationBar
 *
 * {ViewResponsability}
 *
 * @package controllers\examples\cms
 * @category Application View
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace views\examples\cms;

use framework\View;

class NavigationBar extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/examples/cms/navigation_bar";
        parent::__construct($tplName);
    }
    
}
