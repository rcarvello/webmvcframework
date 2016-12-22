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
    <h1>Overview of PHP Web MVC Framework - Example 01a</h1>

    <!-- Example -->
    <div class="panel panel-primary">
        <div class="panel-body">
            <h3>{Message}</h3>
        </div>
    </div>

    <!-- Example actions-->
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-cog"></span> Use the links below for running Hello Controller, its methods or for throwing the exceptions. Then <strong>look at the web browser URL</strong></h3>
        </div>
        <div class="panel-body">
            <ul>
                <li><a href="http://{siteurl}/example01/hello"><span class="text-success">Run</span> Hello Controller without method (default page)</a></li>
                <li><a href="http://{siteurl}/example01/hello/simple_method"><span class="text-success">Invoke</span> simpleMethod() of Hello Controller</a></li>
                <li><a href="http://{siteurl}/example01/hello/another_method/param1/param2"><span class="text-success">Invoke</span> anotherMethod(param1,param2)of Hello Controller</a></li>
                <li><a href="http://{siteurl}/example01/hello/another_method/parameterA/parameterB"><span class="text-success">Invoke</span> anotherMethod() by changing its parameters value</a></li>
                <li><a href="http://{siteurl}/example01/hello_new"><span class="text-danger">Throw</span> when try to call a Controller that is not found into example01 subsystem</a></li>
                <li><a href="http://{siteurl}/example01/hello/basic_method"><span class="text-danger">Throw</span> when try to invoke a method that is not found into Hello Controller</a></li>
                <li><a href="http://{siteurl}/example01/hello/get_site_url"><span class="text-danger">Throw</span> when try to invoke a method that is private or protected into Hello Controller</a></li>
                <li><a href="http://{siteurl}/example01/hello/another_method/param1/param2/param3"><span class="text-danger">Throw</span> when try to invoke an exisiting method but passing to it incorrect number of parameters</a></li>
            </ul>
        </div>
    </div>

    <!-- Example information-->
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-question-sign"></span> Information about this example</h3>
        </div>
        <div class="panel-body">
            This is the first example of the MVC Framework. It shows:<br>
            <ul>
                <li>
                    The source code organization by using namespaces for mapping
                    of subsystems/directories.
                    In this example we are using <strong>example01</strong> and, as you can see,
                    we are referencing to it directly into the Web browser URL request
                </li>
                <li>The source code for classes and the HTML template composing the
                    Hello MVC Instance is organized into (see the source code):
                    <ul>
                        <li><code>controllers\example01\Hello.php</code> The Controller</li>
                        <li><code>models\example01\Hello.php</code> The Model</li>
                        <li><code>views\example01\Hello.php</code> The View</li>
                        <li><code>templates\example01\hello.html.tpl</code> The GUI Template</li>
                    </ul>
                </li>
                <li>Classes PascalCase names and Methods CamelCase names have their respective representation into the browser URLs by using LowerCase with UnderscoredCase names </li>
                <li>
                    The instantiation of the Hello Controller is made by using a
                    SEO friendly URL request having the following format:
                    <ul>
                        <li><code>http://myhost/example01/hello</code></li>
                    </ul>
                </li>
                <li>
                    The assignment of a value, which is provided by the Model, to a simple
                    placeholder: "{message}" (Please, look into Hello controller, model, view
                    and template source code for details)
                </li>
                <li>
                    The invocation of a simple method provided by the Hello Controller is made by
                    using a SEO friendly URL request having the following format:
                    <ul>
                        <li><code>http://myhost/example01/hello/simple_method</code></li>
                    </ul>
                </li>
                <li>
                    The invocation of another method with its parameters provided by the Hello
                    Controller is made by using a SEO friendly URL request having the following
                    format:
                    <ul>
                        <li><code>http://myhost/example01/hello/another_method/param1/param2</code></li>
                    </ul>
                </li>
                <li>
                    Show the Exceptions' throwing for invalid calls of controllers,
                    methods and parameters
                </li>
            </ul>
        </div>
    </div>

    <!-- Navigation -->
    <a href="http://{siteurl}/example01/hello" class="btn btn-primary"><span class="glyphicon glyphicon-home"></span> Example Home</a>
    <a href="http://{siteurl}/example01/hello_extended" class="btn btn-primary">Next Example <span class="glyphicon glyphicon-chevron-right"></span></a>

</div>
</body>
</html>