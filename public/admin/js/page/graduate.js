// Dom Ready
$(function () {
    datatables_columns = [{
        field: "checkID",
        title: "#",
        width: 50,
        sortable: !1,
        textAlign: "center",
        selector: {class: "m-checkbox--solid m-checkbox--brand"}
    }, {
        field: "id",
        title: "STT",
        width: 50,
        sortable: 'asc',
        filterable: !1,
    }, {
        field: "person_name",
        title: "Họ và tên",
        width: 200
    },
    {
        field: "father_name",
        title: "Tên bố (mẹ)",
        width: 200
    },
    {
        field: "year",
        title: "Năm",
        width: 80,
        
    },
    {
        field: "university",
        title: "Tên trường",
        width: 200
    },
    {
        field: "action",
        width: 300,
        title: "Actions",
        sortable: !1,
        overflow: "visible",
        template: function (t, e, a) {
            content = ``;

            
            content += `${permission_edit ? '<span class="m-badge mr-2 m-badge--success m-badge--wide btnEdit" style="padding: .65rem 1rem;border-radius: 2rem;">Sửa</span>' : ''}`;
            content += `${permission_delete ? '<span class="m-badge mr-2 m-badge--danger m-badge--wide btnDelete" style="padding: .65rem 1rem;border-radius: 2rem;">Xóa</span>' : ''}`;

            return content;
        }
    }];
    AJAX_DATATABLES.init();
    AJAX_CRUD_MODAL.init();
    AJAX_CRUD_MODAL.tinymce();
    loadCategory();
    SEO.init_slug();

    $(document).on('click', '.btnEdit', function () {
       
        let modal_form = $('#modal_form');
        let id = $(this).closest('tr').find('input[type="checkbox"]').val();
        AJAX_CRUD_MODAL.edit(function () {
            $.ajax({
                url: url_ajax_edit,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (response) {
                    $('.form-control-feedback').remove();
                    $('.form-group').removeClass('has-danger');
                    $('.form-group').find('bug').remove();
                    
                    $.each(response.data_info, function (key, value) {
                        let element = modal_form.find('[name="' + key + '"]');
                        element.val(value);
                        if (element.hasClass('switchBootstrap')) {
                            element.bootstrapSwitch('state', (value == 1 ? true : false));
                        };
                        // if (key === 'description' && value) tinymce.get(element.attr('id')).setContent(response.data_info.description);
                        // if (key === 'content' && value) tinymce.get(element.attr('id')).setContent(response.data_info.content);
                        // if (key === 'banner' && value) element.closest('.form-group').find('img').attr('src', media_url + value);
                    });
                    loadCategory(response.data_category);
                    modal_form.modal('show');
                  
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                    console.log(textStatus);
                    console.log(jqXHR);
                }
            });
            return false;
        });
    });
});

function loadCategory(dataSelected) {
    console.log(father_id);
    let selector = $('select.category');
    selector.select2({
        placeholder: 'Chọn người dùng',
        allowClear: !0,
        multiple: !1,
        data: dataSelected,
        ajax: {
            url: "graduate/get_all_child",
            data: { 'csrf_test_name': '<?= $this->security->get_csrf_hash(); ?>' }, // Thay bằng tên CSRF thực tế
            dataType: 'json',
            delay: 250,
            data: function (e) {
                return {
                    q: e.term,
                    page: e.page
                }
            },
            processResults: function (e, t) {
                return t.page = t.page || 1, {
                    results: e,
                    pagination: {
                        more: 30 * t.page < e.total_count
                    }
                }
            },
            cache: !0
        }
    });
    if (typeof dataSelected !== 'undefined') selector.find('> option').prop("selected", "selected").trigger("change");
}