<!DOCTYPE html>
<html>
<head>
    <title>AI Category</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.bootstrap5.min.css" rel="stylesheet">
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
<div class="container py-4">
    <h1 class="mb-2">AI / Category</h1>
    <p class="text-body-secondary">Elenco della tabella <strong>category</strong> in forma di DataTable AJAX.</p>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover align-middle w-100" id="table_categories">
            <thead>
            <tr>
                <th style="width:30px;"></th>
                <th>Actions</th>
                <th>Category ID</th>
                <th>Category name</th>
                <th>List order</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <div class="d-flex flex-wrap gap-2 mt-3 align-items-center">
        <a href="{GLOBAL:SITEURL}/ai/category_form/add/new" class="btn btn-success"><i
                    class="bi bi-plus-circle me-1"></i>New category</a>
        <div id="category_export_buttons" class="d-flex flex-wrap gap-2"></div>
        <a href="{GLOBAL:SITEURL}/ai/category" class="btn btn-primary"><i class="bi bi-arrow-clockwise me-1"></i>Reload
            category</a>
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
<script src="https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js"></script>
<script>
    $(document).ready(function () {
        var categoryFormBaseUrl = '{CategoryFormBaseUrl}';
        var categoryProductsBaseUrl = '{CategoryProductsBaseUrl}';
        var categoryOrderUrl = '{CategoryOrderUrl}';
        var initialSearch = new URLSearchParams(window.location.search).get('search') || '';
        var tableStateKey = 'datatable:ai:category';

        var table = $('#table_categories').DataTable({
            "processing": true,
            "serverSide": true,
            "paging": true,
            "stateSave": true,
            "stateDuration": -1,
            "pageLength": 10,
            "order": [[4, "asc"], [3, "asc"]],
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
                "url": '{CategoryAjaxDataUrl}',
                "type": 'POST'
            },
            "columns": [
                {
                    "data": null,
                    "orderable": false,
                    "searchable": false,
                    "render": function () {
                        return '<i class="bi bi-grip-vertical text-secondary" style="cursor:grab;font-size:1.1rem" title="Trascina per riordinare"></i>';
                    }
                },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        if (type !== 'display') {
                            return '';
                        }

                        var id = row.category_id;

                        return '<div class="d-flex gap-1">' +
                            '<a class="btn btn-sm btn-outline-primary" href="' + categoryFormBaseUrl + id + '" title="Edit category"><i class="bi bi-pencil"></i></a>' +
                            '<a class="btn btn-sm btn-outline-success" href="' + categoryProductsBaseUrl + id + '" title="Category products"><i class="bi bi-diagram-3"></i></a>' +
                            '</div>';
                    }
                },
                {
                    "data": "category_id",
                    "render": function (data, type) {
                        if (type === 'display') {
                            return '<a href="' + categoryFormBaseUrl + data + '">' + data + '</a>';
                        }
                        return data;
                    }
                },
                {"data": "category_name"},
                {"data": "list_order"}
            ],
            "columnDefs": [
                {"targets": 0, "orderable": false, "searchable": false},
                {"targets": 1, "orderable": false, "searchable": false}
            ],
            "rowReorder": {
                "dataSrc": 4,
                "selector": "td:first-child"
            },
            "language": {
                "lengthMenu": "_MENU_ record per pagina",
                "zeroRecords": "Nessun record trovato",
                "info": "Pagina _PAGE_ di _PAGES_",
                "infoEmpty": "Nessun record disponibile",
                "search": "Cerca",
                "searchPlaceholder": "Filtra categorie",
                "infoFiltered": "(filtrati da _MAX_ record totali)",
                "paginate": {
                    "first": "Prima",
                    "last": "Ultima",
                    "next": "Successiva",
                    "previous": "Precedente"
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

        table.buttons().container().appendTo('#category_export_buttons');

        table.on('row-reorder', function (e, diff, edit) {
            if (diff.length === 0) {
                return;
            }

            var updates = [];
            var start = table.page.info().start;

            $(table.table().node()).find('tbody tr').each(function (idx) {
                var rowData = table.row(this).data();
                if (rowData) {
                    updates.push({
                        category_id: rowData.category_id,
                        list_order: start + idx + 1
                    });
                }
            });

            $.ajax({
                url: categoryOrderUrl,
                type: 'POST',
                data: {updates: updates},
                success: function () {
                    table.ajax.reload(null, false);
                },
                error: function () {
                    table.ajax.reload(null, false);
                }
            });
        });

        var filter = $('#table_categories_filter');
        var searchInput = filter.find('input');

        searchInput.attr({
            'type': 'search',
            'placeholder': 'Filtra categorie'
        });

        if (!filter.find('.dt-search-clear').length) {
            searchInput.wrap('<div class="dt-search-wrap"></div>');
            searchInput.after('<button class="dt-search-clear" type="button" aria-label="Cancella filtro"><i class="bi bi-x-lg"></i></button>');
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