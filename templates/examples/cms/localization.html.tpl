<!DOCTYPE html>
<html>
<head>
    <title>Localization example</title>
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

<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">{RES:ProjectName}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="">Home</a></li>
                <li><a href="#about">{RES:Contacts}</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{RES:Setting} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">{RES:LanguageSettings}</li>
                        <li><a href="?locale=en">{RES:English}</a></li>
                        <li><a href="?locale=it-it">{RES:Italian}</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">{RES:GuiSettings}</li>
                        <li><a href="">{RES:LookAndFeel}</a></li>
                    </ul>
                </li>
                <li><a href="..">{RES:Exit}</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h1>{RES:Welcome}</h1>
    <p>{BodyMessage}</p>
    <p>{RES:InfoMessage}</p>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>