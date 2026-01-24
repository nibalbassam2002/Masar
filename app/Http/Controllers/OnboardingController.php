<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
   
    public function workspace()
    {
        return view('setup.workspace');
    }

   
    public function storeWorkspace(Request $request)
    {
        $request->validate(['workspace_name' => 'required|string|max:255']);
        session(['setup_workspace_name' => $request->workspace_name]);

        return redirect()->route('setup.team');
    }

    //  واجهة تخصص الفريق
    public function teamProfile()
    {
        return view('setup.team');
    }
    public function storeTeamProfile(Request $request)
{
    $workspace = auth()->user()->workspaces()->first();
    
    // تصنيفات مقترحة بناءً على الاختيار
    $defaults = match($request->team_type) {
        'development' => ['Frontend', 'Backend', 'QA / Testing'],
        'marketing'   => ['Content', 'Ads', 'Design'],
        default       => ['General', 'Admin'],
    };

    // حفظها في قاعدة البيانات فوراً
    foreach($defaults as $name) {
        $workspace->taskCategories()->create(['name' => $name]);
    }

    return redirect()->route('setup.project');
}

    public function project()
    {
        return view('setup.project');
    }

    
    public function storeProject(Request $request)
    {
        $user = auth()->user();

        // 1. إنشاء المساحة
        $workspace = \App\Models\Workspace::create([
            'name' => session('setup_workspace_name'),
            'owner_id' => $user->id,
        ]);

        // 2. الربط في الجدول الوسيط (هذا هو السطر الذي كان ينقصنا)
        $workspace->members()->attach($user->id, [
            'role' => 'admin',
            'job_title' => session('setup_team_type') ?? 'Owner'
        ]);

        // 3. إنشاء المشروع
        $workspace->projects()->create([
            'name' => $request->project_name,
            'status' => 'active',
        ]);

        session()->forget(['setup_workspace_name', 'setup_team_type']);
        return redirect()->route('dashboard');
    }
}