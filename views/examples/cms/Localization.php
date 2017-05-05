<?php
/**
 * Class Localization
 *
 * {ViewResponsability}
 *
 * @package controllers\examples\cms
 * @category Application View
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace views\examples\cms;

use framework\View;

class Localization extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/examples/cms/localization";
        parent::__construct($tplName);
    }
    
    /**
    * Sets value for BodyMessage placeholder
    *
    * @param mixed $value
    */
    public function setVarBodyMessage($value)
    {
        $this->setVar("BodyMessage",$value);
    }

}
