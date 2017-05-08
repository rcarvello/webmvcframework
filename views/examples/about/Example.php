<?php
/**
 * Class Example
 *
 * {ViewResponsability}
 *
 * @package controllers\examples\about
 * @category Application View
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace views\examples\about;

use framework\View;

class Example extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/examples/about/example";
        parent::__construct($tplName);
    }
    
    /**
    * Sets value for Controller placeholder
    *
    * @param mixed $value
    */
    public function setVarController($value)
    {
        $this->setVar("Controller",$value);
    }

    /**
    * Sets value for Example placeholder
    *
    * @param mixed $value
    */
    public function setVarExample($value)
    {
        $this->setVar("Example",$value);
    }

    /**
    * Sets value for Model placeholder
    *
    * @param mixed $value
    */
    public function setVarModel($value)
    {
        $this->setVar("Model",$value);
    }

    /**
    * Sets value for Template placeholder
    *
    * @param mixed $value
    */
    public function setVarTemplate($value)
    {
        $this->setVar("Template",$value);
    }

    /**
    * Sets value for View placeholder
    *
    * @param mixed $value
    */
    public function setVarView($value)
    {
        $this->setVar("View",$value);
    }

    /**
     * Sets value for ControllerFile placeholder
     *
     * @param mixed $value
     */
    public function setVarControllerFile($value)
    {
        $this->setVar("ControllerFile",$value);
    }

    /**
     * Sets value for ModelFile placeholder
     *
     * @param mixed $value
     */
    public function setVarModelFile($value)
    {
        $this->setVar("ModelFile",$value);
    }

    /**
     * Sets value for ViewFile placeholder
     *
     * @param mixed $value
     */
    public function setVarViewFile($value)
    {
        $this->setVar("ViewFile",$value);
    }

    /**
     * Sets value for TemplateFile placeholder
     *
     * @param mixed $value
     */
    public function setVarTemplateFile($value)
    {
        $this->setVar("TemplateFile",$value);
    }
}
