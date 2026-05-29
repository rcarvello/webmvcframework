<?php
/**
 * Class Product
 *
 * WebMVC assembly controller for editing product records.
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
use controllers\examples\cms\NavigationBar;
use models\beans\BeanProduct;
use models\ai\Product as ProductModel;
use views\ai\Product as ProductView;

class Product extends Controller
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
        $navigation = new NavigationBar();
        $navigation->view->loadCustomTemplate('templates/ai/navigation_bar_bs5');
        $this->bindController($navigation);

        /** @var ProductModel $model */
        $model = $this->model;
        /** @var ProductView $view */
        $view = $this->view;

        $model->makeCategoryList($view);

        $record = new Record();
        $record->setName('ProductRecord');
        $record->registerPkUrlParameter('product_id');
        $record->registerActionName($record::ADD, 'aggiungi');
        $record->registerActionName($record::UPDATE, 'modifica');
        $record->registerActionName($record::DELETE, 'elimina');
        $record->registerActionName($record::CLOSE, 'chiudi');
        $record->disallowMode = $record::DISALLOW_MODE_WITH_HIDE;

        $historyBack = SITEURL . '/ai/products';
        $record->redirectAfterClose = $historyBack;
        $record->redirectAfterDelete = $historyBack;
        $record->redirectAfterAdd = $historyBack;
        $record->redirectAfterUpdate = $historyBack;

        $currentRecord = $record->getCurrentRecord();

        $bean = new BeanProduct();
        $beanAdapter = new BeanAdapter($bean);
        $beanAdapter->select($currentRecord);

        if ($bean->getProductId() == 0) {
            $record->disallowAction(Record::DELETE);
            $record->disallowAction(Record::UPDATE);
        }

        if ($record->isSubmitted()) {
            $model->setBeanWithPostedData($bean);
        }

        try {
            $record->init($beanAdapter);

            if ($beanAdapter->isSqlError()) {
                $record->addError($beanAdapter->lastSqlError());
            }
        } catch (\mysqli_sql_exception $e) {
            $record->addError($e->getMessage());
            if ($record->editMode == false) {
                $bean->setProductId(null);
                $record->disallowAction(Record::UPDATE);
                $record->disallowAction(Record::DELETE);
            } else {
                $record->disallowAction(Record::ADD);
            }
        } catch (\Exception $e) {
            if ($record->editMode == false) {
                $bean->setProductId(null);
                $record->disallowAction(Record::UPDATE);
                $record->disallowAction(Record::DELETE);
            } else {
                $record->disallowAction(Record::ADD);
            }
        }

        $this->bindComponent($record, false);
        $view->setFieldsWithBeanData($bean);
        $view->parseErrors($record->getErrors());
    }

    /**
     * Opens an existing product record.
     *
     * @param int|string $pk
     */
    public function open($pk)
    {
        $_GET['product_id'] = $pk;
        $this->autorun();
        $this->render();
    }

    /**
     * Opens the form in add mode.
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
     * @return ProductView
     */
    public function getView()
    {
        $view = new ProductView('/ai/product');
        return $view;
    }

    /**
     * Initialize the model.
     *
     * @return ProductModel
     */
    public function getModel()
    {
        $model = new ProductModel();
        return $model;
    }
}
