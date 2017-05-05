<?php

namespace controllers\examples\cms;
use framework\Controller;
use models\examples\cms\HelloWorld as HelloWorldModel;
use views\examples\cms\HelloWorld as HelloWorldView;

class HelloWorld extends Controller
{

    protected function autorun($parameters = null)
    {
        $this->model = new HelloWorldModel();
        $this->view = new HelloWorldView();
        $modelData = $this->model->getMessage();
        // $message = empty($parameters) ? $modelData : $parameters;
        $this->view->setMessage($modelData);
    }

}
