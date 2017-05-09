<?php
/**
 * Class Controller
 *
 * @package framework
 * @filesource framework/Controller.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework;

use \DOMDocument;
use \ReflectionClass;
use framework\classes\Locale;
use framework\classes\Globalize;
use framework\exceptions\VariableNotFoundException;
use framework\components\Component;

abstract class Controller
{
    protected $view;
    protected $model;
    protected $observersCounter = 0;
    protected $observerPollingInterval = 0;
    protected $subSystem = "";

    protected $rootController = true;

    /**
     * Controller Object constructor.
     *
     * @param View [optional] $view The managed view.
     * @param Model [optional] $model The managed model
     */
    public function __construct(View $view = null, Model $model = null)
    {
        empty($view) ? $this->view = new View() : $this->view = $view;
        empty($model) ? $this->model = new Model() : $this->model = $model;
        if ($this->isInvokedControllerMain()) {
            $this->autorun();
        }
        unset($_GET["url"]);
    }

    /**
     * Gets the Fully Qualified Controller Name
     *
     * @return string
     */
    public function getName()
    {
        return get_class($this);
    }

    /**
     * Applies localizations variables to a given parsed tpl.
     * Localizations are located into an external text file having the format:
     * - ControllerName.txt
     * The .txt is placed inside a directory locales/LOCALE_ID/.. followed by
     * the subsystem name.
     *
     * @uses framework/classes/Locale to manage Locale e Localization file.
     * @param string $parsedTpl A text to translate with localizations.
     *                          Tipically the parsed tpl from View
     * @return string
     */
    public function localize($parsedTpl)
    {
        $locale = new Locale();
        $currentLocale = $locale->getCurrenLocale();
        $currentControllerName = str_replace("\\","/",$this->getName());

        $localeFilename = "locales" . DIRECTORY_SEPARATOR . $currentLocale . DIRECTORY_SEPARATOR. $currentControllerName . ".txt";
        $defaultLocaleFileName = "locales" . DIRECTORY_SEPARATOR . $locale::DEFAULT_LCID. $currentControllerName . ".txt";
        // echo $localeFilename;
        if (file_exists($localeFilename)) {
            $optionals = $locale->loadLocaleFiles($localeFilename);
            $transletedText = $locale->applyLocaleMessages($parsedTpl, $optionals);
        } elseif (file_exists($defaultLocaleFileName)){
            $optionals = $locale->loadLocaleFiles($defaultLocaleFileName);
            $transletedText = $locale->applyLocaleMessages($parsedTpl, $optionals);
        } else {
            $transletedText = $locale->applyLocaleMessages($parsedTpl);
        }
        return $transletedText;
    }

    /**
     * Sets the controller Model.
     *
     * @param Model $model
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Sets the controller View.
     *
     * @param View $view
     */
    public function setView(View $view)
    {
        $this->view = $view;
    }

    /**
     * Outputs the controller content managed, computed and fetched from its View.
     * Apply also translations to the content if locale translation file is presente.
     * Finally get the output, also compressed if constant COMPRESS_OUTPUT is true.
     *
     */
    public function render()
    {
        // $this->view->render();
        $parsedTpl = $this->view->parse();
        $output = $this->localize($parsedTpl);
        $globalize = new Globalize($output);
        $output = $globalize->getContent();
        if (COMPRESS_OUTPUT)
            $output = trim(preg_replace('/\s+/', ' ', $output));
        echo $output;
    }

    /**
     * Hides a block.
     *
     * @param string $block The block name
     */
    public function hide($block)
    {
        $this->view->hide($block);
    }

    /**
     * Gets the controller content.
     *
     * @param string $contentId The Id of HTML tag from witch to wrap content. Default is "all"
     *                          If is not given the default is all contents.
     * @return string The content
     */
    public function get($contentId = "all")
    {
        $parsedView = $this->view->parse();
        if ($contentId == "all") {
            return $parsedView;
        } else {
            $dom = new DOMDocument('1.0', 'utf-8');
            @$dom->loadHTML($parsedView);
            $dom->removeChild($dom->doctype);
            $section = $dom->getElementById($contentId);
            return $dom->saveHTML($section);
        }
    }

    /**
     * A JSON Service witch gets the Controller state and the content of its specific HTML element id.
     * It returns a state representation of the Controller and its base64 encoded content.
     *
     * @param string $contentId The HTML element id from whitch obtain the state and content.
     *                          Default is "all" and returning all Controller content
     *
     * @return string A JSON representation of the controller state and its utf-8 content
     * encoded into base64.
     */
    public function getState($contentId = "all")
    {
        $content = $this->get($contentId);
        $content = html_entity_decode($content, ENT_QUOTES, "UTF-8");
        $contentState = hash('sha512', $content);
        $content = base64_encode($content);
        header('Content-Type: application/json');
        if ($contentId == "all") {
            echo json_encode(array("controllerState" => $contentState, "controllerContent" => "", "section" => "all"));
        } else {
            echo json_encode(array("controllerState" => $contentState, "controllerContent" => $content, "section" => $contentId));
        }
    }

    /**
     * Sets the view polling interval for requesting controller state and content.
     *
     * @param int $interval . The polling interval. Default 5 seconds.
     */
    public function setObserverPollingInterval($interval = 5000)
    {
        $interval = (int)$interval;
        if ($this->observerPollingInterval == 0 and $interval > 0) {
            $this->observerPollingInterval = $interval;
        }
    }

    /**
     * Activate on a root controller the controller state observation for automatically
     * refresh view when its content change.
     *
     * @param string|null $content The content to observe. If null observe all content.
     * @param string $withAlerting Activation flag to manage alert on change. Default is "false".
     *
     * @throws VariableNotFoundException
     * @note Use this method only into first level controllers.
     */
    public function setAsObserver($content = null,$withAlerting="false")
    {
        if (!$this->rootController)
            return;

        if (empty($content))
            $content = "all";

        if ($this->observerPollingInterval == 0)
            $this->setObserverPollingInterval();

        $id = $this->observersCounter;
        $pollingInterval = $this->observerPollingInterval;

        $this->observersCounter = $this->observersCounter + 1;
        $this->observerPollingInterval = $this->observerPollingInterval + 500;

        // Prima implementazione -- Non valido per componente Record
        // $postData = base64_encode(http_build_query($_POST));
        $postData = base64_encode(http_build_query($_GET));
        $jsString = @file_get_contents(JSFRAMEWORK . "/mvc.append.controller.getstate.js");
        $jsString = str_replace("{polling_interval}", $pollingInterval, $jsString);
        $jsString = str_replace("{content_check}", $content, $jsString);
        $jsString = str_replace("{serialized_post}", $postData, $jsString);
        $jsString = str_replace("{alert_flag}", $withAlerting, $jsString);
        $jsString = str_replace("{id}", $id, $jsString);
        $jsString = str_replace("{JSFRAMEWORK}", SITEURL . "/" . JSFRAMEWORK, $jsString);
        $jsString = str_replace("{SERVER_OS_ENCODING}", SERVER_OS_ENCODING, $jsString);
        $jsString = "<" . "script" . ">" . $jsString . "</" . "script" . ">";
        $varBody = "</body>";
        if ($this->view->checkVar($varBody, false)) {
            // Append the script after </body> tag (if it exists)
            $this->view->setVar($varBody, $varBody . PHP_EOL . $jsString, false);
        } else {
            // Append the script at the end of template file
            $this->view->setVar(null, PHP_EOL . $jsString, false);
        }
    }

    /**
     * Resets the observers counter. Use it before binding observer in custom methods.
     */
    public function resetObservers()
    {
        $this->observersCounter = 0;
        $this->observerPollingInterval = 0;
    }

    /**
     * Binds a (nested) controller to a Controller:variable.
     * The variable must be named with the same subusystem\controller class name.
     *
     * @param Controller $controller The controller instance to bind
     * @throws VariableNotFoundException
     */
    public function bindController(Controller $controller)
    {
        $variable = str_replace(APP_CONTROLLERS_PATH . "\\", "", get_class($controller));
        $variable = "Controller:" . $variable;
        // $variable = "Controller:" . get_class($controller);
        $controller->setAsChildController();
        $this->view->setVar($variable, $controller->get());
    }

    /**
     * Sets as Child controller by stopping observations
     */
    public function setAsChildController()
    {
        $this->rootController = false;
    }

    /**
     * Binds a component to a Component:variable.
     * The variable must be named with the same component object property name.
     *
     * @param Component $component The component instance to bind.
     * @param boolean . If true, default, content is automatically rendered to the screen.
     * @throws VariableNotFoundException
     */
    public function bindComponent(Component $component, $render = true)
    {
        $component->setAsChildController();
        if ($component->hasBinding() == true) {

            // Remove namespace from  get_class($component)
            $reflection = new ReflectionClass($component);
            $componentClassName = $reflection->getShortName();

            // Old implementation
            // $variable = get_class($component) . ":" . $component->getName();
            $variable = $componentClassName . ":" . $component->getName();
            $variable = str_replace("framework\\", "", $variable);
            if ($render) {
                /** @noinspection PhpVoidFunctionResultUsedInspection */
                $this->view->setVar($variable, $component->render());
            } else {
                $this->view->setVar($variable, $component->get());
            }
        } else {
            $component->render();
        }
    }

    /**
     * Method automatically executed if no controllers's method is invoked.
     * Reserved for hooking user custom logic when instantiate a new controller.
     *
     * @param mixed $parameters . Customs parameters. Default null
     */
    protected function autorun($parameters = null)
    {

    }

    /**
     * Gets current application subsystem. Developer can organize controllers in
     * different subsystems/sub folders/sub namespaces children of main
     * system/folder/namespace.
     * This method returns the name of subsystem (alias folder or namespace) container
     * of current controller.
     *
     * @return string The sub system of the current controller.
     */
    public function getSubSystem()
    {
        return $this->subSystem;
    }

    /**
     * Defines if actually a controller is running without invoking any of its method.
     *
     * @return bool true if main controller is called without any of its method. Else false
     */
    private function isInvokedControllerMain()
    {
        $get = $_GET;
        $url = isset($get['url']) ? $get['url'] : null;
        if (!empty($url)) {
            $currentSubsystem = Loader::getCurrentSubSystem($url);
            if (!empty($currentSubsystem))
                $url = str_replace($currentSubsystem . "/", "", $url);
            $this->subSystem = $currentSubsystem;
        }
        if (empty($url)) {
            return true;
        } else {
            $urlSegments = explode("/", $url);
            if (isset($urlSegments[1])) {
                return false;
            } else {
                return true;
            }
        }
    }


    public function getModel()
    {
        return $this->model;
    }

    public function getView()
    {
        return $this->view;
    }
}
