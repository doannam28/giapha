<style>
    .search-div {
        right: 0px;
        position: absolute;
    }

    .nav__search:before {
        content: "";
        display: inline-block;
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        background: url(../public/assets/images/icon_search.svg);
    }

    .nav__search input {
        width: 100%;
        padding: 0;
        outline: 0;
        border: 0;
        font-size: 14px;
    }

    .nav__search {
        display: flex;
        width: 256px;
        padding: 8px 12px;
        border-radius: 12px;
        background-color: #fff;
        align-items: center;
        gap: 8px;
    }

    .result {
        position: absolute;
        width: 256px;
        height: 244px;
        border-radius: 12px;
        top: 44px;
        overflow: auto;
        right: 0px;
        background-color: #fff;
        border: 1px solid #D6D9DC;
        z-index: 20;
        padding: 0 8px;
    }

    .contact {
        display: flex;
        align-items: center;
        padding: 12px 0;
        gap: 4px;
        border-bottom: 1px solid #e5e7eb;
        cursor: pointer;
    }

    .contact:last-child {
        border-bottom: none;
    }

    .contact img {
        width: 48px;
        height: 48px;
        object-fit: cover;
        margin-right: 16px;
    }

    .contact span {
        font-size: 14px;
        font-weight: 400;
        color: #333;
    }
    
    .main__head {margin-bottom: 1rem;}
    @media only screen and (max-width: 767px) {
        .main__head {display: block;};
        .main__head .category__list {justify-content: space-between;}
    }
    
    @media (max-width: 991px) {
        .search-div {
            position: relative !important;
            margin: 10px 0;
        }
        .nav__search {
            width: 100%;
        }
    }
</style>
<div class="main__head">
    <a href="#" onclick="goBack()" class="btn-back d-none d-md-flex mr-2">Quay lại</a>
    <div class="category">
        <ul class="category__list">
            <li class="category__item">
                <a href="<?= site_url('gia-pha/pha-do') ?>"
                    class="button <?= $this->router->fetch_method() == 'phado' ? 'button--primary' : '' ?>">
                    Phả đồ
                </a>
            </li>
            <li class="category__item">
                <a href="<?= site_url('gia-pha/toc-uoc') ?>"
                    class="button <?= $this->router->fetch_method() == 'toc_uoc' ? 'button--primary' : '' ?>"> Tộc ước
                </a>
            </li>
            <li class="category__item">
                <a href="<?= site_url('gia-pha/huong-hoa') ?>"
                    class="button <?= $this->router->fetch_method() == 'huong_hoa' ? 'button--primary' : '' ?>"> Hương
                    Hỏa </a>
            </li>
            <li class="category__item">
                <a href="<?= site_url('gia-pha/ngay-gio') ?>"
                    class="button <?= $this->router->fetch_method() == 'ngay_gio' ? 'button--primary' : '' ?>"> Ngày giỗ
                </a>
            </li>
        </ul>
    </div>
    <div class="search-div d-none d-lg-block">
            <div class="nav__search">
                <input type="text" placeholder="Tìm kiếm tên thành viên" id="input_search" name="tu-khoa" />
            </div>
        </div>
        <div class="result" style="display:none">
            <div class="contact">
                <img src="/public/default-thumbnail.webp" alt="Profile">
                <span>Dương Trung Liên</span>
            </div>
    </div>
</div>
<div class="search-div d-block d-lg-none">
    <div class="nav__search">
        <input type="text" placeholder="Tìm kiếm tên thành viên" id="input_search" name="tu-khoa" />
    </div>
    <div class="result" style="display:none">
        <div class="contact">
            <img src="/public/default-thumbnail.webp" alt="Profile">
            <span>Dương Trung Liên</span>
        </div>
    </div>
</div>
<div class="content">
    <div class="genealogy">
        <?= !empty($content_giapha) ? $content_giapha : '' ?>

        <?php $this->load->view($this->template_path . 'block/xuat_pdf'); ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const input = document.getElementById('input_search');
    $(document).ready(function() {
        const $resultContainer = $('.result');
        let debounceTimer;

        $('#input_search').on('input', function() {
            clearTimeout(debounceTimer);
            const value = $(this).val().trim();

            debounceTimer = setTimeout(() => {
                if (value !== '') {
                    $.ajax({
                        url: '<?= site_url('family/search') ?>',
                        type: 'POST',
                        data: {
                            query: value
                        },
                        success: function(response) {
                            $resultContainer.show();
                            $resultContainer.empty();

                            JSON.parse(response).forEach(item => {
                                const contactHtml = `
                                    <div class="contact" onclick="redirect(${item.id})">
                                        <img src="${item.thumbnail || '/public/default-thumbnail.webp'}" alt="Profile">
                                        <span>${item.full_name}</span>
                                    </div>
                                `;
                                $resultContainer.append(contactHtml);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            $resultContainer.hide();
                        }
                    });
                } else {
                    $resultContainer.hide();
                }
            }, 1000);
        });
    });


    function redirect(id) {
        window.location.href = '<?= site_url('pha-do-chi-tiet/') ?>' + id;
    }
</script>