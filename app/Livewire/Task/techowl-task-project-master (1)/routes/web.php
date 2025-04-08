<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
// Admin routes
Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::middleware(['auth', 'role:manager'])->get('/manager/dashboard', function () {
    return view('manager.dashboard');
})->name('manager.dashboard');

Route::middleware(['auth', 'role:employee'])->get('/employee/dashboard', function () {
    return view('employee.dashboard');
})->name('employee.dashboard');
