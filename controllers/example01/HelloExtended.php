<?php


namespace controllers\example01;

use framework\Model;
use framework\View;

class HelloExtended extends \controllers\example01\Hello
{

    public function __construct(View $view=null, Model $model=null)
    {
        parent::__construct($this->view,$this->model);
        $this->setList();
    }

    /**
     * Overrides parent InitView
     * @return \views\example01\Hello
     */
    public function getView()
    {
        $view = parent::getView();
        // Overriding the template with a new one containing html for listing items
        $view->loadCustomTemplate("templates/example01/hello_extended");
        return $view;
    }

    public function setList()
    {
        $listItems = $this->getModel()->getElements();
        $this->view->openBlock("ListItems");
        foreach($listItems as $item){
            $this->view->setVar("Item",$item);
            $this->view->parseCurrentBlock();
        }
        $this->view->setBlock();
    }

    public function hideList()
    {
        parent::autorun(null);
        $this->hide("ListItems");
        $this->render();
    }
}