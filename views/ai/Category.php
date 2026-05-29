<?php
/**
 * Class Category
 *
 * WebMVC assembly view for listing categories.
 *
 * @package views\ai
 * @category Application View
 */

namespace views\ai;

use framework\View;

class Category extends View
{
    /**
     * Object constructor.
     *
     * @param string|null $tplName The html template containing the static design.
     */
    public function __construct($tplName = null)
    {
        if (empty($tplName)) {
            $tplName = '/ai/category';
        }

        parent::__construct($tplName);
    }

    /**
     * Sets the ajax data endpoint url.
     *
     * @param string $url
     */
    public function setAjaxDataUrl($url)
    {
        $this->setVar('CategoryAjaxDataUrl', $url);
    }

    /**
     * Sets the base url used to open the category form.
     *
     * @param string $url
     */
    public function setCategoryFormBaseUrl($url)
    {
        $this->setVar('CategoryFormBaseUrl', $url);
    }

    /**
     * Sets the base url used to open the category products form.
     *
     * @param string $url
     */
    public function setCategoryProductsBaseUrl($url)
    {
        $this->setVar('CategoryProductsBaseUrl', $url);
    }

    /**
     * Sets the endpoint url used to save the category list order.
     *
     * @param string $url
     */
    public function setCategoryOrderUrl($url)
    {
        $this->setVar('CategoryOrderUrl', $url);
    }
}