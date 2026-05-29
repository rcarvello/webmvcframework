<!DOCTYPE html>
<html>
<head>
    <title>{RES:Products_Page_Title}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <style>
        .dt-search-wrap {
            position: relative;
            display: inline-block;
        }

        .dt-search-wrap .form-control,
        .dt-search-wrap input[type="search"] {
            padding-right: 2.5rem;
        }

        .dt-search-clear {
            position: absolute;
            top: 50%;
            right: 0.5rem;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #6c757d;
            padding: 0;
            line-height: 1;
            z-index: 3;
        }

        .dt-search-clear:hover,
        .dt-search-clear:focus {
            color: #212529;
        }
    </style>
</head>
<body>
{Controller:examples\cms\NavigationBar}
<div class="container py-4">
    <h1 class="mb-2">{RES:Products_Page_Title}</h1>
    <p class="text-body-secondary">{RES:Products_Page_Description}</p>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover align-middle w-100" id="table_products">
            <thead>
            <tr>
                <th>{RES:product_id}</th>
                <th>{RES:product_name}</th>
                <th>{RES:category_name}</th>
                <th>{RES:list_order}</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <div class="d-flex flex-wrap gap-2 mt-3 align-items-center">
        <a href="{GLOBAL:SITEURL}/ai/product/add/new" class="btn btn-success"><i
                    class="bi bi-plus-circle me-1"></i>{RES:AddNewProduct}</a>
        <div id="products_export_buttons" class="d-flex flex-wrap gap-2"></div>
        <a href="{GLOBAL:SITEURL}/ai/products" class="btn btn-primary"><i
                    class="bi bi-arrow-clockwise me-1"></i>{RES:ReloadProducts}</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function () {
        var productFormBaseUrl = '{ProductFormBaseUrl}';
        var initialSearch = new URLSearchParams(window.location.search).get('search') || '';
        var tableStateKey = 'datatable:ai:products';

        var table = $('#table_products').DataTable({
            "processing": true,
            "serverSide": true,
            "paging": true,
            "stateSave": true,
            "stateDuration": -1,
            "pageLength": 10,
            "order": [[3, "asc"], [1, "asc"]],
            "dom": "<'row align-items-center mb-3'<'col-md-6 d-flex justify-content-start'l><'col-md-6 text-md-end text-start'f>>Brt<'row align-items-center mt-3'<'col-md-5'i><'col-md-7 d-flex justify-content-md-end justify-content-start'p>>",
            "buttons": [
                {
                    "extend": 'csvHtml5',
                    "text": '<i class="bi bi-filetype-csv me-1"></i>CSV',
                    "className": 'btn btn-warning text-dark border-0'
                },
                {
                    "extend": 'excelHtml5',
                    "text": '<i class="bi bi-file-earmark-excel me-1"></i>EXCEL',
                    "className": 'btn btn-info text-dark border-0'
                },
                {
                    "extend": 'pdfHtml5',
                    "text": '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                    "className": 'btn btn-danger text-white border-0'
                },
                {
                    "extend": 'print',
                    "text": '<i class="bi bi-printer me-1"></i>PRINT',
                    "className": 'btn btn-dark text-white border-0'
                }
            ],
            "ajax": {
                "url": '{ProductsAjaxDataUrl}',
                "type": 'POST'
            },
            "columns": [
                {
                    "data": "product_id",
                    "render": function (data, type) {
                        if (type === 'display') {
                            return '<a href="' + productFormBaseUrl + data + '" class="btn btn-sm btn-outline-primary" title="{RES:EditProductTitle}"><i class="bi bi-pencil-square me-1"></i>' + data + '</a>';
                        }
                        return data;
                    }
                },
                {"data": "product_name"},
                {"data": "category_name"},
                {"data": "list_order"}
            ],
            "language": {
                "lengthMenu": "_MENU_ {RES:record_per_pagina}",
                "zeroRecords": "{RES:zero_records}",
                "info": "{RES:info_page}",
                "infoEmpty": "{RES:info_empty}",
                "search": "{RES:search_label}",
                "searchPlaceholder": "{RES:search_placeholder_products}",
                "infoFiltered": "{RES:info_filtered}",
                "paginate": {
                    "first": "{RES:paginate_first}",
                    "last": "{RES:paginate_last}",
                    "next": "{RES:paginate_next}",
                    "previous": "{RES:paginate_previous}"
                }
            },
            "stateSaveCallback": function (settings, data) {
                localStorage.setItem(tableStateKey, JSON.stringify(data));
            },
            "stateLoadCallback": function () {
                var state = localStorage.getItem(tableStateKey);
                return state ? JSON.parse(state) : null;
            }
        });

        table.buttons().container().appendTo('#products_export_buttons');

        var filter = $('#table_products_filter');
        var searchInput = filter.find('input');

        searchInput.attr({
            'type': 'search',
            'placeholder': '{RES:search_placeholder_products}'
        });

        if (!filter.find('.dt-search-clear').length) {
            searchInput.wrap('<div class="dt-search-wrap"></div>');
            searchInput.after('<button class="dt-search-clear" type="button" aria-label="{RES:clear_filter_aria}"><i class="bi bi-x-lg"></i></button>');
        }

        var clearButton = filter.find('.dt-search-clear');

        function syncClearButton() {
            if (searchInput.val()) {
                clearButton.removeClass('d-none');
            } else {
                clearButton.addClass('d-none');
            }
        }

        if (initialSearch !== '') {
            searchInput.val(initialSearch);
            table.search(initialSearch).draw();
        }

        syncClearButton();

        searchInput.on('input', function () {
            syncClearButton();
        });

        searchInput.on('search', function () {
            if (!this.value) {
                table.search('').draw();
            }
            syncClearButton();
        });

        clearButton.on('click', function () {
            searchInput.val('');
            table.search('').draw();
            searchInput.trigger('focus');
            syncClearButton();
        });
    });
</script>
</body>
</html>
