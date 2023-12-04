<!DOCTYPE html>
<html>
<head>
    <title>Block with inner block</title>
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

<div class="container">
    <h1>Classification</h1>
    <table class="table table-borderd table-hover">
        <thead>
        <tr>
            <th>Name</th>
            <th>Vote</th>
        </tr>
        </thead>
        <tbody>
        <!-- BEGIN Names -->
        <tr>
            <td>{Name}</td>
            <td>
                <div class="col-md-2">
                    <select class="form-control select-option" data-option-selected="{Selected}">
                        <option value="">Select a vote..</option>
                        <!-- BEGIN Votes -->
                        <option value="{Vote}">{Vote}</option>
                        <!-- END Votes -->
                    </select>
                </div>

            </td>
        </tr>
        <!-- END Names -->

        </tbody>
        <tfoot>
        <td class="text-center" colspan="2">All records</td>
        </tfoot>
    </table>
    <h2>This example show how to populate nested blocks</h2>
    <p>Note:</p>
    <h4>Template uses jQuery for reading select <strong>data-option-selected</strong> attribute to identify its default
        values and then for applying <u>selected</u> attribute on its corresponding option</h4>
    jQuery code:
    <pre>
        var selects = $(".select-option");
        $.each(selects, function(key,value){
            currentSelect = $(value);
            defaultValue = currentSelect.attr("data-option-selected");
            currentSelect.val(defaultValue);
        });
    </pre>
    <a href="{GLOBAL:SITEURL}/examples/" class="btn btn-primary">Back</a>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>


<script>
    var selects = $(".select-option");
    $.each(selects, function (key, value) {
        currentSelect = $(value);
        defaultValue = currentSelect.attr("data-option-selected");
        currentSelect.val(defaultValue);
        // currentSelect $("#gate option[value='Gateway 2']").attr("selected", true);
    });
</script>

</body>
</html>