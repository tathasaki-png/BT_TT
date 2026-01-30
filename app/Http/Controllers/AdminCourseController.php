<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminCourseController extends Controller
{
    public function create(): View
    {
        $instructors = User::where('role', 'instructor')->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        return view('admin.courses.create', compact('instructors','categories'));
    }

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Calculate sale_price from discount_percent if provided
        if (isset($data['discount_percent']) && $data['discount_percent'] !== null) {
            $percent = (int) $data['discount_percent'];
            $price = (int) $data['price'];
            $data['sale_price'] = (int) round($price * (100 - $percent) / 100);
        } else {
            $data['sale_price'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Course::create($data);

        return redirect()->route('admin.courses.index')->with('success', 'Đã thêm khóa học mới thành công.');
    }

    public function edit(Course $course): View
    {
        $instructors = User::where('role', 'instructor')->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        return view('admin.courses.edit', compact('course','instructors','categories'));
    }

    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['discount_percent'])) {
            if ($data['discount_percent'] !== null) {
                $percent = (int) $data['discount_percent'];
                $price = (int) $data['price'];
                $data['sale_price'] = (int) round($price * (100 - $percent) / 100);
            } else {
                $data['sale_price'] = null;
            }
        }

        if ($request->hasFile('thumbnail')) {
            // delete old
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('success', 'Đã cập nhật khóa học thành công.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        // Before deleting a course, cancel related open orders (awaiting, pending, shipping)
        $affectedStatuses = ['awaiting','pending','shipping'];
        $orders = \App\Models\Order::whereIn('status', $affectedStatuses)
            ->whereHas('items', function ($q) use ($course) {
                $q->where('course_id', $course->id);
            })->with('user','items.course')->get();

        foreach ($orders as $order) {
            $order->status = 'cancelled';
            $order->save();

            // detach the course from the user if present
            if ($order->user) {
                $order->user->courses()->detach($course->id);
                // notify user synchronously
                Mail::to($order->user->email)->send(new \App\Mail\OrderCancelledMail($order));
            }
        }

        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Đã xóa khóa học và hủy các đơn hàng liên quan.');
    }

    public function index(Request $request): View
    {
        $courses = Course::with(['instructor','category'])->withCount('students')->orderBy('id', 'desc')->paginate(15);
        return view('admin.courses.index', compact('courses'));
    }

    public function approve(Course $course): RedirectResponse
    {
        $course->status = Course::STATUS_PUBLISHED;
        $course->save();
        return redirect()->route('admin.courses.index')->with('success', 'Đã duyệt khóa học "' . $course->title . '" thành công.');
    }

    public function toggleStatus(Course $course): RedirectResponse
    {
        $course->status = $course->status === Course::STATUS_PUBLISHED ? Course::STATUS_DRAFT : Course::STATUS_PUBLISHED;
        $course->save();
        return redirect()->route('admin.courses.index')->with('success', 'Đã cập nhật trạng thái khóa học.');
    }

    /**
     * Cancel a course: mark related orders cancelled, revoke enrollments, notify users.
     */
    public function cancel(Course $course): RedirectResponse
    {
        // Find all orders that include this course (any status except already cancelled)
        $orders = \App\Models\Order::where('status', '!=', 'cancelled')
            ->whereHas('items', function ($q) use ($course) {
                $q->where('course_id', $course->id);
            })->with('user','items.course')->get();

        foreach ($orders as $order) {
            $order->status = 'cancelled';
            $order->save();

            if ($order->user) {
                // detach the course from this user
                $order->user->courses()->detach($course->id);
                // notify user
                Mail::to($order->user->email)->send(new \App\Mail\OrderCancelledMail($order));
            }
        }

        // Optionally mark course as draft/unavailable
        $course->status = Course::STATUS_DRAFT;
        $course->save();

        return redirect()->route('admin.courses.index')->with('success', 'Khóa học đã được hủy; các đơn hàng liên quan đã được cập nhật và thông báo đã gửi.');
    }

    public function students(Course $course): View
    {
        $students = $course->students()->latest('course_user.created_at')->paginate(20);
        return view('admin.courses.students', compact('course', 'students'));
    }
}
