<?php
/**
 * Class Login
 *
 * Generic Login Form Controller
 *
 * @package controllers\common
 * @category Application Controller
 * @author  Rosario Carvello - rosario.carvello@gmail.com
 *
 * @uses \framework\User
 * @uses framework\classes\ChiperService
 *
*/
namespace controllers\common;

use framework\Controller;
use framework\Model;
use framework\View;

use framework\User as  LoginModel;
use framework\classes\ChiperService;
use views\common\Login as LoginView;

class Login extends Controller
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
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view,$this->model);
    }

    /**
    * Autorun method.
     *
    * @param mixed|null $parameters Parameters to manage
    *
    */
    protected function autorun($parameters = null)
    {
        // Handles login form submission
        if (isset($_POST["login_form_do_cancel"])){
            header("Location: " . SITEURL);
        } elseif (isset($_POST["login_form_do_login"])) {
            $this->configCookies();
            $email = $_POST["email"];
            $password = $_POST["password"];
            $this->model->login($email,$password);
            if ($this->model->isLogged()) {
               $this->hide("LoginErrorMessage");
               $returnPage = (isset($_GET["return_link"])) ? SITEURL . "/" . $_GET["return_link"] : SITEURL;
               header("Location:". $returnPage);
            }
        } elseif (isset($_POST["login_form_do_logout"])) {
            $this->model->logout();
            header("Location:". SITEURL);
        } else {
            $this->hide("LoginErrorMessage");
        }

        $this->evaluateLoginAndGrantStatus();
    }

    public function evaluateLoginAndGrantStatus(){

        $hasGrant = isset($_REQUEST["login_warning_message"]) ? false: true;
        if ($this->model->isLogged() && $hasGrant) {
            $this->hide("LoginButton");
            $this->hide("LoginInputs");
            $this->hide("RememberMe");
        } else   {
            $this->hide("LogoutButton");
            $this->hide("IsLoggedInfo");
        }
    }

    /**
     * Creates cookie for the login credentials if user
     * check remember me.
     *
     * Note:
     * It uses ChiperService for Cookie encryption.
     *
     * @uses ChiperService
     */
    protected function configCookies()
    {
        if (isset($_POST["remember_me"])){
            $email = $_POST["email"];
            $password = $_POST["password"];
            if (!empty($email) && !empty($password)) {
                $chiper = new ChiperService();
                $chiper->setCredentialsCookie($email, $password);
            }
        }
    }

    /**
    * Inizialize the View by loading static design of /common/login.html.tpl
    * managed by views\common\Login class
    *
    */
    public function getView()
    {
        $view = new LoginView("/common/login");
        return $view;
    }

    /**
    * Inizialize the Model by loading models\common\Login class
    *
    */
    public function getModel()
    {
        $model = new LoginModel();
        return $model;
    }

}
