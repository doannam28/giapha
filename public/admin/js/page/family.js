// Dom Ready
$(function () {
    datatables_columns = [{
        field: "checkID",
        title: "#",
        width: 50,
        sortable: !1,
        textAlign: "center",
        selector: { class: "m-checkbox--solid m-checkbox--brand" }
    }, {
        field: "id",
        title: "STT",
        width: 50,
        sortable: 'asc',
        filterable: !1,
    }, {
        field: "full_name",
        title: "Họ và tên",
        width: 200
    }, {
        field: "birth_date",
        title: "Ngày sinh",
        width: 80,

    }, {
        field: "gender",
        title: "Giới tính",
        width: 80,

    },
    {
        field: "status",
        title: "Trạng thái",
        width: 100,

    },
    {
        field: "role",
        title: "Vai trò",
        width: 100,

    },
    {
        field: "parent",
        title: "Đời thứ",
        width: 80,

    },
    {
        field: "action",
        width: 350,
        title: "Actions",
        sortable: !1,
        overflow: "visible",
        template: function (t, e, a) {
            content = `<li class="m-nav__item"><span class="m-nav__link">
            <li class="m-nav__item mt-2 button_event">`;

            content += `${permission_edit && t.gender == 'Nam' ? '<span class="m-badge mr-2 m-badge--success m-badge--wide btnAddWife" data-id="Vợ" style="padding: .65rem 1rem;border-radius: 2rem;">Thêm vợ</span>' : ''}`;
            content += `${permission_edit && t.gender == 'Nam' ? '<span class="m-badge mr-2 m-badge--success m-badge--wide btnAddWife" data-id="Con" style="padding: .65rem 1rem;border-radius: 2rem;">Thêm con</span>' : ''}`;
            content += `${permission_edit ? '<span class="m-badge mr-2 m-badge--success m-badge--wide btnEdit" style="padding: .65rem 1rem;border-radius: 2rem;">Sửa</span>' : ''}`;
            content += `${permission_delete ? '<span class="m-badge mr-2 m-badge--danger m-badge--wide btnDelete" style="padding: .65rem 1rem;border-radius: 2rem;">Xóa</span>' : ''}</li>`;

            return content;
        }
    }];
    AJAX_DATATABLES.init();
    loadCategory();
    loadFamily();
    loadHusband();
    loadWife();
    AJAX_CRUD_MODAL.init();
    AJAX_CRUD_MODAL.tinymce();
    SEO.init_slug();
    let type = 'vợ'
    $('[name="is_status"]').on("change", function () {
        table.search($(this).val(), "is_status")
    }), $('[name="is_status"]').selectpicker();

    $(document).on('click', '.btnAddForm', function () {
        $('.form-control-feedback').remove();
        $('.form-group').removeClass('has-danger');
        $('.form-group').find('bug').remove();
        $('select[name="role"]').prop('disabled', false);
        $('select[name="gender"]').prop('disabled', false);
        $('input[name="date_die"]').prop('disabled', true);
        $('select[name="father_id"]').closest('.form-group').show();
        $('select[name="mother_id"]').closest('.form-group').show();
        $('select[name="husband_id"]').closest('.form-group').hide();
        $('.wife').show();
        $("#quanHe").prop('disabled', false);
        let modal_form = $('#modal_form');
        modal_form.find('.modal-title').html('Thêm thành viên');
    });

    $(document).on('click', '.btnAddWife', function () {
        type = $(this).data("id")
        let modal_form = $('#modal_form');
        modal_form.find('.modal-title').html('Thêm thành viên');
        let id = $(this).closest('tr').find('input[type="checkbox"]').val();
        $('select[name="role"]').prop('disabled', false);
        $('select[name="gender"]').prop('disabled', false);
        $('select[name="father_id"]').closest('.form-group').show();
        $('select[name="mother_id"]').closest('.form-group').show();
        $('select[name="husband_id"]').closest('.form-group').hide();
        AJAX_CRUD_MODAL.add();
        $.ajax({
            url: url_ajax_edit,
            type: "POST",
            data: { id: id },
            dataType: "JSON",
            success: function (response) {
                $('.form-control-feedback').remove();
                $('.form-group').removeClass('has-danger');
                $('.form-group').find('bug').remove();

                if (type == 'Vợ') $('.wife').hide();
                else $('.wife').show();
                $('.title-form').show();
                const data = response.data_info;
                $('#type').text(type);
                $('#person').text(data.full_name)
                modal_form.modal('show');
                if (type == 'Vợ') {
                    $('select[name="role"]').val("Vợ");
                    $('select[name="gender"]').val("Nữ");
                    $('select[name="gender"]').prop('disabled', true);
                    $('input[name="husband_id"]').val(data.id);
                    $('select[name="father_id"]').closest('.form-group').hide();
                    $('select[name="mother_id"]').closest('.form-group').hide();
                    $('select[name="husband_id"]').closest('.form-group').show();
                }
                $('input[name="parent_id"]').val(type == 'Vợ' ? data.parent_id : Number(data.parent_id) + 1);
                $('input[name="father_id"]').val(type == 'Con' ? data.id : '');
                $.ajax({
                    url: 'family/get_all_wife/' + data.id, // Đường dẫn tới function
                    type: "POST", // Hoặc "POST"
                    dataType: "json", // Kiểu dữ liệu trả về
                    success: function (response) {
                        // Làm trống select trước khi fill data
                        loadFamily(response.data_father);
                        loadWife(response.data_mother);
                        loadHusband(response.data_husband);
                        if (type == 'Con') {
                            // $("#quanHe").html('<option value="">Chọn</option><option value="Anh trai">Anh trai</option><option value="Chị gái">Chị gái</option><option value="Em trai">Em trai</option><option value="Em gái">Em gái</option>');
                        } else {
                            // $("#quanHe").html('<option value="">Chọn</option><option value="Vợ" selected>Vợ</option><option value="Vợ cả">Vợ cả</option>');
                        };
                    },
                    error: function (xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
                console.log(textStatus);
                console.log(jqXHR);
            }
        });
    });

    $(document).on('click', '.btnEdit', function () {
        $('.title-form').hide();
        $('.wife').show();
        type = ''
        let modal_form = $('#modal_form');
        modal_form.find('.modal-title').html('Chỉnh sửa thành viên');
        let id = $(this).closest('tr').find('input[type="checkbox"]').val();
        // $("#quanHe").html('<option value="">Chọn</option><option value="Anh trai">Anh trai</option><option value="Chị gái">Chị gái</option><option value="Em trai">Em trai</option><option value="Em gái">Em gái</option><option value="Vợ">Vợ</option><option value="Vợ cả">Vợ cả</option><option value="Tổ tiên">Tổ tiên</option>');
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
                    $('select[name="role"]').prop('disabled', false);
                    $('select[name="gender"]').prop('disabled', false);
                    $('select[name="father_id"]').closest('.form-group').show();
                    $('select[name="mother_id"]').closest('.form-group').show();
                    $('select[name="husband_id"]').closest('.form-group').hide();
                    $('.wife').show();
                    $("#quanHe").prop('disabled', false);
                    $.each(response.data_info, function (key, value) {
                        let element = modal_form.find('[name="' + key + '"]');
                        element.val(value);
                        if (element.hasClass('switchBootstrap')) {
                            element.bootstrapSwitch('state', (value == 1 ? true : false));
                        };
                        if (key === 'thumbnail' && value) element.closest('.form-group').find('img').attr('src', media_url + value);
                        if (key === 'album' && value) FUNC.loadMultipleMedia(value);
                        if (key === 'status' && value == 'Sống') {
                            modal_form.find('[name="date_die"]').prop('disabled', true);
                        };
                        if (key === 'status' && value == 'Mất') {
                            modal_form.find('[name="date_die"]').prop('disabled', false);
                        };

                        if (key === 'role') {
                            if (value == 'Vợ' || value == 'Vợ cả') {
                                $('.wife').hide();
                                $('select[name="gender"]').prop('disabled', true);
                                $('select[name="father_id"]').closest('.form-group').hide();
                                $('select[name="mother_id"]').closest('.form-group').hide();
                                $('select[name="husband_id"]').closest('.form-group').show();
                                if (value == 'Vợ') {
                                    // $("#quanHe").html('<option value="">Chọn</option><option value="Vợ" selected>Vợ</option><option value="Vợ cả">Vợ cả</option>');
                                } else {
                                    // $("#quanHe").html('<option value="">Chọn</option><option value="Vợ">Vợ</option><option value="Vợ cả" selected>Vợ cả</option>');
                                }
                            };
                        } else {
                            // $("#quanHe").html('<option value="">Chọn</option><option value="Anh trai">Anh trai</option><option value="Chị gái">Chị gái</option><option value="Em trai">Em trai</option><option value="Em gái">Em gái</option>');
                        }
                    });
                    loadFamily(response.data_father);
                    loadWife(response.data_mother);
                    loadHusband(response.data_husband);
                    modal_form.modal('show');
                    const data = response.data_info;
                    $('#type').text(type);
                    $('#person').text(data.full_name)
                    $('input[name="husband_id"]').val(data.id);
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

    $('#trangThai').change(function () {
        if ($(this).val() === 'Sống') {
            $('input[name="date_die"]').prop('disabled', true);
        } else {
            $('input[name="date_die"]').prop('disabled', false);
        }
    });

    $('#quanHe').change(function () {
        if ($(this).val() === 'Vợ') {
            $('select[name="husband_id"]').closest('.form-group').show();
            $('select[name="father_id"]').closest('.form-group').hide();
            $('select[name="mother_id"]').closest('.form-group').hide();
            $('select[name="gender"]').val("Nữ");
            $('select[name="gender"]').prop('disabled', true);
        } else {
            $('select[name="husband_id"]').closest('.form-group').hide();
            $('select[name="father_id"]').closest('.form-group').show();
            $('select[name="mother_id"]').closest('.form-group').show();
            $('select[name="gender"]').val("Nam");
            $('select[name="gender"]').prop('disabled', false);
        }
    });
    
    $('.mother').change(function () {
        if ($('.father').val() == null) {
                $.ajax({
                url: base_url + 'admin/family/get_all_father/'+$(this).val(),
                type: "POST",
                dataType: "JSON",
                success: function (response) {
                    loadFamily(response.data_father);
                }
            });
        }
    });
    
    $('.father').change(function () {
        if ($('.mother').val() == null) {
                $.ajax({
                url: base_url + 'admin/family/get_all_wife/'+$(this).val(),
                type: "POST",
                dataType: "JSON",
                success: function (response) {
                    loadWife(response.data_wife);
                }
            });
        }
    });
});

function loadCategory(dataSelected) {
    let selector = $('select.category');
    selector.select2({
        placeholder: 'Chọn người',
        allowClear: !0,
        multiple: !1,
        data: dataSelected,
        ajax: {
            url: "family/get_all_wife/" + localStorage.getItem('parent_id'),
            data: { 'csrf_test_name': '<?= $this->security->get_csrf_hash(); ?>' }, // Thay bằng tên CSRF thực tế
            dataType: 'json',
            method: 'POST',
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

function loadWife(dataSelected) {
    let selector = $('select.mother');
    let father_id = $('.father').val();
    selector.select2({
        placeholder: 'Chọn người',
        allowClear: !0,
        multiple: !1,
        data: dataSelected,
        ajax: {
            url: "family/ajax_load/wife?father="+father_id,
            data: { 'csrf_test_name': '<?= $this->security->get_csrf_hash(); ?>' }, // Thay bằng tên CSRF thực tế
            dataType: 'json',
            method: 'POST',
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

function loadFamily(dataSelected) {
    let selector = $('select.father');
    let mother_id = $('.mother').val();
    selector.select2({
        placeholder: 'Chọn người',
        allowClear: !0,
        multiple: !1,
        data: dataSelected,
        ajax: {
            url: "family/ajax_load/parent?husband="+mother_id,
            data: { 'csrf_test_name': '<?= $this->security->get_csrf_hash(); ?>' }, // Thay bằng tên CSRF thực tế
            dataType: 'json',
            method: 'POST',
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

function loadHusband(dataSelected) {
    let selector = $('select.husband');
    selector.select2({
        placeholder: 'Chọn người',
        allowClear: !0,
        multiple: !1,
        data: dataSelected,
        ajax: {
            url: "family/ajax_load/husband",
            data: { 'csrf_test_name': '<?= $this->security->get_csrf_hash(); ?>' }, // Thay bằng tên CSRF thực tế
            dataType: 'json',
            method: 'POST',
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