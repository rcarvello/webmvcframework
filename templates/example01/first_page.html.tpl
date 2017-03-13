<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <title>WEB MVC First Page</title>
</head>
<body>
<div class="container">
    <h1>Welcome to Web MVC Framework</h1>
    Below some dynamic contents obtained from Model and rendered by the View:

    <div class=" panel panel-success">
        Controller: <b>{ControllerNamePlaceHolder}</b>
    </div>

    <div class=" panel panel-success">
        Simple Data from model: <b>{SimpleDataPlaceHolder}</b>
    </div>

    <div class=" panel panel-success">
        Simple list from model:
        <ul>
            <!-- BEGIN Users -->
            <li>
                <i>Name</i>: <b>{NamePlaceHolder}</b> <i>Role</i>: <b>{RolePlaceHolder}</b>
            </li>
            <!-- END Users -->
        </ul>
    </div>

    <div class=" panel panel-success">
        Simple datata from embedded controller: <br>
        {Controller:example02\Demo}
    </div>

</div>
</body>
</html>