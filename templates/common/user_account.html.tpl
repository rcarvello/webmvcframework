<!DOCTYPE html>
<html>
<head>
    <title>{RES:UserTitle}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Rosario Carvello - rosario.carvello@gmail.com">
    <meta name="generator" content="Powered by PHP WEB MVC Framework">
    <meta name="copyright" content="Rosario Carvello">
    <meta name="robots" content="all">

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link href="{GLOBAL:SITEURL}/js/spinner/spinner.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
    <script src="{GLOBAL:SITEURL}/js/password-strengh-meter/zxcvbn-bootstrap-strength-meter.js"></script>

</head>
<body>
<br>
<div class="container">
    <form name="user_record_form" id="user_record_form" method="post" class="form-horizontal">
        <div class="panel panel-primary">

            <div class="panel-heading">
                <h1 class="panel-title">{FormTitle}</h1>
            </div>

            <div class="panel-body">

                <!-- BEGIN ValidationErrors -->
                <div class="form-group col-sm-12">
                    <div class="col-sm-1"></div>
                    <div class="alert alert-danger alert-dismissible col-sm-10" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span></button>{RES:ErrorMessageTitle}
                        <br/>
                        <!-- BEGIN Errors -->
                        <span>{Error}</span>
                        <!-- END Errors -->
                    </div>
                    <div class="col-sm-1"></div>
                </div>
                <!-- END ValidationErrors -->

                <div class="form-group col-sm-12">
                    <div class="col-sm-4 control-label">
                        <label class="text-danger">{RES:FullNameCaption}</label>
                    </div>

                    <div class="col-sm-6 input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                        </div>
                        <input type="hidden" class="form-control" name="id_user" value="{id_user}">
                        <input type="text" class="form-control" placeholder="{RES:PlaceHolderFullName}" name="full_name" value="{full_name}" required>
                    </div>
                </div>

                <div class="form-group col-sm-12">
                    <div class="col-sm-4 control-label">
                        <label class="text-danger">{RES:EmailCaption}</label>
                    </div>
                    <div class="col-sm-6 input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                        </div>
                        <input type="text"   class="form-control" placeholder="{RES:PlaceHolderEmail}" name="email" value="{email}" required>
                    </div>
                </div>

                <div class="form-group row col-sm-12 {NoUpdate}">
                    <div class="col-sm-4 control-label">
                        <label class="text-danger">{RES:AccessLevelCaption}</label>
                    </div>
                    <div class="col-sm-6 input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                        </div>
                        <select class="form-control select-option" id="id_access_level" name="id_access_level" data-option-selected="{id_access_level}" required>
                            <option value="">{RES:SelectAccessLevel}</option>
                            <!-- BEGIN AccessLevelOptionsList -->
                            <option value="{access_level_id}">{access_level_name}</option>
                            <!-- END AccessLevelOptionsList -->
                        </select>
                    </div>
                </div>

                <div class="form-group col-sm-12 {NoUpdate}">
                    <div class="col-sm-4 control-label">
                        <label class="text-danger">{RES:EnabledCaption}</label>
                    </div>
                    <div class="col-sm-6 input-group">
                        <input type="checkbox" name="enabled" value="{enabled}" id="{enabled}" {is_checked}>
                    </div>
                </div>

                <div class="form-group col-sm-12" id="changepwdiv">
                    <div class="col-sm-4 control-label"></div>
                    <div class="col-sm-6 input-group">
                        <a class="btn btn-default" id="hideshowpassword"><span class="glyphicon glyphicon-lock"></span> {RES:ButtonChangePasswordCaption}</a>
                    </div>
                </div>

                <div class="form-group col-sm-12" id="pwdiv">
                    <div class="col-sm-4 control-label">
                        <label class="text-danger">{RES:PasswordCaption}</label>
                    </div>
                    <div class="col-sm-6 input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                        </div>
                        <input type="password" class="form-control" placeholder="{RES:PlaceHolderPassword}" name="password" id="password"  value="{password}" required>
                        <input type="hidden" id="password_is_changed" name="password_is_changed" value="0">

                    </div>
                    <div class="col-md-4"></div>
                    <div class="progress col-md-6">
                        <div id="StrengthProgressBar" class="progress-bar"></div>
                    </div>
                </div>

                <div class="form-group col-sm-12" id="repwdiv">
                    <div class="col-sm-4 control-label">
                        <label class="text-danger">{RES:RePasswordCaption}</label>
                    </div>
                    <div class="col-sm-6 input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                        </div>
                        <input type="password" class="form-control" placeholder="{RES:PlaceHolderRePassword}" id="re_password" name="re_password" value="{password}" required>
                    </div>
                </div>

            </div>

            <div class="panel-footer">
                <div class="form-group text-center">
                    <label class="col-sm-1 control-label"></label>
                    <div class="col-sm-10">
                        {Record:UserRecord}
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
<div id="divLoading"></div>
<script type="text/javascript">
$(document).ready(function() {
    var selects = $(".select-option");
    $.each(selects, function(key,value){
        currentSelect = $(value);
        defaultValue = currentSelect.attr("data-option-selected");
        currentSelect.val(defaultValue);
    });
    $("#password").keydown(function () {
        $("#password_is_changed").val(1);
        $("#re_password").val('');
        $('#changepwdiv').hide();
    });
    $('#hideshowpassword').click(function () {
        $('#pwdiv').toggle();
        $('#repwdiv').toggle();
    });
    var editMode = {edit_mode};
    if (editMode){
        $('#changepwdiv').show();
        $('#pwdiv').hide();
        $('#repwdiv').hide();
    } else {
        $('#changepwdiv').hide();
        $('#pwdiv').show();
        $('#repwdiv').show();
    }

    $("#StrengthProgressBar").zxcvbnProgressBar({
        passwordInput: "#password",
        ratings: ["{RES:VeryWeak}", "{RES:Weak}", "{RES:OK}", "{RES:Strong}", "{RES:VeryStrong}"]
    });

    $('#user_record_form').find('input:submit').on('click', function (e) {
        var currentValidity = true;
        var elementIndex;
        var lastElementIndex = e.currentTarget.form.length - 1;
        for (elementIndex = 0; elementIndex <= lastElementIndex; elementIndex++) {
            currentValidity = e.currentTarget.form[elementIndex].validity.valid;
            if (!currentValidity) {
                $("#divLoading").removeClass('show');
                break;
            }
        }
    });

});
</script>
<script src="{GLOBAL:SITEURL}/js/spinner/spinner.js"></script>

</body>
</html>