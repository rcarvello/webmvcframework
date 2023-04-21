<?php
/**
 * Class HelloBlock
 *
 * {ModelResponsability}
 *
 * @package models\examples\cms
 * @category Application Model
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace models\examples\cms;

use framework\Model;

class HelloBlock extends Model
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

    public function getUsers()
    {
        $users = array(
            array("Name"=>"Bob","Location"=>"England"),
            array("Name"=>"Hellen","Location"=>"USA"),
            array("Name"=>"Ciro","Location"=>"Italy")
        );

        return $users;
    }
}
