<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AllLessonsQuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lessons = \App\Models\Lesson::all();

        foreach ($lessons as $lesson) {
            // Skip if lesson already has questions
            if ($lesson->questions()->exists()) {
                continue;
            }

            // Question 1
            $q1 = \App\Models\Question::create([
                'lesson_id' => $lesson->id,
                'question_text' => 'Câu hỏi ôn tập kiến thức bài học: ' . $lesson->title . ' là gì?',
            ]);

            \App\Models\Option::create([
                'question_id' => $q1->id,
                'option_text' => 'Câu trả lời đúng cho bài học này',
                'is_correct' => true,
            ]);

            \App\Models\Option::create([
                'question_id' => $q1->id,
                'option_text' => 'Phương án sai số 1',
                'is_correct' => false,
            ]);

            \App\Models\Option::create([
                'question_id' => $q1->id,
                'option_text' => 'Phương án sai số 2',
                'is_correct' => false,
            ]);

            \App\Models\Option::create([
                'question_id' => $q1->id,
                'option_text' => 'Phương án sai số 3',
                'is_correct' => false,
            ]);

            // Question 2
            $q2 = \App\Models\Question::create([
                'lesson_id' => $lesson->id,
                'question_text' => 'Bạn đánh giá thế nào về nội dung của bài học này?',
            ]);

            \App\Models\Option::create([
                'question_id' => $q2->id,
                'option_text' => 'Nội dung rất hữu ích và dễ hiểu',
                'is_correct' => true,
            ]);

            \App\Models\Option::create([
                'question_id' => $q2->id,
                'option_text' => 'Nội dung quá khó',
                'is_correct' => false,
            ]);

            \App\Models\Option::create([
                'question_id' => $q2->id,
                'option_text' => 'Tôi chưa nắm được kiến thức',
                'is_correct' => false,
            ]);
        }
    }
}
