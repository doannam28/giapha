<?php $data = getSetting('data_graveyard'); ?>

<style>
    .cemetery__view1 {
        position: relative;
        aspect-ratio: 16 / 9;
        width: 100%;
        border: none;
        background: white;
    }

    .cemetery__view1 iframe {
        position: absolute;
        left: 0;
        width: 100%;
        bottom: 0;
        height: 100%;
        border: none;
    }

    .cemetery__view1 a {
        position: absolute;
        top: 50%;
        transform: translate(-50%, -50%);
        left: 50%;
        z-index: 2;
        color: #fff;
    }
</style>
<div class="title">
    <h2>KHU MỘ HỌ HOÀNG</h2>
   <!-- <p>Bắc Giang</p>-->
</div>
<div class="content">
    <div class="cemetery">
        <div class="cemetery__view1">
            <a href="<?= $data->url_map ?>" target="_blank" type="button" class="button button--primary">
                Tham quan VR360
            </a>
            <iframe width="100%" height="500" src="<?= $data->url_map ?>" allow="vr" frameborder="0" allowfullscreen="" <!--style="background-image: url('/public/Screenshot\ 2025-01-10\ 013140.png');width: 100%;background-size: cover;"-->></iframe>
        </div>
        <div class="panel">
            <h3 class="cemetery__subtitle">Giới thiệu</h3>
            <?= $data->intro ?>
        </div>
        <div class="panel">
            <h3 class="cemetery__subtitle">Vị trí</h3>
            <?= $data->location ?>
        </div>
        <div class="panel">
            <h3 class="cemetery__subtitle">Thông tin chi tiết</h3>
            <?= $data->detail ?>
        </div>
    </div>
</div>
<script defer>
   /* $( document ).ready(function() {
        $('.cemetery__view1 a').click(function() {
            $(this).hide();
        });
    });*/
    document.addEventListener('DOMContentLoaded', function() {
        $('.cemetery__view1 button').click(function() {
            $(this).css('display', 'none');
            $(this).siblings('iframe').attr('src', $(this).data('url'));
        });
    });
</script>