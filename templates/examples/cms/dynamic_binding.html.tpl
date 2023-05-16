<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <title>Dynamic binding</title>
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

</head>
<body>
<div class="container">
    <h3>This example show how to dinamically bind a Controller</h3>

    <a href="{GLOBAL:SITEURL}/examples/cms/dynamic_binding/bind_hello">Bind Hello</a> <br>
    <a href="{GLOBAL:SITEURL}/examples/cms/dynamic_binding/bind_block">Bind Block</a> <br>
    <a href="{GLOBAL:SITEURL}/examples/cms/dynamic_binding">Reset</a> <br><br>
    <a href="{GLOBAL:SITEURL}/examples/index">Home</a> <br> <br>
    <!-- BEGIN Info -->
        After this row, depending on the click you choose, you will see a
        Controller dynamically bounded to the following placeholder
    <!-- END Info -->

</div>
{Dynamic:whitchController}
</body>
</html>
