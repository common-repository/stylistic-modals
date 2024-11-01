jQuery(document).ready(function($) {

    if ($('body.post-type-stylisticmodal.block-editor-page').length) {
        var mode = $('select#mode');
        var timeout = $('input#timeout-time');
        var clickElement = $('input#click-element');

        if (mode[0].value === 'Open after the page did load') {
            timeout.parent().parent().css('display', 'table-row');
            clickElement.parent().parent().css('display', 'none');
        } else {
            timeout.parent().parent().css('display', 'none');
            clickElement.parent().parent().css('display', 'table-row');
        }

        mode.on('change', function() {
            if (this.value === 'Open after the page did load') {
                timeout.parent().parent().css('display', 'table-row');
                clickElement.parent().parent().css('display', 'none');
            } else {
                timeout.parent().parent().css('display', 'none');
                clickElement.parent().parent().css('display', 'table-row');
            }
        });
    }
});
