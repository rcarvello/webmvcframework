<?php
/**
 * Class Globalize
 *
 *  Replacement of Global PlaceHolders variables located inside a content,
 *  typically an HTML template, with user predefined PHP constant.
 *
 *  A global variable is in the format {GLOBAL:ConstantVariableName}.
 *  ConstantVariableName must match the name of a predefined PHP constant.
 *
 *  Example:
 *
 *  {GLOBAL:ConstantVariableName}
 *       wil be replaced with
 *  define("ConstantVariableName","AValue"}
 *
 * @package framework\classes
 * @filesource framework\classes\Globalize.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @see framework/Record
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework\classes;

class Globalize
{
    private $content;
    private $placeholders = array();

    public function __construct($content)
    {
        $this->checkGlobals($content);
        $this->content = $content;
        if (!empty($this->placeholders)) {
            $this->replaceWithGlobals();
        }
    }

    /**
     * Creates placeholders array containing {GLOBAL:*} variables.
     *
     * @param string $content
     */
    private function checkGlobals($content)
    {
        $regexForGlobalPlaceHolder = "/\{(GLOBAL:.*?)\}/s";
        preg_match_all($regexForGlobalPlaceHolder, $content, $result);
        $this->placeholders = $result[1];
    }

    /**
     * Applies the replacements to GLOBAL: placeholders
     */
    private function replaceWithGlobals()
    {
        foreach ($this->placeholders as $placeholder) {
            $variableName = "{" . $placeholder . "}";
            $constantName = str_replace("GLOBAL:", "GLOBAL_", $placeholder);
            $value = @constant($constantName);
            $this->content = str_replace($variableName, $value, $this->content);
        }
    }

    /**
     * Gets the content with replacements.
     *
     * @return string content
     */
    public function getContent()
    {
        return $this->content;
    }

}