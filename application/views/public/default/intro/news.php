<style>
    #page-links {
        display: flex;
        gap: 5px;
    }
</style>
<div class="news">
    <div class="category">
        <h2 class="appendices__title"><?= isset($query) ? 'Kết quả tìm kiếm theo từ khoá: ' . $query : '' ?></h2>
        <ul class="category__list">
            <?php if (!empty($list_category)): ?>
                <?php $i = 1; ?>
                <?php foreach ($list_category as $user): ?>
                    <li class="category__item <?= $cate_id == $user->id ? 'active' : '' ?>">
                        <a href="<?= $user->slug ?>" data-id="<?= $user->id ?>"
                            class="button">
                            <?= $user->title ?>
                        </a>
                    </li>
                    <?php $i++; ?>
                <?php endforeach; ?>
            <?php else: ?>
            <?php endif; ?>

        </ul>
    </div>
    <ul class="news__list">
        <?php if (!empty($post)): ?>
            <?php foreach ($post as $post): ?>
                <li class="news__item">
                    <a href="/chi-tiet/<?= $post->slug ?>" class="card">
                        <div>
                            <div class="card__img">
                            <?= getImage($post->thumbnail); ?>
                            </div>
                            <div class="card__title clamped-text">
                                <?= $post->title ?>
                            </div>
                        </div>
                        <div class="posted-date"><?= date("d/m/Y", strtotime($post->created_time)) ?></div>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nội dung đang được cập nhật…</p>
        <?php endif; ?>
    </ul>
    <?= !empty($pagination) ? $pagination : ''; ?>
</div>