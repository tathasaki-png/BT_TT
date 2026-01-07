<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::prefix('contact')->group(function () {

    Route::get('/', function () {
        return view('contact');
    })->name('contact.form');

    Route::post('/', function (Request $request) {
        $name = $request->name;
        $email = $request->email;

        return view('contact_result', compact('name', 'email'));
    })->name('contact.submit');

});
