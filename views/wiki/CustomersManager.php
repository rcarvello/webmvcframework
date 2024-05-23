<?php
/**
 * Class CustomersManager
 *
 * {ViewResponsability}
 *
 * @package controllers
 * @category Application View
 * @author  {AuthorName} - {AuthorEmail}
 */

namespace views\wiki;

use framework\View;

class CustomersManager extends View
{

    /**
     * Object constructor.
     *
     * @param string|null $tplName The html template containing the static design.
     */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/customers_manager";
        parent::__construct($tplName);
    }

    /**
     * Render CustomersList Block
     *
     * @param \mysqli_result $customers
     * @throws \framework\exceptions\BlockNotFoundException
     * @throws \framework\exceptions\NotInitializedViewException
     * @throws \framework\exceptions\VariableNotFoundException
     */
    public function setCustomersBlock(\mysqli_result $customers)
    {
        if ($customers->num_rows > 0) {
            $this->hide("NoCustomers");
            $this->openBlock("CustomersList");
            while ($customer = $customers->fetch_object()) {
                $this->setVar("CustomerID", $customer->CustomerID);
                $this->setVar("CustomerName", $customer->CustomerName);
                $this->setVar("CustomerEmail", $customer->CustomerEmail);
                $this->parseCurrentBlock();
            }
            $this->setBlock();
        } else {
            $this->hide("CustomersList");
        }
    }
}
