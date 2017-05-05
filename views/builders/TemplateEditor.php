<?php
/**
 * Class TemplateEditor
 *
 * {ViewResponsability}
 *
 * @package controllers\builders
 * @category Application View
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace views\builders;

use framework\View;

class TemplateEditor extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/builders/template_editor";
        parent::__construct($tplName);
    }
    
}
