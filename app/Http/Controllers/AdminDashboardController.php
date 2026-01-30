<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCourses = Course::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::whereIn('status', ['completed', 'delivered'])->sum('total_price');
        
        $recentOrders = Order::with('user')->latest()->limit(10)->get();
        $topCourses = Course::withCount('students')->latest('students_count')->limit(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalCourses', 'totalOrders', 'totalRevenue', 'recentOrders', 'topCourses'));
    }
}
