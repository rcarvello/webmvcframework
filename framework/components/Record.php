<?php
/**
 * Class Record
 *
 * This MVC component should be used together with a custom controller buided to manage
 * an HTML Form. Record component  automatically renders and manages the form
 * actions/buttons and execute SQL DML statements against a database table's row.
 * Its main features are:
 *
 * - It uses a predefined or custom view for the GUI buttons
 * - The Record submissions will be handled and managed against a Bean Adapter used as Model.
 * - It manages necessary form buttons corresponding to the SQL INSERT,UPDATE and DELETE
 *   operations plus other buttons to implements the form close and reset.
 * - It implements disallow methods for disallowing forms buttons and actions.
 * - SQL DML implementations are delegated to the given Bean Adapter which itself manages a
 *   database bean object. Record component intercepts the form behaviour and/or action to
 *   execute,then call the appropriate Bean Adapter method. The BeanAdpter itself uses a
 *   MySQL Bean Class. Bean Class manages a single MySQL table and provides all necessary
 *   methods to executing SQL operations corresponding to the form submission.
 *
 * @package framework
 * @filesource framework/Record.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @note none
 * @see framework/Bean
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

namespace framework\components;

use \DOMDocument;
use framework\BeanAdapter;
use framework\exceptions\BeanActionException;
use framework\exceptions\RecordActionException;
use framework\exceptions\VariableNotFoundException;
use framework\Model;
use framework\View;
use framework\Bean;

class Record extends Component{

    /**
     * Costant to define button name for the ADD form's action
     */
    const ADD       = 'record_add';

    /**
     * Costant to define button name for the UPDATE form's action
     */
    const UPDATE    = 'record_update';

    /**
     * Costant to define button name for the DELETE form's action
     */
    const DELETE    = 'record_delete';

    /**
     * Costant to define button name for the CLOSE form's action
     */
    const CLOSE     = 'record_close';

    /**
     * Costant to define button name for the RESET form's action
     */
    const RESET     = 'record_reset';

    /**
     * Costant to disable buttons by hiding them
     */
    const DISALLOW_MODE_WITH_HIDE       = 'hide';

    /**
     * Costant to disable buttons by disabling them
     */
    const DISALLOW_MODE_WITH_DISABLE    = 'disabled';

    public $editMode = false;
    /**
     * @var bool Allows form ADD, default true
     */
    public $allowAdd=true;

    /**
     * @var bool Allows form UPDATE, default true
     */
    public $allowUpdate=true;

    /**
     * @var bool Allow form DELETE, default true
     */
    public $allowDelete=true;

    /**
     * @var bool Allows form CLOSE, default true
     */
    public $allowClose=true;

    /**
     * @var bool Allows form RESET, default true
     */
    public $allowReset=true;

    /**
     * @var string The buttons separator, default is a space "&nbsp;"
     */
    public $actionsSeparator = "&nbsp;";

    /**
     * @var string Form action method, default POST. Valid values are "GET" and "POST";
     */
    public $formMethod = "POST";

    /**
     * @var string Disallow mode for button, default is hide.
     *             Values must be one from the following Record constant:
     *             Record:DISALLOW_MODE_WITH_HIDE, Record:DISALLOW_MODE_WITH_DISABLE
     */
    public $disallowMode = self::DISALLOW_MODE_WITH_HIDE;

    /**
     * @var string The controller name to redirect after adding. If not set Record remains
     *             to current page
     * @note For controller name use url notation format (lower case and underscore)
     */
    public $redirectAfterAdd = "";

    /**
     * @var string The controller name to redirect after updating. If not set Record remains
     *             to the current page
     * @note For controller name use url notation format (lower case and underscore)
     */
    public $redirectAfterUpdate = "";

    /**
     * @var string The controller name to redirect after updating. If not set Record remains
     *             to the current page
     * @note For controller name use url notation format (lower case and underscore)
     */
    public $redirectAfterDelete = "";

    /**
     * @var string The controller name to redirect after updating. If not set Record remains
     *             to the current page
     * @note For controller name use url notation format (lower case and underscore)
     */
    public $redirectAfterClose = "";

    /**
     * @var Bean The BeanAdpter reference implementing Bean interface to handle the requests.
     */
    private $beanAdapter;

    /**
     * Stores errors messages intercepted from SQL operations and inputs validation.
     * @var array
     */
    private $errors = array();

    /**
     * @var array Array for registering PKs name
     */
    private $pkName = array();

    /**
     * @var array Array for registering PKs values.
     */
    private $currentRecord = array();

    /**
     * @var string Action ADD. Default value is Record::RECORD_ADD. If template has a
     *                         different value for name of input button the value can be
     *                         changed with registerAction() method.
     */
    private $record_add     = self::ADD;

    /**
     * @var string Action UPDATE. Default value is Record::RECORD_UPDATE. If template has a
     *                         different value for name of input button the value can be
     *                         changed with registerAction() method.
     */
    private $record_update  = self::UPDATE;

    /**
     * @var string Action DELETE. Default value is Record::RECORD_DELETE. If template has a
     *                         different value for name of input button the value can be
     *                         changed with registerAction() method.
     */
    private $record_delete  = self::DELETE;

    /**
     * @var string Action CLOSE. Default value is Record::RECORD_CLOSE. If template has a
     *                         different value for name of input button the value can be
     *                         changed with registerAction() method.
     */
    private $record_close   = self::CLOSE;

    /**
     * @var string Action RESET. Default value is Record::RECORD_RESET. If template has a
     *                         different value for name of input button the value can be
     *                         changed with registerAction() method.
     */
    private $record_reset   = self::RESET;

    /**
     * Record constructor.
     * @param View|null $view The view user for the GUI, if null used a predefined one.
     * @param Bean|null $model Model to use
     */
    public function __construct(View $view = null, Bean $model = null)
    {
        if ($view == null) {
            $tpl = "framework/resources/components/record";
            $view = new View();
            $view->loadCustomTemplate($tpl);
        }
        parent::__construct($view,$model);
    }

    /**
     * Initializes the component with a given bean adapter that implement SQL actions
     * of its managed MySQL bean.
     *
     * @param Model|null $beanAdapter
     * @param View|null $view
     * @throws BeanActionException If SQL error occurs
     * @throws VariableNotFoundException If component's variable is not found into template
     */
    public function init(Model $beanAdapter=null, View $view=null)
    {
        $this->beanAdapter = $beanAdapter;
        $this->view->setVar("Separator",$this->actionsSeparator);

        $this->doAction($beanAdapter);

        if (!empty($this->currentRecord[0])) {
            $this->allowAdd = false;
            $this->editMode = true;
        } else {
            $this->allowUpdate = false;
            $this->allowDelete = false;
            $this->editMode = false;
        }

        if ($this->record_add == self::ADD)
            $this->view->setVar(self::ADD,    $this->record_add);
        if ($this->record_update == self::UPDATE)
            $this->view->setVar(self::UPDATE, $this->record_update);
        if ($this->record_delete == self::DELETE)
            $this->view->setVar(self::DELETE, $this->record_delete);
        if ($this->record_close == self::CLOSE)
            $this->view->setVar(self::CLOSE, $this->record_close);
        if ($this->record_reset == self::RESET)
            $this->view->setVar(self::RESET,  $this->record_reset);
        if ($this->allowAdd == false)
            $this->disallowAction(self::ADD);
        if ($this->allowUpdate == false)
            $this->disallowAction(self::UPDATE);
        if ($this->allowDelete == false)
            $this->disallowAction(self::DELETE);
        if ($this->allowClose == false)
            $this->disallowAction(self::CLOSE);
        if ($this->allowReset == false)
            $this->disallowAction(self::RESET);

    }

    /**
     * Verifies if action's name is valid
     * @param string $action The action name
     * @return bool
     * @throws RecordActionException If action name is not valid
     */
    private function verifyAction($action)
    {
        if ($action!=Record::ADD    &&
            $action!=Record::UPDATE &&
            $action!=Record::DELETE &&
            $action!=Record::CLOSE  &&
            $action!=Record::RESET) {
            throw new RecordActionException("Action not in range. Must be one of Record:ADD/UPDATE/DELETE/CLOSE/RESET");
        } else {
            return true;
        }
    }

    /**
     * Registers a record action that must be associate to a form element name that can be
     * submitted, typically an HTML form's button.
     * After form element submission the action is sent through POST or GET, depending by the
     * $formMethod Record's attribute. Record is able to intercepts only registered actions,
     * then it also executes the corresponding BeanAdapter's method.
     *
     * @param string $action The action name must be one of the following Record constants:
     *                      Record::ADD, Record::UPDATE, Record::DELETE, Record::CLOSE,
     *                      Record::RESET
     * @param string $formElement Form button name.
     * @throws RecordActionException If action name is not valid
     * @throws VariableNotFoundException If variable action's is not found into template
     */
    public function registerActionName($action, $formElement)
    {
        $this->verifyAction($action);
        $this->$action=$formElement;
        $this->view->setVar($action, $formElement);
    }

    /**
     * Disallow a (previously registered) form action.
     * By disallowing an action the corresponfing form button will result disabled or
     * hided, depending on component's disallowMode property setting.
     *
     * @param string $action The action name must be one of the following Record constants:
     *                      Record::ADD, Record::UPDATE, Record::DELETE, Record::CLOSE,
     *                      Record::RESET
     * @throws RecordActionException If action name is not valid
     */
    public function disallowAction($action)
    {
        $this->verifyAction($action);
        if ($this->disallowMode == self::DISALLOW_MODE_WITH_HIDE){
            $this->hideAction($action);
        } else {
            $this->disableAction($action);
        }
    }

    /**
     * Disables a form action
     * @param string $action The action name must be one of the following Record constants:
     *                      Record::ADD, Record::UPDATE, Record::DELETE, Record::CLOSE,
     *                      Record::RESET
     * @throws RecordActionException If action name is not valid
     */
    private function disableAction($action)
    {
        $this->verifyAction($action);
        $dom = new DOMDocument('1.0', 'utf-8');
        @$dom->loadHTML($this->view->parse());
        $dom->removeChild($dom->doctype);
        $element_id = $this->$action;
        $element = $dom->getElementById($element_id);
        $element->setAttribute("disabled","true");
        $html = $dom->saveHTML();
        $this->view->replaceTpl($this->sanitizeHtml($html));
    }

    /**
     * Hides a form action
     * @param string $action The action name must be one of the following Record constants:
     *                      Record::ADD, Record::UPDATE, Record::DELETE, Record::CLOSE,
     *                      Record::RESET
     * @throws RecordActionException If action name is not valid
     */
    private function hideAction($action)
    {
        $this->verifyAction($action);
        $dom = new DOMDocument('1.0', 'utf-8');
         @$dom->loadHTML($this->view->parse());
         $dom->removeChild($dom->doctype);
         foreach ($dom->getElementsByTagName('input') as $input) {
             if ($input->getAttribute('name') == $this->$action) {
                 $input->parentNode->removeChild($input);
             }
         }
        $html = $dom->saveHTML();
        $this->view->replaceTpl($this->sanitizeHtml($html));
    }

    /**
     * Sanitizes an HTML string by removing tags html and body.
     *
     * @param string $html The HTML string to sanitize
     * @return string Sanitized HTML string
     */
    private function sanitizeHtml($html)
    {
        $html = str_replace('<html>',"",$html);
        $html = str_replace('</html>',"",$html);
        $html = str_replace('<body>',"",$html);
        $html = str_replace('</body>',"",$html);
        return $html;
    }

    /**
     * Registers the url parameter name used for table primary key and sets its value
     * as current record.
     *
     * @param string $pkName
     */
    public function registerPkUrlParameter($pkName){
        $this->pkName[] = $pkName;
        isset($_GET[$pkName])?  $id_get = $_GET[$pkName] : $id_get =null;
        isset($_POST[$pkName] )?  $id_post = $_POST[$pkName] : $id_post =null;
        ($id_get !=null ) ? $id = $id_get : $id = $id_post;
        $this->currentRecord[] = $id;
    }

    /**
     * Return the PK array of current opened record.
     *
     * @return array
     */
    public function getCurrentRecord()
    {
        return $this->currentRecord;
    }

    /**
     * Verifies if form is submitted
     *
     * @return bool
     */
    public function isSubmitted()
    {
        // $submitted = false;
        if ( isset($_REQUEST[$this->record_add]) || isset($_REQUEST[$this->record_update]) || isset($_REQUEST[$this->record_delete]) || isset($_REQUEST[$this->record_close])){
            $submitted = true;
        } else {
            $submitted = false;
        }
        return $submitted;
    }

    /**
     * Executes record action.
     *
     * @param Bean $beanAdapter BeanAdpter that implements Bean SQL action
     * @throws BeanActionException If SQL error occur.
     */
    private function doAction(BeanAdapter $beanAdapter)
    {
        foreach ($this->pkName as $key) {
            if(isset($_GET[$key]))
                unset($_GET[$key]);
        }

        if (!isset($_REQUEST["getState"])) {
            if (isset($_REQUEST[$this->record_add])) {
                $beanAdapter->insert();
                if (!empty($this->redirectAfterAdd))
                    header("Location: " . $this->redirectAfterAdd);
            }
            if (isset($_REQUEST[$this->record_update])) {
                $beanAdapter->update($this->currentRecord);
                if (!empty($this->redirectAfterUpdate))
                    header("Location: " . $this->redirectAfterUpdate);
            }

            if (isset($_REQUEST[$this->record_delete])) {
                $beanAdapter->delete($this->currentRecord);
                if (!empty($this->redirectAfterDelete))
                    header("Location: " . $this->redirectAfterDelete);
            }

            if (isset($_REQUEST[$this->record_close])) {
                if (!empty($this->redirectAfterClose))
                    header("Location: " . $this->redirectAfterClose);
            }
        }
        if ($beanAdapter->isSqlError() == true)
            throw new BeanActionException($beanAdapter->lastSqlError());

    }

    /**
     * Gets last execution of a given controller.
     *
     * @param string $controller Name of the controller (in url notation).
     * @return string A url string that reproduce last execution of the given controller.
     */
    public function getControllerHistoryBack($controller){
        if (!isset($_SESSION[$controller]))
            $_SESSION[$controller] = "";
        $urlArray = unserialize($_SESSION[$controller]);
        if (!isset($_SESSION["current_subsystem"]))
            $_SESSION["current_subsystem"] = "";
        $currentSubsystem = $_SESSION["current_subsystem"];
        $currentSubsystem == "" ? $currentSubsystem = "": $currentSubsystem = $currentSubsystem . "/";
        $method = (isset($urlArray[0]) && !empty($urlArray[0]) ) ?  "/". $urlArray[0] : "";
        $parameters = (isset($urlArray[1])&& !empty($urlArray[1])) ?  "/". $urlArray[1] : "";
        $get = (isset($urlArray[2]) && ! empty($urlArray[2]) ) ?  "?" . $urlArray[2] : "";
        $post = (isset($urlArray[3]) && ! empty($urlArray[3]) ) ?  "&" . $urlArray[3] : "";
        return  SITEURL . "/". $currentSubsystem . $controller . $method  . $parameters . $get . $post;
    }

    /**
     * Gets occurred errors
     * @return array
     */
    public function getErrors()
    {
        $errors = array_merge(array ($this->beanAdapter->lastSqlError()),$this->errors );
        return $errors;
    }
}