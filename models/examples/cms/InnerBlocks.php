<?php
/**
 * Class InnerBlocks
 *
 * {ModelResponsability}
 *
 * @package models\examples\cms
 * @category Application Model
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace models\examples\cms;

use framework\Model;

class InnerBlocks extends Model
{
    /**
    * Object constructor.
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Autorun method. Put your code here for running it after object creation.
    * @param mixed|array|null $parameters Additional parameters to manage
    *
    */
    protected function autorun($parameters = null)
    {

    }

    /**
     * Gets Names
     * @return array
     */
    public function getNames()
    {
        return array (
            array("name"=>"Bob",  "vote"=>1),
            array("name"=>"Liza", "vote"=>3),
            array("name"=>"Paul", "vote"=>5)
        );

    }

    /**
     * Gets votes
     * @return array
     */
    public function getVotes()
    {
      return array (1,2,3,4,5);
    }
}
