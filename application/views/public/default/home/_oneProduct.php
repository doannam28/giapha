<div class="wrapper">
    <a href="<?= get_url_product($item) ?>" title="<?= $item->title ?>">
        <?php if (!empty($type) && $type == 'khuyenmai'): ?>
            <div class="khuyenmai"></div>
        <?php endif; ?>
        <?php if (!empty($item->is_new)) : ?>
            <div class="sp_new">
                <span>Model mới</span>
            </div>
        <?php endif; ?>
        <div class="picture"><span><?= getThumbnail($item, "100%", "auto"); ?></span></div>
        <div class="information">
            <h3 class="name"><?= $item->title ?></h3>
            <div class="price"><strong><?= number_format($item->price_sale, 0, '', '.'); ?>₫</strong><span class="old_price"><?= number_format($item->price, 0, '', '.'); ?>₫</span></div>
        </div>
    </a>
</div>