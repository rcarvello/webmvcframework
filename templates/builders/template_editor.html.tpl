<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Web MVC Template editor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="../css/template-editor/style.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>
<div class="wrapper">
    <div class="outer">
        <div class="row">
            <div class="col-sm-12 sp toolbar tab-pane" id="htmPane">

                <div class="toolbar">
                    <a id="btnInfo" class="btn btn-default btn-xs">&nbsp;&nbsp;BS Actions&nbsp;&nbsp;</a>
                    <a id="btnContainer" class="btn btn-primary btn-xs"> Container </a>
                    <a id="btnRow" class="btn btn-primary btn-xs"> Row </a>
                    <a id="btnCol" class="btn btn-primary btn-xs"> Col </a>
                </div>

                <div class="inner" id="htmEditor">{EditorDefaultHTML}</div>

                <div class="container-fluid framework-actions">
                    <h3>Frameworks actions:</h3>
                    <div class="btn-group" role="group">
                        <button id="btnUndo"  href="#" class="btn btn-warning">
                            <i class="fa fa-undo" aria-hidden="true"></i> &nbsp;
                        </button>
                        <button href="#" id="btnBlock" class="btn btn-info">
                            <span class="glyphicon glyphicon-list"></span> Block
                        </button>

                        <button href="#" id="btnVariable" class="btn btn-primary">
                            <span class="glyphicon glyphicon-bookmark"></span> Variable
                        </button>
                        <div class="input-group" style="width: 600px;">
                            <input type="text" id="elementName" class="form-control" placeholder="Block or Variable name">
                            <div class="input-group-addon">
                                <i class="fa fa-tags" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="container-fluid framework-actions">
                    <form id="formtemplate" name="formtemplate" class="form-inline" role="form" method="post" action="skeleton_builder">

                        <!--
                        <div class="input-group" style="width: 600px;">
                            <div class="input-group-addon">
                                <i class="fa fa-file-code-o" aria-hidden="true"></i>
                            </div>
                            <input type="text" id="filename" class="form-control" placeholder="Give a name for the template" required>

                        </div>
                        -->
                        <button href="skeleton_builder" id="btnSave" class="btn btn-success">
                            <i class="fa fa-check-circle" aria-hidden="true"></i> Save template
                        </button>

                        <button type="button" class="btn btn-info" id="btnPreview">
                            <span class="glyphicon glyphicon-search"></span> Preview
                        </button>

                        <textarea name="design" id="design" style="display:none;"></textarea>


                        <a href="skeleton_builder?ResetDesign" onclick="return confirm('Are you sure to exit without saving?')" class="btn btn-danger">
                            <i class="fa fa-times-circle" aria-hidden="true"></i> Exit
                        </a>
                    </form>
                </div>
            </div> <!--/.tab-pane-->
        </div><!--/.row-->
    </div><!--/.outer-->
</div><!--/.wrapper-->

<!-- Modal Preview-->
<div id="previewModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Template design preview</h4>
            </div>
            <div class="modal-body row">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>





<script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script type='text/javascript' src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type='text/javascript' src="../js/template-editor/functions.js"></script>
<script type='text/javascript' src="../js/template-editor/template_editor.js"></script>

</body>
</html>
