<?php
/**
 * Class DataRepeater
 *
 * Populate a block's or content_id's variables with array's values or with model result
 * set.
 * The array containing source values must be an associative array having key's name
 * equals to variable's names inside the block.
 *
 * @extends Component
 * @filesource framework/DataRepeater.php
 * @package framework
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

namespace framework\components;
use framework\exceptions\BlockNotFoundException;
use framework\exceptions\VariableNotFoundException;
use framework\Model;
use framework\View;
class DataRepeater extends Component
{

    /**
     * @var string $currentContent The current parsed content
     */
    private $currentContent;

    /**
     * @var array $arrayValues The associative array containing vaules
     */
    private $arrayValues = array();

    /**
     * @var string Repeater type, default is "block"
     */
    private $repeaterType = "block";

    /**
     * @var bool $enableBinding enable or disable Component binding to PlaceHolder. Default is false
     */
    protected $enableBinding = false;

    /**
     * DataRepeater constructor.
     * Populate a block's or content_id's variables with array's values or with model result
     * set.
     * The array containing source values must be an associative array having key's name
     * equals to variable's names inside the block.
     *
     * @param View|null $view       The view reference
     * @param Model|null $model     The Model reference
     * @param null|string $block    The block name to parsing and assigning values from
     *                              Model or from the given $datalist. If no block is
     *                              given it does nothing
     * @param null|array $dataList  Array of values to assign to placeholders of the
     *                              given block (only if a block name was given). If
     *                              null use Model
     *
     */
    public function __construct(View $view=null, Model $model=null, $block=null,$dataList=null)
    {
        parent::__construct($view, $model);

        If(!empty($block) && !empty($dataList)){
            $this->setContentToBlock($block);
            $this->setValuesFromArray($dataList);
        } else if (!empty($block) && empty($dataList)){
            $this->setContentToBlock($block);
            $this->setValuesFromModel();
        }
    }

    /**
     * Sets the content for repeating with array's value to a block name from the View.
     *
     * @param string $block The view's block
     */
    public function setContentToBlock($block)
    {
        $this->currentContent = $block;
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
     * Sets the Model as array of values to assign to block.
     * Important !! Tables/Query column's names must be equals to variable's name
     * of current block/content_id.
     */
    public function setValuesFromModel()
    {
        $result = $this->model->getResultSet();
        $values = array();
        while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
            $values[] = $data;
        }

        if (!empty($values)) {
            $this->arrayValues = $values;
        } else {
            // Gets fiedls if empty resultset
            while ($data = $result->fetch_field()) {
                $tablefField = $data->name;
                $values[$tablefField] = "";
            }
            $noResult = array();
            $noResult[] = $values;
            $this->arrayValues = $noResult;
        }

    }

    /**
     * Renders the block content
     *
     * @throws BlockNotFoundException
     * @throws VariableNotFoundException
     */
    private function renderBlock()
    {

        if (!empty($this->currentContent) && !empty($this->arrayValues)) {
            $this->view->openBlock($this->currentContent);
            foreach ($this->arrayValues as $dataItem) {
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
        if ($this->repeaterType == "block") {
            $this->renderBlock();
        }
    }

}