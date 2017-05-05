$(document).ready(function() {

    var htmEditor;
    $.getScript('//cdnjs.cloudflare.com/ajax/libs/ace/1.1.3/ace.js',function(){
        $.getScript('//cdnjs.cloudflare.com/ajax/libs/ace/1.1.3/ext-language_tools.js',function(){

            // Global preview reference
            var previewModal = $('#previewModal');
            ace.require("ace/ext/language_tools");

            htmEditor = ace.edit("htmEditor");
            htmEditor.getSession().setMode("ace/mode/html");
            htmEditor.setTheme("ace/theme/merbivore");
            htmEditor.setOptions({
                enableBasicAutocompletion: true,
                enableSnippets: true,
                fontSize: "12pt"
            });
            htmEditor.commands.on("afterExec", function(e){
                if (e.command.name == "insertstring"&&/^[\<.]$/.test(e.args)) {
                    htmEditor.execCommand("startAutocomplete")
                }
            });
            htmEditor.setShowPrintMargin(false);
            htmEditor.setHighlightActiveLine(true);

            // htmEditor.getSession().getDocument().getLength()* htmEditor.renderer.lineHeight + htmEditor.renderer.scrollBar.getWidth();

            // Button for BS Container
            $('#btnContainer').click(function(){
                htmEditor.insert("<div class=\"container\"></div>");
            });

            // Button for BS Row
            $('#btnRow').click(function(){
                htmEditor.insert("<div class=\"row\"></div>");
            });

            // Button for BS Col
            $('#btnCol').click(function(){
                htmEditor.insert("<div class=\"col-md-1\"></div>");
            });

            // Button for Framework Block
            $('#btnBlock').click(function(){
                var selectedHTML = htmEditor.session.getTextRange(htmEditor.getSelectionRange());
                var blockName = $("#elementName").val();
                if (blockName == "")
                    blockName = "PUT_YOUR_BLOCK_NAME_HERE";
                var beginBlockSection = "\t<!-- BEGIN " + blockName + " -->\n";
                var endBlockSection =   "\n\t<!-- END "   + blockName + " -->";
                htmEditor.insert(beginBlockSection + selectedHTML + endBlockSection);
            });

            // Button for Framework Variable
            $('#btnVariable').click(function(){
                var variableName = $("#elementName").val();
                if (variableName == "")
                    variableName = "VariableName";
                var variableHTML = "{" + variableName + "}";
                htmEditor.insert(variableHTML);
            });

            // Button for Preview
            $("#btnPreview").click(function(event){
                var htmlDesign = htmEditor.getValue();
                $('#design').val(htmlDesign);
                previewModal.find('.modal-body').html(htmlDesign);
                previewModal.modal('show');
            });

            // Button for Undo
            $('#btnUndo').click(function(){
                htmEditor.undo();
            });

            // Form submission
            $( "#formtemplate" ).submit(function( event ) {
                var htmlDesign = htmEditor.getValue();
                $('#design').val(htmlDesign);
                // event.preventDefault();
            });

        });
    });
});