<?php
/**
 * Class UserAccounts
 *
 * Browsing user accounts
 *
 * @package controllers\common
 * @category Application Controller
 * @author  Rosario Carvello - rosario.carvello@gmail.com
*/
namespace controllers\common;

use framework\Controller;
use framework\Model;
use framework\View;
use models\common\UserAccounts as UserAccountsModel;
use views\common\UserAccounts as UserAccountsView;
use framework\components\DataRepeater;

class UserAccounts extends Controller
{
    protected $view;
    protected $model;

    /**
    * Object constructor.
    *
    * @param View $view
    * @param Model $mode
    */
    public function __construct(View $view=null, Model $model=null)
    {
        $this->grantRole(ADMIN_ROLE_ID);
        $this->restrictToRBAC(null,"common/user_accounts",LoginRBACWarningMessage);
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view,$this->model);
    }

    /**
    * Autorun method. Put your code here for running it after object creation.
    *
    * @param mixed|null $parameters Parameters to manage
    *
    */
    protected function autorun($parameters = null)
    {
        if ($this->model->getResultSet()->num_rows !=0) {
            $userAccounts = new  DataRepeater($this->view, $this->model, "UserAccounts", null);
            $this->bindComponent($userAccounts);
        } else {
            $this->hide("UserAccounts");
        }
    }

    /**
    * Inizialize the View by loading static design of /common/user_accounts.html.tpl
    * managed by views\common\UserAccounts class
    *
    */
    public function getView()
    {
        $view = new UserAccountsView("/common/user_accounts");
        return $view;
    }

    /**
    * Inizialize the Model by loading models\common\UserAccounts class
    *
    */
    public function getModel()
    {
        $model = new UserAccountsModel();
        return $model;
    }
}
