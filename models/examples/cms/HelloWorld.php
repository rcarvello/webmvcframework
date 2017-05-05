<?php

namespace models\examples\cms;

use framework\Model;

class HelloWorld extends Model
{
    /**
     * Gets a simple message.
     * @return string
     */
    public function getMessage()
    {
        return "Hello 2 World from PHP Web MVC Framework";
    }
}
