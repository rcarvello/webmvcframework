<?php

namespace views\examples\cms;

use framework\View;

class HelloWorld extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/examples/cms/hello_world";
        parent::__construct($tplName);
    }

    /**
     * Set  Message PlaceHolder with a given value
     *
     * @param string $msg
     */
    public function setMessage($msg){
        $this->setVar("Message",$msg);
    }
    
}
