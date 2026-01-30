<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::all();
        $lessonTitles = [
            'Giới Thiệu',
            'Cài Đặt & Thiết Lập',
            'Khái Niệm Cốt Lõi',
            'Kỹ Thuật Nâng Cao',
            'Thực Tiễn Tốt Nhất',
            'Ví Dụ Thực Tế',
            'Gỡ Lỗi & Kiểm Tra',
            'Tối Ưu Hóa Hiệu Suất',
        ];

        $position = 1;
        foreach ($courses as $course) {
            for ($i = 0; $i < 5; $i++) {
                Lesson::create([
                    'course_id' => $course->id,
                    'title' => $lessonTitles[$i % count($lessonTitles)],
                    'video_path' => 'videos/sample-video.mp4', // Placeholder path
                    'position' => $i + 1,
                ]);
            }
        }
    }
}
