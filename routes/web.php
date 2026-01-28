<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceController;

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
    
    // ملاحظة للمحترفة: دائماً ضعي الروابط الثابتة قبل الروابط التي تحتوي على متغيرات {project}
    Route::post('/projects/{project}/invite', [ProjectController::class, 'inviteMember'])->name('projects.invite');
    Route::get('/projects/{project}/join/{email}', [ProjectController::class, 'acceptInvitation'])->name('projects.accept-invitation');
    
    // رابط العرض (Show)
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    // --- 2. روابط المهام (Tasks) ---
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

    // الحل الذكي: نضع رابط الإنشاء هكذا لكي لا يتداخل مع روابط المشاريع
    // إذا أرسلنا رقم المشروع يفتح له، وإذا لم نرسل يفتح عام
    Route::get('/tasks/create/{project?}', [TaskController::class, 'create'])->name('tasks.create');
    
    Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/update-status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    Route::get('/tasks/{task}/quick-view', [TaskController::class, 'quickView'])->name('tasks.quick-view');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/notes', [TaskController::class, 'storeNote'])->name('tasks.notes.store');
    Route::get('/tasks/{task}/quick-view', [TaskController::class, 'quickView'])->name('tasks.quick-view');
    Route::delete('/notes/{note}', [TaskController::class, 'destroyNote'])->name('notes.destroy');
    Route::get('/settings/groups', [WorkspaceController::class, 'settingsGroups'])->name('settings.groups');
    Route::post('/settings/groups', [WorkspaceController::class, 'storeGroup'])->name('settings.groups.store');
    Route::delete('/settings/groups/{category}', [WorkspaceController::class, 'destroyGroup'])->name('settings.groups.destroy');
    Route::get('/settings/members', [WorkspaceController::class, 'settingsMembers'])->name('settings.members');
    Route::post('/settings/members/invite', [WorkspaceController::class, 'inviteMember'])->name('settings.members.invite');
    Route::delete('/settings/members/{user}', [WorkspaceController::class, 'removeMember'])->name('settings.members.remove');
    Route::get('/projects/{project}/accept', [ProjectController::class, 'acceptInvitation'])->name('invitation.accept');
});
Route::middleware(['auth'])->prefix('setup')->group(function () {
    Route::get('/workspace', [OnboardingController::class, 'workspace'])->name('setup.workspace');
    Route::post('/workspace', [OnboardingController::class, 'storeWorkspace']);
    
    Route::get('/team-profile', [OnboardingController::class, 'teamProfile'])->name('setup.team');
    Route::post('/team-profile', [OnboardingController::class, 'storeTeamProfile']);
    
    Route::get('/first-project', [OnboardingController::class, 'project'])->name('setup.project');
    Route::post('/first-project', [OnboardingController::class, 'storeProject']);
});

