<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\CategoryController;
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
//Route::get('/todos', [TodoController::class, 'show']);// 5月26日(月)追加
//Route::resource('todos', TodoController::class);検索通らないので6月6日(金)コメントアウト
Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
//Route::put('/todos/{id}', [TodoController::class, 'update'])->name('todos.update');
Route::delete('/todos/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::patch('/todos/update', [TodoController::class, 'update']); //todo更新
Route::get('/todos/search', [TodoController::class, 'search'])->name('todos.search'); // 検索機能
Route::put('/todos/{id}', [TodoController::class, 'update'])->name('todos.update');


Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::post('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');  // 更新
Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit'); // 編集
Route::patch('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update'); // 更新 
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy'); // カテゴリ削除
Route::post('/categories/delete', [CategoryController::class, 'destroy'])->name('categories.destroy');
