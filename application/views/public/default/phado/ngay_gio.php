<div class="panel post post--table">
    <div class="post__title">
        Ngày giỗ họ Hoàng: Bắc Giang
    </div>
    <div class="table">
        <table>
            <colgroup>
                <col />
                <col />
                <col />
            </colgroup>
            <thead>
                <tr>
                    <th>Số thứ tự</th>
                    <th>Ngày giỗ (Âm lịch)</th>
                    <th>Họ và tên</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($list_user)): ?>
                    <?php $i = 1; ?>
                    <?php foreach ($list_user as $user): ?>
                        <tr>
                            <td><?= $offset + $i; ?></td>
                            <td><?= date("Y", strtotime($user['date_die'])) > 1000 ? date("d/m", strtotime($user['date_die'])).'/'.date("Y") : 'Chưa rõ'; ?></td>
                            <td><?= $user['full_name']; ?></td>
                        </tr>
                        <?php $i++; ?>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Đang cập nhật dữ liệu</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?= !empty($pagination) ? $pagination : ''; ?>
</div>