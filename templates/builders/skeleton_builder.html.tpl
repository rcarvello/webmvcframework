<!-- -->
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="{TEMPLATE_PATH}js/jquery-ui-1.12.1/jquery-ui.min.css">

    <!-- CSS for additional plugins-->
    <link rel="stylesheet" href="{TEMPLATE_PATH}css/tree-grid/jquery.treegrid.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <!-- JavaScript for additional plugins -->
    <script type="text/javascript" src="{TEMPLATE_PATH}js/tree-grid/jquery.treegrid.js"></script>
    <script type="text/javascript" src="{TEMPLATE_PATH}js/tree-grid/jquery.treegrid.bootstrap3.js"></script>
    <script type="text/javascript" src="{TEMPLATE_PATH}js/input-file/bootstrap-filestyle.min.js"></script>

    <!-- Custom init actions -->
    <script type="text/javascript">

        $(document).ready(function(){
            // Apply treegrid plugin
            var tree = $('.tree').treegrid();
            tree.treegrid("collapseAll");

            // Apply fileupload plugin
            $(":file").filestyle({placeholder: "Template (optional)"});

            // Forms controls sync.
            $('#addSubSystemButton').on('click',function() {
                var currentSubSystem =$( "#subsystem option:selected" ).val();
                $('select[name="parentSubSystem"]').val(currentSubSystem);
            });
        });


    </script>
    <title>Web MVC Builder Tool</title>
</head>
<body>
     <!-- Main page -->
    <div class="container">
            <h1>Welcome to WEB MVC Framework Builder Tool</h1>
            <p class="lead">This utility performs  MVC Classes and Template skeleton generation.</p>
            <!-- BEGIN ActionMessage -->
            <div class="alert alert-{AlertType} alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <b>{Message}</b>
            </div>
            <!-- END ActionMessage -->
            <form class="form" method="post" name ="c_form" enctype="multipart/form-data" >
                <div class="form-group">
                    <div class="input-group">
                        <select class="form-control" id="subsystem" name="subsystem" required>
                            <option value="">Select a subsystem</option>
                            <!-- BEGIN SubSystems -->
                            <option value="{SubSystem}">{SubSystem}</option>
                            <!-- END SubSystems -->
                        </select>
                        <span class="input-group-btn">
                        <a class="btn btn-default" id="addSubSystemButton" data-toggle="modal" data-target="#addSubSystemModalForm">
                            <i class="glyphicon glyphicon-plus"></i> Add
                        </a>
                      </span>
                    </div>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" id="controller" name="controller" placeholder="Type the MVC entity name to create" required>
                </div>

                <div class="form-group">
                    <input type="file" name="template" class="filestyle" data-buttonText="" data-placeholder="Select your custom HTML Template (optional)">
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label><input type="checkbox" name ="translate" value="yes">Enable language transaltions</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Create Skeleton</button>
                <a href="template_editor" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Edit Template Design <span class="badge">{DesignStatus}</span></a>
                <a href="index" class="btn btn-info"><span class="glyphicon glyphicon-home"></span> Home</a>

                <textarea name="design" style="display:none;">{Design}</textarea>


            </form>
            
            <h3>Below the systems decomposition of your web application</h3>
            <div id="ApplicationTree">
                <table class="table table-hover tree">
                    <thead>
                        <tr>
                            <th>Fully Qualified Name (FQN)</th>
                            <th>FQN Type</th>
                            <th>FQN Depth</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- BEGIN Controllers -->
                        <tr id="id-{Current}" class="treegrid-{Current} treegrid-parent-{Parent} {Type}">
                            <td>{ControllerName}</td>
                            <td>{Type}</td>
                            <td>{Level}</td>
                        </tr>
                        <!-- END Controllers -->
                    </tbody>
                </table>
            </div>
    </div>

     <!-- Modal Dialog page -->
    <div class="modal fade" id="addSubSystemModalForm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close"    data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Add a subsystem</h4>
                </div>

                <!-- Modal Body -->
                <form role="form" action="skeleton_builder" method="post">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Parent subsystem</label>
                            <select class="form-control"  id="parentSubSystem" name="parentSubSystem" required>
                                <option value="">Select the parent subsystem</option>
                                <!-- BEGIN ModalSubSystems -->
                                <option value="{SubSystem}">{SubSystem}</option>
                                <!-- END ModalSubSystems -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="childSubSystem">Child subsystem</label>
                            <input type="text" class="form-control"  id="childSubSystem" name="childSubSystem" placeholder="Type the name of child subsystem to create" required/>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit"  class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Create subsystem</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>