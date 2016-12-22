<!DOCTYPE html>
<html>
<head lang="en">
    <head lang="en">
        <meta charset="UTF-8">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <title>Welcome to Web MVC Framework - example01</title>
    </head>
</head>
<body>
<div class="container">
    <h1>Overview of PHP Web MVC Framework - Example 01b</h1>

    <!-- Example -->
    <div class="panel panel-primary">
        <div class="panel-body">
            <h3>{Message}</h3>
            <ul>
                <!-- BEGIN ListItems -->
                <li>{Item}</li>
                <!-- END ListItems -->
            </ul>
        </div>
    </div>

    <!-- Example actions-->
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-cog"></span> Use the links below for running Hello_Extended Controller, its methods or for throwing the exceptions. Then <strong>look at the web browser URL</strong></h3>
        </div>
        <div class="panel-body">
            <ul>
                <li><a href="http://{siteurl}/example01/hello_extended"><span class="text-success">Run</span> Hello_Extended Controller that specializes the Hello Controler(default page)</a></li>
                <li><a href="http://{siteurl}/example01/hello_extended/simple_method"><span class="text-success">Invoke inherited</span> simpleMethod() from Hello Controller</a></li>
                <li><a href="http://{siteurl}/example01/hello_extended/another_method/param1/param2"><span class="text-success">Invoke inherited</span> anotherMethod(param1,param2) from Hello Controller</a></li>
                <li><a href="http://{siteurl}/example01/hello_extended/another_method/parameterA/parameterB"><span class="text-success">Invoke inherited</span> anotherMethod() by changing its parameters value</a></li>
                <li><a href="http://{siteurl}/example01/hello_extended/hide_list"><span class="text-success">Invoke </span> hideList() of HelloExtended Controller</a></li>
                <li><a href="http://{siteurl}/example01/hello"><span class="text-success">Run and return to</span> parent Hello Controller</a></li>
            </ul>
        </div>
    </div>

    <!-- Example information-->
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-question-sign"></span> Information about this example</h3>
        </div>
        <div class="panel-body">
            This is the second example of the MVC Framework. It extends previous Hello Controller with the following features:<br>
            <ul>
                <li>It shows and provides the same contents and service of the previous Hello
                Controller simply by extending it</li>
                <li>
                    It adds some new services for showing and hiding a list of string items into a
                    template block named ListItems which is identified by some html and placeholders
                    beteween a special comment. A block has the following format: <br>
                    Template code (see <code>hello_extented.html.tpl</code>)
                    <pre>
&lt;ul&gt
    &lt;!- BEGIN ListItems --&gt
        &lt;li&gt{item}&lt;/li&gt
    &lt;!- END ListItmes --&gt
&lt;/ul&gt</pre>
PHP Code for rendering block is: (see <code>HelloExtended.php </code>Controller)
<pre>
private function setList(View $view)
{
    $listItems = array("item a", "item b", "item c");
    $view->openBlock("ListItems");
    foreach($listItems as $item){
        $view->setVar("item",$item);
        $view->parseCurrentBlock();
    }
    $view->setBlock();
}
</pre>
                </li>
                <li>The source code for classes and the HTML template composing the
                    Hello_Extended MVC Instance is organized into (see the source code)
                    some new files and by using some existing files designed for Hello MVC Instance:
                    <ul>
                        <li><code>controllers\example01\HelloExtented.php</code> The Controller. A class that Extentds Hello Controller</li>
                        <li><code>models\example01\Hello.php</code> The Model. HelloExtended Share the Model designed for Hello
                            Controller.</li>
                        <li><code>views\example01\Hello.php</code> The View. HelloExtended Share the View designed for Hello
                            Controller but replaces its template with a new one.</li>
                        <li><code>templates\example01\hello_extended.html.tpl</code> The new GUI Template used by the view. It contains a Placeholder for the message and a Block for showing the items list</li>
                    </ul>
                </li>
                <li>
                    The instantiation of the Hello_Extented Controller is made by using a
                    SEO friendly URL request having the following format:
                    <ul>
                        <li><code>http://myhost/example01/hello_extended</code></li>
                    </ul>
                </li>
                <li>
                    The assignment of a value, which is provided by the Model, to a simple
                    placeholder: "{message}". Look into the inherited Hello controller, model, view
                    and template source code for details. Look into HelloExtended MVC Instance for the new features regarding
                    the items List.
                </li>
                <li>
                    The invocation of a simple method provided by the inherited Hello Controller is made by
                    using a SEO friendly URL request having the following format:
                    <ul>
                        <li><code>http://myhost/example01/hello_extended/simple_method</code></li>
                    </ul>
                </li>
                <li>
                    The invocation of another inherited method with its parameters provided by the parent Hello
                    Controller is made by using a SEO friendly URL request having the following
                    format:
                    <ul>
                        <li><code>http://myhost/example01/hello_extended/another_method/param1/param2</code></li>
                    </ul>
                </li>
                <li>
                    The invocation hideList() method owned by the Hello_Extended
                    Controller is made by using a SEO friendly URL request having the following
                    format:
                    <ul>
                         <li><code>http://myhost/example01/hello_extended/hide_list</code></li>
                    </ul>
                    hideList() uses the abstract Controller functionality for hiding blocks.
                </li>
            </ul>
            Below the UML diagram of Hello and HelloExtended MVC Classes and HTML Templates
            <img src="http://{siteurl}/imgs/example01.png" class="img-responsive" alt="example01">
        </div>
    </div>

    <!-- Navigation -->
    <a href="http://{siteurl}/example01/hello" class="btn btn-primary"><span class="glyphicon glyphicon-home"></span> Example Home</a>
    <a href="#" class="btn btn-primary">Next Example <span class="glyphicon glyphicon-chevron-right"></span></a>


</div>