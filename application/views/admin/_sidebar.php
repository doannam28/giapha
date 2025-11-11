<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>

<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark" style="position: fixed;height: 100%;overflow: auto;z-index:999;padding-bottom: 100px">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu"
        class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
        m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__section">
                <h4 class="m-menu__section-text">
                    Quản lý nội dung
                </h4>
                <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>
            <?php $menu_top = getMenuParent(0, 0); ?>
            <?php if (!empty($menu_top)) foreach ($menu_top as $key => $value) : $menu_top_child = getMenuParent($value->id, 0); ?>
                <?php if (!empty($menu_top_child)): ?>
                    <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                            <i class="m-menu__link-icon flaticon-users"></i>
                            <span class="m-menu__link-text">
                                <?= $value->title; ?>
                            </span>
                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                        </a>
                        <div class="m-menu__submenu ">
                            <span class="m-menu__arrow"></span>
                            <ul class="m-menu__subnav">
                                <?php if (!empty($menu_top_child)) foreach ($menu_top_child as $key => $value) : $method = explode("/", $value->link)[2];
                                    $func = !empty(explode("/", $value->link)[3]) ? explode("/", $value->link)[3] : ''; ?>
                                    <?php if ($method == 'category'): ?>
                                        <?php if (!empty($this->session->admin_permission[$func]['view']) || $this->session->userdata['user_id'] == 1): ?>
                                            <li class="m-menu__item">
                                                <a href="<?= base_url($value->link); ?>" class="m-menu__link">
                                                    <i class="m-menu__link-icon flaticon-settings"></i>
                                                    <span class="m-menu__link-text">
                                                        <?= $value->title; ?>
                                                    </span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if (!empty($this->session->admin_permission[$method]['view']) || $this->session->userdata['user_id'] == 1): ?>
                                            <li class="m-menu__item">
                                                <a href="<?= base_url($value->link); ?>" class="m-menu__link">
                                                    <i class="m-menu__link-icon flaticon-settings"></i>
                                                    <span class="m-menu__link-text">
                                                        <?= $value->title; ?>
                                                    </span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                <?php else:
                    $method = explode("/", $value->link)[2];
                    $func = !empty(explode("/", $value->link)[3]) ? explode("/", $value->link)[3] : ''; ?>
                    <?php if (!empty($this->session->admin_permission[$method]['view']) || $this->session->userdata['user_id'] == 1): ?>
                        <?php if ($method == 'category'): ?>
                            <?php if (!empty($this->session->admin_permission[$func]['view']) || $this->session->userdata['user_id'] == 1): ?>
                                <li class="m-menu__item">
                                    <a href="<?= base_url($value->link); ?>" class="m-menu__link">
                                        <i class="m-menu__link-icon flaticon-settings"></i>
                                        <span class="m-menu__link-text">
                                            <?= $value->title; ?>
                                        </span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="m-menu__item">
                                <a href="<?= base_url($value->link); ?>" class="m-menu__link">
                                    <i class="m-menu__link-icon flaticon-settings"></i>
                                    <span class="m-menu__link-text">
                                        <?= $value->title; ?>
                                    </span>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>


            <?php endforeach; ?>
            <li class="m-menu__section">
                <h4 class="m-menu__section-text">
                    Hệ thống
                </h4>
                <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>
            <?php if (!empty($this->session->admin_permission['setting']['view']) || $this->session->userdata['user_id'] == 1): ?>
                <li class="m-menu__item" aria-haspopup="true">
                    <a href="<?= site_admin_url('setting') ?>" class="m-menu__link" data-type="setting">
                        <i class="m-menu__link-icon flaticon-settings"></i>
                        <span class="m-menu__link-text">
                            Cấu hình chung
                        </span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (!empty($this->session->admin_permission['menus']['view']) || $this->session->userdata['user_id'] == 1): ?>
                <li class="m-menu__item" aria-haspopup="true">
                    <a href="<?= site_admin_url('menus') ?>" class="m-menu__link" data-type="menus">
                        <i class="m-menu__link-icon flaticon-menu"></i>
                        <span class="m-menu__link-text">
                            Menu
                        </span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (!empty($this->session->admin_permission['media']['view']) || $this->session->userdata['user_id'] == 1): ?>
                <!--Quản lý Media-->
                <li class="m-menu__item " aria-haspopup="true">
                    <a href="<?= site_admin_url('media') ?>" class="m-menu__link" data-type="media">
                        <i class="m-menu__link-icon flaticon-menu"></i>
                        <span class="m-menu__link-text">
                            Đa phương tiện
                        </span>
                    </a>
                </li>
                <!--Quản lý Media-->
            <?php endif; ?>
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>