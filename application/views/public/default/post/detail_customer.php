<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <?= !empty($breadcrumb) ? $breadcrumb : ''; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<section id="dev-product" class="pb-30">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12 sidebar">
                <?php $this->load->view($this->template_path . 'block/sidebar_category') ?>
            </div>
            <div class="col-lg-9 col-md-12">

                <div class="content-post">
                    <h1 class="tit-single-post"><?= $oneItem->title ?></h1>
                    <div class="content-text">
                        <?php
                        if (!empty($oneItem->content)) {
                            $content = str_replace('/data/upload', 'public/media/upload', $oneItem->content);
                            $content = str_replace('/data/images/product', 'public/media/upload/product', $oneItem->content);
                            echo $content;
                        } else {
                            echo 'Đang cập nhật dữ liệu ...';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>