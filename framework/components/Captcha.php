<?php
/**
 * Captcha Component
 * Generates a captcha anti BOT
 *
 * @package framework/components
 * @filesource framework/components/Captcha.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

namespace framework\components;
use framework\Model;
use framework\View;
use framework\classes\Captcha as CaptchaClass;

class Captcha extends  Component
{

    private $captcha;
    protected $enableBinding = true;
    public $captchaServiceEndpoint;

    public function __construct(View $view = null, Model $model = null)
    {
        if ($view == null) {
            $tpl = "framework/resources/components/captcha";
            $view = new View();
            $view->loadCustomTemplate($tpl);
        }
        $this->captcha = new CaptchaClass();
        parent::__construct($view,$model);
    }



    public function generateCaptcha()
    {
        $this->captcha->initialize();
        $captchaImage =  $this->captcha->generateCaptcha();
        $this->view->setVar("CaptchaCode",$captchaImage);
        $this->view->setVar("CAPTCHA_RELOAD_SERVICE_ENDPONT",$this->captchaServiceEndpoint);

    }

    public function getCaptcha()
    {
        return $this->captcha;
    }




}