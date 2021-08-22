<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Student\ExamController;
use App\Http\Controllers\Student\ResultController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\AdmissionController;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    return Inertia::render('Welcome');
});


Route::get('/apply', [AdmissionController::class, 'showAdmissionForm'])->name('students.admission');
Route::post('/apply', [AdmissionController::class, 'storeAdmission']);
Route::get('/apply/confirmation', [AdmissionController::class, 'showConfirmation'])->name('students.admission-confirmation');


Route::prefix('students')->name('students.')->middleware('auth')->group(function() {
    Route::get('/', function () {
        return Inertia::render('Student/Dashboard');
    })->name('dashboard');

    //exams
    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/{exam:exam_code}', [ExamController::class, 'startExam'])->name('exams.start');
    Route::post('/exam/{exam:exam_code}/finish', [ExamController::class, 'finishExam'])->name('exams.finish');

    // results
    Route::get('/results', [ResultController::class, 'index'])->name('results.index');
    Route::get('/results/{result:result_code}', [ResultController::class, 'resultSummary'])->name('results.summary');
    Route::get('/results/{result:result_code}/details', [ResultController::class, 'detailsResult'])->name('results.details');

    // profiles
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::put('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
});

require __DIR__.'/auth.php';
