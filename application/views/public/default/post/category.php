
<div id="container_content">
    <div class="container_width">
        <div class="breadcrumb">
            <?= !empty($breadcrumb) ? $breadcrumb : ''; ?>
        </div>

        <section class="warpper">
            <ul class="news_list">
                <?php if (!empty($list_post)) foreach ($list_post as $key => $value) :  ?>
                    <li class="wrapper">
                        <a href="<?= get_url_post($value); ?>" title="<?= $value->title; ?>">
                            <div class="picture"><?= getThumbnail($value, 150, 'auto'); ?></div>
                            <div class="information">
                                <h2><?= $value->title; ?></h2>
                                <div class="teaser"><?= $value->description; ?></div>
                                <div class="timepost"><?= date('d/m/Y', strtotime($value->created_time)) ?></div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="shop_toolbar t_bottom">
                <div class="text-center mx-auto">
                    <button class="btn btn-primary mx-auto my-3 btnLoadMore" data-page="2" data-url="<?= get_url_category_post($oneItem) ?>" type="button">Xem thêm</button>
                </div>
            </div>
        </section>

        <div class="content-home" style="padding: 10px;">
            <?= $content; ?>
        </div>
    </div>
</div>