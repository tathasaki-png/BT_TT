<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InstructorLessonController extends Controller
{
    protected function checkOwnership(Course $course)
    {
        if (auth()->user()->role !== 'admin' && $course->instructor_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền quản lý khóa học này.');
        }
    }

    public function index(Course $course): View
    {
        $this->checkOwnership($course);
        $lessons = $course->lessons()->orderBy('position')->get();
        return view('instructor.lessons.index', compact('course','lessons'));
    }

    public function create(Course $course): View
    {
        $this->checkOwnership($course);
        return view('instructor.lessons.create', compact('course'));
    }

    public function store(StoreLessonRequest $request, Course $course): RedirectResponse
    {
        $this->checkOwnership($course);
        $data = $request->validated();

        if ($request->hasFile('video')) {
            $data['video_path'] = $request->file('video')->store('videos', 'public');
        }

        $max = $course->lessons()->max('position') ?? 0;
        $data['position'] = $max + 1;
        $data['course_id'] = $course->id;

        Lesson::create($data);

        return redirect()->route('instructor.courses.lessons.index', $course)->with('status', 'Lesson created.');
    }

    public function edit(Course $course, Lesson $lesson): View
    {
        $this->checkOwnership($course);
        return view('instructor.lessons.edit', compact('course','lesson'));
    }

    public function update(UpdateLessonRequest $request, Course $course, Lesson $lesson): RedirectResponse
    {
        $this->checkOwnership($course);
        $data = $request->validated();

        if ($request->hasFile('video')) {
            if ($lesson->video_path) {
                Storage::disk('public')->delete($lesson->video_path);
            }
            $data['video_path'] = $request->file('video')->store('videos', 'public');
        }

        $lesson->update($data);

        return redirect()->route('instructor.courses.lessons.index', $course)->with('status', 'Lesson updated.');
    }

    public function destroy(Course $course, Lesson $lesson): RedirectResponse
    {
        $this->checkOwnership($course);
        // shift positions
        $pos = $lesson->position;
        if ($lesson->video_path) {
            Storage::disk('public')->delete($lesson->video_path);
        }
        $lesson->delete();
        Lesson::where('course_id', $course->id)->where('position', '>', $pos)->decrement('position');

        return redirect()->route('instructor.courses.lessons.index', $course)->with('status', 'Lesson deleted.');
    }

    public function moveUp(Course $course, Lesson $lesson): RedirectResponse
    {
        $this->checkOwnership($course);
        $prev = Lesson::where('course_id', $course->id)->where('position', '<', $lesson->position)->orderBy('position', 'desc')->first();
        if ($prev) {
            $tmp = $prev->position;
            $prev->position = $lesson->position;
            $lesson->position = $tmp;
            $prev->save();
            $lesson->save();
        }
        return redirect()->route('instructor.courses.lessons.index', $course);
    }

    public function moveDown(Course $course, Lesson $lesson): RedirectResponse
    {
        $this->checkOwnership($course);
        $next = Lesson::where('course_id', $course->id)->where('position', '>', $lesson->position)->orderBy('position', 'asc')->first();
        if ($next) {
            $tmp = $next->position;
            $next->position = $lesson->position;
            $lesson->position = $tmp;
            $next->save();
            $lesson->save();
        }
        return redirect()->route('instructor.courses.lessons.index', $course);
    }
}
