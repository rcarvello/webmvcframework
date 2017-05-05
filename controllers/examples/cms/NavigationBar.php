<?php

namespace controllers\examples\cms;

use framework\Controller;
use views\examples\cms\NavigationBar as NavigationBarView;
use framework\classes\Common;
class NavigationBar extends Controller
{

    protected function autorun($parameters = null)
    {
        $this->view = new NavigationBarView();
        // $path = Common::PathToRoot();
    }

}
