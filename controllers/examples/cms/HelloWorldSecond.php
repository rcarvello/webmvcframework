<?php

namespace controllers\examples\cms;

use framework\Controller;
use models\examples\cms\HelloWorld as HelloWorldModel;
use views\examples\cms\HelloWorld as HelloWorldView;
use Exception;

class HelloWorldSecond extends Controller
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model = new HelloWorldModel();
        $this->view = new HelloWorldView();
        $this->view->loadCustomTemplate("templates/examples/cms/hello_world_second");
        parent::__construct($this->view,$this->model);
    }

    /**
     * Autorun method. Put your code here for running it after object creation.
     * @param mixed|array|null $parameters Additional parameters for generic purpose.
     *
     */
    protected function autorun($parameters = null)
    {
        $modelData = $this->model->getMessage();
        $message = empty($parameters) ? $modelData : $parameters;
        $this->view->setMessage($message);

        try {
            $this->view->setVar("SITEURL",SITEURL);
        } catch (Exception $e) {
        }


    }

    /**
     * Sets a mobile GUI
     * @param null $withMessage If present show it as a message
     */
    public function mobile($withMessage=null)
    {
        $this->view->loadCustomTemplate("templates/examples/cms/hello_world_mobile");
        $this->autorun($withMessage);
        $this->render();
    }

    /**
     * Shows the given message
     * @param string $m
     */
    public function message($m)
    {
        $this->autorun($m);
        $this->render();
    }

}
