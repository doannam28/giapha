<!DOCTYPE html>
<html lang="en">

<head>
    <link href="<?= site_url('/public/assets/css/bootstrap.min.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?= site_url('/public/assets/css/main.css') ?>" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= site_url('/public/assets/css/perfect-scrollbar.css') ?>" />
    <link rel="stylesheet" href="<?= site_url('/public/assets/css/treant.css') ?>" />
</head>

<body>
    <div class="wrapper" id="wrapper">
        <div class="inner">
            <main class="main main--<?= $class_css; ?>">
                <div class="content">
                    <div class="genealogy">
                        <div class="panel post post--table">
                            <div class="post__title">
                                Hương hỏa họ Hoàng: Bắc Giang
                            </div>
                            <div class="table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Số thứ tự</th>
                                            <th>Ngày mất</th>
                                            <th>Họ và tên</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($list_user)): ?>
                                            <?php $i = $offset + 1; ?>
                                            <?php foreach ($list_user as $user): ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td><?= $user['date_die']; ?></td>
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
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>