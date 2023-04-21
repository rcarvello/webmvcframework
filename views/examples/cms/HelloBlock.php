<?php
/**
 * Class HelloBlock
 *
 * {ViewResponsability}
 *
 * @package controllers\examples\cms
 * @category Application View
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace views\examples\cms;

use framework\View;

class HelloBlock extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/examples/cms/hello_block";
        parent::__construct($tplName);
    }
    
    /**
    * Sets value for WelcomeMessage placeholder
    *
    * @param mixed $value
    */
    public function setVarWelcomeMessage($value)
    {
        $this->setVar("WelcomeMessage",$value);
    }

    /**
    * Opens block Users
    *
    */
    public function openBlockUsers()
    {
        $this->openBlock("Users");
    }

    /**
    * Sets value for Location inside the block Users
    *
    * @param mixed $value
    */
    public function setBlockVarUsersLocation($value)
    {
        $this->setVar("Location",$value);
    }

    /**
    * Sets value for Name inside the block Users
    *
    * @param mixed $value
    */
    public function setBlockVarUsersName($value)
    {
        $this->setVar("Name",$value);
    }

}
