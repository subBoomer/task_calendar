<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TodoController;




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
    $todos = \App\Models\Todo::all();
    
    // Check if $todos is empty
    if ($todos->isEmpty()) {
        // If there are no todos, return the dashboard view without passing any data
        return view('dashboard');
    }

    // If there are todos, pass them to the dashboard view
    return view('dashboard', compact('todos'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/calendar', [CalendarController::class, 'show'])->name('calendar.index');
    Route::post('/calendar/addTask', [CalendarController::class, 'addTask'])->name('calendar.addTask');
    Route::post('/calendar/updateTask', [CalendarController::class, 'updateTask'])->name('calendar.updateTask');
    Route::get('/calendar/events', [CalendarController::class, 'getEvents'])->name('calendar.events');
    Route::delete('/calendar/events/{id}', [CalendarController::class, 'deleteEvent'])->name('calendar.events.delete');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/todos/addTodo', [TodoController::class, 'store'])->name('todos.store');
    Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
    Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
    Route::put('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
});

require __DIR__.'/auth.php';
