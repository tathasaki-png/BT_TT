<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sản Phẩm</title>
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

        .navbar {
            background: white;
            padding: 15px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            color: #333;
            font-size: 1.5em;
        }

        .navbar a {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            transition: transform 0.3s;
        }

        .navbar a:hover {
            transform: translateY(-2px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .alert {
            background: #d4edda;
            color: #155724;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 5px solid #28a745;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            transition: all 0.3s;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }

        .product-image-container {
            position: relative;
            width: 100%;
            height: 250px;
            overflow: hidden;
            background: #f5f5f5;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .image-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
        }

        .product-info {
            padding: 20px;
        }

        .product-title {
            font-size: 1.3em;
            color: #333;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .product-description {
            color: #666;
            margin-bottom: 12px;
            line-height: 1.5;
            font-size: 0.95em;
        }

        .product-price {
            font-size: 1.6em;
            color: #667eea;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .product-gallery {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            padding: 10px;
            background: #f9f9f9;
            max-height: 200px;
            overflow-y: auto;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .gallery-thumb {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .gallery-thumb:hover {
            transform: scale(1.05);
        }

        .product-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .btn {
            padding: 12px;
            text-align: center;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.3s;
            font-size: 0.95em;
        }

        .btn-view {
            background: #4CAF50;
            color: white;
        }

        .btn-view:hover {
            background: #45a049;
            transform: translateY(-2px);
        }

        .btn-edit {
            background: #2196F3;
            color: white;
        }

        .btn-edit:hover {
            background: #0b7dda;
            transform: translateY(-2px);
        }

        .btn-delete {
            grid-column: 1 / -1;
            background: #f44336;
            color: white;
        }

        .btn-delete:hover {
            background: #da190b;
            transform: translateY(-2px);
        }

        .no-products {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            color: #999;
        }

        .no-products-icon {
            font-size: 4em;
            margin-bottom: 20px;
        }

        .no-products-text {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 30px;
        }

        .pagination a, .pagination span {
            padding: 10px 15px;
            background: white;
            border-radius: 6px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .pagination span {
            background: #667eea;
            color: white;
        }

        .pagination a:hover {
            background: #667eea;
            color: white;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>📦 Quản Lý Sản Phẩm</h1>
        <a href="{{ route('products.create') }}">➕ Tạo Sản Phẩm Mới</a>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <div class="product-image-container">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->title }}" class="product-image">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #f0f0f0; color: #999;">
                                    Không có ảnh
                                </div>
                            @endif
                            @if($product->images && count($product->images) > 0)
                                <span class="image-badge">📸 {{ count($product->images) }}</span>
                            @endif
                        </div>

                        <div class="product-info">
                            <h2 class="product-title">{{ $product->title }}</h2>
                            <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                            <div class="product-price">${{ number_format($product->price, 2) }}</div>

                            @if($product->images && count($product->images) > 1)
                                <div class="product-gallery">
                                    @foreach($product->images as $img)
                                        <img src="{{ asset('storage/' . $img['thumbnail']) }}" alt="Gallery" class="gallery-thumb">
                                    @endforeach
                                </div>
                            @endif

                            <div class="product-actions">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-view">👁️ Xem</a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-edit">✏️ Sửa</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="grid-column: 1 / -1;" onsubmit="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">🗑️ Xóa</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination">
                {{ $products->links() }}
            </div>
        @else
            <div class="no-products">
                <div class="no-products-icon">📭</div>
                <div class="no-products-text">Chưa có sản phẩm nào</div>
                <a href="{{ route('products.create') }}" class="btn" style="background: #667eea; color: white; display: inline-block; padding: 12px 30px;">Tạo sản phẩm đầu tiên</a>
            </div>
        @endif
    </div>
</body>
</html>
