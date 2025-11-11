<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .btnAddForm {
        position: fixed;
        right: 25px;
        top: 100px;
        z-index: 99999;
    }
</style>
<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">

            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-12 order-1 order-xl-2 m--align-right">
                        <button type="submit"
                            class="btn btn-primary m-btn m-btn--icon m-btn--air m-btn--pill btnAddForm">
                            <span>
                                <i class="la la-plus"></i>
                                <span>
                                    Update Setting
                                </span>
                            </span>
                        </button>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>

            <div class="m-portlet m-portlet--tabs">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active show" data-key="data_seo" data-toggle="tab"
                                    href="#tab_general" role="tab" aria-selected="true">
                                    <i class="la la-search"></i>
                                    Thông tin liên hệ
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" data-key="data_social"
                                    href="#tab_social" role="tab" aria-selected="false">
                                    <i class="la la-facebook"></i>
                                    Mạng xã hội
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" data-key="data_email"
                                    href="#tab_email" role="tab" aria-selected="false">
                                    <i class="la la-bank"></i>
                                    Thông tin chuyển khoản
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tab_general" role="tabpanel">
                            <div class="tab-content">
                                <form action="" id="data_seo">
                                    <input type="hidden" value="data_seo" name="key_setting">

                                    <div class="form-group">
                                        <label>Người liên hệ:</label>
                                        <input name="contact_person" class="form-control contact" value="<?= isset($data_seo->contact_person) ? $data_seo->contact_person : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Số điện thoại:</label>
                                        <input name="phone" class="form-control contact" value="<?= isset($data_seo->phone) ? $data_seo->phone : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Người liên hệ:</label>
                                        <input name="contact_person_2" class="form-control contact" value="<?= isset($data_seo->contact_person_2) ? $data_seo->contact_person_2 : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Số điện thoại:</label>
                                        <input name="phone_2" class="form-control contact" value="<?= isset($data_seo->phone_2) ? $data_seo->phone_2 : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Địa chỉ</label>
                                        <input name="address" class="form-control contact" value="<?= isset($data_seo->address) ? $data_seo->address : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <input name="email" class="form-control contact" value="<?= isset($data_seo->email) ? $data_seo->email : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Thông tin hiển thị chân trang:</label>
                                        <textarea name="footer_info" class="form-control contact summernote">
                                        <?= isset($data_seo->footer_info) ? $data_seo->footer_info : ''; ?>
                                        </textarea>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab_social" role="tabpanel">
                            <div class="tab-content">
                                <form action="" id="data_social">
                                    <input type="hidden" value="data_social" name="key_setting">
                                    <div class="form-group">
                                        <label>Facebook</label>
                                        <input name="facebook" class="form-control"
                                            value="<?= isset($data_social->facebook) ? $data_social->facebook : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Youtube</label>
                                        <input name="youtube" class="form-control"
                                            value="<?= isset($data_social->youtube) ? $data_social->youtube : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Gmail</label>
                                        <input name="gmail" class="form-control"
                                            value="<?= isset($data_social->gmail) ? $data_social->gmail : ''; ?>">
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_email" role="tabpanel">
                            <div class="tab-content">
                                <form action="" id="data_email">
                                    <input type="hidden" value="data_email" name="key_setting">
                                    <div class="form-group">
                                        <label>Tên chủ ngân hàng</label>
                                        <input name="full_name" class="form-control"
                                            value="<?= isset($data_email->full_name) ? $data_email->full_name : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Số tài khoản ngân hàng</label>
                                        <input name="banknumber" class="form-control"
                                            value="<?= isset($data_email->banknumber) ? $data_email->banknumber : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Tên Ngân hàng</label>
                                        <input name="bankname" class="form-control"
                                            value="<?= isset($data_email->bankname) ? $data_email->bankname : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Ảnh QR</label>
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
                                        <input name="qr_image" type="hidden" class="form-control"
                                            value="<?= isset($data_email->qr_image) ? $data_email->qr_image : ''; ?>">

                                    </div>
                                    <div class="form-group">
                                        <label>Nội dung chuyển khoản</label>
                                        <input name="content" class="form-control"
                                            value="<?= isset($data_email->content) ? $data_email->content : ''; ?>">
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var url_update_setting = '<?= site_admin_url('setting/update_setting') ?>';
</script>