<!DOCTYPE html>
<html>
<head>
    <title>{RES:LoginPageTitle}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Rosario Carvello - rosario.carvello@gmail.com">
  <meta name="generator" content="Powered by PHP WEB MVC Framework">
  <meta name="copyright" content="Rosario Carvello">
  <meta name="robots" content="all">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="{GLOBAL:SITEURL}/js/spinner/spinner.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->
</head>

<body>
<div class="container">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
<h2>Login</h2>
	<h4>{RES:LoginPageTitle}</h4>
    <h5 class="text-danger">{LoginWarningMessage}</h5>
</div>

<div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>

<div role="main" class="col-xs-10 col-sm-6 col-md-4 col-lg-4" >

  <!-- BEGIN LoginErrorMessage -->
  <div class="alert alert-danger alert-dismissible ol-xs-12 col-sm-12 col-md-12 col-lg-12" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <br>{RES:LoginError}
  </div>
  <!-- END LoginErrorMessage -->

    <form role="form" id="login_form" class="form" method="post" name="login_form">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4><span aria-hidden="true" class="glyphicon glyphicon-log-in"> </span>{RES:LogiFormTitle}</h4>
      </div>
      <div class="panel-body">
        
        <div class="form-group">
          <label for="LoginFormemail">Email</label> 
          <div>
            <input type="text" id="LoginFormemail" class="form-control" maxlength="100" value="" name="email" required>
          </div>
        </div>
        <div class="form-group">
          <label for="LoginFormpassword">Password</label> 
          <div>
            <input autocomplete="off" type="password" id="LoginFormpassword" class="form-control" maxlength="100" value="" name="password" required>
          </div>
        </div>
      </div>
      <div class="panel-footer text-center">
        <div class="form-group text-right">
          <input type="checkbox" id="remember_me" class="form-cotrol" value="1" name="remember_me" >  {RES:RememberMeText}
        </div>
        <div class="form-group">
          <!-- BEGIN LoginButton -->
          <input class="btn btn-success btn-lg" type="submit" id="login_form_do_login"  class="Button" alt="{RES:LoginButtonCaption}"   value="{RES:LoginButtonCaption}"  name="login_form_do_login">
          <!-- END LoginButton -->

          <!-- BEGIN LogoutButton -->
          <input class="btn btn-warning btn-lg" type="submit" id="login_form_do_logout"  class="Button" alt="{RES:LogoutButtonCaption}" value="{RES:LogoutButtonCaption}" name="login_form_do_logout" formnovalidate>
          <!-- END LogoutButton -->

          <a class="btn btn-default btn-lg" id="login_form_do_cancel"  value="{RES:CancelButtonCaption}" name="login_form_do_cancel" onclick="history.back()">{RES:CancelButtonCaption}</a>
        </div>
      </div>
    </div>
  </form> 

</div>

<div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
	Copyright © {RES:CopyRightInfo}
</div>
</div>
<div id="divLoading"></div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#login_form').find('input:submit').on('click',function(e){
            var currentValidity = true;
            var elementIndex;
            var lastElementIndex = e.currentTarget.form.length - 1;
            for (elementIndex=0; elementIndex <= lastElementIndex; elementIndex++) {
                currentValidity = e.currentTarget.form[elementIndex].validity.valid;
                if(!currentValidity){
                    $("#divLoading").removeClass('show');
                    break;
                }
            }
        });
    })
</script>
<script src="{GLOBAL:SITEURL}/js/spinner/spinner.js"></script>
</body>
</html>