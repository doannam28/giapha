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
            <div class="col-lg-3 col-md-12 sidebar siba-home">
                <?php $this->load->view($this->template_path . 'block/sidebar_category') ?>
                <div class="list-sp" id="scroll-sp">
                    <p class="left-tit mb-0 w-100">Sản phẩm bán chạy</p>
                    <?php if (!empty($hot_product)) foreach ($hot_product as $value) : ?>
                        <div class="itemprd">
                            <div class="responsive-img">
                                <a href="<?= get_url_product($value) ?>">
                                    <?= getThumbnail($value, 230, 230); ?>
                                </a>
                            </div>
                            <div class="info-itemprd">
                                <h3 class="name bgh ifranke">
                                    <a href="<?= get_url_product($value) ?>" title="<?= $value->title ?>"><?= $value->title ?></a>
                                </h3>
                                <div class="price box row-pr all">
                                    <a href="<?= get_url_product($value) ?>">
                                        <?= show_price($value); ?>
                                    </a>
                                </div>
                                <div class="thongtin all">
                                    <a href="<?= get_url_product($value) ?>">
                                        <?php if (!empty($value->size)) : ?>
                                            <p><?= $value->size ?></p>
                                        <?php endif; ?>
                                        <?php if (!empty($value->mass)) : ?>
                                            <p>T.lượng: <?= $value->mass ?></p>
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="content-post">
                    <h1 class="tit-single-post"><?= $oneItem->title ?></h1>
                    <div class="d-flex flex-wrap justify-content-between my-3">
                        <div class="font-13 time">
                            <?php if(!empty($category)) : ?>
                                <a href="<?= get_url_category_post($category);?>" title="<?= $category->title;?>" class="Cate font-weight-bold"><?= $category->title;?></a> -
                            <?php endif;?>
                            <?= date_post_vn($oneItem->created_time) ?> - <?= timeAgo($oneItem->created_time, "H:i") ?>
                        </div>
                        <?php $this->load->view($this->template_path . 'block/_rate') ?>
                    </div>

                    <div><?= $oneItem->description ?></div>
                    <div class="content-text">
                        <?php
                        $content = str_replace('/data/upload', 'public/media/upload', $oneItem->content);
                        $content = str_replace('/data/images/product', 'public/media/upload/product', $oneItem->content);
                        $content = str_replace('alt=""', 'alt="ketsatgiadinh.vn"', $content);
                        $content = str_replace('alt=" "', 'alt="ketsatgiadinh.vn"', $content);
                        echo $content;
                        ?>
                    </div>
                </div>
                <div class="box-post-lq">
                    <h4 class="tit-ct-sp">Bài viết liên quan</h4>
                    <div class="list-sp-lq owl-carousel owl-theme" data-item="4" data-nav="true" data-autoplay="true" data-lazy="true">
                        <?php if (!empty($list_post)) foreach ($list_post as $key => $value) : ?>
                            <div class="item list-post-lq">
                                <div class="responsive-img ">
                                    <a href="<?= get_url_post($value); ?>" title="<?= $value->title ?>">
                                        <img class="owl-lazy" data-src="<?= getImageThumb($value->thumbnail, 230, 230) ?>" alt="<?= $value->title ?>">
                                    </a>
                                </div>
                                <div class="info-itemprd">
                                    <h3 class="name tit-list-post">
                                        <a href="<?= get_url_post($value); ?>" title="<?= $value->title ?>">
                                            <?= $value->title ?>
                                        </a>
                                    </h3>
                                    <p class="mota"><?= $value->description; ?></p>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>