The simpler component made available by WebMVC is `framework\components\DataRepeater` to easy the displaying of data
coming from a given source. Two possible scenarios where the DataRepeater can be conveniently used are when: a list of
records from a database or data stored in an array must be provided in the output according to a given visualization
structure.   
In the example above example, implemented by coding the `SimpleDataRepeater` assembly, we show how an instance
of `framework\components\DataRepeater` will provide data repetition from different data sources, array and DB, and how
you can use it.

First of all the code for `templates\simple_data_repeater.html.tpl` where a Block Parts is designed to renders data.

```html
<!DOCTYPE html>
<html>
<head>
    <title>DataRepeater component</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->
</head>
<body>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
<div class="container-fluid">
    <h2>Part list example using the DataRepeater component</h2>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Part code</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                   	<!-- BEGIN Parts -->
                     <tr>
                        <td>{part_code}</td>
                        <td>{description}</td>
                    </tr> 
                	<!-- END Parts -->
                </tbody>
            </table>
        </div>
    </div>
</div>
</html>
```

Here the simple `views\SimpleDataRepetaer.php`

```php
<?php
namespace views;

use framework\View;

class SimpleDataRepeater extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/simple_data_repeater";
        parent::__construct($tplName);
    }
    
}
```

Below we show the `models\SimpleDataRepetaer.php` in which we coded two methods `getPartsFromArray()`
and `getPartsFromDB()` (read code comments) providing respectively data from array and DB. You will find the DDL of the
table `part` [here](https://github.com/rcarvello/webmvcframework/blob/master/sql/mrp.sql) (lines from 171 to 198)

```php
<?php

namespace models;

use framework\Model;

class SimpleDataRepeater extends Model
{

    public function getPartsFromArray()
    {

        $users = array(
            array('part_code' => '1', 'description' => 'description 1'),
            array('part_code' => '2', 'description' => 'description 2'),
            array('part_code' => '3', 'description' => 'description 3'),

        );
        return $users;
    }

    /**
     * Provides parts from table part
     *
     * @return \mysqli_result
     * @note  resultset must be in a proper keys and number of columns
     * required by the Block which is used by the Datarepeater
     * component.
     */
    public function getPartsFromDB()
    {
       $this->sql = "SELECT part_code,description FROM part";
       $this->updateResultSet();
    }

}
```

Finally the code for `controllers\SimpleDataRepeater`

```php
<?php

namespace controllers;

use framework\components\DataRepeater;
use framework\Controller;
use framework\Model;
use framework\View;
use models\SimpleDataRepeater as SimpleDataRepeaterModel;
use views\SimpleDataRepeater as SimpleDataRepeaterView;

class SimpleDataRepeater extends Controller
{
    protected $view;
    protected $model;

    /**
     * SimpleDataRepeater constructor.
     *
     * @param View|null $view
     * @param Model|null $model
     * @throws \framework\exceptions\TemplateNotFoundException
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
        $this->useArray();
        // $this->useDB();
        // $this->manualSetupArray();
        // $this->manualSetupDB();
    }

    /**
     * DataReapeter smart initialization and usage with array values
     *
     * @throws \ReflectionException
     * @throws \framework\exceptions\NotInitializedViewException
     * @throws \framework\exceptions\TemplateNotFoundException
     * @throws \framework\exceptions\VariableNotFoundException
     */
    public function useArray(){
        $parts = $this->model->getPartsFromArray();
        $repeater = new DataRepeater($this->view,null,"Parts",$parts);
        $this->bindComponent($repeater);
    }


    /**
     * DataReapeter smart initialization and usage with DB values
     *
     * @throws \ReflectionException
     * @throws \framework\exceptions\NotInitializedViewException
     * @throws \framework\exceptions\TemplateNotFoundException
     * @throws \framework\exceptions\VariableNotFoundException
     */
    public function useDB() {
        $this->model->getPartsFromDB();
        $repeater = new DataRepeater($this->view,$this->model,"Parts",null);
        $this->bindComponent($repeater);
    }


    /**
     *  DataReapeter manual initialization and usage with array values
     */
    public function manualSetupArray(){
        $parts = $this->model->getPartsFromArray();
        $repeater = new DataRepeater();
        $repeater->setView($this->view);
        $repeater->setContentToBlock("Parts");

        $repeater->setValuesFromArray($parts);
        $repeater->render();
    }

    /**
     *  DataReapeter manual initialization and usage with DB values
     */
    public function manualSetupDB(){
        $this->model->getPartsFromDB();
        $repeater = new DataRepeater();
        $repeater->setView($this->view);
        $repeater->setModel($this->model);
        $repeater->setContentToBlock("Parts");

        $repeater->setValuesFromModel();
        $repeater->render();
    }



    /**
    * Initialize the View by loading static design of /simple_data_repeater.html.tpl
    * managed by views\SimpleDataRepeater class
    *
    */
    public function getView()
    {
        $view = new SimpleDataRepeaterView("/simple_data_repeater");
        return $view;
    }

    /**
    * Initialize the Model by loading models\SimpleDataRepeater class
    *
    */
    public function getModel()
    {
        $model = new SimpleDataRepeaterModel();
        return $model;
    }
}
```

In the above code, you will find the following methods. Each one uses different data source and initialization mode for
the DataRepeater component:

* `useArray()`
* `useDB()`
* `manualSetupArray()`
* `manualSetupDB()`

Please read code comments and implementations for technical details regarding the methods above. Let only one of them be
uncommented inside the `autorun` method for showing it's output when running `SimpleDataRepeater`.
