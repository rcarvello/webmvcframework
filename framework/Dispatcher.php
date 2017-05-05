<?php
/**
 * Class Dispatcher
 *
 * @package framework
 * @filesource framework/Dispatcher.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework;

use \ReflectionMethod;
use \DOMDocument;
use framework\exceptions\ControllerNotFoundException;
use framework\exceptions\InvalidMethodParametersException;
use framework\exceptions\MethodNotFoundException;

/**
 * Class Dispatcher
 *
 * Dispatch a url request by creating the appropriate MVC controller
 * instance and runs its method by passing it the parameters.
 *
 * A url request must be in the formats:
 *  - http://site/controller.
 *  - http://site/controller/method.
 *  - http://site/controller/method/param1.
 *  - http://site/controller/method/param1/param2/../paramn.
 *
 * A url request could also contain applications subsystems, e.g.:
 *  - http://site/subsystem/controller/method/param1/param2
 *  - http://site/ubsystem/childsubsystem/controller/method/param1/param2
 *
 * A url request could also contain http get parameters, e.g.:
 *  - http://site/controller?get1=value2&get2=value2
 *  - http://site/controller/method?get1=value2&get2=value2
 *  - http://site/controller/method/param1/param2?get1=value2&get2=value2
 *  - http://site/subsystem/controller/method/param1/param2?get1=value2&get2=value2
 *
 * A url request must be in lower/upper case and can contains underscore. Framework will
 * apply all format conversion to run the appropriate MVC instance.
 *
 * Conversions are like this:
 *
 *  - http://site/user/open/1              => User->open(1);
 *  - http://site/user_manager/get_user/1  => UserManager->getUser(1)
 *
 * @package framework
 * @filesource framework/Bean.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @see framework/Record
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
class Dispatcher
{
    /**
     * @var null|string Store the current subsystem name
     */
    private $currentSubSystem;

    /**
     * @var string The controller class name.
     */
    private $controllerClass;

    /** @var  string Stores the controller class name using a SEO format
     *
     */
    private $controllerSEOClassName;

    /**
     * @var string The method name.
     */
    private $method;

    /**
     * @var array The methods parameters.
     */
    private $methodParameters = array();

    /**
     * @var string The url to parse for generate a request to dispatch.
     */
    private $urlToDispatch;

    /**
     * Dispatcher object constructor.
     */
    function __construct()
    {
        $get = $_GET;
        $url= isset($get['url']) ? $get['url'] : null;
        $currentSubSystem = Loader::getCurrentSubSystem($url);
        if(!empty($url)) {
            //$url= $this->capitalizeUrlSegments($url);
            if(!empty($currentSubSystem))
                $url = str_replace($currentSubSystem."/","",$url);
        }
        $this->currentSubSystem =  str_replace("/","\\",$currentSubSystem). "\\";
        // $this->currentSubSystem.= DIRECTORY_SEPARATOR;
        $this->urlToDispatch = $url;
        $this->parseUrlAndSetAttributes();
    }

    private function capitalizeUrlSegments($url)
    {
        $capitalizedSegments = "";
        if (!empty($url)){
            $urlSegments = explode("/",$url);
            foreach($urlSegments as $segment){
                $capitalizedSegments .= ucfirst($segment) . "/";
            }
            return substr($capitalizedSegments,0,-1);
        }
    }

    /**
     * Dispatches the execution of appropriate controller/method/parameters and
     * shows the result by using the HTML or JSON format.
     * The JSON format is used if the URL contains the get parameter named "getState"
     * with any value, for example getState=myContentId.
     * If getState's value is null the method will show all content managed
     * by the controller otherwise it will show only a portion of global content.
     * This portion of content will be the HTML content contained into an HTML element
     * whose attribute ID is equal to the getState parameter's value.
     *
     * @throws ControllerNotFoundException
     * @throws MethodNotFoundException
     * @throws InvalidMethodParametersException
     */
    public function dispatch()
    {
        ob_start();
        $this->createMVCControllerInstance();
        $content = ob_get_contents();
        ob_end_clean();
        if (!isset($_GET["getState"])){
            echo $content;
        } else {
            $this->contentToJson($content);
        }
    }

    /**
     * Parses url by assuming controller/method/parameter_1/parameter_2/...etc.
     * positioning format and sets class attributes
     *
     */
    private function parseUrlAndSetAttributes()
    {
        if($this->currentSubSystem == "\\")
            $this->currentSubSystem = "";

        // Drop the last char from url string if it is equal to "/"
        if ( isset($this->urlToDispatch[strlen($this->urlToDispatch)]) && $this->urlToDispatch[strlen($this->urlToDispatch) - 1] == "/")
            $this->urlToDispatch = substr($this->urlToDispatch, 0, strlen($this->urlToDispatch) - 1);

        // Generates an array from each sement of the url string delimited by a slash
        $urlSegments = explode("/", $this->urlToDispatch);

        // First segment is the controller  - store its name ad SEO name if controller is passed
        if ($urlSegments[0] != "") {
            $this->controllerClass = "controllers\\". $this->currentSubSystem . $this->underscoreToCamelCase($urlSegments[0],true);
            $this->controllerSEOClassName = strtolower($urlSegments[0]);
        } else {
            // if  root subsystem
            if ($this->currentSubSystem == "") {
                $this->controllerClass = "controllers\\" . $this->underscoreToCamelCase(DEFAULT_CONTROLLER, true);
                $this->controllerSEOClassName = DEFAULT_CONTROLLER;
            } else {
            // if root child subsystem
                $this->controllerClass = "controllers\\". $this->currentSubSystem . $this->underscoreToCamelCase("index",true);
                $this->controllerSEOClassName = strtolower("index");
                // throw new ControllerNotFoundException("No Index");
            }
        }

        // Second segment is a controller Method
        if (isset($urlSegments[1])) {
            $this->method = $this->underscoreToCamelCase($urlSegments[1]);

            // If a method is present, then all the other right segments are
            // considered as method's parameters
            if (count($urlSegments) > 2) {
                $temp = array_slice($urlSegments, 2, count($urlSegments) - 1);
                $i = 0;
                foreach ($temp as $key => $value) {
                    $this->methodParameters[$i] = $value;
                    $i++;
                }
            }
        }

        // Sets a Session variable for storing latest executed controller, method and parameters
        $this->bindControllerToSession();
    }

    /**
     * Creates the appropriate MVC controller instance. Depending on url parsing,
     * it runs controller method/with parameters and outputs the result.
     *
     * @throws ControllerNotFoundException
     * @throws MethodNotFoundException
     * @throws InvalidMethodParametersException
     */
    public function createMVCControllerInstance()
    {
        $controllerClass = $this->controllerClass;
        $method = $this->method;

        // Rem out
        // $separatorBeforeController = !empty($this->currentSubSystem) ? "/":"";
        // $controllerClassFile = "controllers/".$this->currentSubSystem . $separatorBeforeController. $this->controllerClass . ".php";

        /*
        // Commented out for PSR autoloder support
        if (!file_exists($controllerClassFile)){
           // TODO check if controller is shared through subsystems. If yes create Instance.
           throw new ControllerNotFoundInSubSystemException();
        }
        */

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass;
            if (!empty($method) && method_exists($controller, $method)) {
                $reflection = new ReflectionMethod($controllerClass,$method);
                if($reflection->getName() == "__construct") {
                    throw new MethodNotFoundException("access denied to __construct");
                }
                if ($reflection->isProtected() || $reflection->isPrivate()){
                    throw new MethodNotFoundException($reflection->getName() . " access denied");
                }
                $reflectionParametersCount = count($reflection->getParameters());
                if ($reflectionParametersCount != count($this->methodParameters))
                    throw new InvalidMethodParametersException($reflection->getName() . " parameters error");
                if (count($this->methodParameters) > 0) {
                    call_user_func_array(array($controller, $method), $this->methodParameters );
                } else {
                    call_user_func(array($controller, $method));
                }
            } else {
                if (!empty($method) && !method_exists($controller, $method)) {
                    throw new MethodNotFoundException($method . " is not definied");
                } else {
                    call_user_func(array($controller, "render"));
                }
            }
        } else {
            throw new ControllerNotFoundException($controllerClass . " not found");
        }
    }


    /**
     * Shows the controller's content and state in JSON format.
     *
     * @param string $content The controller's content
     */
    private function contentToJson($content)
    {
        $content = html_entity_decode($content,ENT_QUOTES,"UTF-8");

        empty($_GET["getState"]) ? $contentId="all" : $contentId = $_GET["getState"];
        if ($contentId != "all") {
            $dom = new DOMDocument('1.0', 'utf-8');
            @$dom->loadHTML($content);
            $dom->removeChild($dom->doctype);
            $section=$dom->getElementById($contentId);
            $content = $dom->saveHTML($section);
        }

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
     * Converts url notation, underscored and lower case, to Camel/Pascal case notation.
     *
     * @param string $string The url string to convert
     * @param bool $pascalCase . If true uses Pascal Case. Default false, uses Camel Case
     * @return string
     */
    private function underscoreToCamelCase($string, $pascalCase = false)
    {
        //$string = strtolower($string);
        if( $pascalCase == true ) {
            $string[0] = strtoupper($string[0]);
        }
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/_([a-z])/', $func, $string);
    }

    /**
     * Binds current controller and all its parameters into an appropriate
     * session's variable.
     *
     * @note We use this useful session variable to perform some
     * user actions like browser history back action.
     */
    private function bindControllerToSession()
    {
        $last_executed_controller = $this->controllerSEOClassName;
        $last_executed_method = strtolower($this->method);
        $last_executed_parameters = @implode("/", $this->methodParameters);
        @$get = $_GET;
        unset($get["getState"]);
        unset($get["url"]);
        $last_get_parameters = @http_build_query($get);
        @$post = $_POST;
        unset($post["getState"]);
        unset($post["url"]);
        $last_post_parameters = @http_build_query($post);
        $latest= array($last_executed_method,$last_executed_parameters,$last_get_parameters,$last_post_parameters);
        $_SESSION[$last_executed_controller] = serialize($latest);
    }
}