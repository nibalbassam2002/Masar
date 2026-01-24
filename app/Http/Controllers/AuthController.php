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
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        //  إنشاء المستخدم الجديد
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //  تسجيل الدخول تلقائياً
        Auth::login($user);

        if ($request->filled('project_id')) {
            $project = Project::find($request->project_id);
            if ($project) {
                // ربط الموظف الجديد بالمشروع فوراً
                $project->users()->syncWithoutDetaching([$user->id]);

                // التوجيه لصفحة المشروع مع رسالة ترحيب
                return redirect()->route('projects.show', $project->id)
                    ->with('success', 'Welcome to the team! You have joined ' . $project->name);
            }
        }

        return redirect()->route('setup.workspace');
    }

    /**
     * معالجة عملية الدخول
     */
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            // التوجيه للداشبورد أو الصفحة التي كان يحاول دخولها
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * الخروج الآمن وتصفير الجلسة
     */
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}