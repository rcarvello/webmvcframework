Qui sono nel MAIN fuori da qualsiasi blocco
{F0}{C1}{C1}{C1}{C1}{C1}{C1}{C1}{C1}{C1}
    <!-- BEGIN Select -->
        Sono nel blocco Select
        {B1}
        {B2}
        {C1}
        {Prova}

        {Controller:PippoController}
        {Paginator:PippoPaginator}
        {PaginatorBootstrap:PippoPginatorBootStrap}
        {Sorter:PippoSorter}
        {SorterBootstrap:PippoSorterBootstrap}
        {RES:PippoRES}
        {Record:PippoRecord}
            <!-- BEGIN InitFields -->
            Sono nel sotto blocco InitFields
            {C1}{SB1}{SB2}
                <!-- BEGIN SubInit -->
                {SBSB1}{SBSB2} Sono nel sub Sub
                <!-- END SubInit -->
            {C1} {C1} {C1}
            <!-- END InitFields -->
        Ancora nel blocco Select {B3}
    <!-- END Select -->
Nel main, fuori dal blocco Select
{F1}{F2}
    <!-- BEGIN New -->
        {SBSB1}{SBSB2} Sono nel sub Sub
    <!-- END New -->
Ancora nel main