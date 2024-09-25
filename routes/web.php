<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [UserController::class, 'getLogin'])->name('getLogin');
Route::post('login', [UserController::class, 'postLogin'])->name('postLogin')->middleware('throttle:5,5');
Route::get('logout', [UserController::class, 'logout'])->name('logout');
Route::get('reset-password', [UserController::class, 'getResetPassword'])->name('getResetPassword');
Route::post('recover', [UserController::class, 'recover'])->name('recover.password');

Route::prefix('admin')->middleware('check.login')->group(function () {
    Route::get('profile', [UserController::class, 'getProfile'])->name('get.profile');
    Route::post('profile', [UserController::class, 'postProfile'])->name('post.profile');
    Route::post('change-password', [UserController::class, 'changePassword'])->name('post.change.password');
  
    Route::prefix('user')->group(function () {
      Route::get('', [UserController::class, 'getAll'])->name('user');
      Route::get('create', [UserController::class, 'create'])->name('user.create');
      Route::post('create', [UserController::class, 'store'])->name('user.store');
      Route::get('update/{id}', [UserController::class, 'edit'])->name('user.edit')->middleware(['check.user.modify']);
      Route::post('update/{id}', [UserController::class, 'update'])->name('user.update')->middleware(['check.user.modify']);
      Route::post('delete/{id}', [UserController::class, 'destroy'])->name('user.destroy')->middleware(['check.user.modify']);
    });
  
    Route::prefix('permission')->group(function () {
      Route::get('', [PermissionController::class, 'getAll'])->name('permission');
      Route::get('create', [PermissionController::class, 'create'])->name('permission.create');
      Route::post('create', [PermissionController::class, 'store'])->name('permission.store');
      Route::get('update/{id}', [PermissionController::class, 'edit'])->name('permission.edit')->middleware(['check.permission.modify']);
      Route::post('update/{id}', [PermissionController::class, 'update'])->name('permission.update')->middleware(['check.permission.modify']);
      Route::post('delete/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy')->middleware(['check.permission.modify']);
    });
  
    Route::prefix('role')->group(function () {
      Route::get('', [RoleController::class, 'getAll'])->name('role');
      Route::get('create', [RoleController::class, 'create'])->name('role.create');
      Route::post('create', [RoleController::class, 'store'])->name('role.store');
      Route::get('update/{id}', [RoleController::class, 'edit'])->name('role.edit')->middleware(['check.role.modify']);
      Route::post('update/{id}', [RoleController::class, 'update'])->name('role.update')->middleware(['check.role.modify']);
      Route::post('delete/{id}', [RoleController::class, 'destroy'])->name('role.destroy')->middleware(['check.role.modify']);
    });
  });