<!DOCTYPE html>
<html>
<head>
    <title>Customers Manager</title>
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
    <div class="row">
        <div class="col col-12">
            <h1>Customers Manager</h1>
            <hr>
            <div class="table-responsive-lg">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Actions</th>
                        <th scope="col">Customer name</th>
                        <th scope="col">Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- BEGIN CustomersList -->
                    <tr>

                        <th scope="row">
                            <a class="btn btn-info" href="customer_record/open/{CustomerID}"><i class="fa fa-edit"></i>&nbsp;Edit</a>
                            <a class="btn btn-warning" href="mailto:{CustomerEmail}"> <i
                                        class="fa fa-address-card-o"></i>&nbsp;Email</a>
                        </th>
                        <td>{CustomerName}</td>
                        <td>{CustomerEmail}</td>
                    </tr>
                    <!-- END CustomersList -->
                    </tbody>
                    <tfoot>
                    <!-- BEGIN NoCustomers -->
                    <tr>
                        <td colspan="3" class="text-danger text-center">
                            No customer
                        </td>
                    </tr>
                    <!-- END NoCustomers -->
                    <tr>
                        <td colspan="3">
                            <a class="btn btn-primary" href="customer_record"><i class="fa fa-plus"></i>&nbsp;Add a new
                                customer</a>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
