<?php

use Illuminate\Http\Request;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;

Route::get('/hello', function () {
    return view('hello');
});

Route::get('/user/{id}', function ($id) {
    $users = [
        [
            'id' => 1,
            'name' => 'Trần Văn A', 
            'gender' => 'Nam'
        ],
        [
            'id' => 2,
            'name' => 'Trần Thị B', 
            'gender' => 'Nữ'
        ],
        [
            'id' => 3,
            'name' => 'Nguyễn Văn C', 
            'gender' => 'Nam'
        ],
        [
            'id' => 4,
            'name' => 'Lê Thị D', 
            'gender' => 'Nữ'
        ],
        [
            'id' => 5,
            'name' => 'Phạm Văn E', 
            'gender' => 'Nam'
        ]
    ];

    // Tìm user có id tương ứng
    $user = null;
    foreach ($users as $u) {
        if ($u['id'] == $id) {
            $user = $u;
            break;
        }
    }

    return view('user', ['user' => $user, 'users' => $users]);
});
Route::prefix('contact')->group(function () {

    // GET /contact
    Route::get('/', function () {
        return view('contact');
    })->name('contact.form');

    // POST /contact
    Route::post('/', function (Request $request) {
        $name = $request->input('name');
        $email = $request->input('email');

        return "
            <h2>Thông tin đã submit</h2>
            <p><strong>Tên:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
        ";
    })->name('contact.submit');

});

// Resource routes cho Posts và Categories
Route::resource('posts', PostController::class);
Route::resource('categories', CategoryController::class);
