
<style>
.record_button {
    width: 80px;
    padding: 5px;
    margin-top: 10px;
    margin-left: 5px;
}
</style>
<input type="hidden" name="Observer_Data_Changed_Alert_Message" id = "Observer_Data_Changed_Alert_Message" value="{RES:Observer_Data_Changed_Alert_Message}">
<input type="hidden" name="{CSRF_TOKEN_FORM_FIELD}" value="{CRSFTOKEN}">
<input class ="record_button btn btn-success" type="submit" value="{RES:Record_Add}"        id="{record_add}"      name="{record_add}"     data-action="add">
<input class ="record_button btn btn-success" type="submit" value="{RES:Record_Update}"     id="{record_update}"   name="{record_update}"  data-action="update">
<input class ="record_button btn btn-danger"  type="submit" value="{RES:Record_Delete}"     id="{record_delete}"   name="{record_delete}"  data-action="delete" data-jsconfirm="true">
<input class ="record_button btn btn-info"    type="submit" value="{RES:Record_Close}"      id="{record_close}"    name="{record_close}" formnovalidate>
<input class ="record_button btn btn-warning" type="reset"  value="{RES:Record_Reset}"      id="{record_reset}"    name="{record_reset}" >{Separator}
<script>
$('#{record_delete}').click( function(){
    var message= "{RES:Delete_Message}";
    var result = confirm(message);
    if(result){
        return true;
    } else {
        return false;
    }
});
</script>