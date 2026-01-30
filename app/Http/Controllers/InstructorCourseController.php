<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InstructorCourseController extends Controller
{
    public function index(): View
    {
        $courses = Course::where('instructor_id', auth()->id())
            ->with(['category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('instructor.courses.index', compact('courses'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('instructor.courses.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data['instructor_id'] = auth()->id();
        $data['status'] = Course::STATUS_PENDING; // Luôn đặt là pending khi tạo mới

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Course::create($data);

        return redirect()->route('instructor.courses.index')->with('success', 'Khóa học đã được gửi và đang chờ admin duyệt.');
    }

    public function edit(Course $course): View
    {
        if (!auth()->user()->isAdmin() && $course->instructor_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::orderBy('name')->get();
        return view('instructor.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        if (!auth()->user()->isAdmin() && $course->instructor_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Khi giảng viên cập nhật, có thể giữ nguyên trạng thái hoặc chuyển về pending nếu muốn admin duyệt lại
        // Ở đây tạm thời giữ nguyên hoặc chuyển về pending để đảm bảo nội dung an toàn
        $data['status'] = Course::STATUS_PENDING;

        $course->update($data);

        return redirect()->route('instructor.courses.index')->with('success', 'Đã cập nhật khóa học. Đang chờ admin duyệt lại.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        if (!auth()->user()->isAdmin() && $course->instructor_id !== auth()->id()) {
            abort(403);
        }

        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        $course->delete();

        return redirect()->route('instructor.courses.index')->with('success', 'Đã xóa khóa học.');
    }
}
