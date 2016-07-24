var as = {};


as.init = function () {

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

  

    $("a[data-toggle=loader], button[data-toggle=loader]").click(function () {
        if ($(this).parents('form').valid()) {
            as.btn.loading($(this), $(this).data('loading-text'));
            $(this).parents('form').submit();
        }
    });
};

$(document).ready(as.init);