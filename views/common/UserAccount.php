<?php
/**
 * Class UserAccount
 *
 * {ViewResponsability}
 *
 * @package controllers\common
 * @category Application View
 * @author  Rosario Carvello - rosario.carvello@gmail.com
*/
namespace views\common;

use framework\components\DataRepeater;
use framework\Model;
use framework\View;
use models\beans\BeanUser;

class UserAccount extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/common/user_account";
        parent::__construct($tplName);
    }

    /**
     * Renders access level option list
     * @param Model $model The model containing access levels table
     */
    public function renderAccessLevelOptionsList(Model $model){
        $repeater = new DataRepeater($this,$model,"AccessLevelOptionsList",null);
        $repeater->render();
    }

    /**
     * Sets form fiels  with data provided by  BeanUser
     * @param BeanUser $bean
     */
    public function setFieldsWithBeanData(BeanUser $bean)
    {
        // Switch form mode
        if ($bean->getIdUser() == null) {
            $this->setVar("FormTitle","{RES:AddNewUser}");
            $this->setVar("edit_mode","false");
        }else  {
            $this->setVar("FormTitle","{RES:EditUser}: " . $bean->getFullName());
            $this->setVar("edit_mode","true");
        }
        $this->setVar("id_user",$bean->getIdUser());
        $this->setVar("full_name",$bean->getFullName());
        $this->setVar("email",$bean->getEmail());
        $this->setVar("password",$bean->getPassword());
        $this->setVar("enabled",$bean->getEnabled());
        if ($bean->getEnabled() == 1){
            $this->setVar("is_checked","checked");
        } else {
            $this->setVar("is_checked","");
        }
        $this->setVar("id_access_level",$bean->getIdAccessLevel());
    }
    
}
