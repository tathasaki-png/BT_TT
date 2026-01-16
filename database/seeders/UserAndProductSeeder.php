<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Product;

class UserAndProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo role user nếu chưa có
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Tạo test user nếu chưa có
        $testUser = User::where('email', 'user@test.com')->first();
        if (!$testUser) {
            $testUser = User::create([
                'name' => 'Test User',
                'email' => 'user@test.com',
                'password' => bcrypt('user123'),
            ]);
            $testUser->roles()->attach($userRole);
            echo "Created test user: user@test.com / user123\n";
        } else {
            echo "Test user already exists: user@test.com\n";
        }

        // Tạo một số sản phẩm test
        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'slug' => 'iphone-15-pro',
                'description' => 'Điện thoại iPhone 15 Pro 128GB màu tím với chip A17 Pro mạnh mẽ',
                'content' => 'iPhone 15 Pro với chip A17 Pro mang lại hiệu năng vượt trội. Màn hình Super Retina XDR 6.1 inch với ProMotion. Camera chính 48MP với khả năng zoom quang 3x.',
                'regular_price' => 28990000,
                'sale_price' => 27990000,
                'quantity' => 10,
                'image' => 'images/products/iphone15pro.jpg',
                'status' => 'active'
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'slug' => 'samsung-galaxy-s24',
                'description' => 'Samsung Galaxy S24 8GB/256GB với AI tích hợp và camera 50MP',
                'content' => 'Galaxy S24 với chipset Snapdragon 8 Gen 3 for Galaxy mạnh mẽ. Tích hợp AI Galaxy cho trải nghiệm thông minh hơn. Camera 50MP chụp ảnh tuyệt đẹp.',
                'regular_price' => 22990000,
                'sale_price' => 21990000,
                'quantity' => 15,
                'image' => 'images/products/samsung-s24.jpg',
                'status' => 'active'
            ],
            [
                'name' => 'MacBook Air M3',
                'slug' => 'macbook-air-m3',
                'description' => 'MacBook Air M3 13 inch 16GB/512GB - Hiệu năng vượt trội',
                'content' => 'MacBook Air với chip Apple M3 mang lại hiệu năng đột phá và thời lượng pin cả ngày. Thiết kế mỏng nhẹ với màn hình Liquid Retina 13.6 inch.',
                'regular_price' => 34990000,
                'quantity' => 8,
                'image' => 'images/products/macbook-air-m3.jpg',
                'status' => 'active'
            ],
            [
                'name' => 'AirPods Pro 2',
                'slug' => 'airpods-pro-2',
                'description' => 'Tai nghe AirPods Pro thế hệ 2 với chống ồn chủ động',
                'content' => 'AirPods Pro với chip H2 mang đến chất lượng âm thanh vượt trội. Chống ồn chủ động thích ứng và chế độ trong suốt mới.',
                'regular_price' => 6990000,
                'sale_price' => 6490000,
                'quantity' => 20,
                'image' => 'images/products/airpods-pro-2.jpg',
                'status' => 'active'
            ],
            [
                'name' => 'iPad Pro 11 inch',
                'slug' => 'ipad-pro-11-inch',
                'description' => 'iPad Pro 11 inch với chip M4 và màn hình Liquid Retina',
                'content' => 'iPad Pro 11 inch với chip M4 mạnh mẽ nhất từng có trên iPad. Màn hình Liquid Retina với công nghệ ProMotion và True Tone.',
                'regular_price' => 24990000,
                'quantity' => 12,
                'image' => 'images/products/ipad-pro-11.jpg',
                'status' => 'active'
            ]
        ];

        foreach ($products as $productData) {
            // Kiểm tra sản phẩm đã tồn tại chưa
            if (!Product::where('slug', $productData['slug'])->exists()) {
                Product::create($productData);
            }
        }

        $createdCount = Product::count();
        echo "Total products in database: " . $createdCount . "\n";
    }
}