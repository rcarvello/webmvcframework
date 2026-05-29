<?php
/**
 * Class Product
 *
 * WebMVC assembly view for editing product records.
 *
 * @package views\ai
 * @category Application View
 */

namespace views\ai;

use framework\View;
use models\beans\BeanProduct;

class Product extends View
{
    /**
     * Object constructor.
     *
     * @param string|null $tplName The html template containing the static design.
     */
    public function __construct($tplName = null)
    {
        if (empty($tplName)) {
            $tplName = '/ai/product';
        }

        parent::__construct($tplName);
    }

    /**
     * Sets form fields with bean data.
     *
     * @param BeanProduct $bean
     */
    public function setFieldsWithBeanData(BeanProduct $bean)
    {
        if ($bean->getProductId() == null) {
            $this->setVar('FormTitle', '{RES:New_Record}');
            $this->setVar('readonly', 'readonly');
        } else {
            $this->setVar('FormTitle', '{RES:Edit_Record}: ' . $bean->getProductName());
            $this->setVar('readonly', 'readonly');
        }

        $this->setVar('product_id', $bean->getProductId());
        $this->setVar('product_name', $bean->getProductName());
        $this->setVar('category_id', $bean->getCategoryId());
        $this->setVar('list_order', $bean->getListOrder());
    }
}
