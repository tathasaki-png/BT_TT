<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Phát Triển Web'],
            ['name' => 'Phát Triển Mobile'],
            ['name' => 'Khoa Học Dữ Liệu'],
            ['name' => 'Thiết Kế UI/UX'],
            ['name' => 'DevOps'],
        ];

        foreach ($categories as $category) {
            $category['slug'] = Str::slug($category['name']);
            Category::create($category);
        }
    }
}
