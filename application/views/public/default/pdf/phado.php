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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.5/css/lightbox.min.css">
    <link rel="stylesheet" href="/public/assets/css/treant.css" />
    <link href="<?= site_url('/public/assets/css/main.css') ?>?v=<?= ASSET_VERSION ?>" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="/public/assets/css/perfect-scrollbar.css" />
    <script src="<?= site_url('/public/assets/js/vendor/jquery.min.js') ?>?v=<?= ASSET_VERSION ?>"></script>
    <style>
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #222;
            z-index: 9;
        }
    </style>
</head>

<body>
    <div id="preloader">
        <div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.7); color: white; padding: 20px; border-radius: 5px;">Đang tạo PDF...</div>
    </div>
    <div class="wrapper">
        <div class="inne
            <main class="main main--<?= $class_css; ?>">
                <script>
                    var chart_config = {
                        chart: {
                            container: "#chart-genealogy",
                            animation: {
                                nodeSpeed: 0,
                                connectorsSpeed: 0,
                            },
                            connectors: {
                                type: "step",
                                style: {
                                    "arrow-end": "block-wide-long",
                                },
                            },
                            levelSeparation: 40,
                            padding: 96,
                            hideRootNode: true,
                        },

                        nodeStructure: <?= $processedData; ?>
                    };
                </script>
                <div class="chart" id="chart">
                    <div class="legend__note">
                        Nhấn vào tên mỗi người để biết thông tin chi tiết<br />
                        Nhấn vào dấu [ + ] để xem các đời sau (nếu có)
                    </div>
                    <div class="chart__content" id="chart-genealogy"></div>
                    <div class="legend">
                        <div class="legend__title">CHÚ THÍCH</div>
                        <div class="legend__list">
                            <ul>
                                <li>
                                    <span class="label label--text label--origin"></span>Chồng
                                </li>
                                <li>
                                    <span class="label label--text label--partner"></span>Vợ
                                </li>
                                <li>
                                    <span class="label label--bg label--male"></span>Con
                                    trai
                                </li>
                                <li>
                                    <span class="label label--bg label--female"></span>Con
                                    gái
                                </li>
                            </ul>
                        </div>
                        <div class="legend__note">
                            Nhấn vào tên mỗi người để biết thông tin chi tiết<br />
                            Nhấn vào dấu [ + ] để xem các đời sau (nếu có)
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="/public/assets/js/vendor/raphael.js?v=<?= ASSET_VERSION ?>"></script>
    <script src="/public/assets/js/treant.js?v=<?= ASSET_VERSION ?>"></script>
    <script src="/public/assets/js/vendor/jquery.easing.js?v=<?= ASSET_VERSION ?>"></script>
    <script src="/public/assets/js/script.js?v=<?= ASSET_VERSION ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        if (chart_config) {
            new Treant(chart_config);
        }

        $(document).ready(function() {
            const $element = $('#chart-genealogy');
            const $svgElement = $('svg');
            const svgHeight = $svgElement.attr('height');
            const svgWidth = $svgElement.attr('width');

            $element.css({
                width: svgWidth + 'px',
                height: svgHeight + 'px',
                overflow: 'unset'
            });

            const element = document.getElementById('chart-genealogy');
            html2canvas(element, { scale: 2 }).then(canvas => {
                const imgData = canvas.toDataURL('image/jpeg');
                const { jsPDF } = window.jspdf;
            
                const a4Width = 297 * 2.83465;
                const a4Height = 210 * 2.83465;
            
                const imgWidth = canvas.width;
                const imgHeight = canvas.height;
            
                const widthRatio = a4Width / imgWidth;
                const heightRatio = a4Height / imgHeight;
                const scale = Math.min(widthRatio, heightRatio);
            
                const newWidth = imgWidth * scale;
                const newHeight = imgHeight * scale;
            
                const pdf = new jsPDF({
                    orientation: 'landscape',
                    unit: 'pt',
                    format: 'a4',
                    compress: true
                });
            
                const xOffset = (a4Width - newWidth) / 2;
                const yOffset = (a4Height - newHeight) / 2;
            
                pdf.addImage(imgData, 'JPEG', xOffset, yOffset, newWidth, newHeight);
                pdf.save('Pha_do.pdf');
                setTimeout(() => {
                    window.close();
                }, 3000);
            });
        });
    </script>
    <?php $this->load->view($this->template_path . '_script') ?>
    <script src="<?= site_url('/public/assets/js/all.js') ?>?v=<?= ASSET_VERSION ?>"></script>
</body>

</html>