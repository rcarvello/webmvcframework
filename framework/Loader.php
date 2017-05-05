<?php
/**
 * Class Loader
 *
 * @package framework
 * @filesource framework/Loader.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework;

use framework\exceptions\ControllerNotFoundException;
use \Exception;

class Loader
{
    private $directories = array();

    public function __construct($mode="psr0")
    {
        $this->checkPHPVersion();
        if ($mode == "standard") {
            spl_autoload_register(array($this, 'autoload'));
        }else if ($mode == "secured") {
            $this->directories = $this->getDirectories();
            spl_autoload_register(array($this, 'secureAutoload'));
        } else if ($mode == "psr0"){
            spl_autoload_register(array($this, 'psr0Autoload'));
        }
    }

    /**
     * Class loader.
     * Loads the controller class.
     *
     * @param string $className
     * @throws exceptions\ControllerNotFoundException
     * @deprecated Use PSR-0 auto loader
     */
    public function autoload($className)
    {
        $requiredClass = $className . ".php";
        if (file_exists($requiredClass)) {
            require_once($requiredClass);
        }
        else {
            throw new ControllerNotFoundException();
        }

    }

    /**
     * Class auto loader with secure directories check.
     * Search class into CLASSES and SUBSYSTEMS arrays of directories and load it if found.
     *
     * @param string $className The class name to load
     * @throws exceptions\ControllerNotFoundException
     * @deprecated Use PSR-0 auto loader
     */
    public function secureAutoload($className)
    {
        $directories = $this->directories;

        $parts = explode('\\', $className);
        $className = end($parts);

        //For each folder searches and loads the class if it exist.
        if (is_array($directories)) {
            foreach ($directories as $key => $value) {
                $requiredClass = RELATIVE_PATH . $value . "/" . $className . '.php';
                if (file_exists($requiredClass)) {
                    require_once($requiredClass);
                    break;
                }
            }
        } else {
            throw new ControllerNotFoundException();
        }
    }

    /**
     * Class auto loader PSR0
     * Load classes with PSR0 auto loader.
     *
     * @param string $className The class name to load
     */
    public function psr0Autoload($className)
    {
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = ucfirst(substr($className, $lastNsPos + 1));
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        $relativePath = str_replace('\\', DIRECTORY_SEPARATOR, RELATIVE_PATH);
        $fileName = $relativePath . $fileName;
        if (file_exists($fileName))
            require $fileName;

    }

    /**
     * Gets all directories: framework and application's sub systems
     *
     * @return array|mixed
     */
    public static function getDirectories()
    {
        $directories = unserialize(CLASSES);
        $subSystems = array();
        $definedSubSystems = unserialize(SUBSYSTEMS);

        if (is_array($definedSubSystems)) {
            foreach ($definedSubSystems as $key => $value) {
                $subSystems[] = APP_CONTROLLERS_PATH . DIRECTORY_SEPARATOR . $value;
                $subSystems[] = APP_VIEWS_PATH . DIRECTORY_SEPARATOR . $value;
                $subSystems[] = APP_MODELS_PATH .DIRECTORY_SEPARATOR . $value;
            }
        }

        // Merges arrays of subsystems and classes directories
        if (!empty($subSystems))
            $directories = array_merge($subSystems, $directories);

        return $directories;
    }

    /**
     * Verifies if the url contains a subsystem folder.
     *
     * @param string $url Url to parse
     * @return string|null The current subsystem folder
     */
    public static function getCurrentSubSystem($url)
    {
        $currentSubSystem = "";
        $subSystems = unserialize(SUBSYSTEMS);
        if (is_array($subSystems)) {
            foreach ($subSystems as $key => $value) {
                if (substr($url, 0, strlen($value)) === $value) {
                    $temp = substr($url, 0, strlen($value));
                    if (strlen($temp) > strlen($currentSubSystem))
                        $currentSubSystem = $temp;
                }
            }
        }
        $_SESSION["current_subsystem"]=$currentSubSystem;
        return $currentSubSystem;
    }

    /**
     * Checks if PHP version is compatible and all extension needed are loaded.
     * @param string $minVersion Min supported version.
     * @throws Exception if not.
     */
    private function checkPHPVersion($minVersion="5.3.6")
    {
        if (!isset($_SESSION["doCheckEnv"])){
            if (version_compare(phpversion(), $minVersion, '<')) {
                echo "<strong>Errore: Versione minima PHP richiesta 5.3.6</strong>";
                error_reporting(0);
                throw new \Exception();
            }
            $this->checkExtension();
            $_SESSION["doCheckEnv"] = true;
        }
    }

    /**
     * Verify if all extensions needed are loaded
     * @throws Exception if not
     */
    private function checkExtension(){

        if (!extension_loaded('dom')) {
            echo "<strong>Errore: DOM Extension is not loaded. Configure PHP with this exrension.</strong>";
            error_reporting(0);
            throw new \Exception();
        }

        if (!extension_loaded('mysqli')) {
            echo "<strong>Errore: MSQLI Extension is not loaded. Configure PHP with this exrension.</strong>";
            error_reporting(0);
            throw new \Exception();
        }

    }

    /**
     * Gets folders and subfolders of a given directory.
     *
     * @param string $dir Starting directory
     * @return array
     */
    public static function listFolders($dir=APP_CONTROLLERS_PATH){
        $directory = array();
        $elements = scandir($dir);
        foreach($elements as $element){
            if($element != '.' && $element != '..'){
                if(is_dir($dir.'/'.$element)) {
                    $folderName = str_replace(APP_CONTROLLERS_PATH . "/","", $dir. "/" . $element);
                    $directory[] =  $folderName;
                    $directory = array_merge( $directory, self::listFolders($dir . '/' . $element));
                }
            }
        }
        return $directory;
    }

}