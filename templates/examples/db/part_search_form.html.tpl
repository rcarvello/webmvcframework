<div id="search-panel" class="panel panel-primary collapse in" aria-expanded="true">
    <div class="panel-heading">
        <h3 class="panel-title">{RES:SearchFormTitle}</h3>

    </div>

    <form class="form-horizontal" method="post" name="{search_form}">
        <div class="panel-body">

            <div class="form-group row">
                <label class="col-sm-2 control-label text-right"><label>{RES:PartCodeLabel}</label></label>
                <div class="col-sm-10">
                    <input type="text"  value="{s_part_code}" name="s_part_code" id="s_part_code" placeholder="{RES:PartCodePlaceholder}" class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 control-label text-right"><label>{RES:PartDescriptionLabel}</label></label>
                <div class="col-sm-10">
                    <input type="text" value="{s_description}" name="s_description" id="s_description" placeholder="{RES:PartDescriptionPlaceholder}" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label text-right"><label>{RES:SourceLabel}</label></label>
                <div class="col-sm-10">
                    <select class="form-control" name="s_source" id="s_source">
                            <option value="">{RES:SourceSelectAValueText}</option>
                            <option value="MAKE">MAKE</option>
                            <option value="BUY">BUY</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="form-group row">
                <label class="col-sm-2 control-label">&nbsp;</label>
                <div class="col-sm-10">
                    <input class = "btn btn-primary"  type="submit" name="{search_submit}" value="{RES:SearchSubmitCaption}"> &nbsp;
                    <input class = "btn btn-success"  type="submit" name="{search_reset}"  value="{RES:SearchResetCaption}">
                </div>
            </div>
        </div>


    </form>
</div>
<script type="text/javascript">
    var element = document.getElementById('s_source');
    element.value = '{s_source}';
</script>