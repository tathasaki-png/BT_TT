<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Trang chủ: Chỉ lấy 2 khóa học ngẫu nhiên làm nổi bật
        $featuredCourses = Course::where('status', Course::STATUS_PUBLISHED)
            ->inRandomOrder()
            ->take(2)
            ->with(['instructor', 'category'])
            ->get();

        $sliders = Slider::where('status', 1)->orderBy('order')->get();

        $purchasedCourseIds = [];
        if (auth()->check()) {
            $purchasedCourseIds = auth()->user()->courses()->pluck('courses.id')->toArray();
        }

        return view('home', compact('featuredCourses', 'purchasedCourseIds', 'sliders'));
    }

    public function explore(Request $request)
    {
        $query = Course::query()
            ->where('status', Course::STATUS_PUBLISHED)
            ->with(['instructor', 'category'])
            ->withAvg('reviews', 'rating')
            ->withCount(['reviews', 'students']);

        // Search by title
        if ($q = $request->query('q')) {
            $query->where('title', 'like', '%' . $q . '%');
        }

        // Filter by category
        $selectedCategory = null;
        if ($cat = $request->query('category')) {
            $query->where('category_id', $cat);
            $selectedCategory = Category::find($cat);
        }

        // Filter by price
        if ($price = $request->query('price')) {
            if ($price === 'free') {
                $query->where('price', 0);
            } elseif ($price === 'paid') {
                $query->where('price', '>', 0);
            }
        }

        // Filter by rating (Buckets: 5, 4, 3, 2, 1)
        if ($rating = $request->query('rating')) {
            $rating = (int)$rating;
            if ($rating === 5) {
                $query->having('reviews_avg_rating', '>=', 5);
            } else {
                $query->having('reviews_avg_rating', '>=', $rating)
                      ->having('reviews_avg_rating', '<', $rating + 1);
            }
        }

        // Sorting
        $sort = $request->query('sort', 'newest');
        switch ($sort) {
            case 'popular':
                $query->orderByDesc('students_count'); // Assuming students_count exists or we handle it
                break;
            case 'rating':
                $query->orderByDesc('reviews_avg_rating');
                break;
            case 'price_asc':
                $query->orderBy('price');
                break;
            case 'price_desc':
                $query->orderByDesc('price');
                break;
            case 'newest':
            default:
                $query->orderByDesc('created_at');
                break;
        }

        $courses = $query->paginate(12)->withQueryString();
        $purchasedCourseIds = [];
        if (auth()->check()) {
            $purchasedCourseIds = auth()->user()->courses()->pluck('courses.id')->toArray();
        }

        $categories = Category::withCount('courses')->get();

        return view('explore', compact('courses', 'purchasedCourseIds', 'selectedCategory', 'categories'));
    }
}
