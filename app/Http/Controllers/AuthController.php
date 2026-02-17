<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

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
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return $this->handleJoiningProject($user, $request);
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            $user = auth()->user();

            return $this->handleJoiningProject($user, $request);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    private function handleJoiningProject($user, $request) {
     
        if ($user->isSuperAdmin()) {
            return redirect()->intended('dashboard');
        }

       
        if ($request->filled('project_id')) {
            $project = Project::find($request->project_id);
            
            if ($project) {
                $project->users()->syncWithoutDetaching([$user->id]);
                $project->workspace->members()->syncWithoutDetaching([
                    $user->id => ['role' => 'member']
                ]);

                return redirect()->route('projects.show', $project->id)
                                 ->with('success', 'You have joined ' . $project->name);
            }
        }

    
        if ($user->workspaces()->count() == 0 && !Workspace::where('owner_id', $user->id)->exists()) {
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
    // 1. توجيه المستخدم لصفحة جوجل
public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}

// 2. استقبال بيانات المستخدم من جوجل
public function handleGoogleCallback(Request $request)
{
    try {
        $googleUser = Socialite::driver('google')->user();
        
        // البحث عن المستخدم في قاعدتنا عن طريق الـ google_id أو الإيميل
        $user = User::where('google_id', $googleUser->id)
                    ->orWhere('email', $googleUser->email)
                    ->first();

        if ($user) {
            // إذا وجدناه، نحدث الـ google_id إذا لم يكن موجوداً
            $user->update(['google_id' => $googleUser->id]);
        } else {
            // إذا لم نجده، ننشئ مستخدماً جديداً
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => null, // لا يحتاج باسورد
            ]);
        }

        Auth::login($user);
        return $this->handleJoiningProject($user, $request);

    } catch (Exception $e) {
        return redirect('/login')->withErrors(['email' => 'Something went wrong with Google Login']);
    }
}
}