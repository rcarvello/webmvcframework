$('.btn-primary, .btn-info, .btn-success, .btn-warning, .btn-danger').click(function(e) {
    $("#divLoading").addClass('show');
    setTimeout(function(){
        $("#divLoading").removeClass('show');
    }, 5000);
    return true;
});

$('table tbody tr td a, table tfoot tr td a').click(function(e) {
    $("#divLoading").addClass('show');
    setTimeout(function(){
        $("#divLoading").removeClass('show');
    }, 5000);
    return true;
});

$('.loading').click(function(e) {
    $("#divLoading").addClass('show');
    return true;
});


$('form').submit(function(e) {
    $("#divLoading").addClass('show');
    return true;
});

