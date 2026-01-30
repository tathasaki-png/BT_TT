<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $user = Auth::user();

        // Check if user has purchased the course
        if (!$user->hasPurchased($course)) {
            return back()->with('error', 'Bạn phải mua khóa học này mới có thể đánh giá.');
        }

        // Check if user has already reviewed
        $exists = Review::where('user_id', $user->id)->where('course_id', $course->id)->exists();
        if ($exists) {
            return back()->with('error', 'Bạn đã đánh giá khóa học này rồi.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá khóa học!');
    }
}
