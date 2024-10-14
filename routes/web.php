<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', WelcomeController::class);

Route::get('/dashboard', function ()
{
    $task_count    = app(TaskController::class)->count_tasks();
    $project_count = app(ProjectController::class)->count_projects();

    return view('dashboard', compact('task_count', 'project_count'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function ()
{
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/tasks', TaskController::class);
    Route::get('/tasks/report/pdf', [TaskController::class, 'download_pdf'])->name('tasks.report.pdf');
    Route::get('/tasks/report/excel', [TaskController::class, 'download_excel'])->name('tasks.report.excel');

    Route::resource('/projects', ProjectController::class);
});

require __DIR__ . '/auth.php';
