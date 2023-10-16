<!DOCTYPE html>
<html>
<head>
    <title>Listing, paginating, sorting and searching</title>
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
{Controller:examples\cms\NavigationBar}
<div class="container">
    <h1>{RES:PartsList}</h1>

    {Searcher:ricerca}
    <a href="part_record/add/new" class="btn btn-info"><span class="glyphicon glyphicon-plus-sign"></span> {RES:AddNewPart}</a>
    <div class="table table-responsive">
        <table class="table table-bordered" id="parts">
            <thead>
            <tr>
                <th>{SorterBootstrap:part_code}</th>
                <th>{SorterBootstrap:description}</th>
                <th>{SorterBootstrap:source}</th>
                <th>{SorterBootstrap:source_lead_time}</th>
                <th>{SorterBootstrap:measurement_unit_code}</th>
                <th>{SorterBootstrap:part_type_code}</th>
                <th>{SorterBootstrap:part_category_code}</th>
                <th>{SorterBootstrap:wastage}</th>
                <th>{SorterBootstrap:bom_levels}</th>
            </tr>
            </thead>
            <tbody>
            <!-- BEGIN Parts -->
            <tr>
                <td><a href="part_record/open/{part_code}">{part_code}</a></td>
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
                <td class = "text-center" colspan="9">{PaginatorBootstrap:Bottom}</td>
            </tr>
            </tfoot>
        </table>
        <hr>
        <a href="{GLOBAL:SITEURL}/examples/about/example/partListManager" class="btn btn-info">{RES:ShowCode}</a>
        <a href="{GLOBAL:SITEURL}/examples/db/part_list_manager/" class="btn btn-success">{RES:ShowTemplate}</a>
        <a href="{GLOBAL:SITEURL}/examples/db/part_list_manager" class="btn btn-success">{RES:ShowRun}</a>
        <a href="{GLOBAL:SITEURL}/examples/" class="btn btn-primary">{RES:ShowToc}</a>
    </div>

</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>