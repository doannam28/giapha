<?php if (!empty($hot_product)) {
    foreach ($hot_product as $value) : ?>
        <div class="itemprd">
            <div class="responsive-img">
                <a href="<?= get_url_product($value) ?>">
                    <?= getThumbnail($value, 230, 230); ?>
                </a>
            </div>
            <div class="info-itemprd">
                <p class="name bgh ifranke">
                    <a href="<?= get_url_product($value) ?>" title="<?= $value->title ?>"><?= $value->title ?></a>
                </p>
                <div class="price box row-pr all">
                    <a href="<?= get_url_product($value) ?>">
                        <?= show_price($value); ?>
                    </a>
                </div>
                <div class="thongtin all">
                    <a href="<?= get_url_product($value) ?>">
                        <?php if (!empty($value->size)): ?>
                            <p><?= $value->size ?></p>
                        <?php endif; ?>
                        <?php if (!empty($value->mass)): ?>
                            <p>T.lượng: <?= $value->mass ?></p>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
<?php endforeach;
} ?>

