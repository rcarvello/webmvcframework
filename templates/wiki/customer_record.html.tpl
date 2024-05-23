<!DOCTYPE html>
<html>
<head>
    <title>Customer Record</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"
          media="screen">
    <!-- Fonts Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

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
            <a class="navbar-brand" href="#">CRM Simple</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="{GLOBAL:SITEURL}/examples/">Home</a></li>
                <li class="active"><a href="{GLOBAL:SITEURL}/wiki/customers_manager">Customers</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">

    <h1>Customer Record</h1>
    {Operation}
    <hr>
    <form class="form-horizontal" method="post">
        <!-- BEGIN DBError -->
        <div class="alert alert-danger" role="alert">
            {Errors}
        </div>
        <!-- END DBError -->
        <div class="form-group">
            <label for="name" class="control-label col-xs-4">Name</label>
            <div class="col-xs-8">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-user-md"></i>
                    </div>
                    <input id="name" name="name" placeholder="Customer name" type="text" required="required"
                           class="form-control" value="{name}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="control-label col-xs-4">Email</label>
            <div class="col-xs-8">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-address-card-o"></i>
                    </div>
                    <input id="email" name="email" placeholder="Customer email" type="email" required="required"
                           class="form-control" value="{email}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-4">Nationality</label>
            <div class="col-xs-8">
                <!-- BEGIN NationalitiesCheckboxes -->
                <label class="checkbox-inline">
                    <input type="radio" name="nationality" value="{nationality}" {is_checked}>
                    {nationality_text}
                </label>
                <!-- END NationalitiesCheckboxes -->
            </div>
        </div>
        <div class="form-group">
            <label for="assurance" class="control-label col-xs-4">Customer assurance</label>
            <div class="col-xs-8">
                <select id="assurance" name="assurance" required="required" class="select form-control">
                    <!-- BEGIN AssuranceOptions -->
                    <option value="{assurance}" {is_selected}>{assurance_text}</option>
                    <!-- END AssuranceOptions -->
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-xs-offset-4 col-xs-8">
                <input type="hidden" name="customer_id" value="{customer_id}">
                <!-- BEGIN AddMode -->
                <input name="operation_insert" type="submit" class="btn btn-primary" value="Add customer">
                <!-- END AddMode -->
                <!-- BEGIN EditMode -->
                <input name="operation_update" type="submit" class="btn btn-primary" value="Update">
                <input name="operation_delete" id="delete" type="submit" class="btn btn-danger" value="Delete customer">
                <!-- END EditMode -->
                <a href="{GLOBAL:SITEURL}/wiki/customers_manager" class="btn btn-info">Close or Cancel</a>
            </div>

        </div>
    </form>

</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script>
    function confirmDelete() {
        return confirm("Delete current customer ?");
    }

    $(document).ready(function () {
        $("#delete").click(function () {
            return confirmDelete();
        });
    });
</script>
</body>
</html>