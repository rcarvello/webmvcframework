<!DOCTYPE html>
<html>
<head>
    <title>About this example</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap core CSS -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.11.0/styles/atelier-cave-light.min.css" />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.11.0/highlight.min.js"></script>
    <script>
        hljs.tabReplace = '    ';
        hljs.initHighlightingOnLoad();
    </script>
</head>
<body>

<div class="container">
    <h1>About this example : {Example}</h1>
    <h3>Controller</h3>
    <h4>{ControllerFile}</h4>
    {Controller}
    <h3>Model</h3>
    <h4>{ModelFile}</h4>
    {Model}
    <h3>View</h3>
    <h4>{ViewFile}</h4>
    {View}
    <h3>HTML Template</h3>
    <h4>{TemplateFile}</h4>
    <pre><code class="html">{Template} </code></pre>
    <br><br>
    <a href="#" class="btn btn-primary" onclick="history.back()">Back</a>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>


<script type="text/javascript">
</script>

</body>
</html>