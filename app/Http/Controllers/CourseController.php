<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show(Course $course)
    {
        // Only show published courses to general public
        if ($course->status !== Course::STATUS_PUBLISHED) {
            $user = auth()->user();
            $allowed = $user && ($user->isAdmin() || $user->id === $course->instructor_id);
            if (! $allowed) {
                abort(404);
            }
        }

        $course->load(['lessons','instructor','category']);

        return view('course_detail', compact('course'));
    }
}
