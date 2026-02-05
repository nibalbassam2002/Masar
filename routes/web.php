<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    
    Route::post('/projects/{project}/invite', [ProjectController::class, 'inviteMember'])->name('projects.invite');
    Route::get('/projects/{project}/join/{email}', [ProjectController::class, 'acceptInvitation'])->name('projects.accept-invitation');
    
    
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

   
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

   
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
    Route::post('/tasks/{task}/subtasks', [TaskController::class, 'storeSubTask'])->name('tasks.subtasks.store');
    Route::post('/settings/members/{user}/role', [WorkspaceController::class, 'updateMemberRole'])->name('settings.members.role');
    Route::post('/settings/members/{user}/update-dept', [WorkspaceController::class, 'updateMemberDepartment'])->name('settings.members.update-dept');
    Route::post('/tasks/{task}/archive', [TaskController::class, 'archive'])->name('tasks.archive');
    Route::post('/projects/{project}/archive', [ProjectController::class, 'archive'])->name('projects.archive');
    Route::post('/tasks/{task}/unarchive', [TaskController::class, 'unarchive'])->name('tasks.unarchive');
    Route::patch('/projects/{project}/archive', [ProjectController::class, 'archive'])->name('projects.archive');
    Route::patch('/projects/{project}/unarchive', [ProjectController::class, 'unarchive'])->name('projects.unarchive');
    Route::get('/projects/{project}/analytics', [ProjectController::class, 'analytics'])->name('projects.analytics');
    Route::get('/global-search', [DashboardController::class, 'search'])->name('global.search');
});
Route::middleware(['auth'])->prefix('setup')->group(function () {
    Route::get('/workspace', [OnboardingController::class, 'workspace'])->name('setup.workspace');
    Route::post('/workspace', [OnboardingController::class, 'storeWorkspace']);
    
    Route::get('/team-profile', [OnboardingController::class, 'teamProfile'])->name('setup.team');
    Route::post('/team-profile', [OnboardingController::class, 'storeTeamProfile']);
    
    Route::get('/first-project', [OnboardingController::class, 'project'])->name('setup.project');
    Route::post('/first-project', [OnboardingController::class, 'storeProject']);
});
// مسارات الصفحات التعريفية (Footer Links)
Route::prefix('info')->group(function () {
    Route::get('/roadmap', fn() => view('pages.roadmap'))->name('roadmap');
    Route::get('/integrations', fn() => view('pages.integrations'))->name('integrations');
    Route::get('/documentation', fn() => view('pages.docs'))->name('docs');
    Route::get('/help-center', fn() => view('pages.help'))->name('help');
    Route::get('/privacy', fn() => view('pages.privacy'))->name('privacy');
    Route::get('/terms', fn() => view('pages.terms'))->name('terms');
    Route::get('/community', fn() => view('pages.community'))->name('community');
});

Route::get('/run-migrations', function () {
    try {
        // إغلاق أي اتصال مفتوح لتجنب تداخل العمليات الفاشلة
        DB::disconnect();

        // إجبار لارافل على استخدام الإعدادات الصحيحة يدوياً قبل التشغيل
        Config::set('database.connections.pgsql.host', 'ep-quiet-block-ai3hziv4.us-east-1.aws.neon.tech');
        Config::set('database.connections.pgsql.username', 'neondb_owner');
        Config::set('database.connections.pgsql.password', 'npg_LzBdQYk4DR1c');
        Config::set('database.connections.pgsql.database', 'neondb');
        Config::set('database.connections.pgsql.sslmode', 'require');
        
        // تشغيل الميغريشن
        Artisan::call('migrate:fresh', ['--force' => true]);
        
        return "تمت المهمة بنجاح! قاعدة البيانات جاهزة الآن.<br><pre>" . Artisan::output() . "</pre>";
    } catch (\Exception $e) {
        return "ما زال هناك خطأ: " . $e->getMessage();
    }
});