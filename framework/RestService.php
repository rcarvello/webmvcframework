<?php
/**
 * Class RestService
 *
 * REST service implementation.
 * It provides basic responsibilities to build local REST service.
 * You can also use it in conjunction with Bean classes for implementing
 * CRUD operations over local HTTP calls.
 * Developers needs to extend this class to build custom REST methods.
 *
 * @package framework
 * @filesource framework/RestService.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016-2023 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

namespace framework;


abstract class RestService extends Controller
{
    private $allowedMethods = array();
    //TODO Authenticatin
    private $allowedRoles = array();
    private $HTTPRequestMethod;
    private $HTTPRequestHeaders;
    public $debugPrint = false;

    //TODO
    private $restDatas = array();
    private $result;
    private $accessControlAllowOrigins = array();

    public function __construct()
    {
        parent::__construct();
        /* $this->HTTPRequestMethod = getenv('REQUEST_METHOD'); */
        $this->HTTPRequestMethod = $_SERVER['REQUEST_METHOD'];
        $this->HTTPRequestHeaders = getallheaders();
        $this->restDatas = array_merge($_POST, $_GET);
        $this->view->replaceTpl("");

    }

    /**
     * @override
     * @param null $parameters
     */
    public function autorun($parameters = null)
    {
        $this->result = array(
            "status_code:" => 200,
            "status:" => "ok",
            "request_method:" => (empty($this->HTTPRequestMethod)?"":strtoupper($this->HTTPRequestMethod, MB_CASE_UPPER)),
            "request_type:" => "informational",
            "request_headers" => $this->HTTPRequestHeaders,
            "body_data:" => array(
                "message:" => "Web MVC REST Service.",
                "status:" => "ok",
            )
        );
        $this->outputResponse();
    }

    private function outputResponse()
    {
        if (!$this->debugPrint) {

            // Prevent caching.
            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

            // The JSON standard MIME header.
            header('Content-type:application/json;charset=utf-8');

            // CORS
            if (!empty($this->accessControlAllowOrigins)) {
                foreach ($this->accessControlAllowOrigins as $allowedOrigin) {
                    header("Access-Control-Allow-Origin: $allowedOrigin");
                }
            }

            // Output in JSON format
            echo json_encode($this->result);

        } else {
            var_dump($this->result);
        }

    }

    public function __call($method, $args)
    {
        global $_REST;
        if (in_array($method, $this->allowedMethods)) {
            /*
            echo "Called __call with $method","\n<br>\n";
            print_r($args);
            print_r($_REQUEST);
            print_r(getallheaders());
           */
            $this->result = array(
                "status_code" => 200,
                "status:" => "ok",
                "request_method" => $this->HTTPRequestMethod,
                "request_type" => "informational",
                "request_headers" => $this->HTTPRequestHeaders,
                "rest_method" => $method,
                "rest_method_args" => $args,
                "rest_get_post_data" => $_REQUEST,
                "body_data" => array(
                    "message" => "REST method $method was called successful.",
                    "status" => "ok",
                )
            );
            $this->switchAction($method, $args);

        } else {
            $this->result = array(
                "status_code" => 404,
                "status:" => "ko",
                "request_method" => $this->HTTPRequestMethod,
                "request_type" => "informational",
                "body_data:" => array(
                    "message" => "Not found",
                    "status" => "ko",
                )
            );

        }
        $this->outputResponse();

    }

    private function switchAction($method, $args)
    {
        switch ($this->HTTPRequestMethod) {
            case "PUT":
                $operation = array("rest_operation" => "PUT");
                $custom = $this->httpPutRequest($method, $args);
                break;
            case "POST":
                $operation = array("rest_operation" => "POST");
                $custom = $this->httpPostRequest($method, $args);
                break;
            case "DELETE":
                $operation = array("rest_operation" => "DELETE");
                $custom = $this->httpDeleteRequest($method, $args);
                break;
            default: // GET
                $operation = array("rest_operation" => "GET");
                $custom = $this->httpGetRequest($method, $args);
                break;
        }
        $operation_result = array_merge($this->result, $operation, $custom);
        $this->result = $operation_result;
    }

    /**
     * It fires on HTTP GET request
     *
     * @param string $method It contains the name of user method
     * @param array $args It contains an array of parameters given to the
     *                    user method
     *
     * @return array The response to give back after GET request
     */
    public function httpGetRequest($method, $args)
    {
        return array();
    }

    /**
     * It fires on HTTP PUT request
     *
     * @param string $method It contains the name of user method
     * @param array $args It contains an array of parameters given to the
     *                    user method
     *
     * @return array The response to give back after PUT request
     */
    public function httpPutRequest($method, $args)
    {
        return array();
    }

    /**
     * It fires on HTTP POST request
     *
     * @param string $method It contains the name of user method
     * @param array $args It contains an array of parameters given to the
     *                    user method
     *
     * @return array The response to give back after POST request
     */
    public function httpPostRequest($method, $args)
    {
        return array();
    }

    /**
     * It fires on HTTP DELETE request
     *
     * @param string $method It contains the name of user method
     * @param array $args It contains an array of parameters given to the
     *                    user method
     *
     * @return array The response to give back after DELETE request
     */
    public function httpDeleteRequest($method, $args)
    {
        return array();
    }

    /**
     * Define and allow a user method to be called from an HTTP request.
     *
     * @param string $method The method name will be defined and allowed
     *                       in a REST Request
     */
    public function allowMethod($method)
    {
        $this->allowedMethods[] = $method;
    }

    public function addCORS($origin)
    {
        $this->accessControlAllowOrigins[] = $origin;
    }
}