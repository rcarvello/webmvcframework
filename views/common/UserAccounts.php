<?php
/**
 * Class Users
 *
 * {ViewResponsability}
 *
 * @package controllers\common
 * @category Application View
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace views\common;

use framework\View;

class UserAccounts extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/common/user_accounts";
        parent::__construct($tplName);
    }
    
}
