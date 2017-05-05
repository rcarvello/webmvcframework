<?php

namespace models\examples\db;

use framework\Model;

class PartList extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->sql = "SELECT * FROM part";
        $this->updateResultSet();
    }

}
