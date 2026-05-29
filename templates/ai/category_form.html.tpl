<!DOCTYPE html>
<html>
<head>
    <title>AI Category Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
</head>
<body>
<div class="container py-4">
    <form name="category_form" id="category_form" method="post">
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
                            <br/>
                            <!-- BEGIN Errors -->
                            <span>{Error}</span>
                            <!-- END Errors -->
                        </div>
                    </div>
                </div>
                <!-- END ValidationErrors -->

                <div class="row mb-3 align-items-center">
                    <label class="col-sm-4 col-form-label">Category ID</label>
                    <div class="col-sm-6">
                        <div class="input-group">
                        <span class="input-group-text">
                            <i class="fa fa-hashtag" aria-hidden="true"></i>
                        </span>
                            <input type="hidden" name="category_id" value="{category_id}">
                            <input type="text" class="form-control" value="{category_id}" {readonly}>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label class="col-sm-4 col-form-label text-danger">Category name</label>
                    <div class="col-sm-6">
                        <div class="input-group">
                        <span class="input-group-text">
                            <i class="fa fa-tag" aria-hidden="true"></i>
                        </span>
                            <input type="text" class="form-control" name="category_name" value="{category_name}"
                                   required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label class="col-sm-4 col-form-label">List order</label>
                    <div class="col-sm-6">
                        <div class="input-group">
                        <span class="input-group-text">
                            <i class="fa fa-sort-numeric-asc" aria-hidden="true"></i>
                        </span>
                            <input type="number" class="form-control" name="list_order" value="{list_order}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="row justify-content-center text-center">
                    <div class="col-sm-10">
                        {Record:CategoryRecord}
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>