<?php
/**
 * Class InnerBlocks
 *
 * {ViewResponsability}
 *
 * @package controllers\examples\cms
 * @category Application View
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace views\examples\cms;

use framework\View;

class InnerBlocks extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/examples/cms/inner_blocks";
        parent::__construct($tplName);
    }
    
    /**
    * Opens block Names
    *
    */
    public function openBlockNames()
    {
        $this->openBlock("Names");
    }

    /**
    * Opens block Votes
    *
    */
    public function openBlockVotes()
    {
        $this->openBlock("Votes");
    }

    /**
    * Sets value for Name inside the block Names
    *
    * @param mixed $value
    */
    public function setBlockVarNamesName($value)
    {
        $this->setVar("Name",$value);
    }

    /**
     * Sets value for Name inside the block Names
     *
     * @param mixed $value
     */
    public function setBlockVarNamesSelected($value)
    {
        $this->setVar("Selected",$value);
    }

    /**
    * Sets value for Vote inside the block Votes
    *
    * @param mixed $value
    */
    public function setBlockVarVotesVote($value)
    {
        $this->setVar("Vote",$value);
    }

}
