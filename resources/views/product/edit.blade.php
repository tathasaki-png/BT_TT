<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 2.5em;
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
        .current-image {
            margin-bottom: 20px;
            text-align: center;
        }
        .current-image img {
            max-width: 300px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .form-group {
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 1.1em;
        }
        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        .file-input-wrapper input[type=file] {
            position: absolute;
            left: -9999px;
        }
        .file-input-label {
            display: block;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .file-input-label:hover {
            transform: translateY(-2px);
        }
        .file-names {
            margin-top: 10px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 6px;
            color: #666;
        }
        .error {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 5px;
        }
        .error-list {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .error-list ul {
            list-style-position: inside;
            color: #721c24;
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
        .image-preview {
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .preview-item {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('products.index') }}" class="back-btn">← Back to Products</a>
        
        <h1>✏️ Edit Product</h1>

        @if($product->thumbnail)
            <div class="current-image">
                <p style="color: #666; margin-bottom: 10px;"><strong>Current Image:</strong></p>
                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->title }}">
            </div>
        @endif

        @if($errors->any())
            <div class="error-list">
                <strong>Please fix the following errors:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="title">Product Title *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $product->title) }}" required>
                @error('title')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Price ($) *</label>
                <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" required>
                @error('price')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Update Images (Optional - leave empty to keep current image)</label>
                <div class="file-input-wrapper">
                    <input type="file" id="images" name="images[]" accept="image/*" multiple onchange="previewImages(event)">
                    <label for="images" class="file-input-label">
                        📁 Choose New Images (Click to browse)
                    </label>
                </div>
                <div id="fileNames" class="file-names" style="display: none;"></div>
                <div id="imagePreview" class="image-preview"></div>
                @error('images.*')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="submit-btn">Update Product</button>
        </form>
    </div>

    <script>
        function previewImages(event) {
            const files = event.target.files;
            const fileNamesDiv = document.getElementById('fileNames');
            const imagePreview = document.getElementById('imagePreview');
            
            if (files.length > 0) {
                fileNamesDiv.style.display = 'block';
                fileNamesDiv.innerHTML = `<strong>Selected files:</strong> ${files.length} image(s)`;
                
                // Clear previous previews
                imagePreview.innerHTML = '';
                
                // Show preview for each image
                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'preview-item';
                            imagePreview.appendChild(img);
                        }
                        reader.readAsDataURL(file);
                    }
                });
            } else {
                fileNamesDiv.style.display = 'none';
                imagePreview.innerHTML = '';
            }
        }
    </script>
</body>
</html>
