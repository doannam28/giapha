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

    <div class="container_width">
        <section class="product_thumb">
            <h2 class="title">Bài viết cùng chuyên mục</h2>
            <div class="data sale_data">
                <div class="swiper swiper_hotproduct">
                    <div class="swiper-wrapper">
                        <?php if (!empty($list_post)) foreach ($list_post as $key => $item) : ?>
                            <div class="swiper-slide">
                                <div class="wrapper" style="width: 100% !important;">
                                    <a href="<?= get_url_post($item) ?>" title="<?= $item->title ?>">
                                        <div class="picture"><span><?= getThumbnail($item, "", ""); ?></span></div>
                                        <div class="information">
                                            <h2 class="name"><?= $item->title ?></h2>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <div class="clear"></div>
            </div>
        </section>
    </div>

    <div class="container_width">
        <section class="product_thumb">
            <h2 class="title">Bài viết mới nhất</h2>
            <div class="data sale_data">
                <div class="swiper swiper_hotproduct">
                    <div class="swiper-wrapper">
                        <?php if (!empty($post_newst)) foreach ($post_newst as $key => $item) : ?>
                            <div class="swiper-slide">
                                <div class="wrapper" style="width: 100% !important;">
                                    <a href="<?= get_url_post($item) ?>" title="<?= $item->title ?>">
                                        <div class="picture"><span><?= getThumbnail($item, "", ""); ?></span></div>
                                        <div class="information">
                                            <h2 class="name"><?= $item->title ?></h2>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <div class="clear"></div>
            </div>
        </section>
    </div>
</div>