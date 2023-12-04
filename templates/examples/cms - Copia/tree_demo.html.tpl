<!DOCTYPE html>
<html>
<head>
    <title>Tree Structure Demo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"
          media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->

</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{RES:Setting} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">{RES:LanguageSettings}</li>
                        <li><a href="?locale=en">{RES:English}</a></li>
                        <li><a href="?locale=it-it">{RES:Italian}</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">{RES:GuiSettings}</li>
                        <li><a href="">{RES:LookAndFeel}</a></li>
                    </ul>
                </li>
                <li><a href="{GLOBAL:SITEURL}/examples/">{RES:Exit}</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h1>{RES:TreeStructureMsg}</h1>
    <hr>

    <!-- BEGIN TreeBlock -->
    <div id="tree-div-container" style="display:none">
        <ul class="tree" id="mytree">
            {TreeStructure:MyTree}
        </ul>
    </div>
    <a id="exp_tree" href="#">{RES:ExpandTree}</a> | <a id="col_tree" href="#">{RES:CollapseTree}</a>
    <!-- END TreeBlock -->

    <!-- BEGIN LinkClickBlock -->
    Method <b>linkClick</b>
    <br><a href="{GLOBAL:SISTEURL}/examples/cms/tree_demo">Back</a>
    <!-- END LinkClickBlock -->
    <hr>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script>
    jQuery(document).ready(function ($) {

        /* Init Tree */
        $(".tree").tree();

        /*Custom page initialization */

        /* Collapse drom level 2 */
        $("#mytree ul:nth-child(2)").css("display", "none");

        /* Show div containing the tree (by default it was manually hidden for hiding collapse effects) */
        $("#tree-div-container").css("display", "");

        /* Custom Expand Tree link action */
        $("#exp_tree").click(function () {
            $("#mytree ul:nth-child(2)").css("display", "block");
        });

        /* Custom Collapse Tree link action */
        $("#col_tree").click(function () {
            $("#mytree ul:nth-child(2)").css("display", "none");
        });
    });
</script>
</body>
</html>