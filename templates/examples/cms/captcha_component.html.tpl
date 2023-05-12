<!DOCTYPE html>
<html lang="en">
<head>
    <title>Captcha component</title>
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
<div class="container">
    <h1>Web MVC Framework</h1>
    <h2>Captcha component</h2>
    <br>

    <form class="form-horizontal" method="post">
        <fieldset>

            <!-- Form Name -->
            <legend>A simple form</legend>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-sm-4 control-label" for="textinput">Full name</label>
                <div class="col-sm-6">
                    <input id="full_name" name="full_name" type="text" placeholder="Full name" class="form-control input-md">
                    <span class="help-block">Insert your name</span>
                </div>
            </div>

            <!-- Captcha -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="button_submit">&nbsp;</label>
                <div class="col-md-4">
                    {Captcha:TheCaptcha}
                </div>
            </div>

            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="button_submit">&nbsp;</label>
                <div class="col-md-4">
                    <button id="action" name="action" class="btn btn-primary" value="submit">Submit</button>
                    {VerificationStatus}
                </div>
            </div>

        </fieldset>
    </form>

    <br><br>
    <a href="{GLOBAL:SITEURL}/examples/about/example/captcha" class="btn btn-info">Show source code</a>
    <a href="{GLOBAL:SITEURL}/examples/cms/captcha_component/" class="btn btn-success">Template</a>
    <a href="{GLOBAL:SITEURL}/examples/cms/captcha_component" class="btn btn-success">Run again</a>
    <a href="{GLOBAL:SITEURL}/examples/" class="btn btn-primary">Examples TOC</a>

</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
