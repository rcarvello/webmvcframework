<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Hello World Mobile version</title>
    <!-- Bootstrap core CSS -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">

    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.js"></script>
</head>
<body>

<div data-role="page" data-theme="a">
    <div data-role="header" data-position="inline">
        <div data-role="navbar">
            <ul>
                <li><a href="{GLOBAL:SITEURL}/examples/" data-ajax="false" data-icon="home" class="ui-btn-active">Home</a></li>
                <li><a href="Buttons" data-icon="star">Buttons</a></li>
                <li><a href="List" data-icon="grid">Lists</a></li>
                <li><a href="Nav" data-icon="search">Nav</a></li>
                <li><a href="Forms" data-icon="gear">Forms</a></li>
            </ul>
        </div>
    </div>
    <div data-role="content" data-theme="a">
        <a href="Show this message" data-role="button" data-icon="star">Show this message</a>
        <h3>{Message}</h3>

    </div>
</div>

</body>
</html>