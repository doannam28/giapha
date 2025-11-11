<div class="content">
    <div class="BannerStickyLeft">
        <div class="BannerStickyLeft_content" style="bottom: 0px;">
            <div class="d-block mb-10">
                <div class="appendices">
                    <div class="appendices__content">
                        <h2 class="appendices__title">DANH MỤC</h2>
                        <ul class="appendices__list">
                            <li class="appendices__item">
                                <a href="<?= site_url('gioi-thieu') ?>" class="appendices__link <?= $this->router->fetch_method() == 'index' ? 'active' : '' ?>">
                                    Gia phả Họ Hoàng
                                </a>
                            </li>
                            <li class="appendices__item">
                                <a href="<?= site_url('lich-su') ?>" class="appendices__link  <?= $this->router->fetch_method() == 'history' ? 'active' : '' ?>">
                                    Lịch sử Họ Hoàng
                                </a>
                            </li>
                            <li class="appendices__item">
                                <a href="<?= site_url('tu-duong') ?>" class="appendices__link  <?= $this->router->fetch_method() == 'home' ? 'active' : '' ?>">
                                    Từ đường
                                </a>
                            </li>
                            <li class="appendices__item">
                                <a href="<?= site_url('tin-tuc/tin-tuc-chung') ?>" class="appendices__link <?= $this->router->fetch_method() == 'news' ? 'active' : '' ?>">
                                    Tin tức
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="d-block mb-10"></div>
        </div>
    </div>
    <?= !empty($content_intro) ? $content_intro : '' ?>
</div>