<!-- BEGIN Pagination -->
<table border="0" align="center">
    <tbody>
    <tr>

        <td>
            <!-- BEGIN Total -->
            {RES:TotalRecords} &nbsp; <strong>{TotalRecords}  &nbsp; </strong>
            <!-- END Total -->
        </td>

        <td>
            &nbsp;
            <!-- BEGIN First -->
                <a href="{First_URL}">{First_On}</a>{First_Off}&nbsp;
            <!-- END First -->

            <!-- BEGIN Prev -->
                <a href="{Prev_URL}">{Prev_On}</a>{Prev_Off}&nbsp;
            <!-- END Prev -->

            <select id="paging">
                <!-- BEGIN Pages -->
                <option value="{Page_URL}" {is_active}> {Page_Number}</option>
                <!-- END Pages -->
            </select>
            &nbsp;
            <!-- BEGIN Next -->
                <a href="{Next_URL}">{Next_On}</a>{Next_Off}&nbsp;
            <!-- END Next -->

            <!-- BEGIN Last -->
                <a href="{Last_URL}">{Last_On}</a>{Last_Off}&nbsp;
            <!-- END Last -->

        </td>
    </tr>
    </tbody>
</table>
<!-- END Pagination -->

<script>
    // onchange handler for select control
    var selectElement = document.getElementById('paging');
    selectElement.onchange = function(){
        var goto = this.value;
        redirect(goto);
    };

    // onchange action (redirect)
    function redirect(goto){
        if ( goto != '') {
            window.location = goto;
        }
    }
</script>


