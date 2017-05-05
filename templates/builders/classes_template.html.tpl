<!-- BEGIN Controller --><?php
/**
 * Class {classname}
 *
 * {ControllerResponsability}
 *
 * @package {controllers}{namespace}
 * @category Application Controller
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace {controllers}{namespace};

use framework\Controller;
use framework\Model;
use framework\View;
use {models}{namespace}\{classname} as {classname}Model;
use {views}{namespace}\{classname} as {classname}View;

class {classname} extends Controller
{
    protected $view;
    protected $model;

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
    }

    /**
    * Autorun method. Put your code here for running it after object creation.
    * @param mixed|null $parameters Parameters to manage
    *
    */
    protected function autorun($parameters = null)
    {

    }

    /**
    * Inizialize the View by loading static design of {template_path}/{template_file}.html.tpl
    * managed by {views}{namespace}\{classname} class
    *
    */
    public function getView()
    {
        $view = new {classname}View("{template_path}/{template_file}");
        return $view;
    }

    /**
    * Inizialize the Model by loading {models}{namespace}\{classname} class
    *
    */
    public function getModel()
    {
        $model = new {classname}Model();
        return $model;
    }
}
<!-- END Controller -->
<!-- BEGIN Model --><?php
/**
 * Class {classname}
 *
 * {ModelResponsability}
 *
 * @package {models}{namespace}
 * @category Application Model
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace {models}{namespace};

use framework\Model;

class {classname} extends Model
{
    /**
    * Object constructor.
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Autorun method. Put your code here for running it after object creation.
    * @param mixed|array|null $parameters Additional parameters to manage
    *
    */
    protected function autorun($parameters = null)
    {

    }
}
<!-- END Model -->
<!-- BEGIN View --><?php
/**
 * Class {classname}
 *
 * {ViewResponsability}
 *
 * @package {controllers}{namespace}
 * @category Application View
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace {views}{namespace};

use framework\View;

class {classname} extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "{template_path}/{template_file}";
        parent::__construct($tplName);
    }
    {views_functions}
}
<!-- END View -->
<!-- BEGIN FUNCTION_SET_VAR -->
    /**
    * Sets value for {PLACEHOLDER} placeholder
    *
    * @param mixed $value
    */
    public function setVar{PLACEHOLDER}($value)
    {
        $this->setVar("{PLACEHOLDER}",$value);
    }
<!-- END FUNCTION_SET_VAR -->
<!-- BEGIN FUNCTION_OPEN_BLOCK -->
    /**
    * Opens block {BLOCK}
    *
    */
    public function openBlock{BLOCK}()
    {
        $this->openBlock("{BLOCK}");
    }
<!-- END FUNCTION_OPEN_BLOCK -->
<!-- BEGIN FUNCTION_SET_BLOCK_VAR -->
    /**
    * Sets value for {PLACEHOLDER} inside the block {BLOCK}
    *
    * @param mixed $value
    */
    public function setBlockVar{BLOCK}{PLACEHOLDER}($value)
    {
        $this->setVar("{PLACEHOLDER}",$value);
    }
<!-- END FUNCTION_SET_BLOCK_VAR -->
<!-- BEGIN Template --><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{classname}</title>
</head>
<body>
</body>
</html>
<!-- END Template -->

