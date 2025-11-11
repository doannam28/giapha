<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-8 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                            <div class="col-md-4">
                                <div class="m-input">
                                    <div class="m-form__control">
                                        <select class="form-control m-bootstrap-select" name="is_status">
                                            <option value="">
                                                Tất cả
                                            </option>
                                            <option value="1">
                                                Đã xuất bản
                                            </option>
                                            <option value="0">
                                                Chưa xuất bản
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <div class="col-md-8">
                                <div class="m-input-icon m-input-icon--left">

                                    <input type="text" class="form-control m-input" placeholder="Search..."
                                        id="generalSearch" value="">
                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                        <span>
                                            <i class="la la-search"></i>
                                        </span>
                                    </span>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                        <?= button_admin(['add', 'delete']) ?>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="m_datatable" id="ajax_data"></div>
            <!--end: Datatable -->
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="formModalLabel">Thêm mới menu</h3>
            </div>
            <div class="modal-body">
                <?= form_open('', ['id' => '', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed m-form--state']) ?>
                <input type="hidden" name="id" value="0">
                <div class="m-portlet--tabs">
                    <div class="m-portlet__body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tab_language" role="tabpanel">
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Tiêu đề</label>
                                            <input name="title" placeholder="Tiêu đề" class="form-control"
                                                type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label>Đường dẫn (Url)</label>
                                            <input name="slug" placeholder="Link" class="form-control" type="text" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_info" role="tabpanel">
                                <?php if ($this->router->fetch_method() != 'events'): ?>
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label>Danh mục cha:</label>
                                                <div class="input-group">
                                                    <select name="parent_id" class="form-control m-select2 category"
                                                        style="width: 100%;"></select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Layout style</label>
                                                <input name="layout" placeholder="Layout style" class="form-control"
                                                    type="text" />
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    Trạng thái:
                                                </label>
                                                <div class="m-input">
                                                    <input data-switch="true" type="checkbox" name="is_status"
                                                        class="switchBootstrap" checked="checked">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="banner">Thumbnail</label>
                                                <div class="input-group m-input-group m-input-group--air">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="input_thumbnail">
                                                            <i class="la la-picture-o"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" name="thumbnail" onclick="FUNC.chooseImage(this)"
                                                        class="form-control m-input chooseImage"
                                                        placeholder="Click để chọn ảnh" aria-describedby="input_thumbnail">
                                                </div>
                                                <div class="alert m-alert m-alert--default preview text-center mt-1"
                                                    role="alert">
                                                    <img width="100" height="100" src="<?= getImageThumb('', 100, 100) ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Link banner</label>
                                                <input name="link_banner" placeholder="Link banner" class="form-control"
                                                    type="text" />
                                            </div>
                                            <div class="form-group">
                                                <label for="banner">Banner</label>
                                                <div class="input-group m-input-group m-input-group--air">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="input_thumbnail">
                                                            <i class="la la-picture-o"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" name="banner" onclick="FUNC.chooseImage(this)"
                                                        class="form-control m-input chooseImage"
                                                        placeholder="Click để chọn ảnh" aria-describedby="input_thumbnail">
                                                </div>
                                                <div class="alert m-alert m-alert--default preview text-center mt-1"
                                                    role="alert">
                                                    <img width="100" height="100" src="<?= getImageThumb('', 100, 100) ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="row">
                                        <div class="col-lg-12 col-12">
                                            <div class="form-group">
                                                <label for="banner">Thumbnail</label>
                                                <div class="input-group m-input-group m-input-group--air">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="input_thumbnail">
                                                            <i class="la la-picture-o"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" name="thumbnail" onclick="FUNC.chooseImage(this)"
                                                        class="form-control m-input chooseImage"
                                                        placeholder="Click để chọn ảnh" aria-describedby="input_thumbnail">
                                                </div>
                                                <div class="alert m-alert m-alert--default preview text-center mt-1"
                                                    role="alert">
                                                    <img width="100" height="100" src="<?= getImageThumb('', 100, 100) ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-12">
                                            <div class="form-group">
                                                <label>Loại:</label>
                                                <div class="input-group">
                                                    <select name="parent_id" class="form-control" style="width: 100%;">
                                                        <option value="">--Chọn--</option>
                                                        <option value="1">Hình ảnh</option>
                                                        <option value="2">Video</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-12">
                                            <div class="add-img">
                                                <fieldset class="form-group album-contain">
                                                    <legend>Thêm album</legend>
                                                    <div data-id="0" data-name="files" id="gallery"></div>
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-primary btnAddMore"
                                                            onclick="FUNC.chooseMultipleMedia('gallery')">
                                                            <i class="la la-plus"></i> Thêm
                                                        </button>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <div class="add-video row" id="input-list">
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="">Link youtube 1</label>
                                                        <input type="text" class="form-control" onchange="updateArray()">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="">Link youtube 2</label>
                                                        <input type="text" class="form-control" onchange="updateArray()">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="">Link youtube 3</label>
                                                        <input type="text" class="form-control" onchange="updateArray()">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="">Link youtube 4</label>
                                                        <input type="text" class="form-control" onchange="updateArray()">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="">Link youtube 5</label>
                                                        <input type="text" class="form-control" onchange="updateArray()">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="">Link youtube 6</label>
                                                        <input type="text" class="form-control" onchange="updateArray()">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="">Link youtube 7</label>
                                                        <input type="text" class="form-control" onchange="updateArray()">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="">Link youtube 8</label>
                                                        <input type="text" class="form-control" onchange="updateArray()">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-group" style="display: none">
                                                <label>Link banner</label>
                                                <input name="link_banner" id="banner" placeholder="Link banner" class="form-control"
                                                    type="text" />
                                                <div class="form-group">
                                                    <label for="banner">Banner</label>
                                                    <div class="input-group m-input-group m-input-group--air">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="input_thumbnail">
                                                                <i class="la la-picture-o"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" name="banner" onclick="FUNC.chooseImage(this)"
                                                            class="form-control m-input chooseImage"
                                                            placeholder="Click để chọn ảnh" aria-describedby="input_thumbnail">
                                                    </div>
                                                    <div class="form-group" style="display: none">
                                                        <label>
                                                            Trạng thái:
                                                        </label>
                                                        <div class="m-input">
                                                            <input data-switch="true" type="checkbox" name="is_status"
                                                                class="switchBootstrap" checked="checked">
                                                        </div>
                                                    </div>
                                                    <div class="alert m-alert m-alert--default preview text-center mt-1"
                                                        role="alert">
                                                        <img width="100" height="100" src="<?= getImageThumb('', 100, 100) ?>">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btnSave">Save and Close</button>
                <button type="submit" class="btn btn-success btnSaveUpdate">Update</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var url_ajax_load_category = '<?= site_admin_url('category/ajax_load/' . $this->_method) ?>';
    $(function() {
        $("#imagePreview").empty();
        datatables_columns = [{
                field: "checkID",
                title: "#",
                width: 50,
                sortable: !1,
                textAlign: "center",
                selector: {
                    class: "m-checkbox--solid m-checkbox--brand"
                },
            },
            {
                field: "id",
                title: "STT",
                width: 50,
                sortable: "asc",
                filterable: !1,
            },
            {
                field: "title",
                title: "Tiêu đề",
                width: 350,
            },
            {
                field: "action",
                width: 250,
                title: "Actions",
                sortable: !1,
                overflow: "visible",
                template: function(t, e, a) {
                    content = `
            <li class="m-nav__item mt-2 button_event">`;
                    content += `${permission_edit
          ? '<span class="m-badge mr-2 m-badge--success m-badge--wide btnEdit" style="padding: .65rem 1rem;border-radius: 2rem;">Sửa</span>'
          : ""
          }`;
                    content += `${permission_delete
          ? '<span class="m-badge mr-2 m-badge--danger m-badge--wide btnDelete" style="padding: .65rem 1rem;border-radius: 2rem;">Xóa</span>'
          : ""
          }</li>`;

                    return content;
                },
            },
        ];
        AJAX_DATATABLES.init();
        loadCategory();
        AJAX_CRUD_MODAL.init();
        AJAX_CRUD_MODAL.tinymce();
        AJAX_CRUD_MODAL.summernote();
        SEO.init_slug();

        $('[name="is_status"]').on("change", function() {
                table.search($(this).val(), "is_status");
            }),
            $('[name="is_status"]').selectpicker();

        $(document).on("click", ".btnEdit", function() {
            let modal_form = $("#modal_form");
            let id = $(this).closest("tr").find('input[type="checkbox"]').val();
            AJAX_CRUD_MODAL.edit(function() {
                $.ajax({
                    url: url_ajax_edit,
                    type: "POST",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        $('.form-control-feedback').remove();
                        $('.form-group').removeClass('has-danger');
                        $('.form-group').find('bug').remove();

                        $.each(response.data_info, function(key, value) {
                            let element = modal_form.find('[name="' + key + '"]');
                            element.val(value);
                            if (element.hasClass("switchBootstrap")) {
                                element.bootstrapSwitch("state", value == 1 ? true : false);
                            }
                            if (key === "content" && value && modal_form.find(".tinymce").length > 0)
                                tinymce
                                .get(element.attr("id"))
                                .setContent(response.data_info.content);
                            if (key === "banner" && value && modal_form.find(".tinymce").length > 0)
                                element
                                .closest(".form-group")
                                .find("img")
                                .attr("src", media_url + value);
                            if (key === 'thumbnail' && value) {
                                thumbnail = value ? FUNC.getImageThumb(value) : base_url + 'public/default-thumbnail.webp';
                                element.closest('.form-group').find('img').attr('src', thumbnail);
                            }
                            if (key === 'album' && value) FUNC.loadMultipleMedia(value);
                        });
                        if (response.data_info.parent_id == 1) {
                            $('.add-img').show();
                            $('.add-video').hide();
                        } else if (response.data_info.parent_id == 2) {
                            $('.add-img').hide();
                            $('.add-video').show();
                        } else {
                            $('.add-img').hide();
                            $('.add-video').hide();
                        }
                        if (response.data_info.link_banner.length == 0)
                            $("#imagePreview").empty();
                        loadCategory(response.data_category);
                        modal_form.modal("show");
                        var listImg =
                            response.data_info.link_banner.length > 0 ?
                            response.data_info.link_banner.split("; ") :
                            [];
                        const inputs = document.querySelectorAll("#input-list input");

                        // Lặp qua từng input và gán giá trị từ mảng linksArray
                        inputs.forEach((input, index) => {
                            input.value = listImg[index] || ""; // Gán giá trị hoặc để trống nếu không có dữ liệu
                        });
                        listImg.forEach(function(link) {
                            var imgHtml = `
                            <div style="margin: 5px; position: relative;">
                                <img src="${link}" width="150" height="150" style="border: 1px solid #ddd;">
                                <span style="position: absolute; top: 0; right: 0; cursor: pointer;" class="remove-img">X</span>
                            </div>`;
                            $("#imagePreview").append(imgHtml);
                        });
                        $('.img_gallery').on('error', function() {
                            $(this).attr('src', '/public/default-thumbnail.webp');
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        console.log(textStatus);
                        console.log(jqXHR);
                    },
                });
                return false;
            });
        });
        $("#files").on("change", function() {
            var formData = new FormData();
            var files = $("#files")[0].files;

            // Thêm các file vào FormData
            for (var i = 0; i < files.length; i++) {
                formData.append("files[]", files[i]);
            }

            // Gửi AJAX upload file khi onchange
            $.ajax({
                url: "multifile", // Controller xử lý upload
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.status === "success") {
                        var fileLinks = [];

                        // Hiển thị hình ảnh và thêm vào input banner
                        data.files.forEach(function(file) {
                            fileLinks.push(file);

                            var imagePath = '<?= base_url("uploads/") ?>' + file;
                            fileLinks.push(file);

                            var imgHtml = `
                            <div style="margin: 5px; position: relative;">
                                <img src="${file}" width="150" height="150" style="border: 1px solid #ddd;">
                                <span style="position: absolute; top: 0; right: 0; cursor: pointer;" class="remove-img">X</span>
                            </div>`;
                            $("#imagePreview").append(imgHtml);
                        });

                        $("#banner").val(fileLinks.join("; "));
                    } else {
                        alert(data.message);
                    }
                },
                error: function() {
                    alert("File upload failed!");
                },
            });
        });

        // Xóa ảnh khỏi giao diện và input
        $("#imagePreview").on("click", ".remove-img", function() {
            $(this).parent().remove();

            var remainingLinks = [];
            $("#imagePreview img").each(function() {
                var src = $(this).attr("src").split("/").pop();
                remainingLinks.push(src);
            });

            $("#banner").val(remainingLinks.join("; "));
        });
        // Set the value to '1' (for "Đã xuất bản")

        // $('select[name="is_status"]').val("1").trigger("change");
    });
</script>