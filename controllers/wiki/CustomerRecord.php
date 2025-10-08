<?php
/**
 * Class CustomerRecord
 *
 * {ControllerResponsability}
 *
 * @package controllers
 * @category Application Controller
 * @author  {AuthorName} - {AuthorEmail}
 */

namespace controllers\wiki;

use framework\Controller;
use framework\Model;
use framework\View;

use models\wiki\CustomerRecord as CustomerRecordModel;
use views\wiki\CustomerRecord as CustomerRecordView;

class CustomerRecord extends Controller
{
    protected $view;
    protected $model;

    /**
     * CustomerRecord constructor.
     *
     * @param View|null $view
     * @param Model|null $model
     * @throws \framework\exceptions\TemplateNotFoundException
     */
    public function __construct(View $view = null, Model $model = null)
    {
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view, $this->model);
    }

    /**
     * Autorun method. Put your code here for running it after
     * object creation.
     *
     * @param mixed|null $parameters Parameters to manage
     */
    protected function autorun($parameters = null)
    {
        $this->handleFormActionsSubmission();
        $this->view->initFormFields($this->model);
    }

    /**
     * Manage open action of a customer record
     *
     * @param int $customerID The customer id you need to select
     * @throws \framework\exceptions\NotInitializedViewException
     */
    public function open($customerID)
    {

        $currentRecord = $this->model->select($customerID);
        if (!$currentRecord)
            $this->closeAndRedirect();
        $this->autorun();
        $this->render();
    }

    /**
     * Manage form actions submission.
     *
     */
    private function handleFormActionsSubmission()
    {
        try {
            if (isset($_POST["operation_update"])) {
                $this->handlePostFields();
                $this->model->updateCurrent();
                $this->handleSqlError($this->model);
            }
            if (isset($_POST["operation_delete"])) {
                $this->model->delete($_POST["customer_id"]);
                $this->handleSqlError($this->model);
                $this->closeAndRedirect();
            }
            if (isset($_POST["operation_insert"])) {
                $this->handlePostFields();
                $this->model->insert();
                $this->handleSqlError($this->model);
                $this->closeAndRedirect();
            }
        } catch (\mysqli_sql_exception $e) {
            $_SESSION["mysql_error"] = $e->getMessage();
        }
    }

    /**
     * Handle CRUD SQL Errors
     */
    private function handleSqlError($model)
    {
        if ($model->isSqlError()) {
            $_SESSION["mysql_error"] = $model->lastSqlError();
        }
    }

    /**
     * Handle post fields and setting the corresponding
     * model values.
     *
     */
    private function handlePostFields()
    {
        $this->model->setName(@$_POST["name"]);
        $this->model->setEmail(@$_POST["email"]);
        $this->model->setNationality(@$_POST["nationality"]);
        $this->model->setAssurance(@$_POST["assurance"]);
    }

    /**
     * Closing and redirecting if no SQL error occurred
     *
     */
    private function closeAndRedirect()
    {
        if (!$this->model->isSqlError()) {
            header("location:" . SITEURL . "/wiki/customers_manager");
        }
    }


    /**
     * Init View by loading static design of /customer_record.html.tpl
     * managed by views\CustomerRecord class
     *
     */
    public function getView()
    {
        $view = new CustomerRecordView("wiki/customer_record");
        return $view;
    }

    /**
     * Init Model by loading models\CustomerRecord class
     *
     */
    public function getModel()
    {
        $model = new CustomerRecordModel();
        return $model;
    }
}
