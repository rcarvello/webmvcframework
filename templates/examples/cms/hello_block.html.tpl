<!DOCTYPE html>
<html>
<head>
    <title>Hello world second version</title>
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

<div class="container">

    <h1>{WelcomeMessage}</h1>
    <div class="well">
        This example introduces BLOCK
    </div>
    <!-- BEGIN Users -->
    <div class="row">
        <div class="col-md-6 col-xs-6">{Name}</div>
        <div class="col-md-6 col-xs-6">{Location}</div>
    </div>
	<!-- END Users -->

    <a href="{GLOBAL:SITEURL}/examples/about/example/hello_block" class="btn btn-info">Show source code</a>
    <a href="{GLOBAL:SITEURL}/examples/cms/hello_block/" class="btn btn-success">Template</a>
    <a href="{GLOBAL:SITEURL}/examples/cms/hello_block" class="btn btn-success">Run again</a>
    <a href="{GLOBAL:SITEURL}/examples/" class="btn btn-primary">Examples TOC</a>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>