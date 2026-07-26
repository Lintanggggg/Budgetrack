<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SavingsGoalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\UserController;

// Root redirect
Route::get('/', function () {
    return redirect()->route('login');
});

// User Routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('incomes', IncomeController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('savings-goals', SavingsGoalController::class);
    Route::post('savings-goals/{savingsGoal}/add-fund', [SavingsGoalController::class, 'addFund'])
    ->name('savings-goals.add-fund');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::post('/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');
    Route::get('/change-password', [DashboardController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [DashboardController::class, 'updatePassword'])->name('change-password.update');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/logs', [UserController::class, 'logs'])->name('logs.index');
});

require __DIR__.'/auth.php';