<?php

namespace controllers\examples\cms;

use framework\Controller;
use models\examples\cms\HelloWorld as HelloWorldModel;
use views\examples\cms\HelloWorld as HelloWorldView;

class HelloWorld extends Controller
{

    protected function autorun($parameters = null)
    {
        // Uses a Model
        $this->model = new HelloWorldModel();

        // Uses a View
        $this->view = new HelloWorldView();

        // Gets some data from Model
        $modelData = $this->model->getMessage();

        // Run some method of the View by passing it some data (from Model)
        $this->view->setMessage($modelData);
    }

}
