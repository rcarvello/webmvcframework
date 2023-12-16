<?php
/**
 * Class UserAccount
 *
 * {ModelResponsability}
 *
 * @package models\common
 * @category Application Model
 * @author  Rosario Carvello - rosario.carvello@gmail.com
*/
namespace models\common;

use framework\classes\ChiperService;
use framework\Model;
use models\beans\BeanUser;

class UserAccount extends Model
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
     * Sets BeanUser data with fields submitted by UserAccount form.
     *
     * @param BeanUser $bean
     */
    public function setBeanWithPostedData(BeanUser $bean)
    {
        $bean->setFullName($_POST["full_name"]);
        $bean->setEmail($_POST["email"]);
        if ($_POST["password_is_changed"] == 1) {
            $salt = ChiperService::getNewSalt();
            $password = ChiperService::encryptDBPassword($_POST["password"], $salt);
            $bean->setSalt($salt);
            $bean->setPassword($password);
        }
        $bean->setEnabled( isset($_POST["enabled"])?1:-1);
        $bean->setIdAccessLevel($_POST["id_access_level"]);
    }

    /**
     * Gets a Model containinf access level table rows .
     *
     * @return Model Model containing  all access level table rows
     */
    public function getAccessLevelOptionsList(){
        $model = new Model();
        $model->sql = "SELECT id_access_level AS access_level_id, name AS access_level_name FROM access_level";
        $model->updateResultSet();
        return $model;
    }
}