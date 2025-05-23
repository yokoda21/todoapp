<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

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

// 例：TodoControllerのindexメソッドを表示したい場合
Route::get('/', [App\Http\Controllers\TodoController::class, 'index']);

Route::resource('todos', TodoController::class);
Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
Route::put('/todos/{id}', [TodoController::class, 'update'])->name('todos.update');
Route::delete('/todos/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');

