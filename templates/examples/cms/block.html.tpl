<!DOCTYPE html>
<html>
<head>
    <title>Block</title>
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
    <h2>Block example</h2>
    <h4>This example shows Blocks usage for data repetition inside a static GUI</h4>
    <h3>{Message}</h3>
    <!-- BEGIN ContentUsers -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <tr>
                <th>First name</th>
                <th>Last name</th>
            </tr>

            <!-- BEGIN Users -->
            <tr>
                <td>{FirstName}</td>
                <td>{LastName}</td>
            </tr>
            <!-- END Users -->
        </table>
    </div>
    <!-- END ContentUsers -->
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>