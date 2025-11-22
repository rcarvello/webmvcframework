<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ACE HTML Editor con Bootstrap - Anteprima in Tab</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.0/ace.js"></script>

    <style>
        html, body { height: 100%; margin: 0; overflow: hidden; }
        #editor-container, #preview-container {
            height: calc(100vh - 140px); /* top bar (50) + tabs (40) + bottom bar (50) */
            overflow: hidden;
        }
        #editor {
            width: 100%;
            height: 93%;
            padding-bottom: 60px; /* prevent bottom overlap */
        }
        iframe {
        width: 100%;
        height: 100%;
        border: none;
        padding-bottom: 60px; /* avoid bottom toolbar overlap */
        }
        .toolbar-fixed { height: 60px; background:#f8f9fa; border-bottom:1px solid #ddd; display:flex; align-items:center; padding:0 10px; }
        #toolbar-top .btn { padding: 2px 8px; font-size: 0.8rem; line-height: 1.8; }
    </style>
</head>
<body>

<!-- TOOLBAR SUPERIORE -->
<div id="toolbar-top" class="toolbar-fixed">
<div class="btn-group" role="group">
    <button id="btnContainer" type="button" class="btn btn-danger">
        <i class="fa fa-box"></i> Container
    </button>

    <button id="btnRow" type="button" class="btn btn-warning">
        <i class="fa fa-bars"></i> Row
    </button>

    <button id="btnCol" type="button" class="btn btn-success">
        <i class="fa fa-square"></i> Col
    </button>
</div>

</div>

<!-- TABS -->
<ul class="nav nav-tabs" id="mainTabs" style="margin-top:10px;">
  <li class="nav-item">
    <a class="nav-link active" data-bs-toggle="tab" href="#tab-editor">Editor</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#tab-preview" id="preview-tab-btn">Anteprima</a>
  </li>
</ul>

<!-- TAB CONTENT -->
<div class="tab-content">
    <div class="tab-pane fade show active" id="tab-editor">
        <div id="editor-container"><div id="editor"></div></div>
    </div>

    <div class="tab-pane fade" id="tab-preview">
        <div id="preview-container"><iframe id="previewFrame"></iframe></div>
    </div>
</div>

<!-- TOOLBAR INFERIORE -->
<div id="toolbar-bottom" class="toolbar-fixed" style="position:fixed; bottom:0; width:100%; border-top:1px solid #ddd;">
    <!--
    <button id="btn-open-bottom" class="btn btn-light me-2" title="Apri"><i class="fa fa-folder-open"></i></button>
    <button id="btn-save-bottom" class="btn btn-light me-2" title="Salva"><i class="fa fa-save"></i></button>
    <button id="btn-undo-bottom" class="btn btn-light me-2" title="Undo"><i class="fa fa-undo"></i></button>
    <button id="btn-redo-bottom" class="btn btn-light me-2" title="Redo"><i class="fa fa-redo"></i></button>
    -->
    <button id="btn-preview-bottom" class="btn btn-primary me-2" title="Anteprima"><i class="fa fa-eye"></i></button>
    <button id="btnUndo" href="#" class="btn btn-warning me-2">
        <i class="fa fa-undo" aria-hidden="true"></i> &nbsp;
    </button>
    <button href="#" id="btnBlock" class="btn btn-info me-2">
        <i class="fa fa-page"></i> Block
    </button>
    <button href="#" id="btnVariable" class="btn btn-primary">
        <span class="glyphicon glyphicon-bookmark"></span> Variable
    </button>
    <input id="elementName" type="text" class="form-control ms-3" placeholder="Block or Variable name"
           style="width:250px;"/>

    <form id="formtemplate" name="formtemplate" class="form-inline" style="display: flex; justify-content: flex-end" role="form" method="post" action="skeleton_builder">
        <button href="skeleton_builder" id="btnSave" class="btn btn-success">
            <i class="fa fa-check-circle" aria-hidden="true"></i> Save template
        </button>
        <textarea name="design" id="design" style="display:none;"></textarea>
        <a href="skeleton_builder?ResetDesign" onclick="return confirm('Are you sure to exit without saving?')" class="btn btn-danger">
            <i class="fa fa-times-circle" aria-hidden="true"></i> Exit
        </a>
    </form>


     
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/html");
    let html=  `{EditorDefaultHTML}`;
    editor.setValue(html);

    editor.clearSelection();


    // Funzione di rendering anteprima
    function renderPreview() {
        let html = editor.getValue();
        let iframeDoc = document.getElementById("previewFrame").contentWindow.document;
        iframeDoc.open();
        iframeDoc.write(html);
        iframeDoc.close();
    }

    // Preview button
    $("#btn-preview-bottom").on("click", function() {
        renderPreview();
        new bootstrap.Tab($("a[href='#tab-preview']")[0]).show();
    });

    // Tab button -> update preview
    $("#preview-tab-btn").on("shown.bs.tab", function () {
        renderPreview();
    });

    // Helper function
    function insertAtCursor(text) {
        editor.session.insert(editor.getCursorPosition(), text);
    }

    // BS Container button/
    $("#btnContainer").on("click", function () {
        insertAtCursor(`<div class="container">\n    \n</div>\n`);
    });

    // BS Row button
    $("#btnRow").on("click", function () {
        insertAtCursor(`<div class="row">\n    \n</div>\n`);
    });

     // BS Col button
    $("#btnCol").on("click", function () {
        insertAtCursor(`<div class="col">/div>\n`);
    });

    // Framework Block button
    $('#btnBlock').click(function(){
        var selectedHTML = editor.session.getTextRange(editor.getSelectionRange());
        var blockName = $("#elementName").val();
        if (blockName == "")
            blockName = "PUT_YOUR_BLOCK_NAME_HERE";
        var beginBlockSection = "\t<!-- BEGIN " + blockName + " -->\n";
        var endBlockSection =   "\n\t<!-- END "   + blockName + " -->";
        editor.insert(beginBlockSection + selectedHTML + endBlockSection);
    });

    // Framework Variable button
    $('#btnVariable').click(function(){
        var variableName = $("#elementName").val();
        if (variableName == "")
            variableName = "VariableName";
        var variableHTML = "{" + variableName + "}";
        editor.insert(variableHTML);
    });

 
    // Undo button
    $('#btnUndo').click(function(){
        editor.undo();
    });

    // Form submission
    $( "#formtemplate" ).submit(function( event ) {
        // event.preventDefault();
        var htmlDesign = editor.getValue();
        $('#design').val(htmlDesign);
   
    });
</script>

</body>
</html>
