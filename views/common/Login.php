<?php
/**
 * Class Login
 *
 * {ViewResponsability}
 *
 * @package controllers\common
 * @category Application View
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace views\common;

use framework\View;

class Login extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/common/login";
        parent::__construct($tplName);
        $this->setLoginWarningMessage();

    }
    protected function setLoginWarningMessage()
    {
        if (isset($_GET["login_warning_message"])) {
            $warningMessage = $_GET["login_warning_message"];
        } else {
            $warningMessage = "";
        }
        $this->setVar("LoginWarningMessage", $warningMessage);
    }
}
