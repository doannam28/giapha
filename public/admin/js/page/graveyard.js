$(function () {
    AJAX_CRUD_MODAL.tinymce();
    AJAX_CRUD_MODAL.summernote();
    $('.datetimepicker').datetimepicker({
        format: 'yyyy/mm/dd hh:ii',
    });

    $(document).on('click', '.btnAddForm', function (event) {
        event.preventDefault();
        let key_setting = 'data_graveyard';
        let data = $('#' + key_setting).serialize();
        $.ajax({
            url: url_update_setting,
            type: 'POST',
            dataType: 'JSON',
            data: $('#' + key_setting).serialize(),
        }).done(function (response) {
            toastr[response.type](response.message);
        });
    });
});
