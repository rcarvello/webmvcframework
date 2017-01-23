<?php

/**
 * Class MVCMySqlSimpleTemplate
 * Provides all necessary functionality for parsing and processing the template defined for the class source code.
 * Responsability:
 *
 *  - Loads the template defined as structural content for the class source code
 *  - Parses and processes its blocks, sub-blocks and variables by replacing them with data managed by MVCMySqlBeanBuilder
 *  - Gets the processed content ... the source code :-)
 *
 * @filesource MVCMySqlSimpleTemplate.php
 * @category Framework Utility
 * @package util\mysqlreflection
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version CVS: v1.0.0
 * @uses file MVCMySqlBeanClass.php.tpl
 * @see file MVCMySqlBeanClass.php.tpl
 * @note This class is extracted from my personal MVC Framework.
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved .  See License.txt file
 * @license BSD
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD Public License.
 */
class MVCMySqlSimpleTemplate
{

    /**
     * @var string Stores the processed content
     */
    private $processedContent;

    /**
     * @var string Stores the template content
     */
    private $template;

    /**
     * @var string Store the block content (not processed)
     */
    private $block;

    /**
     * Constructor
     * @param string $template the template file name
     * @return MVCMySqlSimpleTemplate object
     */
    public function __construct($template)
    {
        $this->template = @file_get_contents($template);
    }

    /**
     * setBlock
     * Sets a block for processing
     * @param string $block The name of the block which is defined into the template file
     * @param bool $isContent If is true the $block given is not a template's block but a real content previously processed
     */
    public function setBlock($block,$isContent=false)
    {
        if (!$isContent) {
            $regex = "/\<\!-- BEGIN $block --\>(.*?)\<\!-- END $block --\>/s";
            preg_match_all($regex, $this->template, $result);
            // var_dump($result);
            @$block = $result[1][0];
            $this->block = $block;

        } else {
            $this->block = $block;
        }
    }

    /**
     * setInnerBlock
     * Processes the content of sub block.
     *
     * Replaces the sub-block template content with a single placeholder, the given $varname
     * @param string $block the sub-block name which is defined into the template file
     * @param string $varName the placeholder name to replace into sub-block
     */
    public function setInnerBlock($block,$varName)
    {
        $regex = "/\<\!-- BEGIN $block --\>(.*?)\<\!-- END $block --\>/s";
        preg_match_all($regex, $this->block, $result);
        $content = $result[1][0];
        $this->block = str_replace($content,"{".$varName."}", $this->block);
        $this->block = str_replace("<!-- BEGIN $block -->","", $this->block);
        $this->block = str_replace("<!-- END $block -->","", $this->block);
    }

    /**
     * setVar
     * Replace a placeholder of current block with a given value
     * @param string $var the placeholder, alias the variable name
     * @param string $value the value to replace
     */
    public function setVar($var,$value = "")
    {
        $this->block= str_replace("{" . $var . "}", $value, $this->block);
    }

    /**
     * Gets a child block of the current block
     * @param string $block the sub-block name which is defined into the template file
     * @return string The template structure for the given sub-block
     */
    public function getInnerBlock($block)
    {
        $regex = "/\<\!-- BEGIN $block --\>(.*?)\<\!-- END $block --\>/s";
        preg_match_all($regex, $this->block, $result);
        $content = $result[1][0];
        return $content;
    }

    /**
     * get
     * Gets the global processed content from template or the partial processed content from the current block
     * @param bool $currentBlock if true the output is of the processed content from the current block
     * @return string containing the processed content
     */
    public function get($currentBlock = false)
    {
        if ($currentBlock){
            return $this->block;
        } else {
            return $this->processedContent;
        }
    }

    /**
     * parse
     * Parses the current blocks and its variables by generating, step by step, the global content.
     * You must invoke this function to closing a block, generating its content and by adding it to the global
     * previously generated content (by a previously invocation of this method)
     */
    public function parse()
    {
        $this->processedContent = $this->processedContent . $this->block;
    }
}