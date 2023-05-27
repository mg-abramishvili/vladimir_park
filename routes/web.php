<?php

use Illuminate\Support\Facades\Route;

Route::prefix("k")->group(function() {
    Route::get('{any}', function () {
        return view('front');
    })->where('any', '.*');
});

Route::get('/admin', function () {
    return view('admin');
});

Route::prefix("admin")->group(function() {
    Route::get('{any}', function () {
        return view('admin');
    })->where('any', '.*');
});