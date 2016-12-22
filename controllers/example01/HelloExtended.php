<?php


namespace controllers\example01;

use framework\View;
class HelloExtended extends \controllers\example01\Hello
{

    protected function initView()
    {
        $view = parent::initView();
        $view->loadCustomTemplate("templates/example01/hello_extended");
        $this->setList($view);
        return $view;
    }

    private function setList(View $view)
    {
        $listItems = array("item a", "item b", "item c");
        $view->openBlock("ListItems");
        foreach($listItems as $item){
            $view->setVar("Item",$item);
            $view->parseCurrentBlock();
        }
        $view->setBlock();
    }

    public function hideList()
    {
        parent::autorun(null);
        $this->hide("ListItems");
        $this->render();
    }
}