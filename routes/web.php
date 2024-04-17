<?php
namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;


Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'AuthLogin']);
Route::get('logout', [AuthController::class, 'logout']);
Route::get('forgot-password', [AuthController::class, 'forgotpassword']);
Route::post('forgot-password', [AuthController::class, 'PostForgotPassword']);


Route::get('admin/admin/list', function () {
    return view('admin.admin.list');
});

Route::get('admin/dashboard', function () {
    return view('admin.dashboard');
});


Route::group(['middleware' => AdminMiddleware::class], function (){
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);

});

// Route::group(['middleware' => 'teacher'], function (){
//     Route::get('teacher/dashboard', function () {
//         return view('admin.dashboard');
//     });
// });

// Route::group(['middleware' => 'student'], function (){
//     Route::get('student/dashboard', function () {
//         return view('admin.dashboard');
//     });
// });

// Route::group(['middleware' => 'parent'], function (){
//     Route::get('parent/dashboard', function () {
//         return view('admin.dashboard');
//     });
// });
Route::group(['middleware' => TeacherMiddleware::class], function () {
    Route::get('teacher/dashboard', [DashboardController::class, 'dashboard']);

});

Route::group(['middleware' => StudentMiddleware::class], function () {
    Route::get('student/dashboard', [DashboardController::class, 'dashboard']);

   
});

Route::group(['middleware' => ParentMiddleware::class], function () {
    Route::get('parent/dashboard', [DashboardController::class, 'dashboard']);


});