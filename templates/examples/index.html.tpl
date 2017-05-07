<!DOCTYPE html>
<html>
<head>
    <title>PHP Web MVC Framework - Examples TOC</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap core CSS -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->
</head>
<body>

<div class="container">
    <h1>Welcome to PHP Web MVC Framework</h1>
    <h2>Examples TOC</h2>
</div>
<div class="container">
    <div class="well">
    <p>Below a list of examples demonstrating framework features</p>
    <footer>Examples were grouped by objective</footer>
    </div>
    
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

  <div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="headingCMS">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#CMS" aria-expanded="true" aria-controls="collapseCMS">
          Content Management features
        </a>
      </h4>
    </div>
    <div id="CMS" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingCMS">
        <div class="panel-body">
            <ul>
                <li><a href="cms/hello_world">Hello World</a></li>
                <li><a href="cms/hello_world_second">Hello World</a> (2nd edition)</li>
                <li><a href="cms/block">Blocks usage for handling data repetition </li>
                <li><a href="cms/block_extended">Controller Inheritance and Block Hiiding</li>
                <li><a href="cms/localization">Localization and multi languages feautures (Use Settings DropDown Menu)</li>
                <li><a href="cms/composite_page">Hierarchical MVC</li>
            </ul>
        </div>
    </div>
  </div>

  <div class="panel panel-success">
    <div class="panel-heading" role="tab" id="headingUtilities">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#Utilities" aria-controls="collapseTwo">
          CMS Components and Builders Utilities
        </a>
      </h4>
    </div>
    <div id="Utilities" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
            <ul>
                <li><a href="cms/block_data_repeater">Blocks management by the Datarepeater Component</li>
            </ul>
            Buiders:
            <ul>
                <li><a href="../builders/">Builders index</a></li>
                 <li><a href="../builders/skeleton_builder">MVC Skeleton Builder</a></li>
                 <li><a href="../util/app_create_beans.php">MySQL tables to classes Builder</a></li>

            </ul>
        </div>
    </div>
  </div>

  <div class="panel panel-info">
    <div class="panel-heading" role="tab" id="headingDatabase">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#Database"  aria-controls="collapseThree">
          Database features and components
        </a>
      </h4>
    </div>
    <div id="Database" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
        <div class="panel-body">
            <ul>
                <li><a href="db/part_list">Part table listing</li>
                <li><a href="db/part_paginator">Part table listing and paginating</li>
                <li><a href="db/part_custom_paginator">Part table listing and paginating with a custom paginator design</li>
                <li><a href="db/part_paginator_sorter">Part table listing, paginating and sorting</li>
                <li><a href="db/part_paginator_sorter_search">Part table listing, paginating, sorting and search form</li>
                <li><a href="db/part_paginator_sorter_search_external">Part table listing, paginating, sorting and search form with external design</li>
                <li><a href="db/part_list_manager">Part List Manager - Full Application with part record management</li>
            </ul>
        </div>
    </div>
  </div>

</div>
    
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var lastActivePanel=$.cookie('activePanel');
        if (lastActivePanel!=null) {
            $("#CMS").removeClass('in');
            $("#"+lastActivePanel).collapse();
        }
    });
    $('.panel').on('shown.bs.collapse', function (e) {
        var lastActivePanelId = e.target.id;
        $.cookie('activePanel', lastActivePanelId);
    })
</script>

</body>
</html>
