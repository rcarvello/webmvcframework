<?php
/**
 * Class CategoryForm
 *
 * WebMVC assembly controller for editing category records.
 *
 * @package controllers\ai
 * @category Application Controller
 */

namespace controllers\ai;

use framework\BeanAdapter;
use framework\components\Record;
use framework\Controller;
use framework\Model;
use framework\View;
use models\ai\CategoryForm as CategoryFormModel;
use models\beans\BeanCategory;
use views\ai\CategoryForm as CategoryFormView;

class CategoryForm extends Controller
{
    protected $view;
    protected $model;

    /**
     * Object constructor.
     *
     * @param View|null $view
     * @param Model|null $model
     */
    public function __construct(?View $view = null, ?Model $model = null)
    {
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view, $this->model);
    }

    /**
     * Autorun method.
     *
     * @param mixed|null $parameters Parameters to manage
     */
    protected function autorun($parameters = null)
    {
        $record = new Record();
        $record->setName('CategoryRecord');
        $record->registerPkUrlParameter('category_id');
        $record->registerActionName($record::ADD, 'aggiungi');
        $record->registerActionName($record::UPDATE, 'modifica');
        $record->registerActionName($record::DELETE, 'elimina');
        $record->registerActionName($record::CLOSE, 'chiudi');
        $record->disallowMode = $record::DISALLOW_MODE_WITH_HIDE;

        $historyBack = SITEURL . '/ai/category';
        $record->redirectAfterClose = $historyBack;
        $record->redirectAfterDelete = $historyBack;
        $record->redirectAfterAdd = $historyBack;
        $record->redirectAfterUpdate = $historyBack;

        $currentRecord = $record->getCurrentRecord();

        $bean = new BeanCategory();
        $beanAdapter = new BeanAdapter($bean);
        $beanAdapter->select($currentRecord);

        if ($bean->getCategoryId() == 0) {
            $record->disallowAction(Record::DELETE);
            $record->disallowAction(Record::UPDATE);
        }

        if ($record->isSubmitted()) {
            $this->model->setBeanWithPostedData($bean);
        }

        try {
            $record->init($beanAdapter);

            // Explicit SQL error handling to surface DB errors in ValidationErrors block.
            if ($beanAdapter->isSqlError()) {
                $record->addError($beanAdapter->lastSqlError());
            }
        } catch (\mysqli_sql_exception $e) {
            $record->addError($e->getMessage());
            if ($record->editMode == false) {
                $bean->setCategoryId(null);
                $record->disallowAction(Record::UPDATE);
                $record->disallowAction(Record::DELETE);
            } else {
                $record->disallowAction(Record::ADD);
            }
        } catch (\Exception $e) {
            if ($record->editMode == false) {
                $bean->setCategoryId(null);
                $record->disallowAction(Record::UPDATE);
                $record->disallowAction(Record::DELETE);
            } else {
                $record->disallowAction(Record::ADD);
            }
        }

        $this->bindComponent($record, false);
        $this->view->setFieldsWithBeanData($bean);
        $this->view->parseErrors($record->getErrors());
    }

    /**
     * Open an existing category record.
     *
     * @param int|string $pk
     */
    public function open($pk)
    {
        $_GET['category_id'] = $pk;
        $this->autorun();
        $this->render();
    }

    /**
     * Add a new category record.
     *
     * @param mixed|null $dummy
     */
    public function add($dummy = null)
    {
        $this->autorun();
        $this->render();
    }

    /**
     * Initialize the view.
     *
     * @return CategoryFormView
     */
    public function getView()
    {
        $view = new CategoryFormView('/ai/category_form');
        return $view;
    }

    /**
     * Initialize the model.
     *
     * @return CategoryFormModel
     */
    public function getModel()
    {
        $model = new CategoryFormModel();
        return $model;
    }
}