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

                            <div class="col-md-8">
                                <div class="m-input-icon m-input-icon--left">

                                    <input type="text" class="form-control m-input" placeholder="Tìm kiếm theo họ tên"
                                        id="generalSearch">
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
                <h3 class="modal-title" id="formModalLabel">Thêm mới thành viên</h3>
            </div>
            <div class="modal-body">
                <?= form_open('', ['id' => '', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed m-form--state']) ?>
                <input type="hidden" name="id" value="0">
                <div class="m-portlet--tabs">
                    <div class="m-portlet__body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tab_language" role="tabpanel">
                                <h2 class="title-form" style="display: none;">Thêm <b id="type"></b> Cho <b id="person"></b></h2>
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Họ và tên</label>
                                            <input name="full_name" placeholder="Họ và tên" class="form-control"
                                                type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label>Số điện thoại</label>
                                            <input name="phone" placeholder="Số điện thoại" class="form-control"
                                                type="text" maxlength="11" />
                                        </div>
                                        <div class="form-group">
                                            <label>Công việc</label>
                                            <input name="job_title" placeholder="Công việc" class="form-control"
                                                type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label>Trường học</label>
                                            <input name="education" placeholder="Trường học" class="form-control"
                                                type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label>Giới tính </label>
                                            <select class="form-control" id="gender" name="gender">
                                                <option value="Nam">Nam</option>
                                                <option value="Nữ">Nữ</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label> Mẹ:</label>
                                            <div class="input-group">
                                                <select name="mother_id" class="form-control m-select2 mother" style="width: 100%;"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Cha:</label>
                                            <div class="input-group">
                                                <select name="father_id" class="form-control m-select2 father" style="width: 100%;"></select>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: none;">
                                            <label>Chồng:</label>
                                            <div class="input-group">
                                                <select name="husband_id" class="form-control m-select2 husband" style="width: 100%;"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Trạng thái </label>
                                            <select id="trangThai" class="form-control" name="status">
                                                <option value="Sống">Còn sống</option>
                                                <option value="Mất">Đã mất</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Ngày sinh</label>
                                            <input name="birth_date"  class="form-control" type="date" />
                                        </div>
                                        <div class="form-group">
                                            <label>Ngày mất (Âm lịch)</label>
                                            <input name="date_die"  class="form-control" type="date"  />
                                        </div>
                                        <div class="form-group">
                                            <label>Vai trò trong gia đình</label>
                                            <select id="quanHe" name="role" class="form-control">
                                                <option value="">Chọn</option>
                                                <option value="Anh trai">Anh trai</option>
                                                <option value="Chị gái">Chị gái</option>
                                                <option value="Em trai">Em trai</option>
                                                <option value="Em gái">Em gái</option>
                                                <option value="Vợ">Vợ</option>
                                            </select>
                                            <input name="parent_id" placeholder="Họ và tên" class="form-control" style="display: none" type="text" value="1" />
                                            <input name="wife_index" placeholder="Họ và tên" class="form-control" style="display: none" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label for="banner">Ảnh đại diện</label>
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
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Phả ký</label>
                                            <textarea name="description" id="description" class="form-control tinymce" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
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
    var father_id = '';
    var url_ajax_load_category = '<?= site_url('admin/family/get_all_wife/1') ?>';
</script>