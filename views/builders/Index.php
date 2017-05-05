<?php
/**
 * Class Index
 *
 * {ViewResponsability}
 *
 * @package controllers
 * @category Application View
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace views\builders;

use framework\View;

class Index extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/buiders/index";
        parent::__construct($tplName);
    }
    
}
