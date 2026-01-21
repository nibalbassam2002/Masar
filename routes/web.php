<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ProjectController;

Route::get('/', [HomeController::class, 'index'])->name('home');
// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected Routes (بعد تسجيل الدخول)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
});
Route::middleware(['auth'])->prefix('setup')->group(function () {
    Route::get('/workspace', [OnboardingController::class, 'workspace'])->name('setup.workspace');
    Route::post('/workspace', [OnboardingController::class, 'storeWorkspace']);
    
    Route::get('/team-profile', [OnboardingController::class, 'teamProfile'])->name('setup.team');
    Route::post('/team-profile', [OnboardingController::class, 'storeTeamProfile']);
    
    Route::get('/first-project', [OnboardingController::class, 'project'])->name('setup.project');
    Route::post('/first-project', [OnboardingController::class, 'storeProject']);
});