<?php
/**
 * Class CustomersManager
 *
 * {ModelResponsability}
 *
 * @package models
 * @category Application Model
 * @author  {AuthorName} - {AuthorEmail}
 */

namespace models\wiki;

use framework\Model;

class CustomersManager extends Model
{
    /**
     * Object constructor.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Autorun method. Put your code here for running it after object creation.
     * @param mixed|array|null $parameters Additional parameters to manage
     *
     */
    protected function autorun($parameters = null)
    {

    }


    public function getCustomers()
    {
        // Notice: we use PHP HereDoc to specify SQL string
        $this->sql = <<<SQL
        SELECT 
            customer_id as CustomerID,
            name as CustomerName,
            email as CustomerEmail   
        FROM
            customer
        ORDER BY
            name;
SQL;
        $this->updateResultSet();
        // The mysqli result set already has the format:
        // array( array('CustomerID'=>'','CustomerName'=>'','CustomerEmail'=>''),)
        return $this->getResultSet();
    }
}
