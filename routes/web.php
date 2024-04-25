<?php
namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;




Route::get('/', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'AuthLogin']);
Route::get('logout', [AuthController::class, 'logout']);
Route::get('forgot-password', [AuthController::class, 'forgotpassword']);
Route::post('forgot-password', [AuthController::class, 'PostForgotPassword']);
Route::get('reset/{token}', [AuthController::class, 'reset']);
Route::post('reset/{token}', [AuthController::class, 'PostReset']);




Route::get('admin/admin/list', function () {
    return view('admin.admin.list');
});

Route::get('admin/dashboard', function () {
    return view('admin.dashboard');
});


Route::group(['middleware' => AdminMiddleware::class], function (){
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('admin/admin/list', [AdminController::class, 'list']);
    Route::get('admin/admin/add', [AdminController::class, 'add']);
    Route::post('admin/admin/add', [AdminController::class, 'insert']);
    Route::get('admin/admin/edit/{id}', [AdminController::class, 'edit']);
    Route::post('admin/admin/edit/{id}', [AdminController::class, 'update']);
    Route::get('admin/admin/delete/{id}', [AdminController::class, 'delete']);

   // class url
   Route::get('admin/class/list', [ClassController::class, 'list']);
   Route::get('admin/class/add', [ClassController::class, 'add']);
   Route::post('admin/class/add', [ClassController::class, 'insert']);
   Route::get('admin/class/edit/{id}', [ClassController::class, 'edit']);
   Route::post('admin/class/edit/{id}', [ClassController::class, 'update']);
   Route::get('admin/class/delete/{id}', [ClassController::class, 'delete']);

   // subject url
   Route::get('admin/subject/list', [SubjectController::class, 'list']);
   Route::get('admin/subject/add', [SubjectController::class, 'add']);
   Route::post('admin/subject/add', [SubjectController::class, 'insert']);
   Route::get('admin/subject/edit/{id}', [SubjectController::class, 'edit']);
   Route::post('admin/subject/edit/{id}', [SubjectController::class, 'update']);
   Route::get('admin/subject/delete/{id}', [SubjectController::class, 'delete']);



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