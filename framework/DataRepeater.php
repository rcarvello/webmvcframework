<?php
/**
 * Class DataRepeater
 *
 * Populate a block's or content_id's variables with array's values or with model result
 * set.
 * Array for source values must be an associative array having key's name equals to
 * variable's names inside the block.
 *
 * @extends Component
 * @filesource DataRepeater.php
 * @package framework
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD Public License.
 */
namespace framework;

class DataRepeater extends Component
{

    private $currentContent;
    private $arrayValues = array();
    private $repeaterType = "block";
    protected $enableBinding = false;


    /**
     * Sets the content for repeating with array's value to a block name from the View.
     *
     * @param string $block The view's block
     */
    public function setContentToBlock($block)
    {
      $this->currentContent=$block;
        $this->repeaterType = "block";
    }

    /**
     * Sets an associative array as values to assign to block.
     *
     * @param array $dataList The associative array having key's name equals
     * to variable's name present inside the block.
     */
    public function setValuesFromArray($dataList)
    {
        $this->arrayValues = $dataList;
    }

    /**
     * Sets the Model record set as values to assign to block. Tables/Query column's names
     * must be equals to variable's name of current block/content_id.
     */
    public function setValuesFromModel(){
        $result = $this->model->getResultSet();
        $values = array();
        while ($data = $result->fetch_array(MYSQL_ASSOC) ) {
            $values[] = $data;
        }
        $this->arrayValues = $values;
    }

    /**
     * Renders block content
     * @throws BlockNotFoundException
     * @throws VariableNotFoundException
     */
    private function renderBlock()
    {

        if (!empty($this->currentContent) && !empty($this->arrayValues)){
            $this->view->openBlock($this->currentContent);
            foreach($this->arrayValues as $dataItem){
                foreach ($dataItem as $key => $value) {
                    $this->view->setVar($key, $value);
                }
                $this->view->parseCurrentBlock();
            }
            $this->view->setBlock();
        }
    }

    /**
     * Renders the component
     */
    public function render()
    {
        if ($this->repeaterType == "block"){
            $this->renderBlock();
        }
    }


}