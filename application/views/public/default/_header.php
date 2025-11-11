<header class="header">
    <div class="container">
        <div class="content">
            <a href="<?= site_url('/') ?>" class="logo">
                <div class="logo__img">

                    <img src="<?= site_url('/public/assets/images/logo_pc.png') ?>" alt="" />
                </div>
                <h1 class="logo__text">GIA PHẢ HỌ HOÀNG</h1>
            </a>
            <?php $menu_top = getListMenu(1); ?>
            <div class="nav">
                <div class="nav__popper">
                    <ul class="nav__list">
                        <?php foreach ($menu_top as $menu): ?>
                            <?php
                            $class = '';
                            if ($this->router->fetch_class() == $menu->class || (($this->router->fetch_class() == 'home' && $menu->class == 'intro' && base_url() == current_url()))) $class = 'active';
                            else {
                                $current_url = current_url();
                                if (strpos($current_url, $menu->link) !== false) $class = 'active';
                            }
                            ?>
                            <li class="nav__item">
                                <a href="<?= site_url($menu->link) ?>" class="nav__link <?= $class ?>">
                                    <?= $menu->title ?>
                                </a>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                    <div class="nav__heading">
                        <div class="logo">
                            <div class="logo__img"></div>
                            <h1 class="logo__text">HỌ HOÀNG</h1>
                        </div>
                        <div class="nav__menu">
                            <button type="button" class="nav__close">
                                <img src="<?= site_url('/public/assets/images/icon_close.svg') ?>" alt="" />
                            </button>
                        </div>
                    </div>
                </div>
                <div class="nav__menu">
                    <button type="button" class="nav__bar">
                        <img src="<?= site_url('/public/assets/images/icon_menu.svg') ?>" alt="" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>