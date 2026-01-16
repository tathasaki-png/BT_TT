<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'name' => 'Xu hướng công nghệ 2026',
                'slug' => 'xu-huong-cong-nghe-2026',
                'description' => 'Khám phá những xu hướng công nghệ mới nhất và tác động của chúng đến cuộc sống.',
                'content' => 'Năm 2026 đánh dấu một bước ngoặt quan trọng trong lĩnh vực công nghệ với sự phát triển mạnh mẽ của AI, IoT và blockchain. Những công nghệ này đang thay đổi cách chúng ta làm việc, giao tiếp và sinh hoạt hàng ngày.',
                'image' => 'images/posts/tech-trend.jpg',
                'status' => 'active',
                'published_at' => now(),
            ],
            [
                'name' => 'Mẹo chọn smartphone phù hợp',
                'slug' => 'meo-chon-smartphone-phu-hop',
                'description' => 'Hướng dẫn chi tiết cách chọn mua smartphone phù hợp với nhu cầu và ngân sách.',
                'content' => 'Việc chọn một chiếc smartphone phù hợp không chỉ dựa vào giá cả mà còn cần xem xét nhiều yếu tố như hiệu năng, camera, pin và hệ điều hành. Bài viết này sẽ giúp bạn đưa ra quyết định tốt nhất.',
                'image' => 'images/posts/smartphone-guide.jpg',
                'status' => 'active',
                'published_at' => now(),
            ],
            [
                'name' => 'Laptop cho sinh viên - Top 5 lựa chọn tốt nhất',
                'slug' => 'laptop-cho-sinh-vien-top-5-lua-chon-tot-nhat',
                'description' => 'Danh sách những mẫu laptop tốt nhất dành cho sinh viên với giá cả phải chăng.',
                'content' => 'Sinh viên cần một chiếc laptop vừa đáp ứng nhu cầu học tập, vừa có giá cả hợp lý. Bài viết này sẽ giới thiệu top 5 mẫu laptop tốt nhất cho sinh viên từ các thương hiệu uy tín như Apple, Dell, HP và Asus.',
                'image' => 'images/posts/student-laptop.jpg',
                'status' => 'active',
                'published_at' => now(),
            ],
        ];

        foreach ($posts as $postData) {
            Post::create($postData);
        }

        echo "Created " . count($posts) . " test posts\n";
    }
}