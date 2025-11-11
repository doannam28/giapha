<style>
    .main--about .content {
        display: block !important;
    }
</style>
<div class="main__head d-none d-md-inline-block">
    <a href="#" onClick="goBack()" class="btn-back">Quay lại</a>
</div>
<div class="content">
    <div class="news news--detail">
        <div class="panel post">
            <h3 class="post__title"><?= $item_content->title ?></h3>
            <div class="posted-date"><?= date("d/m/Y", strtotime($item_content->created_time)) ?></div>
            <div class="detail">
                <?= $item_content->content ?>
            </div>
        </div>
        <div class="news__more">
            <h3>Tin tức khác</h3>
            <ul class="news__list">
                <?php if (!empty($posts)): ?>
                    <?php $i = 1; ?>
                    <?php foreach ($posts as $post): ?>
                        <?php if ($i < 4 && $post->id != $item_content->id): ?>
                            <li class="news__item">
                                <a href="/chi-tiet/<?= $post->slug ?>" class="card">
                                    <div class="card__img">
                                        <?= getImage($post->thumbnail); ?>
                                    </div>
                                    <div class="card__title clamped-text">
                                        <?= $post->title ?>
                                    </div>
                                    <div class="posted-date"><?= date("d/m/Y", strtotime($post->created_time)) ?></div>
                                </a>
                            </li>
                            <?php $i++; ?>
                        <?php endif; ?>

                    <?php endforeach; ?>
                <?php else: ?>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</div>