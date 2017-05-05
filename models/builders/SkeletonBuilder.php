<?php

namespace models\builders;

use framework\Model;
use \RecursiveDirectoryIterator;

class SkeletonBuilder extends Model
{
    private $subSystems = array();

    private function controllersIterator($iterator = null, $level=1, $current=1,$parent=0,$array_dir = null)
    {

        $outputs  = empty($array_dir) ? array() : $array_dir;
        $iterator = empty($iterator) ? new RecursiveDirectoryIterator(APP_CONTROLLERS_PATH,4096) : $iterator ;

        foreach ($iterator as $path) {
            if ($path->isDir()){
                $currentDirectory = $path->getPathname();
                if ($currentDirectory == "controllers\builders")
                   continue;
                $currentDirectoryToShow = str_replace(RELATIVE_PATH,"",$currentDirectory);
                $this->subSystems[] = array("SubSystem"=>$currentDirectoryToShow);
                $arr = array("ControllerName"=>$currentDirectoryToShow,"Level"=>$level,"Current"=>$current, "Parent" =>$parent, "Type"=>"Namespace/Subsystem");
                $outputs[] = $arr;
                $i = new RecursiveDirectoryIterator($currentDirectory,4096);
                $outputs = $this->controllersIterator($i,$level+1,$current+1,$current,$outputs);
                $current = count($outputs) + 1;
            } else {
                $file = $path->getPathname();
                $fileToShow = str_replace(RELATIVE_PATH,"",$file);
                if (strtolower(substr($file, -4)) == ".php" ) {
                    $arr = array("ControllerName" => $fileToShow, "Level" => $level, "Current" => $current, "Parent" => $parent, "Type" => "Controller");
                    $outputs[] = $arr;
                    $current = $current + 1;
                }
            }

        }
        return $outputs;
    }

    public function getControllers() {
        $controllers = $this->controllersIterator();
        $app_controller_path = str_replace(RELATIVE_PATH,"",APP_CONTROLLERS_PATH);
        $arr = array("ControllerName"=>$app_controller_path . "","Level"=>"0","Current"=>"0","Parent" =>null,"Type"=>"Subsystems root");
        $controllers[] = $arr;
        asort($controllers);
        return $controllers;
    }

    public function getSubsystems()
    {
        if (empty($this->subSystems)) {
            $this->getControllers();
        }
        $app_controller_path = str_replace(RELATIVE_PATH,"",APP_CONTROLLERS_PATH);
        $this->subSystems[] = array("SubSystem"=>$app_controller_path);
        asort($this->subSystems);
        return $this->subSystems;
    }

    /**
     * Builds MVC subsystem folders.
     *
     * @return bool True when successfully writesfolders, else false
     */
    public function createMVCFolders($basePath)
    {

        $os = $this->isWindows() ? true: false;

        $controller_path = @mkdir(APP_CONTROLLERS_PATH. $basePath, 0777,$os) ? true : false;
        $model_path = @mkdir(APP_MODELS_PATH . $basePath, 0777,$os) ? true : false;
        $view_path  = @mkdir(APP_VIEWS_PATH . $basePath,0777,$os) ? true : false;
        $template_path = @mkdir(APP_TEMPLATES_PATH . $basePath,0777,$os) ? true: false ;
        $locale_path = @mkdir(APP_LOCALE_PATH. DIRECTORY_SEPARATOR . "en" . DIRECTORY_SEPARATOR . APP_CONTROLLERS_PATH  . $basePath,0777,$os)? true: false;


        if ($controller_path && $model_path && $view_path && $template_path  && $locale_path) {
            $build = true;
        } else {
            $build = false;
        }

        return $build;
    }

    /**
     * Writes a source code file
     *
     * @param string $destinationPath Destination path
     * @param string $fileName  File name
     * @param string $content  Content
     */
    public function createSourceFile($destinationPath, $fileName, $content)
    {
        if (!file_exists($destinationPath. $fileName)) {
            if (@file_put_contents($destinationPath . $fileName, $content)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Checks if is Windows OS
     * @return bool
     */
    public function isWindows() {
        return (stristr(PHP_OS, 'winnt')!==false || stristr(PHP_OS, 'win32')!==false);
    }

}