<!DOCTYPE html>
<html>
<head>
    <title>Listing, paginating, sorting and searching</title>
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


    <div id="search-panel" class="panel panel-primary collapse in" aria-expanded="true">
        <div class="panel-heading">
            <h3 class="panel-title">{RES:SearchFormTitle}</h3>

        </div>

        <form class="form-horizontal" method="post" name="{search_form}">
            <div class="panel-body">

                <div class="form-group row">
                    <label class="col-sm-2 control-label text-right"><label>{RES:PartCodeLabel}</label></label>
                    <div class="col-sm-10">
                        <input type="text"  value="{s_part_code}" name="s_part_code" id="s_part_code" placeholder="{RES:PartCodePlaceholder}" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 control-label text-right"><label>{RES:PartDescriptionLabel}</label></label>
                    <div class="col-sm-10">
                        <input type="text" value="{s_description}" name="s_description" id="s_description" placeholder="{RES:PartDescriptionPlaceholder}" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 control-label text-right"><label>{RES:SourceLabel}</label></label>
                    <div class="col-sm-10">
                        <select class="form-control" name="s_source" id="s_source">
                            <option value="">{RES:SourceSelectAValueText}</option>
                            <option value="MAKE">MAKE</option>
                            <option value="BUY">BUY</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="panel-footer">
                <div class="form-group row">
                    <label class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-10">
                        <input class = "btn btn-primary"  type="submit" name="{search_submit}" value="{RES:SearchSubmitCaption}"> &nbsp;
                        <input class = "btn btn-success"  type="submit" name="{search_reset}"  value="{RES:SearchResetCaption}">
                    </div>

                </div>

            </div>

        </form>

    </div>

    <script type="text/javascript">
        var element = document.getElementById('s_source');
        element.value = '{s_source}';
    </script>

    <div class="table table-responsive">
        <table class="table table-bordered">
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
                <td class = "text-center" colspan="9">{PaginatorBootstrap:Bottom}</td>
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