<?php
/**
 * Class Block
 *
 * {ModelResponsability}
 *
 * @package models\examples\cms
 * @category Application Model
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace models\examples\cms;

use framework\Model;

class Block extends Model
{

    /**
     * Gets the users list.
     *
     * @return array
     */
    public function getUsers()
    {
        $users = array (
            array("FirstName" => "John", "LastName" => "Red"),
            array("FirstName" => "Mark", "LastName" => "White"),
            array("FirstName" => "Diana", "LastName" => "Brown"),
            array("FirstName" => "Sunny", "LastName" => "Black"),
            array("FirstName" => "Gilda", "LastName" => "Green"),
            array("FirstName" => "Eric", "LastName" => "Red"),
            array("FirstName" => "Tom", "LastName" => "Blue"),
            array("FirstName" => "Fred", "LastName" => "Brown")
        );
        return $users;
    }

    /**
     * Gets a simple message
     *
     * @return string
     */
    public function getMessage()
    {
        return "Registered users:";
    }

}
