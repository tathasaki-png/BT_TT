<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorDashboardController extends Controller
{
    public function index()
    {
        $instructor = Auth::user();
        
        // Get instructor's courses
        $courses = Course::where('instructor_id', $instructor->id)->get();
        $totalCourses = $courses->count();
        
        // Get total students
        $totalStudents = 0;
        foreach ($courses as $course) {
            $totalStudents += $course->students()->count();
        }
        
        // Get revenue from courses
        $totalRevenue = OrderItem::whereIn('course_id', $courses->pluck('id'))
            ->whereHas('order', fn($q) => $q->where('status', 'completed'))
            ->sum('price');
        
        // Get recent orders
        $recentOrders = OrderItem::whereIn('course_id', $courses->pluck('id'))
            ->with(['order.user', 'course'])
            ->latest()
            ->limit(10)
            ->get();
        
        // Get top courses
        $topCourses = $courses->map(function($course) {
            return [
                'course' => $course,
                'students' => $course->students()->count(),
                'revenue' => $course->orderItems()->whereHas('order', fn($q) => $q->where('status', 'completed'))->sum('price'),
            ];
        })->sortByDesc('students')->take(5);
        
        // Monthly revenue
        $monthlyRevenue = $this->getMonthlyRevenue($courses->pluck('id'));
        
        return view('instructor.dashboard', compact(
            'totalCourses',
            'totalStudents', 
            'totalRevenue',
            'recentOrders',
            'topCourses',
            'monthlyRevenue'
        ));
    }
    
    private function getMonthlyRevenue($courseIds)
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue = OrderItem::whereIn('course_id', $courseIds)
                ->whereHas('order', function($q) use ($month) {
                    $q->where('status', 'completed')
                      ->whereBetween('created_at', [
                          $month->startOfMonth(),
                          $month->endOfMonth()
                      ]);
                })
                ->sum('price');
            
            $data[$month->format('M')] = $revenue;
        }
        return $data;
    }
}
