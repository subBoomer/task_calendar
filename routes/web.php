<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\EventController;



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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/calendar', [CalendarController::class, 'show'])->name('calendar');
    Route::post('/calendar/add-task', [CalendarController::class, 'addTask'])->name('calendar.addTask');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'showAll'])->name('tasks');
    Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/groups', [GroupController::class, 'index'])->name('groups');
    Route::get('/groups/{id?}', [GroupController::class, 'show'])->name('groups.show');
    Route::get('/groups/create', [GroupController::class, 'showCreateForm'])->name('groups.showCreateForm');
    Route::post('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::put('/groups/{id}', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups/{id}', [GroupController::class, 'destroy'])->name('groups.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
});

require __DIR__.'/auth.php';
