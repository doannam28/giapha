<div class="panel post post--table">
    <div class="post__title">
        Hương hỏa Họ Hoàng
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
                    <th>Ngày mất</th>
                    <th>Họ và tên</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($list_user)): ?>
                    <?php $i = 1; ?>
                    <?php foreach ($list_user as $user): ?>
                        <tr>
                            <td><?= $offset + $i; ?></td>
                            <td><?= date("Y", strtotime($user['date_die'])) > 1000 ? date("d/m/Y", strtotime($user['date_die'])) : 'Chưa rõ'; ?></td>
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