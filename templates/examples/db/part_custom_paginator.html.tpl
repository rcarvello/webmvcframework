<!DOCTYPE html>
<html>
<head>
    <title>Listing and paginating</title>
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
{Controller:examples\cms\NavigationBar}
<div class="container">
    <h1>{RES:PartsList}</h1>
    <div class="table table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>{RES:part_code}</th>
                <th>{RES:description}</th>
                <th>{RES:source}</th>
                <th>{RES:source_lead_time}</th>
                <th>{RES:measurement_unit_code}</th>
                <th>{RES:part_type_code}</th>
                <th>{RES:part_category_code}</th>
                <th>{RES:wastage}</th>
                <th>{RES:bom_levels}</th>
            </tr>
            </thead>
            <tbody>
            <!-- BEGIN Parts -->
            <tr>
                <td>{part_code}</td>
                <td>{description}</td>
                <td>{source}</td>
                <td>{source_lead_time}</td>
                <td>{measurement_unit_code}</td>
                <td>{part_type_code}</td>
                <td>{part_category_code}</td>
                <td>{wastage}</td>
                <td>{bom_levels}</td>
            </tr>
            <!-- END Parts -->
            </tbody>
            <tfoot>
            <tr>
                <td class = "text-center" colspan="9">{Paginator:Bottom}</td>
            </tr>
            </tfoot>
        </table>
    </div>

</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>