<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Todo\TodoController;
use App\Http\Controllers\Admin\Faqs\FaqsController;
use App\Http\Controllers\Admin\Blog\BlogController;


use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin|super-admin|user'])->prefix('admin')->group(function () {

    Route::get('/index', [AdminController::class, 'index'])->name('admin.index');

    Route::group(['prefix' => 'todo'], function () {

        Route::get('/index', [TodoController::class, 'index'])->name('admin.todo.index');

        Route::post('/store', [TodoController::class, 'store'])->name('admin.todo.store');

        Route::get('/{id}/edit', [TodoController::class, 'edit'])->name('admin.todo.edit');

        Route::put('/{id}/update', [TodoController::class, 'update'])->name('admin.todo.update');
        
        Route::delete('/{id}/delete', [TodoController::class, 'destroy'])->name('admin.todo.delete');
  
      });

      Route::group(['prefix' => 'faqs'], function () {

        Route::get('/', [FaqsController::class, 'index'])->name('admin.faqs.index');

        Route::post('/', [FaqsController::class, 'store'])->name('admin.faqs.store');

        Route::put('/{id}', [FaqsController::class, 'update'])->name('admin.faqs.update');
        
        Route::delete('/{id}', [FaqsController::class, 'destroy'])->name('admin.faqs.destroy');

    });
    Route::group(['prefix' => 'blog'], function () {

      Route::get('/', [BlogController::class, 'index'])->name('admin.blog.index');

      Route::post('/', [BlogController::class, 'store'])->name('admin.blog.store');

      Route::put('/{id}', [BlogController::class, 'update'])->name('admin.blog.update');
      
      Route::delete('/{id}', [BlogController::class, 'destroy'])->name('admin.blog.destroy');

  });


});

?>