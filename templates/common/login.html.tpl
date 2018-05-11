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
<div class="col-md-12 text-center">   
	<h2>Login</h2>
	<h4>{RES:LoginPageTitle}</h4>
    <h5 class="text-danger">{LoginWarningMessage}</h5>
</div> 
<div class="col-sm-4"></div>

<div role="main" class="col-sm-4 center-block">
  <!-- BEGIN LoginErrorMessage -->
  <div class="alert alert-danger alert-dismissible col-sm-12" role="alert">
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
            <input type="password" id="LoginFormpassword" class="form-control" maxlength="100" value="" name="password" required>
          </div>
        </div>
      </div>
      <div class="panel-footer text-center">
        <div class="form-group text-right">
          <input type="checkbox" id="remember_me" class="form-cotrol" value="1" name="remember_me" >  {RES:RememberMeText}
        </div>
        <div class="form-group">
          <input class="btn btn-success btn-lg" type="submit" id="login_form_do_login"  class="Button" alt="{RES:LoginButtonCaption}"   value="{RES:LoginButtonCaption}"  name="login_form_do_login">
          <input class="btn btn-warning btn-lg" type="submit" id="login_form_do_logout"  class="Button" alt="{RES:LogoutButtonCaption}" value="{RES:LogoutButtonCaption}" name="login_form_do_logout" formnovalidate>
          <input class="btn btn-default btn-lg" type="submit" id="login_form_do_cancel" class="Button" alt="{RES:CancelButtonCaption}"  value="{RES:CancelButtonCaption}" name="login_form_do_cancel" onclick="history.back()" formnovalidate>
        </div>
      </div>
    </div>
  </form> 

</div>
<div id="divLoading"></div>
<div class="col-sm-4"></div>
<div class="col-md-12 text-center">   
	Copyright © {RES:CopyRightInfo}
</div> 

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="{GLOBAL:SITEURL}/js/spinner/spinner.js"></script>
</body>
</html>