<?php
/**
 * Class Products
 *
 * WebMVC assembly view for browsing products.
 *
 * @package views\ai
 * @category Application View
 */

namespace views\ai;

use framework\View;

class Products extends View
{
    /**
     * Object constructor.
     *
     * @param string|null $tplName The html template containing the static design.
     */
    public function __construct($tplName = null)
    {
        if (empty($tplName)) {
            $tplName = '/ai/products';
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
        $this->setVar('ProductsAjaxDataUrl', $url);
    }

    /**
     * Sets the base url used to open the product form.
     *
     * @param string $url
     */
    public function setProductFormBaseUrl($url)
    {
        $this->setVar('ProductFormBaseUrl', $url);
    }
}
