<?php
/**
 * Tree Structure Component
 * Generates a browsable tree structure of parent/child nodes
 *
 * @package framework/components
 * @filesource framework/components/TreeStructure.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

namespace framework\components;

use framework\Controller;
use framework\View;
use framework\Model;
use framework\exceptions\MVCException;

class TreeStructure extends Component
{
    protected $enableBinding = true;

    private $nodeTpl;
    private $openContainer;
    private $closeContainer;
    private $showNodeLink = true;
    private $showNodeLevel = true;

    private $nodeIdField = "node_id";
    private $nodeParentIdField = "node_parent_id";
    private $nodeLinkField = "node_link";
    private $nodeDescriptionField = "node_description";

    private $tree = array();

    /**
     * TreeStructure constructor.
     *
     * @param View|null $view
     * @param Model|null $model
     * @throws \framework\exceptions\BlockNotFoundException
     * @throws \framework\exceptions\NotInitializedViewException
     * @throws \framework\exceptions\TemplateNotFoundException
     */
    public function __construct(View $view = null, Model $model = null)
    {
        if ($view == null) {
            $tpl = "framework/resources/components/tree_structure";
            $view = new View();
            $view->loadCustomTemplate($tpl);

        }
        parent::__construct($view, $model);

        $this->view->openBlock("Node");
        $this->nodeTpl = $this->view->parseCurrentBlock();
        $this->view->setBlock();

        $this->view->openBlock("OpenContainer");
        $this->openContainer = $this->view->parseCurrentBlock();
        $this->view->setBlock();

        $this->view->openBlock("CloseContainer");
        $this->closeContainer = $this->view->parseCurrentBlock();
        $this->view->setBlock();

    }

    /**
     * Init JS and CSS of component
     * @return void
     */
    public function initCCSJS(Controller $controller, View  $view)
    {
        $headCSS="    <!-- Include Framework CSS Tree -->
    <link href=\"{GLOBAL:SITEURL}/framework/resources/css/component/tree.css\" rel=\"stylesheet\" media=\"screen\">
</head>";
        $bodyJS="<!-- Include Framework JS Tree -->
<script src=\"{GLOBAL:SITEURL}/framework/resources/js/components/tree.js\"></script>
</body>";

        $content = $controller->get();
        // $view = $controller->getView();
        $html = str_replace("</head>",$headCSS,$content);
        $html = str_replace("</body>",$bodyJS,$html);
        $view->replaceTpl($html);
    }
    /**
     * Builds the tree structure
     * @param array|null $elements The data elements, If null it uses Model
     * @param int $rootId Starting root node ID for building Tree. Default is 0
     * @param int $level Starting depth level. Default is 0
     * @return array
     * @throws MVCException
     */
    public function buildTree(array $elements = null, $rootId = 0, $level = 0)
    {
        $branch = array();
        if (empty($elements))
            $elements = $this->model->getResultSet();
        $this->checkElements($elements);
        foreach ($elements as $element) {
            if ($element[$this->nodeParentIdField] == $rootId) {
                $children = $this->buildTree($elements, $element[$this->nodeIdField], $level + 1);
                if ($children) {
                    $element['children'] = $children;
                    $element['level'] = $level + 1;
                    if (!isset($element[$this->nodeLinkField]))
                        $element[$this->nodeLinkField] = "#";
                    if (!isset($element[$this->nodeDescriptionField]))
                        $element[$this->nodeDescriptionField] = $element[$this->nodeIdField];
                }
                $element['level'] = $level;
                if (!isset($element[$this->nodeLinkField]))
                    $element[$this->nodeLinkField] = "#";
                if (!isset($element[$this->nodeDescriptionField]))
                    $element[$this->nodeDescriptionField] = $element[$this->nodeIdField];
                $branch[] = $element;
            }
        }
        $this->tree = $branch;
        return $branch;
    }

    /**
     * @param array $data
     * @param string $markup
     * @return string
     * @throws \framework\exceptions\NotInitializedViewException
     * @throws \framework\exceptions\TemplateNotFoundException
     * @throws \framework\exceptions\VariableNotFoundException
     */
    private function parseTree(array $data, $markup = '')
    {
        foreach ($data as $elm) {
            $markup .= $this->parseMarkUp($elm);
            if (isset($elm['children'])) {
                $markup .= $this->parseTree($elm['children']) . '</li>';
            } else {
                $markup .= "</li>";
            }
        }
        return $this->openContainer . $markup . $this->closeContainer;
    }

    /**
     * @param $elm
     * @return string
     * @throws \framework\exceptions\NotInitializedViewException
     * @throws \framework\exceptions\TemplateNotFoundException
     * @throws \framework\exceptions\VariableNotFoundException
     */
    private function parseMarkUp($elm)
    {
        $markUp = new View();
        $markUp->replaceTpl($this->nodeTpl);
        $markUp->setVar("node_id", $elm['id']);
        $markUp->setVar("node_parent_id", $elm['parent_id']);
        $markUp->setVar("node_description", $elm[$this->nodeDescriptionField]);

        if ($this->showNodeLink) {
            $markUp->setVar("node_link", $elm[$this->nodeLinkField]);
        } else {
            $markUp->hide("OpenLink");
            $markUp->hide("CloseLink");
        }

        if ($this->showNodeLevel) {
            $markUp->setVar("node_level", $elm["level"]);
        } else {
            $markUp->hide("Level");
        }

        return $markUp->parse();
    }

    /**
     * Checks data validity
     * @param $elements
     * @throws MVCException
     */
    private function checkElements($elements)
    {
        if (empty($elements))
            throw  new MVCException("No data for building Tree");
        foreach ($elements as $element) {
            if (!isset($element[$this->nodeIdField]))
                throw  new MVCException("Incompatible structure of the given data");

            if (!isset($element[$this->nodeParentIdField]))
                throw  new MVCException("Incompatible structure of the given data");

            break 1;
        }
    }

    /**
     * Sets the field name to use for referencing the node ID
     * Default name is "node_id"
     *
     * @param string $nodeId
     */
    public function setNodeIdField($nodeId = "node_id")
    {
        $this->nodeIdField = $nodeId;
    }

    /**
     * Sets the field name to use for referencing the parent ID
     * of the current node.
     * Default name is "node_parent_id"
     *
     * @param string $nodeParentId
     */
    public function setNodeParentIdField($nodeParentId = "node_parent_id")
    {
        $this->nodeParentIdField = $nodeParentId;
    }

    /**
     * Sets the field name to use for referencing the node link
     * Default name is "node_link"
     *
     * @param string $nodeLink
     */
    public function setNodeLinkField($nodeLink)
    {
        $this->nodeLinkField = $nodeLink;
    }

    /**
     * Sets the field name to use for referencing the node description
     * Default name is node_description
     *
     * @param string $nodeDescription
     */
    public function setNodeDescriptionField($nodeDescription)
    {
        $this->nodeDescriptionField = $nodeDescription;
    }

    /**
     *  Enables node level info
     */
    public function enableNodeLevel()
    {
        $this->showNodeLevel = true;
    }

    /**
     *  Disables node level info
     */
    public function disableNodeLevel()
    {
        $this->showNodeLevel = false;
    }

    /**
     *  Enables node link info
     */
    public function enableNodeLink()
    {
        $this->showNodeLink = true;
    }

    /**
     *  Disables node link info
     */
    public function disableNodeLink()
    {
        $this->showNodeLink = false;
    }


    public function render()
    {
        try {
            $this->view->replaceTpl($this->parseTree($this->tree));
        } catch (MVCException $e) {
            $this->view->replaceTpl("Error: " . $e->getMessage());
        }
        $tree = $this->view->parse();
        $regex = "/\<\!-- (.*?) --\>/s";
        preg_match_all($regex, $tree, $matches);
        foreach ($matches[0] as $comment) {
            $tree = str_replace($comment, "", $tree);
        }
        return $tree;
    }

}