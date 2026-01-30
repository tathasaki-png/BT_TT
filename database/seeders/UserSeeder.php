<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('1234'),
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);

        // Instructors
        $instructorNames = ['Nguyễn Văn An', 'Trần Thị Bình'];
        for ($i = 1; $i <= 2; $i++) {
            User::create([
                'name' => $instructorNames[$i - 1],
                'email' => "instructor$i@example.com",
                'password' => Hash::make('1234'),
                'role' => User::ROLE_INSTRUCTOR,
                'status' => User::STATUS_ACTIVE,
            ]);
        }

        // Students
        $studentNames = ['Lê Minh Hiếu', 'Phạm Thế Phong', 'Hoàng Anh Tuấn', 'Vũ Thanh Hà', 'Đặng Kim Loan', 'Ngô Hải Yến', 'Bùi Quốc Anh', 'Tô Thị Minh Ngân', 'Trương Gia Huy', 'Võ Khánh Linh'];
        foreach ($studentNames as $index => $name) {
            User::create([
                'name' => $name,
                'email' => "student" . ($index + 1) . "@example.com",
                'password' => Hash::make('1234'),
                'role' => User::ROLE_STUDENT,
                'status' => User::STATUS_ACTIVE,
            ]);
        }
    }
}
