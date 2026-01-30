<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lesson = \App\Models\Lesson::first();
        if ($lesson) {
            $q1 = \App\Models\Question::create([
                'lesson_id' => $lesson->id,
                'question_text' => 'Mục đích chính của bài học này là gì?',
            ]);
            \App\Models\Option::create(['question_id' => $q1->id, 'option_text' => 'Giới thiệu nội dung khóa học', 'is_correct' => true]);
            \App\Models\Option::create(['question_id' => $q1->id, 'option_text' => 'Hướng dẫn cài đặt phần mềm', 'is_correct' => false]);
            \App\Models\Option::create(['question_id' => $q1->id, 'option_text' => 'Giải quyết một bài toán cụ thể', 'is_correct' => false]);

            $q2 = \App\Models\Question::create([
                'lesson_id' => $lesson->id,
                'question_text' => 'Đây là khóa học về ngôn ngữ lập trình nào?',
            ]);
            \App\Models\Option::create(['question_id' => $q2->id, 'option_text' => 'Laravel PHP', 'is_correct' => true]);
            \App\Models\Option::create(['question_id' => $q2->id, 'option_text' => 'Python', 'is_correct' => false]);
            \App\Models\Option::create(['question_id' => $q2->id, 'option_text' => 'JavaScript', 'is_correct' => false]);
        }
    }
}
