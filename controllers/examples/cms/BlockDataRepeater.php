<?php

namespace controllers\examples\cms;

use framework\components\DataRepeater;
class BlockDataRepeater extends Block
{
    public function autorun($parameters = null)
    {

        $users = $this->getModel()->getUsers();

        $repeater = new DataRepeater();

        // Share the view with component
        $repeater->setView($this->view);

        // Set the block
        $repeater->setContentToBlock("Users");

        // Binds array values to the block. (ONLY IF BLOCK PLACEHOLDERS NAME = ARRAY KEYS)
        $repeater->setValuesFromArray($users);

        // Shortcut
        //$repeater = new DataRepeater($this->view,null,"Users",$users);

        // Renders block
        $repeater->render();

        $this->view->setVar("Message",".. but now we are using the Data Repeater Component and the inheritance of the \"Block\" controller");

    }
}