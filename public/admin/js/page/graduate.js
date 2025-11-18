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
    SEO.init_slug();

    // Load category lúc khởi tạo
    loadCategory();


    // ==========================
    //      EDIT BUTTON
    // ==========================
    $(document).on('click', '.btnEdit', function () {

        let modal_form = $('#modal_form');
        let id = $(this).closest('tr').find('input[type="checkbox"]').val();

        AJAX_CRUD_MODAL.edit(function () {
            $.ajax({
                url: url_ajax_edit,
                type: "POST",
                data: { id: id },
                dataType: "JSON",
                success: function (response) {

                    $('.form-control-feedback').remove();
                    $('.form-group').removeClass('has-danger');
                    $('.form-group').find('bug').remove();

                    // Load category + callback set selected
                    loadCategory(response.data_category, function () {

                        // Set tất cả field
                        $.each(response.data_info, function (key, value) {
                            let element = modal_form.find('[name="' + key + '"]');

                            element.val(value);

                            // Select2
                            if (element.hasClass('select2-hidden-accessible')) {
                                element.trigger('change');
                            }

                            // Switch
                            if (element.hasClass('switchBootstrap')) {
                                element.bootstrapSwitch('state', (value == 1 ? true : false));
                            }
                        });

                        modal_form.modal('show');
                    });

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



// ==========================================
//           HÀM LOAD CATEGORY CHUẨN
// ==========================================
function loadCategory(selectedItem = null, callback = null) {
    let selector = $('select.category');

    // Khởi tạo select2 1 lần
    if (!selector.hasClass("select2-hidden-accessible")) {
        selector.select2({
            placeholder: 'Chọn người dùng',
            allowClear: true,
            ajax: {
                url: "graduate/get_all_child",
                type: "GET",
                dataType: "json",
                delay: 300,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            }
        });
    }

    // ===========================
    // 🔥 GỌI API NGAY LẬP TỨC
    // ===========================
    $.ajax({
        url: "graduate/get_all_child",
        type: "GET",
        dataType: "json",
        success: function (data) {

            selector.empty();

            // Thêm toàn bộ option
            $.each(data, function(i, item) {
                selector.append(new Option(item.text, item.id, false, false));
            });

            // Nếu có selected value → set
            if (selectedItem) {
                selector.val(selectedItem.id).trigger("change");
            }

            if (callback) callback();
        }
    });
}
