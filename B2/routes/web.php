<?php

use Illuminate\Support\Facades\Route;

Route::get('/user/{id}', function ($id) {
    $users=[
        [
            'id'=>1,
            'name'=>'Tran Van A',
            'gender'=>'Nam'
        ],
        [
            'id'=>2,
            'name'=>'Nguyen Van B',
            'gender'=>'Nam',
            
        ],
        [
            'id'=>3,
            'name'=>'Le Thi C',
            'gender'=>'Nu'
        ]
    ];
    $user = null;
    foreach ($users as $u) {
        if ($u['id'] == $id) {
            $user = $u;
            break;
        }
    }
    return view('user', compact('user'));
});
