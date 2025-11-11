<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="57x57" href="/public/assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/public/assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/public/assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/public/assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/public/assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/public/assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/public/assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/public/assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/public/assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/public/assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/public/assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/public/assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <meta name="description" content="Trang web gia phả Họ Hoàng – Nơi lưu giữ thông tin về lịch sử, nguồn gốc, và thành tựu dòng Họ Hoàng. Cùng khám phá và kết nối thế hệ hôm nay và mai sau." />
    <meta name="keywords" content="Gia phả Họ Hoàng, lịch sử Họ Hoàng, dòng Họ Hoàng, kết nối Họ Hoàng, phả hệ, lưu truyền gia phả" />
    <meta name="author" content="Ban Quản Trị Gia Phả Họ Hoàng" />
    <meta property="og:title" content="Gia Phả Họ Hoàng | Lưu Truyền Lịch Sử và Phát Triển Dòng Tộc" />
    <meta property="og:description" content="Trang web gia phả Họ Hoàng – Nơi lưu giữ thông tin về lịch sử, nguồn gốc, và thành tựu dòng Họ Hoàng. Cùng khám phá và kết nối thế hệ hôm nay và mai sau." />
    <meta property="og:image" content="[URL_Ảnh_Đại_Diện]" />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Gia Phả Họ Hoàng | Lưu Truyền Lịch Sử và Phát Triển Dòng Tộc" />
    <meta name="twitter:description" content="Trang web gia phả Họ Hoàng – Nơi lưu giữ thông tin về lịch sử, nguồn gốc, và thành tựu dòng Họ Hoàng. Cùng khám phá và kết nối thế hệ hôm nay và mai sau." />
    <meta name="robots" content="index, follow" />
    <title><?= $title ?? '' ?> - Họ Hoàng Việt Nam</title>
    <link href="<?= site_url('/public/assets/css/bootstrap.min.css') ?>" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="https://rawcdn.githack.com/nextapps-de/spotlight/0.7.8/src/css/spotlight.css">
    <link rel="stylesheet" href="/public/assets/css/treant.css" />
    <link href="<?= site_url('/public/assets/css/main.css') ?>?v=<?= ASSET_VERSION ?>" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="/public/assets/css/perfect-scrollbar.css" />
    <script src="<?= site_url('/public/assets/js/vendor/jquery.min.js') ?>?v=<?= ASSET_VERSION ?>"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        #spotlight {width: 100%; height: 100%;max-width: 874px;max-height: 582px;top: 50%; left: 50%; transform: translate(-50%, -50%);border-radius: 12px;background-color: #FFF;}
        .spl-track {height: 100%;max-height:448px;margin-top: 50px;}
        .spl-prev, .spl-next{top:unset;bottom:25px;background-color: #F6DCAC;transform: translateX(0);border-radius:8px;width: 40px; height: 40px;background-size: inherit;}
        .spl-prev {left:calc(50% - 45px);background-image: url(/public/assets/images/arrow-left-svg.svg);opacity: 1;}
        .spl-next {right:calc(50% - 45px);background-image: url(/public/assets/images/arrow-right-svg.svg);opacity: 1;}
        #spotlight.menu .spl-next {transform: unset;}
        .spl-header {transform: translateY(0);background-color: #fff;color: #000;}
        .spl-close { background-image: url(/public/assets/images/close.png); }
        .spl-header div {opacity: 1 !important;}
        .hide-scrollbars::after {content: ' '; position: fixed; width: 100%; height: 100%; top: 0; left: 0; background: rgba(0, 0, 0, .5); z-index: 999;}
        @media only screen and (max-width: 920px) {#spotlight {width: calc(100% - 32px);}}
        .clamped-text {display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 3;overflow: hidden;text-overflow: ellipsis;}
        .news__list {align-items: stretch;}
        .news__list .card {display: grid ; height: 100%;min-height:270px;}
        .chart {height:800px;}
        .phado-controls {position: absolute; bottom: 0; right: 0; width: 45px; z-index: 1;display: none;}
        .phado-controls #reset {width: 25px; height: 28px; border-radius: 4px; background: #f6dcac; padding: 5px;color: #000;}
        .job table {min-width: 100% !important}
        .Viewed {overflow: auto;height:100%;width:100%;}
        @media only screen and (max-width: 600px) {.job table {min-width: 1000px !important}.Treant {scale: .5; overflow: unset !important;}}
        @media only screen and (max-width: 990px) {.chart {height:600px;}.legend{position: absolute;bottom: 1%;height:128px;top:unset;margin: 0;right: 1%;width: 98%;}.phado-controls {bottom: unset;top: 15px;display: block;}}
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="inner">
            <!-- Add class 'open' -->
            <?php $this->load->view($this->template_path . '_header') ?>


            <main class="main main--<?= $class_css; ?>">
                <div class="container">

                    <?= !empty($main_content) ? $main_content : '' ?>
                </div>
            </main>

            <?php $this->load->view($this->template_path . '_footer') ?>

        </div>
    </div>
    
    <script src="/public/assets/js/vendor/raphael.js?v=<?= ASSET_VERSION ?>"></script>
    <script src="/public/assets/js/treant.js?v=<?= ASSET_VERSION ?>"></script>
    <script src="/public/assets/js/vendor/jquery.easing.js?v=<?= ASSET_VERSION ?>"></script>
    <script src="https://www.unpkg.com/@panzoom/panzoom@4.6.0/dist/panzoom.js"></script>
    <script src="/public/assets/js/script.js?v=<?= ASSET_VERSION ?>"></script>
    <script src="https://rawcdn.githack.com/nextapps-de/spotlight/0.7.8/dist/spotlight.bundle.js"></script>
    <script>
        new Treant(chart_config);
    
        const chart = document.getElementById('chart');
        const chartWidth = chart.clientWidth;
        const elem = document.getElementById('chart-genealogy');
        const $svgElement = $('svg');
        let scale = 1;
    
        function initializePanzoom() {
            if (chartWidth > 600) {
                let minZoom = 0.1;
                if (chartWidth < 600) minZoom = 0.5;
                var scaleValue = getCookie("scale");
                return Panzoom(elem, {
                    maxScale: 1,
                    minScale: minZoom,
                    startScale: scaleValue,
                });
            }
        }
        
        elem.addEventListener('panzoomzoom', (event) => {
            scale = event.detail.scale;
            setCookie("scale", scale, 7);
        });
        
        const panzoom = initializePanzoom();
    
        const parent = elem.parentElement;
        parent.addEventListener('wheel', panzoom.zoomWithWheel);
    
        document.getElementById('zoom-in').addEventListener('click', panzoom.zoomIn);
        document.getElementById('zoom-out').addEventListener('click', panzoom.zoomOut);
        document.getElementById('reset').addEventListener('click', function() {
            panzoom = initializePanzoom(scale);
        });
    
        Spotlight.show();
        
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }
    </script>
    <?php $this->load->view($this->template_path . '_script') ?>
    <script src="<?= site_url('/public/assets/js/all.js') ?>?v=<?= ASSET_VERSION ?>"></script>
</body>

</html>