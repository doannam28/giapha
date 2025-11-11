<div class="main__head">
  <div class="category">
    <ul class="category__list">
      <li class="category__item">
        <a href="<?= site_url('/tai-lieu/hinh-anh') ?>" class="button <?= $type == 'hinh-anh' ? 'button--primary' : '' ?>">
          Hình ảnh sự kiện
        </a>
      </li>
      <li class="category__item">
        <a href="<?= site_url('/tai-lieu/video') ?> " class="button <?= $type == 'video' ? 'button--primary' : '' ?>">Video sự kiện</a>
      </li>
    </ul>
  </div>
</div>
<div class="content">
  <div class="news">
    <ul class="news__list">
      <?php if (!empty($list_file)): ?>
        <?php foreach ($list_file as $file): ?>
          <li class="news__item">
            <a href="<?= site_url('/tai-lieu/' . $type . '/' . $file->slug) ?>" class="card">
              <div>
                  <div class="card__img">
                    <?= getImage($file->thumbnail); ?>
                  </div>
                  <div class="card__title clamped-text">
                    <?= $file->title ?>
                  </div>
              </div>
              <div class="posted-date"><?= date("d/m/Y", strtotime($file->created_time)) ?></div>
            </a>
          </li>

        <?php endforeach; ?>
      <?php else: ?>
          <p>Nội dung đang được cập nhật…</p>
      <?php endif; ?>
    </ul>
    <?= !empty($pagination) ? $pagination : ''; ?>
  </div>
</div>