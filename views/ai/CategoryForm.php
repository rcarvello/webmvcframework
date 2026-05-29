<?php
/**
 * Class CategoryForm
 *
 * WebMVC assembly view for editing category records.
 *
 * @package views\ai
 * @category Application View
 */

namespace views\ai;

use framework\View;
use models\beans\BeanCategory;

class CategoryForm extends View
{
    /**
     * Object constructor.
     *
     * @param string|null $tplName The html template containing the static design.
     */
    public function __construct($tplName = null)
    {
        if (empty($tplName)) {
            $tplName = '/ai/category_form';
        }

        parent::__construct($tplName);
    }

    /**
     * Sets form fields with bean data.
     *
     * @param BeanCategory $bean
     */
    public function setFieldsWithBeanData(BeanCategory $bean)
    {
        if ($bean->getCategoryId() == null) {
            $this->setVar('FormTitle', 'New Category');
            $this->setVar('readonly', 'readonly');
        } else {
            $this->setVar('FormTitle', 'Edit Category: ' . $bean->getCategoryName());
            $this->setVar('readonly', 'readonly');
        }

        $this->setVar('category_id', $bean->getCategoryId());
        $this->setVar('category_name', $bean->getCategoryName());
        $this->setVar('list_order', $bean->getListOrder());
    }
}