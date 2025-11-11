<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="panel download">
    <div class="download__title">Tải tài liệu</div>
    <div class="download__filter">
        <div class="group">
            <div class="checkbox">
                <input type="checkbox" id="pha-do" class="input" value="pha-do" />
                <label for="pha-do" class="label">Phả đồ</label>
            </div>
            <div class="checkbox">
                <input type="checkbox" id="toc-uoc" class="input" value="toc-uoc" />
                <label for="toc-uoc" class="label">Tộc ước</label>
            </div>
            <div class="checkbox">
                <input type="checkbox" id="huong-hoa" class="input" value="huong-hoa" />
                <label for="huong-hoa" class="label">Hương hỏa</label>
            </div>
        </div>
    </div>
    <div class="download__btn">
        <button type="button" id="download">Xuất dữ liệu ra PDF</button>
    </div>
</div>
<style>
    .modal {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        width: 840px;
        height: 300px;
        padding: 24px 16px;
        border-radius: 8px;
        background-color: #fff;
    }
    
    @media only screen and (max-width: 900px) {
        .modal-content {
            margin: 0 16px;
        }
    }

    .close {
        color: #aaa;
        text-align: end;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    #confirm {
        border-radius: 8px;
        padding: 10px 16px;
        background-color: #ae2e13;
        color: #fff;
        margin-top: 20px;
    }

    .select2-container .select2-selection--single {
        height: 48px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 48px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 48px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #000 transparent transparent transparent;
    }

    .form-check-input {
        width: 24px;
        height: 24px;
        margin-left: -3.25rem;
        margin-top: 0;
        border-radius: 8px;
        border: 3px solid #d0d0d0;
        appearance: none;
    }

    .form-check {
        padding-left: 3.25rem;
    }

    .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
    }

    .form-check-input:checked::after {
        content: '';
        display: block;
        width: 6px;
        height: 12px;
        border: solid white;
        border-width: 0 2px 2px 0;
        position: absolute;
        top: 3px;
        left: 7px;
        transform: rotate(45deg);
    }

    .modal select {
        width: 100%;
        height: 48px;
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-container .select2-selection--single .select2-selection__clear {
        display: none;
    }
</style>
<div id="myModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.42417 5.57576C6.18985 5.34145 5.80995 5.34145 5.57564 5.57576C5.34132 5.81007 5.34132 6.18997 5.57564 6.42429L11.1514 12L5.57564 17.5758C5.34132 17.8101 5.34132 18.19 5.57564 18.4243C5.80995 18.6586 6.18985 18.6586 6.42417 18.4243L11.9999 12.8486L17.5756 18.4243C17.81 18.6586 18.1899 18.6586 18.4242 18.4243C18.6585 18.19 18.6585 17.8101 18.4242 17.5758L12.8484 12L18.4242 6.42429C18.6585 6.18997 18.6585 5.81007 18.4242 5.57576C18.1899 5.34145 17.81 5.34145 17.5756 5.57576L11.9999 11.1515L6.42417 5.57576Z" fill="#141415" />
            </svg>
        </span>
        <h2 style="text-align: center;font-family: Roboto;font-size: 20px;font-weight: 600;line-height: 28px;text-underline-position: from-font;text-decoration-skip-ink: none;">Xuất file</h2>
        <div class="form-check">
            <input class="form-check-input" name="type" type="checkbox" value="1" id="flexCheckDefault" checked>
            <label class="form-check-label" for="flexCheckDefault">Tất cả</label>
        </div>
        <div class="form-check mt-2">
            <input class="form-check-input" name="type" type="checkbox" value="2" id="flexCheckDefault2">
            <label class="form-check-label" for="flexCheckDefault2">Theo lựa chọn</label>
        </div>
        <form action="" id="form_Sec" method="get">
            <div class="row mt-2" id="select_form" style="display: none;">
                <div class="col-6">
                    <select name="doi" id="" class="doi"></select>
                </div>
                <div class="col-6">
                    <select name="thanhvien" id="" class="thanhvien"></select>
                </div>
            </div>
            <input type="hidden" name="typee" id="typee" value="1">
            <div class="row">
                <div class="col-12 text-center">
                    <button type="button" id="confirm">Xác nhận</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    const url = '<?= base_url('pdf/gia_pha'); ?>';
    const urlTU = '<?= base_url('gia-pha/toc-uoc'); ?>';
    const urlHH = '<?= base_url('pdf/huong_hoa'); ?>';

    $('.modal-content input[type="checkbox"]').on('change', function() {
        $('input[type="checkbox"]').not(this).prop('checked', false);
        if ($(this).val() == 2) {
            $("#select_form").show();
            $("#typee").val(2);
        } else {
            $("#select_form").hide();
            $("#typee").val(1);
        }
    });

    loadDoi();
    loadThanhvien();

    function loadDoi(dataSelected) {
        let selector = $('select.doi');
        selector.select2({
            placeholder: 'Chọn đời',
            allowClear: !0,
            multiple: !1,
            data: dataSelected,
            ajax: {
                url: "/family/ajax_load/doi",
                data: {
                    'csrf_test_name': '<?= $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                method: 'POST',
                delay: 250,
                data: function(e) {
                    return {
                        q: e.term,
                        page: e.page
                    }
                },
                processResults: function(e, t) {
                    return t.page = t.page || 1, {
                        results: e,
                        pagination: {
                            more: 30 * t.page < e.total_count
                        }
                    }
                },
                cache: !0
            }
        });
        if (typeof dataSelected !== 'undefined') selector.find('> option').prop("selected", "selected").trigger("change");
    }

    function loadThanhvien(dataSelected) {
        let selector = $('select.thanhvien');
        selector.select2({
            placeholder: 'Chọn thành viên',
            allowClear: !0,
            multiple: !1,
            data: dataSelected,
            ajax: {
                url: "/family/ajax_load/thanhvien",
                data: {
                    'csrf_test_name': '<?= $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                method: 'POST',
                delay: 250,
                data: function(e) {
                    return {
                        q: e.term,
                        page: e.page
                    }
                },
                processResults: function(e, t) {
                    return t.page = t.page || 1, {
                        results: e,
                        pagination: {
                            more: 30 * t.page < e.total_count
                        }
                    }
                },
                cache: !0
            }
        });
        if (typeof dataSelected !== 'undefined') selector.find('> option').prop("selected", "selected").trigger("change");
    }
    $("#confirm").on('click', function () {
        const urlPdf = url + "?" + $("#form_Sec").serialize() + '&all=1';
        window.open(urlPdf, '_blank');
    });
    document.getElementById('download').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.input');
        let isChecked = false;
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                isChecked = true;
            }
        });

        if (!isChecked) {
            alert('Vui lòng chọn ít nhất một tài liệu để tải.');
            return;
        }

        console.log('Xuất dữ liệu ra PDF...');

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                if (checkbox.value == 'pha-do') {
                    let c3d = document.getElementById('chart--mini');
                    if (c3d) {
                        const element = document.getElementById('chart--mini');
                        html2canvas(element).then(canvas => {
                            const imgData = canvas.toDataURL('image/png');
                            const {
                                jsPDF
                            } = window.jspdf;

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
                            });

                            const xOffset = (a4Width - newWidth) / 2;
                            const yOffset = (a4Height - newHeight) / 2;

                            pdf.addImage(imgData, 'PNG', xOffset, yOffset, newWidth, newHeight);
                            pdf.save('Pha_do.pdf');
                        });
                    } else {
                        var modal = $('#myModal');
                        modal.show();
                    }
                }

                if (checkbox.value == 'toc-uoc') {
                    fetchAndGeneratePDF(urlTU, '.post', 'Toc_uoc.pdf');
                }

                if (checkbox.value == 'huong-hoa') {
                    fetchAndGeneratePDFs(['<?= base_url('pdf/huong_hoa?page=1&limit=40'); ?>', '<?= base_url('pdf/huong_hoa?page=2&limit=40'); ?>'], '.genealogy', 'Huong_hoa.pdf');
                }
            }
        });
    });

    function fetchAndGeneratePDF(url, className, pdfName) {
        const loadingIndicator = document.createElement('div');
        loadingIndicator.innerText = 'Đang tạo PDF...';
        loadingIndicator.style.position = 'fixed';
        loadingIndicator.style.top = '50%';
        loadingIndicator.style.left = '50%';
        loadingIndicator.style.transform = 'translate(-50%, -50%)';
        loadingIndicator.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
        loadingIndicator.style.color = 'white';
        loadingIndicator.style.padding = '20px';
        loadingIndicator.style.borderRadius = '5px';
        document.body.appendChild(loadingIndicator);

        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const content = doc.querySelector(className);

                if (!content) {
                    console.error(`No element with class "${className}" found!`);
                    document.body.removeChild(loadingIndicator);
                    return;
                }

                content.style.fontSize = '30px';
                content.style.lineHeight = '40px';

                const tableCells = content.querySelectorAll('.table tbody td');
                tableCells.forEach(cell => {
                    cell.style.fontSize = '30px';
                    cell.style.fontFamily = 'Arial, sans-serif';
                    cell.style.padding = '5px';
                    cell.style.border = '1px solid #000';
                });

                const tempDiv = document.createElement('div');
                tempDiv.appendChild(content.cloneNode(true));
                document.body.appendChild(tempDiv);

                html2canvas(tempDiv).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const {
                        jsPDF
                    } = window.jspdf;

                    const pdf = new jsPDF({
                        orientation: 'portrait',
                        unit: 'mm',
                        format: 'a4',
                    });

                    const a4Width = pdf.internal.pageSize.getWidth();
                    const a4Height = pdf.internal.pageSize.getHeight();
                    const imgWidth = a4Width - 20;
                    const imgHeight = (canvas.height * imgWidth) / canvas.width;

                    let heightLeft = imgHeight;
                    let position = 10;

                    pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                    heightLeft -= pdf.internal.pageSize.height;

                    while (heightLeft >= 0) {
                        position = heightLeft - imgHeight;
                        pdf.addPage();
                        pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                        heightLeft -= pdf.internal.pageSize.height;
                    }

                    pdf.save(pdfName);
                    document.body.removeChild(tempDiv);
                    document.body.removeChild(loadingIndicator);
                });
            })
            .catch(err => {
                console.error('Error fetching page:', err);
                document.body.removeChild(loadingIndicator);
            });
    }

    async function fetchAndGeneratePDFs(urls, className, pdfName) {
        const loadingIndicator = document.createElement('div');
        loadingIndicator.innerText = 'Đang tạo PDF...';
        loadingIndicator.style.position = 'fixed';
        loadingIndicator.style.top = '50%';
        loadingIndicator.style.left = '50%';
        loadingIndicator.style.transform = 'translate(-50%, -50%)';
        loadingIndicator.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
        loadingIndicator.style.color = 'white';
        loadingIndicator.style.padding = '20px';
        loadingIndicator.style.borderRadius = '5px';
        document.body.appendChild(loadingIndicator);

        const {
            jsPDF
        } = window.jspdf;
        const pdf = new jsPDF({
            orientation: 'portrait',
            unit: 'mm',
            format: 'a4',
        });

        for (const url of urls) {
            try {
                const response = await fetch(url);
                if (!response.ok) throw new Error('Network response was not ok');
                const html = await response.text();

                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const content = doc.querySelector(className);

                if (!content) {
                    console.error(`No element with class "${className}" found in ${url}!`);
                    continue;
                }
                content.style.fontSize = '30px';
                content.style.lineHeight = '40px';
                const tableCells = content.querySelectorAll('.table tbody td');
                tableCells.forEach(cell => {
                    cell.style.fontSize = '30px';
                    cell.style.lineHeight = '40px';
                    cell.style.fontFamily = 'Arial, sans-serif';
                    cell.style.padding = '5px';
                    cell.style.border = '1px solid #000';
                });

                const tempDiv = document.createElement('div');
                tempDiv.appendChild(content.cloneNode(true));
                document.body.appendChild(tempDiv);
                const canvas = await html2canvas(tempDiv);
                const imgData = canvas.toDataURL('image/png');
                const a4Width = pdf.internal.pageSize.getWidth();
                const a4Height = pdf.internal.pageSize.getHeight();
                const imgWidth = a4Width - 20;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                let heightLeft = imgHeight;
                let position = 10;
                pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                pdf.addPage();
                document.body.removeChild(tempDiv);
            } catch (err) {
                console.error('Error fetching page:', err);
            }
        }

        pdf.save(pdfName);
        document.body.removeChild(loadingIndicator);
    }
</script>