<!DOCTYPE html>
<html>
<head>
    <title>Static replacement example</title>
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
    <h1>Static replacement example</h1>
    <p>
        This example shows the static replacement by using a special type of placeholder having the
        following format:<br><br>&nbsp;
    {<span>STATICTPL:<strong>template_file_name</strong></span>}<br>
    </p>
    <div class="well">
        By using this type of placeholder and by replacing <strong>template_file_name</strong>
        with the name of an existing file located in the templates folder (by omitting html.tpl extension),
        the framework automatically will render its static content.
    </div>
    <div class="well">
        Below we put the placeholder {<span>STATICTPL:<strong>examples\cms\static_content</strong></span>}<br>
        Framework will automatically render the file <strong>templates\examples\cms\static_content.html.tpl</strong>
    </div>

    <br />
    {STATICTPL:examples\cms\static_content}

    <a href="{GLOBAL:SITEURL}/examples/" class="btn btn-primary">Examples TOC</a>

</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
