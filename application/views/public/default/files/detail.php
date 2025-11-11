<style>
  .modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }

  .modal-content {
    position: relative;
    background: white;
    width: 874px;
    padding: 20px;
    border-radius: 10px;
  }

  #modal-image {
    max-width: 100%;
    max-height: 80vh;
  }

  .close {
    position: absolute;
    top: 10px;
    right: 10px;
    background: transparent;
    border: none;
    font-size: 24px;
    cursor: pointer;
  }

  .nav-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: #F6DCAC;
  }

  .nav-btn img {
    display: flex;
    justify-items: center;
    justify-content: center;
    margin: auto;
  }

  .flex-btn {
    margin-top: 12px;
    display: flex;
    justify-content: center;
    gap: 8px;
  }

  #modal-image {
    margin-top: 20px;
  }
</style>
<div class="main__head d-none d-md-inline-block">
  <a href="<?= base_url('tai-lieu/' . $type); ?>" class="btn-back">Quay lại</a>
</div>
<div class="content">
  <div class="panel post">
    <h3 class="post__title"><?= $detail->title ?></h3>
    <div class="posted-date"><?= date("d/m/Y", strtotime($detail->created_time)) ?></div>
    <div class="detail">
      <?= $detail->content ?>
    </div>
  </div>
  <div class="document <?= $type == 'video' ? 'document--video' : '' ?>">
    <h3 class="document__title"><?= $type == 'hinh-anh' ? 'Hình ảnh' : 'Video' ?> tại sự kiện</h3>
    <div class="panel">
      <ul class="document__list">
        <?php if ($type == 'hinh-anh'): ?>
          <?php if (!empty($detail->album)) foreach (json_decode($detail->album) as $item): ?>
            <li class="document__item">
              <a href="<?= MEDIA_URL . $item ?>" class="spotlight" style="display: flex"><img src="<?= MEDIA_URL . $item ?>" alt=""></a>
            </li>
          <?php endforeach ?>
        <?php else: ?>
          <?php $array = $detail->link_banner == '' ? [] : explode('; ', $detail->link_banner);
          $i = 1; ?>
          <?php foreach ($array as $item): ?>
            <li class="document__item">
              Video <?= $i++ ?>:
              <a
                href="<?= $item ?>"
                target="_blank"><?= $item ?>
              </a>
            </li>
          <?php endforeach ?>
        <?php endif; ?>
      </ul>
    </div>
  </div>

  <div class="news"></div>
</div>
<div id="modal" class="modal">
  <div class="modal-content">
    <button id="close-modal" class="close">
      <img src="
      <?= site_url('/public/assets/images/close.png') ?>" alt="">
    </button>
    <img id="modal-image" src="" alt="Modal Image">
    <div class="flex-btn">
      <button id="prev" class="nav-btn"><img src="<?= site_url('/public/assets/images/prev.png') ?>" alt=""></button>
      <button id="next" class="nav-btn"><img src="<?= site_url('/public/assets/images/next.png') ?>" alt=""></button>
    </div>
  </div>
</div>
<script>
  // Lấy danh sách các thẻ a trong ul.nav__list
  const navLinks = document.querySelectorAll('.nav__list a');

  // Duyệt qua từng thẻ a
  navLinks.forEach(link => {
    // Kiểm tra nếu href chứa 'tai-lieu'
    if (link.href.includes('tai-lieu')) {
      // Thêm class 'active' vào thẻ a
      link.classList.add('active');
    }
  });
  // JavaScript for Modal Functionality
  const gallery = document.querySelectorAll('.thumbnail');
  const modal = document.getElementById('modal');
  const modalImage = document.getElementById('modal-image');
  const closeModal = document.getElementById('close-modal');
  const prevBtn = document.getElementById('prev');
  const nextBtn = document.getElementById('next');

  let currentIndex = 0;

  // Open modal
  gallery.forEach((thumbnail, index) => {
    thumbnail.addEventListener('click', () => {
      currentIndex = index;
      openModal();
    });
  });

  function openModal() {
    modal.style.display = 'flex';
    updateModalImage();
  }

  // Update modal image
  function updateModalImage() {
    modalImage.src = gallery[currentIndex].src;
  }

  // Close modal
  closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
  });

  prevBtn.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + gallery.length) % gallery.length;
    updateModalImage();
  });

  nextBtn.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % gallery.length;
    updateModalImage();
  });

  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.style.display = 'none';
    }
  });
</script>