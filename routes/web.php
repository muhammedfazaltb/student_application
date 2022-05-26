<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['namepspace' => '','middleware'=>['auth:web']], function () {
 Route::get('/admin_dashboard', [App\Http\Controllers\AdminController::class, 'adminDashboard'])->name('admin.dashboard');
 Route::get('/teacher_dashboard', [App\Http\Controllers\AdminController::class,'teacherDashboard'])->name('teacher.dashboard');
 
  Route::get('/admin/addteacher', [App\Http\Controllers\AdminController::class,'addTeacher'])->name('admin.addnewteacher');
  Route::post('/admin/addteacher', [App\Http\Controllers\AdminController::class,'createTeacher'])->name('admin.createteacher');
 Route::get('/admin/createclass', [App\Http\Controllers\AdminController::class,'createclass'])->name('admin.addclass');
 Route::post('/admin/createclass', [App\Http\Controllers\AdminController::class,'AddClass'])->name('admin.addclass');
 Route::get('/admin/createdivision', [App\Http\Controllers\AdminController::class,'createdivision'])->name('admin.adddivision');
 Route::post('/admin/createdivision', [App\Http\Controllers\AdminController::class,'AddDivision'])->name('admin.adddivision');
  Route::get('/admin/createsubject', [App\Http\Controllers\AdminController::class,'createSubject'])->name('admin.addsubject');
  Route::post('/admin/createsubject', [App\Http\Controllers\AdminController::class,'AddSubject'])->name('admin.createsubject');
  Route::get('/teacher/createstudent', [App\Http\Controllers\HomeController::class,'AddStudent'])->name('teacher.addstudent');
  Route::get('/teacher/addmark', [App\Http\Controllers\HomeController::class,'AddMark'])->name('teacher.addmark');
  Route::post('/teacher/addmark', [App\Http\Controllers\HomeController::class,'CreateMarks'])->name('teacher.createmark');
   Route::post('/teacher/createsubject', [App\Http\Controllers\HomeController::class,'CreateStudent'])->name('teacher.createstudent');
   Route::get('/admin/studentreport', [App\Http\Controllers\AdminController::class,'Studentreport'])->name('admin.students');
    Route::get('/admin/studentmarkreport', [App\Http\Controllers\AdminController::class,'Studentmarkreport'])->name('admin.student.mark');
   
Route::post('post-data', [App\Http\Controllers\HomeController::class, 'userPostManage'])->name('UserPostManage');

});

