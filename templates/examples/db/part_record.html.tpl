<!DOCTYPE html>
<html>
<head>
    <title>Part list manager</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap core CSS -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>

</head>
<body>
{Controller:examples\cms\NavigationBar}

<div class="container">
    <h1>{RES:PartManager}</h1>
    <form name="part_record_form" id="part_record_form" method="post" class="form-horizontal">
    
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
                            <span class="sr-only">Close</span></button>{RES:errormsg}
                        <br/>
                        <span id="campione_record_inccampioneErrorBlock">{Error}</span> 
                    </div>
                    <div class="col-sm-1"></div>
                </div>
                <!-- END ValidationErrors -->
                
                <div class="form-group col-sm-12">
                    <div class="col-sm-4 control-label">
                        <label class="text-danger">{RES:part_code}</label> 
                    </div>
     
                    <div class="col-sm-6 input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-th" aria-hidden="true"></i> 
                        </div>
                        <input type="text" class="form-control" name="part_code" value="{part_code}" required {readonly}>
                    </div>
                </div>
                
                <div class="form-group col-sm-12">
                    <div class="col-sm-4 control-label">
                        <label class="text-danger">{RES:description}</label> 
                    </div>
     
                    <div class="col-sm-6 input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                        </div>
                        <input type="text" class="form-control" name="description" value="{description}" required>
                    </div>
                </div>
                
                <div class="form-group row col-sm-12">
                    <div class="col-sm-4 control-label">
                        <label>{RES:source}</label>
                    </div>
                    <div class="col-sm-6 input-group">

                        <!--
                             <div class="input-group-addon">
                            <i class="fa fa-file-o" aria-hidden="true"></i>
                        </div>

                        <select class="form-control" name="source_old" id="source_old">
                                <option value="">{RES:source_select_value}</option>
                                <option value="MAKE">MAKE</option>
                                <option value="BUY">BUY</option>
                        </select>
                        -->

                        <label class="radio-inline"><input type="radio" value="MAKE" name="source" checked="checked">MAKE</label>
                        <label class="radio-inline"><input type="radio" value="BUY"  name="source">BUY</label>

                    </div>
                </div>

                <div class="form-group col-sm-12">
                    <div class="col-sm-4 control-label">
                        <label>{RES:source_lead_time}</label> 
                    </div>
     
                    <div class="col-sm-6 input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                        </div>
                        <input type="number" class="form-control" name="source_lead_time" value="{source_lead_time}">
                    </div>
                </div>
                
                <div class="form-group row col-sm-12">
                    <div class="col-sm-4 control-label">
                        <label class="text-danger">{RES:measurement_unit_code}</label>
                    </div>
                    <div class="col-sm-6 input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-expand" aria-hidden="true"></i>
                        </div>
                        <select class="form-control" name="measurement_unit_code" id="measurement_unit_code" required>
                            <option value="">{RES:measurement_unit_code_select_value}</option>
                            <!-- BEGIN measurament_unit_code_list -->
                            <option value="{measurement_unit_code}">{name}</option>
                            <!-- END measurament_unit_code_list -->
                        </select>
                    </div>
                </div>

                <div class="form-group row col-sm-12">
                    <div class="col-sm-4 control-label">
                        <label class="text-danger">{RES:part_type_code}</label>
                    </div>
                    <div class="col-sm-6 input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-sitemap" aria-hidden="true"></i>
                        </div>
                        <select class="form-control" name="part_type_code" id="part_type_code" required>
                            <option value="">{RES:part_type_code_select_value}</option>
                            <!-- BEGIN part_type_code_list -->
                            <option value="{part_type_code}">{name}</option>
                            <!-- END part_type_code_list -->
                        </select>
                    </div>
                </div>

                <div class="form-group row col-sm-12">
                    <div class="col-sm-4 control-label">
                        <label class="text-danger">{RES:part_category_code}</label>
                    </div>
                    <div class="col-sm-6 input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                        </div>
                        <select class="form-control" name="part_category_code" id="part_category_code" required>
                            <option value="">{RES:part_category_code_value}</option>
                            <!-- BEGIN part_category_code_list -->
                            <option value="{part_category_code}">{name}</option>
                            <!-- END part_category_code_list -->
                        </select>
                    </div>
                </div> 
                
                <div class="form-group col-sm-12">
                    <div class="col-sm-4 control-label">
                        <label>{RES:wastage}</label> 
                    </div>
     
                    <div class="col-sm-6 input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        </div>
                        <input type="number" class="form-control" name="wastage" value="{wastage}">
                    </div>
                </div>  
 
                <div class="form-group col-sm-12">
                    <div class="col-sm-4 control-label">
                        <label>{RES:bom_levels}</label> 
                    </div>
     
                    <div class="col-sm-6 input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-list-ol" aria-hidden="true"></i>
                        </div>
                        <input type="number" class="form-control" name="bom_levels" value="{bom_levels}">
                    </div>
                </div>                 
                
            </div>
     
            <div class="panel-footer">
                <div class="form-group text-center">
                  <label class="col-sm-1 control-label"></label> 
                  <div class="col-sm-10">
                    {Record:PartManagerRecord}
                  </div>
                </div>
            </div>
    
        </div>
        
    </form>
</div>
<script type="text/javascript">
    // Sets all form selects option value


    /** Method 1
    var element = document.getElementById('source');
    element.value = '{source}';

    var element = document.getElementById('measurement_unit_code');
    element.value = '{measurement_unit_code}';

    var element = document.getElementById('part_type_code');
    element.value = '{part_type_code}';

    var element = document.getElementById('part_category_code');
    element.value = '{part_category_code}';
    */

    // Method 2 - Better (do not change values when reset button is pressed)
    // $("#source option[value={source}]").attr('selected','selected');

    $('input[name=source][value="{source}"]').prop('checked', true);

    var measurement_unit_code = '{measurement_unit_code}';
    if (measurement_unit_code != '')
        $("#measurement_unit_code option[value={measurement_unit_code}]").attr('selected','selected');

    var part_type_code = '{part_type_code}';
    if (part_type_code != '')
        $("#part_type_code option[value={part_type_code}]").attr('selected','selected');

    var part_category_code = '{part_category_code}';
    if (part_category_code != '')
        $("#part_category_code option[value={part_category_code}]").attr('selected','selected');
</script>
</body>
</html>
