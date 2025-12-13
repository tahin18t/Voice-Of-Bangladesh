<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupController;

Route::get('/', function () {
    return view('index');
});
Route::get('/index', function () {
    return view('index');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/officer-dashboard', function () {
    return view('officer-dashboard');
});
Route::get('/submit-feedback', function () {
    return view('submit-feedback');
});

Route::get('/track', function () {
    return view('track');
});


Route::get('/public-insights', function () {
    return view('index');
});

Route::get('/signup', [SignupController::class, 'create'])->name('signup.show');
Route::post('/signup', [SignupController::class, 'store'])->name('signup.store');
