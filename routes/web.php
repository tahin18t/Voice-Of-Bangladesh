<?php

use Illuminate\Support\Facades\Route;

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