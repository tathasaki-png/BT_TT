<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $instructors = User::where('role', User::ROLE_INSTRUCTOR)->get();
        $categories = \App\Models\Category::all();

        // Prices are in VND (whole numbers, no decimals)
        $courses = [
            ['title' => 'Nền Tảng Laravel', 'price' => 299000, 'sale_price' => 199000],
            ['title' => 'PHP Nâng Cao', 'price' => 399000, 'sale_price' => 299000],
            ['title' => 'Thành Thạo React.js', 'price' => 349000, 'sale_price' => 249000],
            ['title' => 'Cơ Bản Vue.js', 'price' => 299000, 'sale_price' => 199000],
            ['title' => 'Python cho Khoa Học Dữ Liệu', 'price' => 449000, 'sale_price' => 349000],
            ['title' => 'Học Máy 101', 'price' => 499000, 'sale_price' => 399000],
            ['title' => 'Nguyên Tắc Thiết Kế UI', 'price' => 249000, 'sale_price' => 149000],
            ['title' => 'Docker & Kubernetes', 'price' => 399000, 'sale_price' => 299000],
            ['title' => 'Giải Pháp Cloud AWS', 'price' => 549000, 'sale_price' => 449000],
            ['title' => 'Hướng Dẫn JavaScript Hoàn Chỉnh', 'price' => 349000, 'sale_price' => 249000],
        ];

        foreach ($courses as $index => $courseData) {
            Course::create([
                'title' => $courseData['title'],
                'slug' => Str::slug($courseData['title']),
                'price' => $courseData['price'],
                'sale_price' => $courseData['sale_price'],
                'short_description' => 'Học ' . $courseData['title'] . ' từ đầu với các ví dụ thực tế.',
                'content' => 'Khóa học toàn diện này bao gồm tất cả các khía cạnh của ' . $courseData['title'] . '. Bạn sẽ học từ các khái niệm cơ bản đến các kỹ thuật nâng cao.',
                'status' => Course::STATUS_PUBLISHED,
                'instructor_id' => $instructors[$index % $instructors->count()]->id,
                'category_id' => $categories[$index % $categories->count()]->id,
            ]);
        }
    }
}
