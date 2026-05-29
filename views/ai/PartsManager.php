<?php
/**
 * Class PartsManager
 *
 * PartsManager WebMVC assembly view for listing parts.
 *
 * @package views\ai
 * @category Application View
 */

namespace views\ai;

use framework\View;

class PartsManager extends View
{
    /**
     * Object constructor.
     *
     * @param string|null $tplName The html template containing the static design.
     */
    public function __construct($tplName = null)
    {
        if (empty($tplName)) {
            $tplName = '/ai/parts_manager';
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
        $this->setVar('PartsManagerAjaxDataUrl', $url);
    }
}