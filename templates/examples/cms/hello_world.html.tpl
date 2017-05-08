<!DOCTYPE html>
<html>
<head>
    <title>Hello World Example</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap core CSS -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->
</head>
<body>

<div class="container">
    <h1>Web MVC Framework</h1>
    <h2>Hello World</h2>
    <p>
        This example shows the basic concept for data communication among all the MVC layers.<br>
        It uses a simple <strong>placeholder</strong>, located inside of the GUI static design,
        for placing data provided from model and through the following control flow:<br><br>
    </p>
    <div class="well">
        <ol class="h5">
            <li>HTTP Request => Dispatcher => Controller</li>
            <li>Model <=> Controller <=> View <= Template</li>
            <li>Controller => Dispatcher => Response</li>
        </ol>
    </div>
    <p> 1) and 3) are automatically handled by the framework dispatcher</p>
    <p> 2) is made by extending the Framework Classes (Controller,Model,View)and by consuming their services</p>

    <h3>{Message}</h3>
    <br /><br />

    <a href="../about/example/helloWorld" class="btn btn-info">Show source code</a>
    <a href=".." class="btn btn-primary">Examples TOC</a>

</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>