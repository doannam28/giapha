<style>
    .rss-list .ic {
        background: #ee802f;
        fill: #fff;
        padding: 2px;
        width: 20px;
        height: 20px;
        margin-top: -3px;
        margin-left: 10px;
        border-radius: 1px;
        display: inline-block;
        vertical-align: middle;
    }
    .ic {
        width: 16px;
        height: 16px;
        fill: #757575;
        display: inline-block;
        vertical-align: middle;
    }
</style>
<svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <defs>
        <symbol id="rss" viewBox="0 0 32 32">
            <path d="M10 26c0 1.4-0.8 2.7-2 3.5-1.2 0.7-2.8 0.7-4 0s-2-2-2-3.5c0-1.5 0.8-2.7 2-3.5 1.2-0.7 2.8-0.7 4 0s2 2 2 3.5z"></path>
            <path d="M30 30h-5.4c0-12.4-10.2-22.6-22.6-22.6v-5.4c15.4 0 28 12.6 28 28z"></path>
            <path d="M20.6 30h-5.2c0-7.4-6-13.4-13.4-13.4v-5.2c10.2 0 18.6 8.4 18.6 18.6z"></path>
        </symbol>
    </defs>
</svg>
<div class="container">
    <div class="content_container bg-white p-3">
        <div class="mn_dh mb-3">
            <div class="d-flex align-items-center">
                <a class="hot" href="/"><strong>Home:</strong></a>
                <h1 class="mb-0 ml-3" style="font-size: 15px;">
                    <?= $this->_settings->hometitle?> - RSS
                </h1>
            </div>
        </div>

        <div class="ct_noidung">
            <p>
                <b>RSS là gì ?</b>
            </p>
            <p>
                RSS (Really Simple Syndication) là một chuẩn tựa XML được rút gọn dành cho việc phân tán và khai thác nội dung thông tin Web (ví dụ như các tiêu đề tin tức). Sử dụng RSS, các nhà cung cấp nội dung Web có thể dễ dàng tạo và phổ biến các nguồn dữ liệu ví dụ như các liên kết tin tức, tiêu đề, ảnh và tóm tắt
            </p>
            <p><b><?= $this->_settings->title?> cung cấp những kênh thông tin RSS sau:</b></p>
            <?php if (!empty($allCate)):?>
            <table width="100%" border="1" bordercolor="#ccc" cellpadding="4" style="border-color:#ccc; border-collapse:collapse;">
                <ul class="rss-list">
<!--                    --><?php //$remove = [4,7,6,133355,141657]?>
                    <?php foreach ($allCate as $k=>$cate):?>
<!--                    --><?php //if (in_array($cate->term_id,$remove)) continue?>
                    <li class="my-2 pr-2">
                        <svg class="ic ic-rss"><use xlink:href="#rss"></use></svg>
                        <a href="<?= base_url() . 'rss/' . $cate->slug?>.rss" style="color:#0b679c; font-size:14px; font-weight:bold;">RSS <?= $cate->title?></a>
                    </li>
                    <?php endforeach;?>
                </ul>
            </table>
            <?php endif?>

            <p><b>Các giới hạn sử dụng</b></p>
            <p>Các nguồn kênh tin được cung cấp miễn phí cho các cá nhân và các tổ chức phi lợi nhuận. Chúng tôi yêu cầu bạn cung cấp rõ các thông tin cần thiết khi bạn sử dụng các nguồn kênh tin này từ <?= $this->_settings->title?></p>
            <p><?= $this->_settings->title?> hoàn toàn có quyền yêu cầu bạn ngừng cung cấp và phân tán thông tin dưới dạng này ở bất kỳ thời điểm nào và với bất kỳ lý do nào.</p>
        </div>
    </div>
</div>