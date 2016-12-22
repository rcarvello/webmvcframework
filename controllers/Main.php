<?php

namespace controllers;

use framework\Controller;
use framework\View;

class Main extends Controller
{
    public function autorun($parameter=null)
    {
        $view = new View("main");
        $this->setView($view);
    }
}
