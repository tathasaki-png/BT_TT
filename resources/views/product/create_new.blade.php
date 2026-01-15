<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Sản Phẩm Mới</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 1.1em;
        }

        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 20px;
            transition: background 0.3s;
        }

        .back-btn:hover {
            background: #5a6268;
        }

        .error-box {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            color: #721c24;
        }

        .error-box ul {
            list-style-position: inside;
            margin-top: 10px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 1.05em;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1em;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        input[type="file"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .file-input-wrapper {
            position: relative;
        }

        .file-input-wrapper input[type="file"] {
            display: none;
        }

        .file-input-label {
            display: block;
            padding: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s;
            font-weight: 600;
            font-size: 1.1em;
        }

        .file-input-label:hover {
            transform: translateY(-2px);
        }

        .file-info {
            margin-top: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 6px;
            color: #666;
            font-weight: 600;
        }

        .image-preview {
            margin-top: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
        }

        .preview-item {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #e0e0e0;
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .error-text {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.2em;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
        }

        .submit-btn:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('products.index') }}" class="back-btn">← Quay Lại</a>

        <div class="header">
            <h1>➕ Tạo Sản Phẩm Mới</h1>
            <p>Thêm sản phẩm mới vào cửa hàng</p>
        </div>

        @if($errors->any())
            <div class="error-box">
                <strong>⚠️ Vui lòng sửa các lỗi sau:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">📝 Tên Sản Phẩm *</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Nhập tên sản phẩm" required>
                @error('title')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">📄 Mô Tả</label>
                <textarea id="description" name="description" placeholder="Nhập mô tả chi tiết về sản phẩm">{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">💰 Giá ($) *</label>
                <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price') }}" placeholder="0.00" required>
                @error('price')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>🖼️ Ảnh Sản Phẩm * (Có thể chọn nhiều ảnh)</label>
                <div class="file-input-wrapper">
                    <input type="file" id="images" name="images[]" accept="image/*" multiple required onchange="previewImages(event)">
                    <label for="images" class="file-input-label">
                        📁 Chọn Ảnh (Kéo thả hoặc nhấp chuột)
                    </label>
                </div>
                <div id="fileInfo" class="file-info" style="display: none;"></div>
                <div id="imagePreview" class="image-preview"></div>
                @error('images.*')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="submit-btn">✅ Tạo Sản Phẩm</button>
        </form>
    </div>

    <script>
        function previewImages(event) {
            const files = event.target.files;
            const fileInfo = document.getElementById('fileInfo');
            const imagePreview = document.getElementById('imagePreview');

            if (files.length > 0) {
                fileInfo.style.display = 'block';
                fileInfo.innerHTML = `📊 Đã chọn: <strong>${files.length}</strong> ảnh`;

                imagePreview.innerHTML = '';

                Array.from(files).forEach((file, index) => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const container = document.createElement('div');
                            container.className = 'preview-item';

                            const img = document.createElement('img');
                            img.src = e.target.result;

                            container.appendChild(img);
                            imagePreview.appendChild(container);
                        }
                        reader.readAsDataURL(file);
                    }
                });
            } else {
                fileInfo.style.display = 'none';
                imagePreview.innerHTML = '';
            }
        }

        // Drag and drop support
        const fileInput = document.getElementById('images');
        const label = document.querySelector('.file-input-label');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            label.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            label.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            label.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            label.style.background = 'linear-gradient(135deg, #7c8eee 0%, #8b5ba8 100%)';
        }

        function unhighlight(e) {
            label.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
        }

        label.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;

            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        }
    </script>
</body>
</html>
