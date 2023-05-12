<?php
/**
 * Class CaptchaComponent
 *
 * {ControllerResponsability}
 *
 * @package controllers\examples\cms
 * @category Application Controller
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace controllers\examples\cms;

use framework\Controller;
use framework\Model;
use framework\View;
use models\examples\cms\CaptchaComponent as CaptchaComponentModel;
use views\examples\cms\CaptchaComponent as CaptchaComponentView;
use framework\components\Captcha;
class CaptchaComponent extends Controller
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
        $this->grantRole(100);
        //$this->restrictToRBAC("","examples/cms/captcha_component","Restricted");

        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view,$this->model);
    }

    /**
    * Autorun method. Put your code here for running it after object creation.
    * @param mixed|null $parameters Parameters to manage
    *
    */
    protected function autorun($parameters = null)
    {

        $theCaptcha = new Captcha();
        if (isset($_REQUEST["action"])){
            $verificationCode = $_REQUEST['captcha_code_verification'];
            $currentCaptcha= $theCaptcha->getCaptcha();
            $verification= $currentCaptcha::verifyCaptchaCode($verificationCode);
            if ($verification){
                $this->view->setVar("VerificationStatus","Verification passed");
            } else {
                $this->view->setVar("VerificationStatus","Verification fail");
            }
        } else {
            $this->view->setVar("VerificationStatus","");
        }

        $theCaptcha->captchaServiceEndpoint = "examples/cms/captcha_component/reloadCaptcha";
        $theCaptcha->setName("TheCaptcha");
        $theCaptcha->generateCaptcha();
        $this->bindComponent($theCaptcha,false);
    }


    public function reloadCaptcha()
    {
        $theCaptcha = new Captcha();
        $theCaptcha->getCaptcha()->initialize();
        $img = $theCaptcha->getCaptcha()->generateCaptcha();
        echo $img;
    }

    /**
    * Inizialize the View by loading static design of /examples/cms/captcha_component.html.tpl
    * managed by views\examples\cms\CaptchaComponent class
    *
    */
    public function getView()
    {
        $view = new CaptchaComponentView("/examples/cms/captcha_component");
        return $view;
    }

    /**
    * Inizialize the Model by loading models\examples\cms\CaptchaComponent class
    *
    */
    public function getModel()
    {
        $model = new CaptchaComponentModel();
        return $model;
    }
}
