<div id="container_content">
    <div class="container_width">
        <div class="breadcrumb">
            <?= !empty($breadcrumb) ? $breadcrumb : ''; ?>
        </div>
        <div class="content-home" style="padding: 10px;">
            <div class="post_header">
                <h1 class="tit-single-post"><?= $oneItem->title ?></h1>
                <div class="d-flex flex-wrap justify-content-between my-3">
                    <div class="font-13 time">
                        <?php if (!empty($category)) : ?>
                            <a href="<?= get_url_category_post($category); ?>" title="<?= $category->title; ?>" class="Cate font-weight-bold"><?= $category->title; ?></a> -
                        <?php endif; ?>
                        <?= date_post_vn($oneItem->created_time) ?> - <?= timeAgo($oneItem->created_time, "H:i") ?>
                    </div>
                    <?php $this->load->view($this->template_path . 'block/_rate') ?>
                </div>
            </div>

            <div><?= $oneItem->description ?></div>
            <?php
            $content = str_replace('/data/upload', 'public/media/upload', $oneItem->content);
            $content = str_replace('/data/images/product', 'public/media/upload/product', $oneItem->content);
            $content = str_replace('alt=""', 'alt="ketsatgiadinh.vn"', $content);
            $content = str_replace('alt=" "', 'alt="ketsatgiadinh.vn"', $content);
            echo $content;
            ?>
        </div>
    </div>
</div>