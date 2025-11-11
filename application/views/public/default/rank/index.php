<div class="title">
    <h2>BẢNG TRẠNG NGUYÊN</h2>
</div>
<div class="content" style="min-height: 400px;">
    <div class="status">
        <div class="status__bg">
            <img src="./public/assets/images/bg-parchment-status.png" alt="" />
        </div>
        <div class="status__table" style="min-height: 400px;">
            <div class="table table--scroll">
                <table>
                    <colgroup>
                        <col style="width: 92px" />
                        <col style="width: 235px" />
                        <col style="width: 235px" />
                        <col />
                    </colgroup>

                    <thead>
                        <tr>
                            <th>Số thứ tự</th>
                            <th>Họ và tên</th>
                            <th>Tên bố (mẹ)</th>
                            <th>Tên trường</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($list_rank)): ?>
                            <?php $i = 1; ?>
                            <?php foreach ($list_rank as $user): ?>
                                <tr>
                                    <td><?= $offset + $i; ?></td>
                                    <td><?= $user['full_name']; ?></td>
                                    <td>
                                        <?php if (!empty($user['father_name']) && !empty($user['mother_name'])): ?>
                                            <?= $user['father_name']; ?>
                                        <?php else: ?>
                                            <?= $user['father_name']; ?> <?= !empty($user['mother_name']) ? '('.$user['mother_name'].')':''; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $user['university']; ?></td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php if (count($list_rank) == 0): ?>
                                <tr>
                                    <td colspan="5">Đang cập nhật dữ liệu</td>
                                </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?= !empty($pagination) ? $pagination : ''; ?>
        </div>
        <div class="status__bg">
            <img src="./public/assets/images/bg-parchment-status.png" alt="" />
        </div>
    </div>
    <div class="typical">
        <?php if (!empty($posts)): ?>
            <div class="typical__col">
                <h3 class="typical__title">Thanh niên tiêu biểu</h3>
                <ul class="typical__list">
                    <?php foreach ($posts as $post): ?>
                        <li class="typical__item">
                            <a href="<?= site_url('/chi-tiet/' . $post->slug) ?>" class="card card--type2">
                                <div class="card__img">
                                    <?= getImage($post->thumbnail); ?>
                                </div>
                                <div class="card__content">
                                    <div class="card__title">
                                        <?= $post->title ?>
                                    </div>
                                    <p class="card__desc">
                                        <?= $post->description ?>

                                    </p>
                                    <div class="posted-date">
                                        <?= date("d/m/Y", strtotime($post->created_time)) ?>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>

                </ul>
            </div>
        <?php endif; ?>
        <?php if (!empty($posts)): ?>
            <div class="typical__col typical__col--news">
                <h3 class="typical__title">Tin mới nhất</h3>
                <ul class="typical__list">
                    <?php $i = 1; ?>
                    <?php foreach ($posts as $post): ?>
                        <?php if ($i <= 3): ?>
                            <li class="typical__item"> <a href="<?= site_url('/chi-tiet/' . $post->slug) ?>" class="card">
                                    <div class="card__img"><?= getImage($post->thumbnail); ?></div>
                                    <div class="card__title"> <?= $post->title ?></div>
                                    <div class="posted-date"><?= date("d/m/Y", strtotime($post->created_time)) ?></div>
                                </a> </li>
                            <?php $i++ ?>
                        <?php endif; ?>

                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>