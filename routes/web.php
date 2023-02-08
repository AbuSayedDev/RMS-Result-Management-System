<?php

use App\Http\Controllers\Backend\BatchController;
use App\Http\Controllers\Backend\ExamController;
use App\Http\Controllers\Backend\IndexController;
use App\Http\Controllers\Backend\ResultController;
use App\Http\Controllers\Backend\SeasonController;
use App\Http\Controllers\Backend\StudentController;
use App\Http\Controllers\Backend\TeacherController;
use App\Http\Controllers\Backend\SubjectController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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



Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::post('change-password', [FrontendController::class, 'changePassword'])->name('admin_password_change');

    Route::get('/', [FrontendController::class, 'index'])->name('frontend_index');
});

Route::group(['middleware' => 'student'], function () {
    Route::get('exam', [FrontendController::class, 'exam'])->name('frontend_exam');
});

// admin
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', [IndexController::class, 'index'])->name('admin_index');

    Route::group(['prefix' => 'students'], function () {
        Route::get('/', [StudentController::class, 'index'])->name('admin_students_index');
        Route::post('store', [StudentController::class, 'store'])->name('admin_students_store');
        Route::put('update/{id}', [StudentController::class, 'update'])->name('admin_students_update');
        Route::delete('delete/{id}', [StudentController::class, 'destroy'])->name('admin_students_delete');
        Route::get('results/{id}', [FrontendController::class, 'exam'])->name('admin_students_results');
    });

    Route::group(['prefix' => 'teachers'], function () {
        Route::get('/', [TeacherController::class, 'index'])->name('admin_teachers_index');
        Route::post('store', [TeacherController::class, 'store'])->name('admin_teachers_store');
        Route::put('update/{id}', [TeacherController::class, 'update'])->name('admin_teachers_update');
        Route::delete('delete/{id}', [TeacherController::class, 'destroy'])->name('admin_teachers_delete');
    });

    Route::group(['prefix' => 'seasons'], function () {
        Route::get('/', [SeasonController::class, 'index'])->name('admin_seasons_index');
        Route::post('store', [SeasonController::class, 'store'])->name('admin_seasons_store');
        Route::put('update/{id}', [SeasonController::class, 'update'])->name('admin_seasons_update');
        Route::delete('delete/{id}', [SeasonController::class, 'destroy'])->name('admin_seasons_delete');
    });

    Route::group(['prefix' => 'batches'], function () {
        Route::get('/', [BatchController::class, 'index'])->name('admin_batches_index');
        Route::post('store', [BatchController::class, 'store'])->name('admin_batches_store');
        Route::put('update/{id}', [BatchController::class, 'update'])->name('admin_batches_update');
        Route::delete('delete/{id}', [BatchController::class, 'destroy'])->name('admin_batches_delete');
    });

    Route::group(['prefix' => 'exams'], function () {
        Route::get('/', [ExamController::class, 'index'])->name('admin_exams_index');
        Route::post('store', [ExamController::class, 'store'])->name('admin_exams_store');
        Route::put('update/{id}', [ExamController::class, 'update'])->name('admin_exams_update');
        Route::delete('delete/{id}', [ExamController::class, 'destroy'])->name('admin_exams_delete');
    });

    Route::group(['prefix' => 'subjects'], function () {
        Route::get('/', [SubjectController::class, 'index'])->name('admin_subjects_index');
        Route::post('store', [SubjectController::class, 'store'])->name('admin_subjects_store');
        Route::put('update/{id}', [SubjectController::class, 'update'])->name('admin_subjects_update');
        Route::delete('delete/{id}', [SubjectController::class, 'destroy'])->name('admin_subjects_delete');
    });

    Route::group(['prefix' => 'results'], function () {
        Route::get('/', [ResultController::class, 'index'])->name('admin_results_index');
        Route::post('store', [ResultController::class, 'store'])->name('admin_results_store');
        Route::put('update/{id}', [ResultController::class, 'update'])->name('admin_results_update');
        Route::delete('delete/{id}', [ResultController::class, 'destroy'])->name('admin_results_delete');
    });
});

// teacher
// Route::group(['prefix' => 'admin', 'middleware' => ['teacher']], function () {
//     Route::group(['prefix' => 'students'], function () {
//         Route::get('/', [StudentController::class, 'index'])->name('admin_students_index');
//         Route::post('store', [StudentController::class, 'store'])->name('admin_students_store');
//         Route::put('update/{id}', [StudentController::class, 'update'])->name('admin_students_update');
//         Route::delete('delete/{id}', [StudentController::class, 'destroy'])->name('admin_students_delete');
//         Route::get('results/{id}', [FrontendController::class, 'exam'])->name('admin_students_results');
//     });

//     Route::group(['prefix' => 'subjects'], function () {
//         Route::get('/', [SubjectController::class, 'index'])->name('admin_subjects_index');
//         Route::post('store', [SubjectController::class, 'store'])->name('admin_subjects_store');
//         Route::put('update/{id}', [SubjectController::class, 'update'])->name('admin_subjects_update');
//         Route::delete('delete/{id}', [SubjectController::class, 'destroy'])->name('admin_subjects_delete');
//     });

//     Route::group(['prefix' => 'results'], function () {
//         Route::get('/', [ResultController::class, 'index'])->name('admin_results_index');
//         Route::post('store', [ResultController::class, 'store'])->name('admin_results_store');
//         Route::put('update/{id}', [ResultController::class, 'update'])->name('admin_results_update');
//         Route::delete('delete/{id}', [ResultController::class, 'destroy'])->name('admin_results_delete');
//     });
// });
