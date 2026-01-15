<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
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
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 2.5em;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 20px;
            transition: transform 0.3s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .product-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .product-info {
            padding: 20px;
        }
        .product-title {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 10px;
        }
        .product-description {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.6;
        }
        .product-price {
            font-size: 1.8em;
            color: #667eea;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .product-actions {
            display: flex;
            gap: 10px;
        }
        .btn-small {
            flex: 1;
            padding: 10px;
            text-align: center;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9em;
            transition: all 0.3s;
        }
        .btn-view {
            background: #4CAF50;
            color: white;
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
        .btn-small:hover {
            opacity: 0.8;
            transform: translateY(-2px);
        }
        .no-products {
            text-align: center;
            padding: 50px;
            color: #666;
            font-size: 1.2em;
        }
        .pagination {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }
        .product-image-gallery {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            padding: 10px;
            background: #f5f5f5;
            max-height: 300px;
            overflow-y: auto;
        }
        .gallery-thumb {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .gallery-thumb:hover {
            transform: scale(1.05);
        }
        .image-count {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📦 Product Management</h1>
        
        <a href="{{ route('products.create') }}" class="btn">➕ Add New Product</a>

        @if(session('success'))
            <div class="alert">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <div style="position: relative;">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->title }}" class="product-image" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect fill=%22%23ccc%22 width=%22100%22 height=%22100%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2214%22 fill=%22%23999%22%3ENo Image%3C/text%3E%3C/svg%3E'">
                            @else
                                <div class="product-image" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999;">
                                    No Image
                                </div>
                            @endif
                            
                            @if($product->images && count($product->images) > 0)
                                <span class="image-count">📸 {{ count($product->images) }}</span>
                            @endif
                        </div>
                        
                        <div class="product-info">
                            <h2 class="product-title">{{ $product->title }}</h2>
                            <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                            <div class="product-price">${{ number_format($product->price, 2) }}</div>
                            
                            @if($product->images && count($product->images) > 1)
                                <div class="product-image-gallery">
                                    @foreach($product->images as $img)
                                        <img src="{{ asset('storage/' . $img['thumbnail']) }}" alt="Gallery" class="gallery-thumb" title="Click to view full image">
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="product-actions">
                                <a href="{{ route('products.show', $product->id) }}" class="btn-small btn-view">View</a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn-small btn-edit">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Are you sure you want to delete this product and all its images?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-small btn-delete" style="width: 100%;">Delete</button>
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
                📭 No products found. Create your first product!
            </div>
        @endif
    </div>
</body>
</html>
