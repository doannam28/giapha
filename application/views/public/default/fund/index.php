<?php
$bank_info = getInfo('data_email')
?>
<style>
    .qr__img img {
        width: auto;
        height: 264px;
    }
</style>
<div class="main__head" style="justify-content: center;">
    <div class="category">
        <ul class="category__list">
            <li class="category__item">
                <a href="<?= site_url('/quan-ly-quy/quy-dong-ho') ?>" class="button  <?= $type == 'quy-dong-ho' ? 'button--primary' : '' ?>">
                    Quỹ dòng họ
                </a>
            </li>
            <li class="category__item">
                <a href="<?= site_url('/quan-ly-quy/quy-khuyen-hoc') ?>" class="button <?= $type == 'quy-khuyen-hoc' ? 'button--primary' : '' ?>">
                    Quỹ khuyến học
                </a>
            </li>
            <li class="category__item">
                <a href="<?= site_url('/quan-ly-quy/chi-quy') ?>" class="button  <?= $type == 'chi-quy' ? 'button--primary' : '' ?>"> Chi tiêu </a>
            </li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="panel post post--table">
        <div class="post__title">Danh sách
            <?php if ($type == 'quy-khuyen-hoc'): ?>
                đóng góp quỹ khuyến học
            <?php elseif ($type == 'quy-dong-ho'): ?>
                đóng góp quỹ dòng Đỗ
            <?php else: ?>
                chi tiêu quỹ Đỗ
            <?php endif; ?>
        </div>
        <div class="table table--scroll">
            <table>
                <colgroup>
                    <col style="width: 100px" />
                    <col style="width: 285px" />
                    <col style="width: 285px" />
                    <col style="width: 285px" />
                    <col style="width: 285px" />
                </colgroup>
                <thead>
                    <tr>
                        <th>Số thứ tự</th>
                        <th><?= $type == 'chi-quy' ? 'Đầu mục chi' : 'Họ và tên' ?></th>
                        <th>Thời gian <?= $type == 'chi-quy' ? 'chi' : 'đóng góp' ?></th>
                        <th>Số tiền</th>
                        <th style="min-width:300px;">Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($list_fund)): ?>
                        <?php $i = 1; ?>
                        <?php foreach ($list_fund as $item): ?>
                            <tr>
                                <td><?= $offset + $i; ?></td>
                                <td><?= $type == 'chi-quy' ? $item['title'] : $item['person_name']; ?></td>
                                <td><?= date("d/m/Y", strtotime($item['created_at'])); ?></td>
                                <td><?= $item['money']; ?></td>
                                <td><?= $item['description']; ?></td>
                            </tr>
                            <?php $i++; ?>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Đang cập nhật dữ liệu</td>
                        </tr>
                    <?php endif; ?>
                    </tr>
                </tbody>
            </table>
        </div>
        <?= !empty($pagination) ? $pagination : ''; ?>
    </div>
    <div class="panel qr">
        <div class="qr__title">Thông tin đóng góp</div>
        <div class="qr__content">
            <div class="qr__img">
               <!-- <img src="<?/*= $bank_info->qr_image */?>" alt="" />-->
                <?= getImage($bank_info->qr_image); ?>
            </div>
            <div class="qr__text">
                <p>
                    Vui lòng chuyển khoản tới tài khoản đại diện dòng họ Hoàng:
                </p>
                <div class="qr__info">
                    <b>Tên chủ tài khoản:</b> <?= $bank_info->full_name ?><br />
                    <b>Số tài khoản:</b> <?= $bank_info->banknumber ?><br />
                    <b>Ngân hàng:</b> <?= $bank_info->bankname ?><br />
                    <b>Nội dung chuyển khoản khuyến nghị:</b><br />
                    “<?= $bank_info->content ?>”
                </div>
            </div>
        </div>
    </div>
</div>