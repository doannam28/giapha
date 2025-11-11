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
                <h3 class="modal-title" id="formModalLabel">Thêm thông tin bảng vàng</h3>
            </div>
            <div class="modal-body">
                <?= form_open('', ['id' => '', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed m-form--state']) ?>
                <input type="hidden" name="id" value="0">
                <div class="m-portlet--tabs">
                    <div class="m-portlet__body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tab_language" role="tabpanel">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Họ và tên</label>

                                            <select id="trangThai" class="form-control m-select category" style="width: 100%" name="person_id">
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Năm đỗ đại học</label>
                                            <input name="year" placeholder="Năm đỗ đại học" class="form-control"
                                                type="number" max="4" />
                                        </div>

                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Tên trường </label>
                                            <input name="university" placeholder="Tên trường" class="form-control"
                                                type="text" />
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