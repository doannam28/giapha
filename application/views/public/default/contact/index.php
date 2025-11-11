<?php
$info = getInfo();
$social = getInfo('data_social');
?>
<div class="content">
    <div class="panel contact">
        <div class="contact__item">
            <h2 class="contact__title">Thông tin liên hệ</h2>
            <div class="contact__detail">
                <ul>
                    <?php if (!empty($info->contact_person) && !empty($info->phone)): ?>
                        <li>
                            <span class="icon icon--card"></span>
                            Người liên hệ: <?= $info->contact_person ?><br>
                            Điện thoại: <?= $info->phone ?>
                        </li>
                    <?php endif; ?>

                    <?php if (!empty($info->contact_person_2) && !empty($info->contact_person_2_phone)): ?>
                        <li>
                            <span class="icon icon--card"></span>
                            Người liên hệ: <?= $info->contact_person_2 ?><br>
                            Điện thoại: <?= $info->contact_person_2_phone ?>
                        </li>
                    <?php endif; ?>

                    <?php if (!empty($info->address)): ?>
                        <li>
                            <span class="icon icon--location"></span>
                            Địa chỉ: <?= $info->address ?>
                        </li>
                    <?php endif; ?>

                    <?php if (!empty($info->email)): ?>
                        <li>
                            <span class="icon icon--email"></span>
                            Email: <?= $info->email ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="contact__item">
            <h2 class="contact__title">Mạng xã hội</h2>
            <div class="contact__detail">
                <ul>
                    <?php if (!empty($social->facebook)): ?>
                        <li>
                            <img src="<?= site_url('/public/assets/images/icon_facebook.svg') ?>" alt="Facebook">
                            <a href="<?= $social->facebook ?>" target="_blank">
                                <?= $social->facebook ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (!empty($social->youtube)): ?>
                        <li>
                            <img src="<?= site_url('/public/assets/images/icon_youtube.svg') ?>" alt="YouTube">
                            <a href="<?= $social->youtube ?>" target="_blank">
                                <?= $social->youtube ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>