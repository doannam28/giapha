<?php
$info = getInfo();
?>
<footer class="footer">
    <div class="container">
        <div class="content">
            <div class="column">
                <div class="logo">
                    <h2>TRANG THÔNG TIN GIA PHẢ HỌ HOÀNG</h2>
                </div>
                <div class="info">
                    <?= $info->footer_info ?>
                </div>
            </div>
            <?php $menu_footer = getListMenu(2); ?>
            <div class="column">
                <div class="nav">
                    <ul class="nav__list">
                        <?php foreach ($menu_footer as $menu): ?>
                            <li class="nav__item">
                                <a href="<?= site_url($menu->link) ?>" class="nav__link">
                                    <?= $menu->title ?>
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <?php $listContact = getInfo('data_social'); ?>
                <?php if (!empty($listContact)): ?>
                    <div class="contact">
                        <p>Thông tin liên hệ</p>
                        <ul class="contact__list">
                            <?php foreach ($listContact as $title => $url): ?>
                                <?php if (!empty($url)): ?>
                                    <li class="contact__item">
                                        <a href="<?= $url; ?>">
                                            <img src="<?= site_url('/public/assets/images/') ?>icon_<?= $title; ?>.svg" alt="" />
                                        </a>
                                    </li>
                                <?php endif ?>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="more">
        <p>
            Thiết kế bởi STARBOND
            <a href="https://starbond.vn/" target="_blank">
                Tìm hiểu thêm
                <img src="<?= site_url('/public/assets/images/icon_arrow-right.svg') ?>" alt="" />
            </a>
        </p>
    </div>
</footer>