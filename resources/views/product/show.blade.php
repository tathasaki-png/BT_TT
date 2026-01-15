<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->title }}</title>
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
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 30px;
            transition: background 0.3s;
        }
        .back-btn:hover {
            background: #5a6268;
        }
        .product-detail {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }
        .image-section img {
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .thumbnail-section {
            margin-top: 20px;
        }
        .thumbnail-section h3 {
            margin-bottom: 10px;
            color: #666;
        }
        .thumbnail-section img {
            width: 300px;
            height: 300px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }
        .info-section h1 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 20px;
        }
        .price {
            font-size: 2.5em;
            color: #667eea;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .description {
            color: #666;
            line-height: 1.8;
            margin-bottom: 30px;
            font-size: 1.1em;
        }
        .actions {
            display: flex;
            gap: 15px;
        }
        .btn {
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .btn-edit {
            background: #2196F3;
            color: white;
        }
        .btn-delete {
            background: #f44336;
            color: white;
            border: none;
            cursor: pointer;
        }
        @media (max-width: 768px) {
            .product-detail {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('products.index') }}" class="back-btn">← Back to Products</a>
        
        <div class="product-detail">
            <div class="image-section">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}">
                    
                    @if($product->thumbnail)
                        <div class="thumbnail-section">
                            <h3>Thumbnail (300x300):</h3>
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="Thumbnail">
                        </div>
                    @endif
                @else
                    <div style="width: 100%; height: 400px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 12px;">
                        <span style="color: #999; font-size: 1.5em;">No Image</span>
                    </div>
                @endif
            </div>
            
            <div class="info-section">
                <h1>{{ $product->title }}</h1>
                <div class="price">${{ number_format($product->price, 2) }}</div>
                <div class="description">
                    {{ $product->description ?? 'No description available.' }}
                </div>
                
                <div class="actions">
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-edit">Edit Product</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete">Delete Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
