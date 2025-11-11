<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">

            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-12 order-1 order-xl-2 m--align-right">
                        <?= button_admin(['update']) ?>
                    </div>
                </div>
            </div>

            <form action="" id="data_graveyard">
                <input type="hidden" value="data_graveyard" name="key_setting">
                <div class="form-group">
                    <label>Giới Thiệu </label>
                    <textarea name="intro" class="form-control summernote"><?= !empty($data_graveyard->intro) ? $data_graveyard->intro : ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Vị trí </label>
                    <textarea name="location" class="form-control summernote"><?= !empty($data_graveyard->location) ? $data_graveyard->location : ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Chi Tiết</label>
                    <textarea name="detail" class="form-control summernote"><?= !empty($data_graveyard->detail) ? $data_graveyard->detail : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Link 360 Map</label>
                    <input name="url_map"
                        placeholder="Url"
                        class="form-control" type="text"
                        value="<?= isset($data_graveyard->url_map) ? $data_graveyard->url_map : ''; ?>" />
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    var url_update_setting = '<?= site_url('admin/setting/update_setting') ?>';
</script>