<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->

<head>
    <meta charset="utf-8" />
    <title>
        Admin CMS | Dashboard
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta id="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash() ?>">
    <!--begin::Web font -->
    <script>
        WebFontConfig = {
            google: {
                families: ["Nunito Sans:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <link href="<?= $this->templates_assets ?>assets/vendors/base/vendors.bundle.css?v=<?= ASSET_VERSION ?>" rel="stylesheet" type="text/css" />
    <link href="<?= $this->templates_assets ?>assets/demo/default/base/style.bundle.css?v=<?= ASSET_VERSION ?>" rel="stylesheet" type="text/css" />
    <link href="<?= $this->templates_assets ?>assets/vendors/custom/jquery-ui/jquery-ui.bundle.css?v=<?= ASSET_VERSION ?>" rel="stylesheet" type="text/css" />
    <link href="<?= $this->templates_assets ?>css/custom.css?v=<?= ASSET_VERSION ?>" rel="stylesheet" type="text/css" />
    <!--begin::Base Scripts -->
    <script src="<?= $this->templates_assets ?>assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
    <script src="<?= $this->templates_assets ?>assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
    <!--end::Base Scripts -->

    <!--end::Base Styles -->
    <link rel="shortcut icon" href="<?= site_url('public/favicon.ico') ?>" />
    <style>
        body {
            font-family: 'Arial', Roboto, Helvetica, Sans-serif, Verdana !important;
            font-size: 14px !important;
        }

        .content p,
        em,
        span {
            font-size: 14px !important;
        }

        h2 {
            font-size: 18px !important;
        }

        h3 {
            font-size: 16px !important;
        }

        .modal-open .modal {
            overflow-x: hidden;
            overflow-y: hidden;
            height: 800px;
            padding-right: 0 !important;
        }

        .modal-body {
            overflow: auto;
            height: 800px;
            padding-bottom: 200px !important;
        }
        
        bug {color: #F4516C;}
    </style>
</head>

<!-- end::Head -->

<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
    <?php

    $class = $this->router->fetch_class();
    $user_id = !empty($this->session->userdata('admin_group_id')) ? $this->session->userdata('admin_group_id') : '';
    ?>

    <script>
        var class_name = '<?= $class; ?>';
        var base_url = '<?= base_url(); ?>',
            base_admin_url = '<?= site_admin_url(); ?>',
            current_url = '<?= current_url(); ?>',
            path_media = '<?= MEDIA_PATH; ?>',
            media_name = '<?= MEDIA_NAME; ?>',
            media_url = '<?= MEDIA_URL; ?>',
            language = {},
            lang_cnf = {},
            permission_edit = '<?= !empty($this->session->admin_permission[$this->_controller]['edit']) || $user_id == 1 ? true : false ?>',
            permission_delete = '<?= !empty($this->session->admin_permission[$this->_controller]['delete']) || $user_id == 1 ? true : false ?>',
            permission_all = '<?= json_encode($this->session->admin_permission) ?>',
            user_id = '<?= $this->session->userdata('admin_group_id'); ?>',
            admin_group_id = '<?= $this->session->userdata('admin_group_id'); ?>';

        <?php if (!empty($this->_controller)): ?>
            var url_ajax_list = '<?= site_url("admin/$this->_controller/ajax_list") ?>',
                url_ajax_load = '<?= site_url("admin/$this->_controller/ajax_load") ?>',
                url_ajax_add = '<?= site_url("admin/$this->_controller/ajax_add") ?>',
                url_ajax_copy = '<?= site_url("admin/$this->_controller/ajax_copy") ?>',
                url_ajax_edit = '<?= site_url("admin/$this->_controller/ajax_edit") ?>',
                url_ajax_update = '<?= site_url("admin/$this->_controller/ajax_update") ?>',
                url_ajax_update_field = '<?= site_url("admin/$this->_controller/ajax_update_field") ?>',
                url_ajax_delete = '<?= site_url("admin/$this->_controller/ajax_delete") ?>';
        <?php endif; ?>
        <?php if (!empty($this->config->item('language_name'))) foreach ($this->config->item('language_name') as $lang_code => $lang_name) { ?>
            lang_cnf['<?= $lang_code; ?>'] = '<?= $lang_name; ?>';
        <?php } ?>
    </script>

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <!-- BEGIN: Header -->
        <?php $this->load->view($this->template_path . '_header') ?>
        <!-- END: Header -->
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
            <!-- BEGIN: Left Aside -->
            <?php $this->load->view($this->template_path . '_sidebar') ?>
            <!-- END: Left Aside -->
            <div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-left: 250px;">
                <!-- begin::Body -->
                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    <!-- BEGIN: Subheader -->
                    <div class="m-subheader ">
                        
                    </div>
                    <!-- END: Subheader -->
                    <?= !empty($main_content) ? $main_content : '' ?>
                </div>
                <!-- end:: Body -->
            </div>
        </div>
        <!-- begin::Footer -->
        <?php $this->load->view($this->template_path . '_footer') ?>
        <!-- end::Footer -->
    </div>
    <!-- end:: Page -->
    <!-- begin::Quick Sidebar -->

    <!-- end::Quick Sidebar -->
    <!-- begin::Scroll Top -->
    <div id="m_scroll_top" class="m-scroll-top">
        <i class="la la-arrow-up"></i>
    </div>
    <!-- end::Scroll Top -->

    <!--begin::Page Vendors -->
    <script src="<?= $this->templates_assets ?>assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
    <!--end::Page Vendors -->

    <!--Jquery UI-->
    <script src="<?= $this->templates_assets ?>assets/vendors/custom/jquery-ui/jquery-ui.bundle.js" type="text/javascript"></script>
    <!--Jquery UI-->

    <!--Sort select2-->
    <script src="<?= $this->templates_assets ?>assets/vendors/custom/select2-sort/select2-sort.js" type="text/javascript"></script>
    <!--Sort select2-->

    <!--begin::Page Snippets -->
    <script src="<?= $this->templates_assets ?>js/jquery.nestable.js" type="text/javascript"></script>
    <script src="<?= $this->templates_assets ?>plugins/tinymce/tinymce.min.js" type="text/javascript"></script>
    <script src="<?= $this->templates_assets ?>plugins/moxiemanager/js/moxman.loader.min.js" type="text/javascript"></script>
    <!-- <script src="<?= $this->templates_assets ?>plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.vi.js" type="text/javascript"></script>
<script src="<?= $this->templates_assets ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script> -->
    <script src="<?= $this->templates_assets ?>js/main.js?v=<?= ASSET_VERSION ?>" type="text/javascript"></script>
    <?php if (!empty($this->_controller)): ?><script src="<?= $this->templates_assets ?>js/page/<?= $this->_controller ?>.js?v=<?= ASSET_VERSION ?>" type="text/javascript"></script><?php endif; ?>
    <!--end::Page Snippets -->
</body>

</html>