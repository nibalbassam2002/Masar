<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    /**
     * تسجيل مستخدم جديد + الانضمام للمشروع إذا وجد رابط دعوة
     */
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // تنفيذ عملية الانضمام للمشروع إذا كان قادماً من رابط دعوة
        return $this->handleJoiningProject($user, $request);
    }

    /**
     * تسجيل دخول مستخدم قديم (مثل حالة هالة) + الانضمام للمشروع
     */
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            $user = auth()->user();

            // تنفيذ عملية الانضمام للمشروع حتى للمستخدم القديم
            return $this->handleJoiningProject($user, $request);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * وظيفة خاصة (Helper) للتعامل مع الانضمام التلقائي للمشاريع
     * صممتها لتعمل مع الـ Login والـ Register معاً
     */
    private function handleJoiningProject($user, $request) {
        // إذا كان الرابط يحتوي على رقم مشروع
        if ($request->filled('project_id')) {
            $project = Project::find($request->project_id);
            
            if ($project) {
                // 1. ربط المستخدم بالمشروع (جدول project_user)
                $project->users()->syncWithoutDetaching([$user->id]);
                
                // 2. ربط المستخدم بمساحة العمل (جدول workspace_user) لكي تظهر له في القائمة
                $project->workspace->members()->syncWithoutDetaching([
                    $user->id => ['role' => 'member']
                ]);

                // توجيهه مباشرة للمشروع الذي دُعي إليه لكي يراه فوراً
                return redirect()->route('projects.show', $project->id)
                                 ->with('success', 'You have joined ' . $project->name);
            }
        }

        // إذا لم تكن هناك دعوة، التوجه للداشبورد كالمعتاد
        // ملاحظة: إذا كان المستخدم جديداً وليس لديه مساحة عمل، يذهب للإعداد
        if ($user->workspaces()->count() == 0 && !\App\Models\Workspace::where('owner_id', $user->id)->exists()) {
             return redirect()->route('setup.workspace');
        }

        return redirect()->intended('dashboard');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}