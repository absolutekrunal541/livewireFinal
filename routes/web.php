<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {

    // Admin Dashboard
    Route::middleware('role:Admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/tasks/manage', [TaskController::class, 'index'])->name('tasks.manage');
        Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    });

    // Manager Dashboard
    Route::middleware('role:Manager')->group(function () {
        Route::get('/manager/dashboard', [ManagerController::class, 'index'])->name('manager.dashboard');
        Route::get('/tasks/assign', [TaskController::class, 'assign'])->name('tasks.assign');
    });

    // Employee Dashboard
    Route::middleware('role:Employee')->group(function () {
        Route::get('/employee/dashboard', [EmployeeController::class, 'index'])->name('employee.dashboard');
        Route::get('/my-tasks', [TaskController::class, 'myTasks'])->name('tasks.my');
    });

    // Shared Access (Admin + Manager)
    Route::middleware('role:Admin,Manager')->group(function () {
        Route::get('/shared/tasks', [TaskController::class, 'shared'])->name('tasks.shared');
    });
});
