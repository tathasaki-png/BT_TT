<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;

class AdminQuestionController extends Controller
{
    public function index(Lesson $lesson)
    {
        $lesson->load('questions.options');
        return view('admin.questions.index', compact('lesson'));
    }

    public function store(Request $request, Lesson $lesson)
    {
        $request->validate([
            'question_text' => 'required',
            'options' => 'required|array|min:2',
            'correct_option' => 'required',
        ]);

        $question = Question::create([
            'lesson_id' => $lesson->id,
            'question_text' => $request->question_text,
        ]);

        foreach ($request->options as $index => $text) {
            Option::create([
                'question_id' => $question->id,
                'option_text' => $text,
                'is_correct' => $request->correct_option == $index,
            ]);
        }

        return back()->with('success', 'Câu hỏi đã được thêm thành công.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return back()->with('success', 'Câu hỏi đã được xóa.');
    }
}
