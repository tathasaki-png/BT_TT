<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Post;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Posts
        Post::query()->delete(); // Xóa tất cả posts hiện tại

        Post::create([
            'name' => 'Chào mừng đến với cửa hàng của chúng tôi',
            'slug' => 'chao-mung-den-voi-cua-hang',
            'description' => 'Đây là bài viết đầu tiên trên hệ thống.',
            'content' => 'Nội dung chi tiết bài viết chào mừng...',
            'status' => 'active',
            'published_at' => now(),
        ]);

        Post::create([
            'name' => 'Xu hướng thời trang 2026',
            'slug' => 'xu-huong-thoi-trang-2026',
            'description' => 'Cập nhật những mẫu mới nhất.',
            'content' => 'Chi tiết các mẫu thời trang mới nhất...',
            'status' => 'active',
            'published_at' => now(),
        ]);

        // Products
        Product::query()->delete(); // Xóa tất cả sản phẩm hiện tại

        Product::create([
            'name' => 'Mô hình Kamen Rider Kuuga',
            'slug' => 'mo-hinh-kamen-rider-kuuga',
            'regular_price' => 300000,
            'sale_price' => 250000,
            'quantity' => 10,
            'description' => 'Mô hình đồ chơi Kamen Rider Kuuga phiên bản cao cấp',
            'content' => 'Chi tiết mô hình Kamen Rider Kuuga với nhiều khớp cử động và phụ kiện.',
            'status' => 'active',
        ]);

        Product::create([
            'name' => 'Mô hình Kamen Rider Agito',
            'slug' => 'mo-hinh-kamen-rider-agito',
            'regular_price' => 350000,
            'sale_price' => 300000,
            'quantity' => 15,
            'description' => 'Mô hình đồ chơi Kamen Rider Agito với thiết kế mạnh mẽ',
            'content' => 'Mô tả chi tiết về mô hình Kamen Rider Agito, phù hợp cho người sưu tập.',
            'status' => 'active',
        ]);

        Product::create([
            'name' => 'Mô hình Kamen Rider Ryuki',
            'slug' => 'mo-hinh-kamen-rider-ryuki',
            'regular_price' => 400000,
            'sale_price' => 350000,
            'quantity' => 8,
            'description' => 'Mô hình đồ chơi Kamen Rider Ryuki với card deck',
            'content' => 'Bao gồm mô hình và bộ card để chơi game.',
            'status' => 'active',
        ]);

        Product::create([
            'name' => 'Mô hình Kamen Rider Faiz',
            'slug' => 'mo-hinh-kamen-rider-faiz',
            'regular_price' => 450000,
            'sale_price' => 400000,
            'quantity' => 12,
            'description' => 'Mô hình đồ chơi Kamen Rider Faiz với phone accessory',
            'content' => 'Mô hình cao cấp với phụ kiện phone để biến hình.',
            'status' => 'active',
        ]);

        Product::create([
            'name' => 'Mô hình Kamen Rider Blade',
            'slug' => 'mo-hinh-kamen-rider-blade',
            'regular_price' => 500000,
            'sale_price' => 450000,
            'quantity' => 5,
            'description' => 'Mô hình đồ chơi Kamen Rider Blade với sword',
            'content' => 'Mô hình với kiếm và khả năng biến hình.',
            'status' => 'active',
        ]);
    }
}
