## Introduction

One of the purposes of WebMVC is to provide tools that allow software developers to take advantage of sound principles
when they design and implement complex web applications. An important principle of software engineering is system
decomposition that can be used to split out a software system into smaller interacting parts, called _subsystems_, in
order to dominate the system complexity.

## Subsystems and namespaces

In WebMVC, the decomposition of a software can be pursued considering several perspectives. We have already seen how the
splitting into model, view, and controller can be done. MVC is a canonical architectural pattern that can be applied in
a great variety of software applications, and in a certain sense, we can say that the MVC decomposition pattern can be
used for many application domains regardless of their structure.   
Another decomposition perspective concerns how to split a software with respect to an application domain. Consider, for
example, a software system that has the purpose to manage some fundamental functions of an enterprise such
as `manufacturing`and `crm`(customers relationship management); we call it `minierp`. After the system design phase made
by the software engineer, **the subsystems structure can be represented in WebMVC by means of two fundamental concepts
strictly related to each other**. They are:

* a **hierarchy of directories**, by which, we can organize the different source code files used to compose the software
  application

* **namespaces**, groups of related software entities, e.g. classes or interfaces, that each has a unique name or
  identifier and also a scope in which it was defined

> In the broadest definition **namespaces** are a way of encapsulating items. This can be seen as an abstract concept in
> many places. For example, in any operating system directories serve to group related files, and act as a namespace for
> the files within them. As a concrete example, the file foo.txt can exist in both directory /home/greg and in
> /home/other, but two copies of foo.txt cannot co-exist in the same directory. In addition, to access the foo.txt file
> outside of the /home/greg directory, we must prepend the directory name to the file name using the directory separator
> to get /home/greg/foo.txt. This same principle extends to namespaces in the programming world

For each subsystem, WebMVC uses both directories and namespaces:

* It uses a directory to physically store all its classes, interfaces, functions, and constants.
* Then it uses a namespace, labeled with the same directory name and path, to load, refer and use each class (or
  interface, function, etc.) needs to be instantiated and executed;

## Naming convention for subsystems and namespaces

WebMVC directories and namespaces must mandatory have

* identical names
* identical path
* they must be conventionally written in lowercase
* it is also preferable to use shorts and semantically descriptive names.

## A practical example of subsystems

For example, if we decide to implement the subsystem `manufacturing` for the `minierp` application we previously
introduced, we must define:

1. `controllers\manufacturing` - the **directory path** where to store classes for the manufacturing subsystem;
2. `controllers\manufacuring` - the **namespace** that we must use when coding each class of the manufacturing
   subsystem.

An excerpt of directory structure for the minierp web application is shown in figure 6.1.   
**We must mandatory use two decomposition levels for defining the directories structure**:

1. the first is the **MVC decomposition**, the directories controllers, models, views and templates
2. the second is provided by the directories structure we have for representing the **application domain**.
   **Important!** we have a replica of the **application domain directories structure** within the models, views,
   controllers, and templates directory.

Figure 6.1. _An excerpt of the static system decomposition of minierp._

![](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/minierp_structure.png)

In the minierp software, the initial application domain decomposition is made by the subsystems `crm `,
and `manufacturing`; the latter comprises the class `Inventory`.
Note that the directory `controllers `is the root directory from which all application controllers for the defined
subsystems can be invoked. This is because in WebMVC the directory controllers is the entry point to access application
software functionalities. You can also note the replica of application domain directories structure (we did at
controllers folder level) within models directory, views, and templates.

## How to invoke a subsystem controller class

In the [Controller page](https://github.com/rcarvello/webmvcframework/wiki/Controller), we have learned how to invoke a
controller from the URL according to the format:

`http://site/controller`

`http://site/controller/method/param1/param2/.../paramn`

where the automatic conversion from the URL to the class name works, for example, as follows:

`http://localhost/hello_world/say_hello_message/Mark`  =>   `controllers\UserManager->sayHelloMessage('Mark')`

**We extend this convention in order to call a controller class located within a subsystem using formats like**:

`http://site/subsystem/controller/method/param1/param2/.../paramn`

`http://site/subsystem/.../subsystem/controller/method/param1/param2/.../paramn.`

## Managing the inventory record

An example taken from the minierp web application concerns the presentation of the _inventory records list_ whose code
is located within the subsystem `manufacturing/Inventory`. It is a simplified version of a software application that
aims at the inventory management of a manufacturing industry. The inventory table is taken from the database named
minierp and is made of the following attributes:

* `code` -> the record key
* `description` -> the description of the good maintained in the inventory
* `stock` -> quantity in stock

The task to retrieve the inventory records is in charge of the `Inventory model`:

```php
namespace models\manufacturing;

use framework\Model;

class Inventory extends Model
{
    public function getInventory()
    {
        $this->sql = "SELECT * FROM inventory";
        $this->updateResultSet();
	return $this->getResultSet();
    }
}
```

Next, the `Inventory view` class receives the records retrieved by the model and proceeds with the substitution of the
template placeholders contained in `/manufacturing/inventory` with the values taken from the records. The Inventory view
takes advantage of the concept of block.

```php
namespace views\manufacturing;

use framework\View;

class Inventory extends View
{
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/manufacturing/inventory";
        parent::__construct($tplName);
    }

    public function setInventoryBlock(\mysqli_result $resultset){
        $this->openBlock("Parts");
        while ($part = $resultset->fetch_object()) {
            $this->setVar("code",$part->code);
            $this->setVar("description",$part->description);
            $this->setVar("stock",$part->stock);
            $this->parseCurrentBlock();
        }
        $this->setBlock();
    }
}        
```

The file `inventory.html.tpl` simply arranges the output in the form of a table. The block named `Parts` states how the
record retrieved by the inventory table will be rendered in output one row at a time by the Inventory view.

```html template
 <!DOCTYPE html>
<html>
<head>
    <title>Inventory</title>
</head>
<body>
    <h1>Inventory</h1>
	<table>
            <thead>
                    <th>code</th>
                    <th>description</th>
                    <th>stock</th>
            </thead>
            <tbody>
                <!-- BEGIN Parts -->
                <tr>
                    <td>{code}</td>
                    <td>{description}</td>
                    <td>{stock}</td>
                </tr>
                <!-- END Parts -->
            </tbody>
        </table> 
</body>
</html>
```

Finally, the code of the `Inventory controller` coordinates, as usual, the work made by the model and the view. We
remark that the function `showInventory()` has to be public; it first invokes the method `getInventory()` from the
model, then it passes the result set to the method `setInventoryBlock()` of the view that arranges for the placeholder
substitutions with the values contained in the retrieved records.

```php 
namespace controllers\manufacturing;

use framework\Controller;
use framework\Model;
use framework\View;

use models\manufacturing\Inventory as InventoryModel;
use views\manufacturing\Inventory as InventoryView;


class Inventory extends Controller
{
    public function __construct(View $view=null, Model $model=null)
    {
        $this->view = empty($view) ? $this->getView() : $view;
        $this->model = empty($model) ? $this->getModel() : $model;
        parent::__construct($this->view,$this->model);
    }

   public function showInventory() {
		$inventoryResultSet = $this->model->getInventory();
		$this->view->setInventoryBlock($inventoryResultSet);
		$this->render();
   }
    
    public function getView()
    {
        $view = new InventoryView("/manufacturing/inventory");
        return $view;
    }

    public function getModel()
    {
        $model = new InventoryModel();
        return $model;
    }
}
```

Assuming that in the table inventory there are data of components necessary to build a digital mouse, we can get the
output typing:

`http://localhost/minierp/manufacturing/inventory/show_inventory`

![](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/inventory_output.png)

## Summary

Subsystems allow splitting software with respect to an application domain. After the system design phase made by the
software engineer, the subsystems structure can be represented in WebMVC by means of two fundamental concepts strictly
related to each other. They are:

* a hierarchy of directories
* the namespace  
  For each subsystem, WebMVC uses a directory to physically store all its classes and uses a namespace to refer each
  class when it needs to be instantiated and executed.  
  Into WebMVC package you will find different examples of
  subsystems [here](https://github.com/rcarvello/webmvcframework/wiki/Examples)

## What's Next

In the next section, you will learn how WebMVC let you apply another pattern
for [decomposing the content of an application](https://github.com/rcarvello/webmvcframework/wiki/Content-based-decomposition-and-HMVC)