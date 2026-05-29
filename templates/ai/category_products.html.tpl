<!DOCTYPE html>
<html>
<head>
    <title>AI Category Products</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <form name="category_products_form" id="category_products_form" method="post">
        <div class="card border-primary shadow-sm">
            <div class="card-header bg-primary text-white">
                <h1 class="h4 mb-0">{FormTitle}</h1>
            </div>

            <div class="card-body">
                <!-- BEGIN ValidationErrors -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            Validation errors
                            <br>
                            <!-- BEGIN Errors -->
                            <span>{Error}</span><br>
                            <!-- END Errors -->
                        </div>
                    </div>
                </div>
                <!-- END ValidationErrors -->

                <div class="row mb-3 align-items-center">
                    <label class="col-sm-3 col-form-label">Category ID</label>
                    <div class="col-sm-3">
                        <input type="hidden" name="category_id" value="{category_id}">
                        <input type="text" class="form-control" value="{category_id}" readonly>
                    </div>

                    <label class="col-sm-2 col-form-label">List order</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="list_order" value="{list_order}">
                    </div>
                </div>

                <div class="row mb-4 align-items-center">
                    <label class="col-sm-3 col-form-label text-danger">Category name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="category_name" value="{category_name}"
                               maxlength="20" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="h5 mb-0">Products</h2>
                    <button type="button" id="btn_add_product" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Add product row
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="products_table">
                        <thead class="table-light">
                        <tr>
                            <th style="width: 120px;">Product ID</th>
                            <th>Product name</th>
                            <th style="width: 140px;">List order</th>
                            <th style="width: 110px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- BEGIN ProductsRows -->
                        <tr>
                            <td>
                                <input type="hidden" name="product_id[]" value="{product_id}">
                                <input type="text" class="form-control" value="{product_id}" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="product_name[]" value="{product_name}"
                                       maxlength="20" required>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="product_list_order[]"
                                       value="{product_list_order}">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm js-remove-row">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- END ProductsRows -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer">
                <div class="d-flex flex-wrap gap-2 justify-content-end">
                    <button type="submit" name="operation_save" value="1" class="btn btn-primary">
                        <i class="bi bi-floppy me-1"></i>Save category and products
                    </button>
                    <a href="{BackUrl}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i>Close
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        var tableBody = document.querySelector('#products_table tbody');
        var addButton = document.getElementById('btn_add_product');

        function createRow() {
            var row = document.createElement('tr');
            var nextOrder = tableBody.querySelectorAll('tr').length + 1;

            row.innerHTML =
                '<td>' +
                '<input type="hidden" name="product_id[]" value="">' +
                '<input type="text" class="form-control" value="" readonly>' +
                '</td>' +
                '<td>' +
                '<input type="text" class="form-control" name="product_name[]" value="" maxlength="20" required>' +
                '</td>' +
                '<td>' +
                '<input type="number" class="form-control" name="product_list_order[]" value="' + nextOrder + '">' +
                '</td>' +
                '<td class="text-center">' +
                '<button type="button" class="btn btn-outline-danger btn-sm js-remove-row"><i class="bi bi-trash"></i></button>' +
                '</td>';

            tableBody.appendChild(row);
        }

        addButton.addEventListener('click', function () {
            createRow();
        });

        tableBody.addEventListener('click', function (event) {
            var button = event.target.closest('.js-remove-row');
            if (!button) {
                return;
            }

            var row = button.closest('tr');
            if (!row) {
                return;
            }

            row.remove();
            // Nessuna riga viene aggiunta automaticamente se tutte vengono rimosse
        });

        // Nessuna riga viene aggiunta automaticamente all'avvio se non ci sono prodotti
    })();
</script>
</body>
</html>
