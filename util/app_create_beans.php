<?php
error_reporting(E_ALL);
include_once("mysqlreflection/mysqlreflection.config.php");
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>MySQL Database Bean Builder</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap core CSS -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->
    <script type="text/javascript" src="http://gc.kis.v2.scr.kaspersky-labs.com/11F1C66A-3ADD-7A47-AD0A-773DFF1E736D/main.js" charset="UTF-8"></script></head>
    <style>
        .progress {
                background: rgba(204, 237, 220, 1);
                border: 5px solid rgba(56, 46, 166, 0.27);
                border-radius: 10px; height: 36px;
        }
    </style>
<script>
    var globalCount =0 ;
    var globalPercent = 0;
</script>
<body>
<div class="container">
    <h1>MySQL Database Beans generator</h1>
    <h3>This utility performs automatically  a source code generation of PHP
        Classes from MySQL tables </h3>
    <h4>Current database :<?= DBNAME ?> (to change it edit mysqlreflection.config.php)</h4>
    <a class="btn btn-success" onclick="document.getElementById('results').value = ''" href="?build=1"><span class="glyphicon glyphicon-wrench"></span> Generate classes</a>
    <a href="../builders/index" class="btn btn-info"><span class="glyphicon glyphicon-home"></span> Home</a>
    <br />  <br />
    <div class="progress progress-striped">
        <div class="progress-bar" role="progressbar" aria-valuenow="0"
             aria-valuemin="0" aria-valuemax="100" style="width:0%">
        </div>
    </div>

    <div class="text-center">
        <textarea cols="140" rows="20" id="results" name "results"></textarea>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script>
    function aggiornaProgressBar(done=false) {
        var step = 2;
        var progress = $('.progress-bar');
        var currentValue = parseInt(progress.attr("aria-valuenow"));
        globalCount = globalCount +1;
        globalPercent = globalPercent +1;
        if (currentValue==100) {
            currentValue = 50;
        }
        currentValue += 1;
        progress.attr("aria-valuenow",currentValue);
        var percValue = currentValue + '%';
        progress.css('width',percValue);

        var textarea = document.getElementById('results');
        textarea.scrollTop = textarea.scrollHeight;

        if (done) {
            progress.attr("aria-valuenow",100);
            progress.css('width',"100%");
            percValue = "Done. " + globalCount + " classes were generated";
        }
        progress.html(percValue);
    }

    function aggiornaTextArea(msg){
        var m = msg + '&#xA;';
        $('#results').append(m);

    }

    function setNumberOfTables(ntables){
        if (numberOfTables === 'undefined' || !numberOfTables)
            var numberOfTables=ntables;
    }
</script>

</body>

<?php
if (isset($_GET["build"])) {
    /**
     *  Demo application: generate classes from a mysql db schema
     */

    // CLI mode
    // error_reporting(E_ALL);
    // include_once("mysqlreflection/mysqlreflection.config.php");
    // header('Content-Type: text/html; charset=utf-8');

    $msg = "Building classes for mysql schema:[" . DBNAME . "]";
    // CLI mode
    // echo $msg;
    echo "<script>$('#results').append('" . $msg . "');</script>";

    // Destination path for the generated classes
    $destinationPath = dirname(__FILE__) . "/../models/beans/";
    // $destinationPath = "source/";

    // Create reflection object and invoke classes generation from the specified schema into mysql_connection.inc.php
    $reflection = new MVCMySqlSchemaReflection();

    // Generates the classes into the given path. During the generation it outputs the results.
    $reflection->generateClassesFromSchema($destinationPath);

    // CLI Mode
    // echo "<hr>Done.";
    // echo "<script> window.scrollTo(0,document.body.scrollHeight);</script>";

    echo "<script>$('#results').append('" . "Done." . "&#xA;" . "');</script>";
    echo "<script>aggiornaProgressBar(true);</script>";
}
?>