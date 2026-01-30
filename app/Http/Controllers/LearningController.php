<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LearningController extends Controller
{
    public function show(Course $course, Lesson $lesson = null)
    {
        $user = Auth::user();

        // 1. Get all lessons for the sidebar
        $lessons = $course->lessons()->orderBy('position')->get();
        if (!$lesson) {
            $lesson = $lessons->first();
        }

        // 2. Authorization check
        $isTeacher = $user && $user->id === $course->instructor_id;
        $isAdmin = $user && $user->isAdmin();
        $isPurchased = $user && $user->hasPurchased($course);
        $isFreePreview = $lesson && $lesson->is_free;

        if (!$isPurchased && !$isAdmin && !$isTeacher && !$isFreePreview) {
            abort(403, 'Khóa học này yêu cầu thanh toán để xem nội dung.');
        }

        if ($lesson && $lesson->course_id !== $course->id) {
            abort(404);
        }

        // 3. Load progress data
        $lesson_progress = DB::table('lesson_user')
            ->where('user_id', $user->id)
            ->whereIn('lesson_id', $lessons->pluck('id')->toArray())
            ->get(['lesson_id', 'completed_at', 'current_time'])
            ->keyBy('lesson_id')
            ->toArray();

        // Extract completed dates
        $completed = array_map(fn($item) => $item->completed_at, $lesson_progress);
        // Current lesson progress time
        $currentTime = $lesson_progress[$lesson->id]->current_time ?? 0;

        // 4. Load Quiz Questions if any
        $lesson->load(['questions.options']);
        $quizResult = \App\Models\QuizResult::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->latest()
            ->first();

        return view('learn', compact('course', 'lessons', 'lesson', 'completed', 'currentTime', 'quizResult'));
    }

    public function submitQuiz(Request $request, Course $course, Lesson $lesson)
    {
        $user = Auth::user();
        $answers = $request->input('answers', []); // question_id => option_id
        
        $questions = $lesson->questions()->with('options')->get();
        $score = 0;
        $totalQuestions = $questions->count();

        if ($totalQuestions === 0) {
            return back()->with('error', 'Không có câu hỏi nào cho bài học này.');
        }

        foreach ($questions as $question) {
            $correctOption = $question->options->where('is_correct', true)->first();
            if (isset($answers[$question->id]) && $answers[$question->id] == $correctOption->id) {
                $score++;
            }
        }

        \App\Models\QuizResult::create([
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
            'score' => $score,
            'total_questions' => $totalQuestions,
        ]);

        // If score is 100%, mark lesson as completed
        if ($score === $totalQuestions) {
            $now = Carbon::now();
            DB::table('lesson_user')->updateOrInsert(
                ['user_id' => $user->id, 'lesson_id' => $lesson->id],
                ['completed_at' => $now, 'updated_at' => now(), 'created_at' => now()]
            );
        }

        return back()->with('status', "Bạn đã hoàn thành bài kiểm tra với số điểm $score/$totalQuestions.");
    }

    public function saveProgress(Request $request, Course $course, Lesson $lesson)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['message' => 'Unauthorized'], 401);

        $time = (int) $request->input('time', 0);

        DB::table('lesson_user')->updateOrInsert(
            ['user_id' => $user->id, 'lesson_id' => $lesson->id],
            ['current_time' => $time, 'updated_at' => now(), 'created_at' => now()]
        );

        return response()->json(['status' => 'success']);
    }

    public function complete(Request $request, Course $course, Lesson $lesson)
    {
        $user = Auth::user();

        $isTeacher = $user && $user->id === $course->instructor_id;
        $isAdmin = $user && $user->isAdmin();
        $isPurchased = $user && $user->hasPurchased($course);

        if (!$isPurchased && !$isAdmin && !$isTeacher) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if ($lesson->course_id !== $course->id) {
            return response()->json(['message' => 'Invalid lesson'], 400);
        }

        $now = Carbon::now();

        DB::table('lesson_user')->updateOrInsert(
            ['user_id' => $user->id, 'lesson_id' => $lesson->id],
            ['completed_at' => $now, 'updated_at' => now(), 'created_at' => now()]
        );

        return response()->json(['message' => 'completed', 'completed_at' => $now->toDateTimeString()]);
    }
}
