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

class AdminLessonController extends Controller
{
    public function index(Course $course): View
    {
        $lessons = $course->lessons()->orderBy('position')->get();
        return view('admin.lessons.index', compact('course','lessons'));
    }

    public function create(Course $course): View
    {
        return view('admin.lessons.create', compact('course'));
    }

    public function store(StoreLessonRequest $request, Course $course): RedirectResponse
    {
        $data = $request->except(['video', 'video_url']);
        $data['is_free'] = $request->has('is_free');

        if ($request->hasFile('video')) {
            $data['video_path'] = $request->file('video')->store('videos', 'public');
        } elseif ($request->filled('video_url')) {
            $data['video_path'] = $request->input('video_url');
        }

        $max = $course->lessons()->max('position') ?? 0;
        $data['position'] = $max + 1;
        $data['course_id'] = $course->id;

        Lesson::create($data);

        return redirect()->route('admin.courses.lessons.index', $course)->with('success', 'Bài học đã được thêm thành công.');
    }

    public function edit(Course $course, Lesson $lesson): View
    {
        return view('admin.lessons.edit', compact('course','lesson'));
    }

    public function update(UpdateLessonRequest $request, Course $course, Lesson $lesson): RedirectResponse
    {
        $data = $request->except(['video', 'video_url']);
        $data['is_free'] = $request->has('is_free');

        if ($request->hasFile('video')) {
            if ($lesson->video_path && !str_starts_with($lesson->video_path, 'http')) {
                Storage::disk('public')->delete($lesson->video_path);
            }
            $data['video_path'] = $request->file('video')->store('videos', 'public');
        } elseif ($request->filled('video_url')) {
            if ($lesson->video_path && !str_starts_with($lesson->video_path, 'http')) {
                Storage::disk('public')->delete($lesson->video_path);
            }
            $data['video_path'] = $request->input('video_url');
        }

        $lesson->update($data);

        return redirect()->route('admin.courses.lessons.index', $course)->with('success', 'Bài học đã được cập nhật.');
    }

    public function destroy(Course $course, Lesson $lesson): RedirectResponse
    {
        $pos = $lesson->position;
        if ($lesson->video_path) {
            Storage::disk('public')->delete($lesson->video_path);
        }
        $lesson->delete();
        Lesson::where('course_id', $course->id)->where('position', '>', $pos)->decrement('position');

        return redirect()->route('admin.courses.lessons.index', $course)->with('success', 'Bài học đã được xóa.');
    }

    public function moveUp(Course $course, Lesson $lesson): RedirectResponse
    {
        $prev = Lesson::where('course_id', $course->id)->where('position', '<', $lesson->position)->orderBy('position', 'desc')->first();
        if ($prev) {
            $tmp = $prev->position;
            $prev->position = $lesson->position;
            $lesson->position = $tmp;
            $prev->save();
            $lesson->save();
        }
        return redirect()->route('admin.courses.lessons.index', $course)->with('success', 'Đã thay đổi thứ tự bài học.');
    }

    public function moveDown(Course $course, Lesson $lesson): RedirectResponse
    {
        $next = Lesson::where('course_id', $course->id)->where('position', '>', $lesson->position)->orderBy('position', 'asc')->first();
        if ($next) {
            $tmp = $next->position;
            $next->position = $lesson->position;
            $lesson->position = $tmp;
            $next->save();
            $lesson->save();
        }
        return redirect()->route('admin.courses.lessons.index', $course)->with('success', 'Đã thay đổi thứ tự bài học.');
    }
}
