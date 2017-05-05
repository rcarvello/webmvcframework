<?php

namespace controllers\examples\cms;

use framework\components\DataRepeater;

class BlockExtended extends Block
{
   public function autorun($parameters = null)
   {
       $this->view->loadCustomTemplate("templates/examples/cms/block_extended");
       $this->view->setVar("SITEURL",SITEURL);
       parent::autorun($parameters);
       if (empty($parameters))
        $this->hide("DisallowMessage");
   }

    public function hideUsers(){
        $this->autorun();
        $this->hide("ContentUsers");
        $this->render();
    }

    public function disallowUsers(){
        $this->autorun("ShowDisallowMessageBlock");

        // You can also replace ContentUsers content
        $this->view->openBlock("ContentUsers");
        $this->view->setBlock("Empty list");

        $this->render();
    }


}