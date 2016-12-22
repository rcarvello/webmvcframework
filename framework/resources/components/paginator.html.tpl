<!-- BEGIN Pagination -->
<style>
    .disabled {
        pointer-events: none;
        cursor: default;
        opacity: 0.6;
        color: #000000;
        text-decoration: none;
        font-weight: bolder;
    }
    a, a:visited, a:hover, a:active {
        color: inherit;
    }
</style>
<table border="0" align="center">
    <tbody>
    <tr>
        <td>
            <!-- BEGIN Total -->
            {RES:TotalRecords} &nbsp; <strong>{TotalRecords} &nbsp; </strong>
            <!-- END Total -->
        </td>
        <td>
            <!-- BEGIN First -->
            <a href="{First_URL}">{First_On}</a>{First_Off}&nbsp;
            <!-- END First -->

            <!-- BEGIN Prev -->
            <a  href="{Prev_URL}">{Prev_On}</a>{Prev_Off}&nbsp;
            <!-- END Prev -->

            <!-- BEGIN Pages -->
                <a class="{is_active}" href="{Page_URL}">{Page_Number}</a>&nbsp;
            <!-- END Pages -->

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