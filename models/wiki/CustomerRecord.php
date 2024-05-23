<?php
/**
 * Class CustomerRecord
 *
 * {ModelResponsability}
 *
 * @package models
 * @category Application Model
 * @author  {AuthorName} - {AuthorEmail}
 */

namespace models\wiki;

use models\beans\BeanCustomer;

class CustomerRecord extends BeanCustomer
{
    /**
     * Get the list of allowed nationalities for a customer.
     *
     * @return array Array of nationalities
     */
    public function getCustomerNationalitiesList()
    {
        return array(
            array("it", "Italian"),
            array("out", "Guest")
        );
    }

    /**
     * Get the list of allowed assurances level for a customer.
     *
     * @return array Array of assurances level
     */
    public function getCustomerAssurancesList()
    {
        return array(
            array("1", "Low"),
            array("2", "Middle"),
            array("3", "High"),
        );
    }
}
