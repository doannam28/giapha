<style>
        .upload-container {
            text-align: center;
        }
        .image-preview {
            width: 200px;
            height: 200px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
        }
        .image-preview img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
<div class="upload-container">

<input type="text" id="fileNameInput" placeholder="Tên file" name="thumbnail" readonly style="margin-bottom: 10px;" class="form-control">
    <label for="imageUpload" style="cursor: pointer;">
        <input type="file" id="imageUpload" style="display: none;" accept="image/*">
        <div class="image-preview" id="preview">
            <img src="" alt="" id="previewImage" style="display: none;">
        </div>
    </label>
</div>

<script>
    const input = document.getElementById('imageUpload');
const previewImg = document.getElementById('previewImage');
const preview = document.getElementById('preview');
const fileNameInput = document.getElementById('fileNameInput');
fileNameInput.addEventListener('click', () => {
    input.click();
});
fileNameInput.addEventListener('input', () => {
    const filePath = fileNameInput.value;
    if (filePath) {
        previewImg.style.display = 'block';
        previewImg.src = filePath;
    }
});
input.addEventListener('change', () => {
    const file = input.files[0];
    if (file) {

        const formData = new FormData();
        formData.append('image', file);

        fetch('<?= site_url('/admin/upload/do_upload') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fileNameInput.value = data.file_path;
            } else {
                alert('Có lỗi xảy ra khi upload ảnh.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
});

</script>