<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Todo\TodoController;
use App\Http\Controllers\Admin\Faqs\FaqsController;


use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin|super-admin|user'])->prefix('admin')->group(function () {

    Route::get('/index', [AdminController::class, 'index'])->name('admin.index');

    Route::group(['prefix' => 'todo'], function () {

        Route::get('/index', [TodoController::class, 'index'])->name('admin.todo.index');

        Route::post('/todo/store', [TodoController::class, 'store'])->name('admin.todo.store');

        Route::get('todo/{id}/edit', [TodoController::class, 'edit'])->name('admin.todo.edit');

        Route::put('todo/{id}/update', [TodoController::class, 'update'])->name('admin.todo.update');
        
        Route::delete('todo/{id}/delete', [TodoController::class, 'destroy'])->name('admin.todo.delete');
  
      });

      Route::group(['prefix' => 'faqs'], function () {

        Route::get('/index', [FaqsController::class, 'index'])->name('admin.faqs.index');

    });


});

?>