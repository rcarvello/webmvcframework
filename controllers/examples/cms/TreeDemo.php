<?php
/**
 * Class TreeDemo
 *
 * {ControllerResponsability}
 *
 * @package controllers\examples\cms
 * @category Application Controller
 * @author  {AuthorName} - {AuthorEmail}
 */

namespace controllers\examples\cms;

use framework\Controller;
use framework\Model;
use framework\View;
use models\examples\cms\TreeDemo as TreeDemoModel;
use views\examples\cms\TreeDemo as TreeDemoView;
use framework\components\TreeStructure;

class TreeDemo extends Controller
{
    protected $view;
    protected $model;

    /**
     * Object constructor.
     *
     * @param View $view
     * @param Model $mode
     */
    public function __construct(View $view = null, Model $model = null)
    {
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view, $this->model);
    }

    /**
     * Autorun method. Put your code here for running it after object creation.
     * @param mixed|null $parameters Parameters to manage
     *
     */
    protected function autorun($parameters = null)
    {
        $tree = new TreeStructure();

        $tree->setName("MyTree");
        $tree->setNodeIdField("id");
        $tree->setNodeParentIdField("parent_id");
        $tree->setNodeDescriptionField("description");
        $tree->setNodeLinkField("link");

        $tree->disableNodeLevel();
        //$tree->disableNodeLink();

        // Init JS and CSS
        $tree->initCCSJS($this,$this->view);

        $tree->buildTree($this->model->getResultSet());
        $this->bindComponent($tree);

        $this->hide("LinkClickBlock");
    }

    /**
     * linkClickDemo()
     * A simple method for handling the link click of item id 10 contained
     * into the tree structure
     *
     * @return void
     */
    public function linkClick()
    {
        $this->hide("TreeBlock");
        $this->render();
    }

    /**
     * Inizialize the View by loading static design of /examples/cms/tree_demo.html.tpl
     * managed by views\examples\cms\TreeDemo class
     *
     */
    public function getView()
    {
        $view = new TreeDemoView("/examples/cms/tree_demo");
        return $view;
    }

    /**
     * Inizialize the Model by loading models\examples\cms\TreeDemo class
     *
     */
    public function getModel()
    {
        $model = new TreeDemoModel();
        return $model;
    }
}
