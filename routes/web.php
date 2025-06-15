<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\RedemptionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/guide/login', function () {
    return view('guide.login');
});
Route::get('/guide/dashboard', function () { 
    return view('guide.dashboard'); 
});
Route::post('/guide/redeem', [RedemptionController::class, 'redeem']);

Route::get('/admin/dashboard', function () { 
    return view('admin.dashboard'); 
});
Route::get('/admin/login', function () {
    return view('admin.login');
});

// Route::get('/login', function () {
//     return view('Admin.login'); // or your login view
// })->name('login');