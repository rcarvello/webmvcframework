<!DOCTYPE html>
<html>
<head>
    <title>{RES:Product_Form_Page_Title}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
</head>
<body>
{Controller:examples\cms\NavigationBar}
<div class="container py-4">
    <form name="product_form" id="product_form" method="post">
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
                            {RES:ErrorMessageTitle}
                            <br/>
                            <!-- BEGIN Errors -->
                            <span>{Error}</span>
                            <!-- END Errors -->
                        </div>
                    </div>
                </div>
                <!-- END ValidationErrors -->

                <div class="row mb-3 align-items-center">
                    <label class="col-sm-4 col-form-label">{RES:product_id}</label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-hashtag" aria-hidden="true"></i>
                            </span>
                            <input type="hidden" name="product_id" value="{product_id}">
                            <input type="text" class="form-control" value="{product_id}" {readonly}>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label class="col-sm-4 col-form-label text-danger">{RES:product_name}</label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-tag" aria-hidden="true"></i>
                            </span>
                            <input type="text" class="form-control" name="product_name" value="{product_name}"
                                   maxlength="20" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label class="col-sm-4 col-form-label">{RES:category_name}</label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-folder-open" aria-hidden="true"></i>
                            </span>
                            <select class="form-select" name="category_id" id="category_id">
                                <option value="">{RES:no_category_option}</option>
                                <!-- BEGIN CategoryOptions -->
                                <option value="{category_id}">{category_name} ({RES:ID_Label}: {category_id})</option>
                                <!-- END CategoryOptions -->
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label class="col-sm-4 col-form-label">{RES:list_order}</label>
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
                        {Record:ProductRecord}
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var categoryId = '{category_id}';
    if (categoryId !== '') {
        $('#category_id option[value="' + categoryId + '"]').prop('selected', true);
    }
</script>
</body>
</html>
