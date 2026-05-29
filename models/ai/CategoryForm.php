<?php
/**
 * Class CategoryForm
 *
 * WebMVC assembly model for editing category records.
 *
 * @package models\ai
 * @category Application Model
 */

namespace models\ai;

use framework\Model;
use models\beans\BeanCategory;

class CategoryForm extends Model
{
    /**
     * Updates the bean with posted form data.
     *
     * @param BeanCategory $bean
     */
    public function setBeanWithPostedData(BeanCategory $bean)
    {
        if (isset($_POST['category_id']) && $_POST['category_id'] !== '') {
            $bean->setCategoryId($_POST['category_id']);
        }

        $bean->setCategoryName(@$_POST['category_name']);
        $bean->setListOrder(@$_POST['list_order']);
    }
}