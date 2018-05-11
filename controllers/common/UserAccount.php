<?php
/**
 * Class UserAccount
 *
 * Manages user record
 *
 * @package controllers\common
 * @category Application Controller
 * @author  Rosario Carvello - rosario.carvello@gmail.com
*/
namespace controllers\common;

use framework\Controller;
use framework\Model;
use framework\User;
use framework\View;
use models\beans\BeanUser;
use models\common\UserAccount as UserModel;
use views\common\UserAccount as UserView;
use framework\components\Record;
use framework\BeanAdapter;
use controllers\hr\common\NavigationBar;

class UserAccount extends Controller
{
    protected $view;
    protected $model;
    private $currentLoggedUser;
    private $currentEditingUser;
    private $onlyCurrent = false;
    private $isAdmin = false;
    /**
    * Object constructor.
    *
    * @param View $view
    * @param Model $mode
    */
    public function __construct(View $view=null, Model $model=null)
    {
        // Computes variables to store current edited record
        // and current logged user
        $user = new User();
        $this->currentLoggedUser = $user->getId();
        @$this->currentEditingUser = $_GET["id_user"];

        // Grants access to non admin only on editing its own record
        if ($this->currentLoggedUser == $this->currentEditingUser ) {
            // $this->grantRole(50);
            // $this->grantRole(60);
            $nonAdminRoles = $user->query("SELECT " . USER_ROLE . " FROM ". USER_TABLE . " WHERE " . USER_ROLE . "!=" . ADMIN_ROLE_ID);
            if ($nonAdminRoles){
                while ($role=$nonAdminRoles->fetch_array()){
                    $this->grantRole($role[0]);
                }
            }
            $this->onlyCurrent = true;
        }

        // Computes if current user is admin
        if ($user->getRole()==100)
            $this->isAdmin = true;

        $this->grantRole(100);
        $this->restrictToRBAC(null,"common/user_accounts",LoginRBACWarningMessage);
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view,$this->model);
        $nav = new NavigationBar();
        $this->bindController($nav);
    }

    /**
    * Autorun method. Put your code here for running it after object creation.
    * @param mixed|null $parameters Parameters to manage
    *
    */
    protected function autorun($parameters = null)
    {
        $options = $this->model->getAccessLevelOptionsList();
        $this->view->renderAccessLevelOptionsList($options);
        $this->buildRecord();
        if ($this->onlyCurrent && !$this->isAdmin){
            $this->view->setVar("NoUpdate","hide");
        } else {
            $this->view->setVar("NoUpdate","");
        }
    }

    /**
     * Builds Record component for UserAccount forms.
     */
    protected function buildRecord()
    {
        $record = new Record();

        // Customizes the record components
        $record->setName("UserRecord");
        $record->registerPkUrlParameter("id_user");

        // Gets current record
        $currentRecord = $record->getCurrentRecord();

        // Sets history back for button close and delete
        // Note: for non admin temporary granted on editing its own
        // record history back is setted to home
        $historyBack = $record->getControllerHistoryBack("user_accounts");
        if ($this->onlyCurrent && !$this->isAdmin)
            $historyBack = SITEURL . "/hr/home";

        $record->redirectAfterClose = $historyBack;
        $record->redirectAfterDelete = $historyBack;
        $record->redirectAfterAdd =$historyBack;
        $record->redirectAfterUpdate=$historyBack;

        // Hides when non admin temporary granted on editing
        // its own record
        if ($this->onlyCurrent && !$this->isAdmin) {
            $record->allowAdd =false;
            $record->allowDelete =false;
        }

        // Sets disallow mode
        $record->disallowMode = $record::DISALLOW_MODE_WITH_HIDE;

        // Instantiates Bean and BeanAdpter for handling Record actions
        $bean = new BeanUser();
        $beanAdapter = new BeanAdapter($bean);
        $beanAdapter->select($currentRecord);

        // Handles form submission and updates the bean attributes
        // with posted data
        // Note Put your business data validation rules here before.
        // If  there were Business Validation Errors use : init($beanAdapter,null,true);
        if ($record->isSubmitted()) {
            $customValidationErrors = $this->customValidation($record);
            $this->model->setBeanWithPostedData($bean);
        } else {
            $customValidationErrors = false;
            $record->redirectOnEmpyEdit($bean);
        }

        // Initializes record component with its BeanAdapter and (automatically) with its managed Bean
        $record->init($beanAdapter,null,$customValidationErrors);

        // Binding Record Component to the view (without rendering)
        $this->bindComponent($record,false);

        // Set others view fields values with bean data
        $this->view->setFieldsWithBeanData($bean);

        // Processes record errors
        $this->view->parseErrors($record->getErrors());

    }


    /**
     * Funzione open: Apre la schermata relativa al record dei dati anagrafici associato all'id dipendente selezionato dall'utente.
     */
    public function open($pk=null)
    {
        $_GET["id_user"] = $pk;
        $this->currentEditingUser = $pk;
        $this->autorun();
        $this->render();
    }

    /**
     * Funzione add: Viene invocata quando l'utente vuole inserire un nuovo dipendente.
     */
    public function add($dummy)
    {
        $this->autorun();
        $this->render();
    }

    /**
     * Custom server side validations
     * @param Record $record
     * @return bool return true if error cccurs else false
     */
    private function customValidation(Record $record)
    {
        $isError = false;
        if ($record->isSubmitted()){
            // Checks password /confirmation matching if changing user password
            if ($_POST["password_is_changed"]==1){
                if ( $_POST["password"] != $_POST["re_password"]){
                    $record->addError("{RES:PasswordDoesntMatch}");
                    return true;
                }
            }

            // Checks constraints when editing builtin admin
            if ($_POST["id_user"]==1) {
                if ($_POST["id_access_level"]!=100) {
                    $record->addError("{RES:CannotEditBuiltInPermission}");
                    $isError = true;
                } elseif(!isset($_POST["enabled"])){
                    $record->addError("{RES:CannotEditBuiltInStatus}");
                    $isError = true;
                } elseif ($_POST[$record::DELETE]) {
                    $record->addError("{RES:CannotDeleteBuiltIn}");
                    $isError = true;
                } else {
                    $isError = false;
                }
            } else {
                $isError = false;
            }
        }
        return $isError;
    }

    /**
    * Inizialize the View by loading static design of /common/user.html.tpl
    * managed by views\common\User class
    *
    */
    public function getView()
    {
        $view = new UserView("/common/user_account");
        return $view;
    }

    /**
    * Inizialize the Model by loading models\common\User class
    *
    */
    public function getModel()
    {
        $model = new UserModel();
        return $model;
    }
}
