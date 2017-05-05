<?php
/**
 * Class PartList
 *
 * {ControllerResponsability}
 *
 * @package controllers\examples\db
 * @category Application Controller
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace controllers\examples\db;
use framework\Controller;
use framework\Model;
use framework\View;

use models\examples\db\PartList as PartListModel;
use views\examples\db\PartList as PartListView;
use controllers\examples\cms\NavigationBar;
use framework\components\DataRepeater;


class PartList extends Controller
{
    /**
    * Object constructor.
    *
    * @param View $view
    * @param Model $mode
    */
    public function __construct(View $view=null, Model $model=null)
    {
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view,$this->model);
        $navigation = new NavigationBar();
        $this->bindController($navigation);
    }


    protected function autorun($parameters = null)
    {
        $this->view->setBlockParts($this->model->getResultSet());
    }

    /**
     * Use a DataRepeater to simplify the job
     */
    public function useRepeater()
    {
        $parts = new DataRepeater($this->view,$this->model,"Parts",null);
        $this->bindComponent($parts);
        $this->render();
    }

    /**
    * Inizializes the View
    */
    public function getView()
    {
        $view = new PartListView("/examples/db/part_list");
        return $view;
    }

    /**
    * Inizializes the Model
    */
    public function getModel()
    {
        $model = new PartListModel();
        return $model;
    }
}
