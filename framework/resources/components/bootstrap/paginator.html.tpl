<!-- BEGIN Pagination -->
<nav>
    <ul class="pagination">

        <!-- BEGIN First -->
        <li class="{First_Off}">
            <a href="{First_URL}">
                <span aria-hidden="true" class="{First_On}"></span>
            </a>
        </li>
        <!-- END First -->

        <!-- BEGIN Prev -->
        <li class="{Prev_Off}">
            <a href="{Prev_URL}" aria-label="Previous">
                 <span aria-hidden="true" class="{Prev_On}"></span>
            </a>
        </li>
        <!-- END Prev -->

        <!-- BEGIN Pages -->
            <li class="{is_active}">
                <a href="{Page_URL}">
                    <span aria-hidden="true">{Page_Number}</span>
                </a>
            </li>
        <!-- END Pages -->

        <!-- BEGIN Next -->
        <li class="{Next_Off}">
            <a href="{Next_URL}" aria-label="Next">
                <span aria-hidden="true" class="{Next_On}"> </span>
            </a>

        </li>
        <!-- END Next -->

        <!-- BEGIN Last -->
        <li class="{Last_Off}">
            <a href="{Last_URL}">
                <span aria-hidden="true" class="{Last_On}"></span>
            </a>
        </li>
        <!-- END Last -->

        <!-- BEGIN Total -->
        <li>
            <span aria-hidden="true">{RES:TotalRecords}&nbsp;{TotalRecords}</span>
        </li>
        <!-- END Total -->


    </ul>
</nav>
<!-- END Pagination -->
