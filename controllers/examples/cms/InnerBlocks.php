<?php
/**
 * Class InnerBlocks
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
use framework\User;
use framework\View;
use models\examples\cms\InnerBlocks as InnerBlocksModel;
use views\examples\cms\InnerBlocks as InnerBlocksView;

class InnerBlocks extends Controller
{
    protected $view;
    protected $model;

    /**
    * Object constructor.
    *
    * @param View $view
    * @param Model $mode
    */
    public function __construct(View $view=null, Model $model=null)
    {
        $this->grantRole(100);  // Administrator
        $this->grantRole(60);   // Manager (see access_level table)
        $this->restrictToRBAC(null,"examples/cms/inner_blocks");
        // Alternatively it requires only to be an athenticated user
        // $this->restrictToAuthentication(null,"examples/cms/inner_blocks");
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        $user = new User();
        $user->scanToken();
        $msg = $user->validateToken() ? "Valido" : "Non valido";
        echo "token $msg";
        parent::__construct($this->view,$this->model);
    }

    public function __destruct()
    {
        // $user = new User();
        // $user->logout();
    }

    /**
    * Autorun method. Put your code here for running it after object creation.
    * @param mixed|null $parameters Parameters to manage
    *
    */
    protected function autorun($parameters = null)
    {
        $names= $this->model->getNames();
        $votes= $this->model->getVotes();

        $this->view->openBlockNames();
        foreach ($names as $name){
            $this->view->setBlockVarNamesName($name["name"]);
            $this->view->setBlockVarNamesSelected($name["vote"]);
            $this->view->parseCurrentBlock();
        }
        $this->view->setBlock();


        $this->view->openBlockVotes();
        foreach($votes as $vote){
         $this->view->setBlockVarVotesVote($vote);
         $this->view->parseCurrentBlock();
        }
        $this->view->setBlock();


    }

    /**
    * Inizialize the View by loading static design of /examples/cms/inner_blocks.html.tpl
    * managed by views\examples\cms\InnerBlocks class
    *
    */
    public function getView()
    {
        $view = new InnerBlocksView("/examples/cms/inner_blocks");
        return $view;
    }

    /**
    * Inizialize the Model by loading models\examples\cms\InnerBlocks class
    *
    */
    public function getModel()
    {
        $model = new InnerBlocksModel();
        return $model;
    }
}
