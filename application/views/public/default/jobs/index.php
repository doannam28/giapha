<div class="title">
    <h2>BẢNG NGÀNH NGHỀ</h2>
    <p>Danh sách nghành nghề con cháu Họ Hoàng</p>
</div>
<div class="jobs-content">
    <div class="job">
        <div class="job__bg">
            <img src="./public/assets/images/bg-job.png" alt="" />
        </div>
        <div class="job__table" style="min-height: 400px;">
            <div class="table table--scroll">
                <table>
                    <colgroup>
                        <col style="width: 80px" />
                        <col style="width: 150px" />
                        <col style="width: 150px" />
                        <col style="width: 150px" />
                        <col style="width: 150px" />
                        <col style="width: 150px" />
                    </colgroup>

                    <thead>
                        <tr>
                            <th>Số thứ tự</th>
                            <th>Họ và tên</th>
                            <th>Đời thứ</th>
                            <th>Tên bố</th>
                            <th>Số điện thoại</th>
                            <th>Nghề nghiệp</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (!empty($list_person)): ?>
                            <?php $i = 1; ?>
                            <?php foreach ($list_person as $user): ?>
                                <tr>
                                    <td style="min-width:80px;"><?= $offset + $i; ?></td>
                                    <td style="min-width:150px;"><?= $user['fullname']; ?></td>
                                    <td style="min-width:150px;"><?= $user['parent_id']; ?></td>
                                    <td style="min-width:150px;">
                                        <?php if (!empty($user['father_name']) && !empty($user['mother_name'])): ?>
                                            <?= $user['father_name']; ?>
                                        <?php else: ?>
                                            <?= $user['father_name']; ?> <?= !empty($user['mother_name']) ? '('.$user['mother_name'].')':''; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td style="min-width:150px;"><?= $user['phone']; ?></td>
                                    <td><?= $user['job_title']; ?></td>
                                </tr>
                                <?php $i++; ?>

                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">Đang cập nhật dữ liệu</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?= !empty($pagination) ? $pagination : ''; ?>
        </div>
    </div>
</div>