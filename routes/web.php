<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminCourseController;
use App\Http\Controllers\InstructorLessonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/explore', [HomeController::class, 'explore'])->name('explore');

// Authentication (simple Blade + controller-based)
Route::get('register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('register/verify', [AuthController::class, 'showVerify'])->name('register.verify');
Route::post('register/verify', [AuthController::class, 'verify'])->name('verify.otp');
Route::post('register/resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');

Route::get('login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Redirect /admin to dashboard
Route::get('/admin', function() {
    return redirect()->route('admin.dashboard');
});

Route::middleware(['auth', 'role:instructor'])->get('/instructor', function () {
    return view('welcome')->with('message', 'Instructor dashboard (protected)');
})->name('dashboard.instructor');

Route::middleware(['auth', 'role:student'])->get('/student', function () {
    return view('welcome')->with('message', 'Student dashboard (protected)');
})->name('dashboard.student');

// Public course detail
Route::get('courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');

// Checkout (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('vnpay-return', [CheckoutController::class, 'vnpayReturn'])->name('vnpay.return');
    Route::post('cart/add/{course}', [CheckoutController::class, 'addToCart'])->name('cart.add');
    Route::delete('cart/remove/{course}', [CheckoutController::class, 'removeFromCart'])->name('cart.remove');
    // Learning routes - only for users who purchased the course
    Route::get('learn/{course:slug}/{lesson?}', [LearningController::class, 'show'])->name('learn.show');
    Route::post('learn/{course}/lessons/{lesson}/complete', [LearningController::class, 'complete'])->name('learn.complete');
    Route::post('learn/{course}/lessons/{lesson}/progress', [LearningController::class, 'saveProgress'])->name('learn.progress');
    Route::post('learn/{course}/lessons/{lesson}/quiz', [LearningController::class, 'submitQuiz'])->name('learn.quiz.submit');
    // Profile routes
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('orders', [ProfileController::class, 'orders'])->name('profile.orders');
    
    // Certificate routes
    Route::get('certificate/{course:slug}', [\App\Http\Controllers\CertificateController::class, 'generate'])->name('certificate.generate');
    Route::get('certificate/view/{certificate}', [\App\Http\Controllers\CertificateController::class, 'show'])->name('certificate.show');
    Route::get('certificate/download/{certificate}', [\App\Http\Controllers\CertificateController::class, 'download'])->name('certificate.download');
    
    // Review routes
    Route::post('courses/{course}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

    // Change payment method route
    Route::post('orders/{order}/change-payment-method', [CheckoutController::class, 'changePaymentMethod'])->name('orders.change-payment-method');
});

// Admin routes: management
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'role:admin']
], function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Categories
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    
    // Courses
    Route::resource('courses', AdminCourseController::class)->except(['show']);
    Route::get('courses/{course}/students', [\App\Http\Controllers\AdminCourseController::class, 'students'])->name('courses.students');
    Route::post('courses/{course}/toggle-status', [\App\Http\Controllers\AdminCourseController::class, 'toggleStatus'])->name('courses.toggleStatus');
    Route::post('courses/{course}/cancel', [\App\Http\Controllers\AdminCourseController::class, 'cancel'])->name('courses.cancel');

    // Lessons (Admin can also manage lessons for courses)
    Route::resource('courses.lessons', \App\Http\Controllers\AdminLessonController::class)->except(['show']);
    Route::post('courses/{course}/lessons/{lesson}/move-up', [\App\Http\Controllers\AdminLessonController::class, 'moveUp'])->name('courses.lessons.moveUp');
    Route::post('courses/{course}/lessons/{lesson}/move-down', [\App\Http\Controllers\AdminLessonController::class, 'moveDown'])->name('courses.lessons.moveDown');

    // Users (Customer Management)
    Route::resource('users', \App\Http\Controllers\AdminUserController::class);
    Route::patch('users/{user}/role', [\App\Http\Controllers\AdminUserController::class, 'updateRole'])->name('users.updateRole');
    Route::patch('users/{user}/status', [\App\Http\Controllers\AdminUserController::class, 'toggleStatus'])->name('users.toggleStatus');

    // Orders
    Route::get('orders', [\App\Http\Controllers\AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [\App\Http\Controllers\AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [\App\Http\Controllers\AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('orders/{order}', [\App\Http\Controllers\AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // Sliders
    Route::resource('sliders', \App\Http\Controllers\AdminSliderController::class)->except(['show']);

    // Questions
    Route::get('lessons/{lesson}/questions', [\App\Http\Controllers\AdminQuestionController::class, 'index'])->name('lessons.questions.index');
    Route::post('lessons/{lesson}/questions', [\App\Http\Controllers\AdminQuestionController::class, 'store'])->name('lessons.questions.store');
    Route::delete('questions/{question}', [\App\Http\Controllers\AdminQuestionController::class, 'destroy'])->name('questions.destroy');

    // Revenue
    Route::get('revenue', [\App\Http\Controllers\AdminRevenueController::class, 'index'])->name('revenue.index');
});

// Instructor routes: lessons management (nested under courses)
Route::group([
    'prefix' => 'instructor',
    'as' => 'instructor.',
    'middleware' => ['auth', 'role:instructor']
], function () {
    // Dashboard
    Route::get('/', [\App\Http\Controllers\InstructorDashboardController::class, 'index'])->name('dashboard');
    
    // Courses
    Route::resource('courses', \App\Http\Controllers\InstructorCourseController::class)->except(['show']);
    
    // Lessons
    Route::resource('courses.lessons', \App\Http\Controllers\InstructorLessonController::class)->except(['show']);

    Route::post('courses/{course}/lessons/{lesson}/move-up', [\App\Http\Controllers\InstructorLessonController::class, 'moveUp'])->name('courses.lessons.moveUp');
    Route::post('courses/{course}/lessons/{lesson}/move-down', [\App\Http\Controllers\InstructorLessonController::class, 'moveDown'])->name('courses.lessons.moveDown');
});

// Admin group additional routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function() {
    Route::patch('courses/{course}/approve', [\App\Http\Controllers\AdminCourseController::class, 'approve'])->name('courses.approve');
});

// Test Email Routes (ONLY for development - remove in production)
if (app()->environment('local', 'development')) {
    Route::prefix('test-email')->as('test-email.')->group(function() {
        Route::get('{order}', [\App\Http\Controllers\TestEmailController::class, 'testOrderCompletedEmail'])->name('send');
        Route::get('{order}/job', [\App\Http\Controllers\TestEmailController::class, 'testOrderCompletedEmailJob'])->name('job');
        Route::get('{order}/sync', [\App\Http\Controllers\TestEmailController::class, 'testOrderCompletedEmailSync'])->name('sync');
        Route::get('preview/{order}', [\App\Http\Controllers\TestEmailController::class, 'previewOrderEmail'])->name('preview');
    });
    
    Route::get('test-vnpay-return', [\App\Http\Controllers\TestEmailController::class, 'testVnpayReturn'])->name('test-vnpay.return');
    Route::get('test-logs', [\App\Http\Controllers\TestEmailController::class, 'viewLogs'])->name('test.logs');
    Route::get('test-queue-status', [\App\Http\Controllers\TestEmailController::class, 'queueStatus'])->name('test.queue');
}

