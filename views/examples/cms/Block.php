<?php
/**
 * Class Block
 *
 * {ViewResponsability}
 *
 * @package controllers\examples\cms
 * @category Application View
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace views\examples\cms;

use framework\View;

class Block extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/examples/cms/block";
        parent::__construct($tplName);
    }
    
    /**
    * Sets value for Message placeholder
    *
    * @param mixed $value
    */
    public function setMessage($value)
    {
        $this->setVar("Message",$value);
    }


    /**
     * Sets users list with data
     *
     * @param array $userList
     */
    public function setUsers($userList)
    {
        $this->openBlock("Users");
        foreach ($userList as $user){
            $this->setVar("FirstName",$user["FirstName"]);
            $this->setVar("LastName",$user["LastName"]);
            $this->parseCurrentBlock();
        }
        $this->setBlock();
    }



}
