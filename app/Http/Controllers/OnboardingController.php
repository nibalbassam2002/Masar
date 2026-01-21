<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    // 1. واجهة اسم مساحة العمل
    public function workspace()
    {
        return view('setup.workspace');
    }

    // 2. حفظ اسم مساحة العمل
    public function storeWorkspace(Request $request)
    {
        $request->validate(['workspace_name' => 'required|string|max:255']);
        
        // سنقوم بحفظ البيانات في جلسة (Session) مؤقتاً حتى ننتهي من كل الخطوات
        session(['setup_workspace_name' => $request->workspace_name]);

        return redirect()->route('setup.team');
    }

    // 3. واجهة تخصص الفريق
    public function teamProfile()
    {
        return view('setup.team');
    }

    // 4. حفظ تخصص الفريق (هذه هي الدالة التي كانت ناقصة وتسببت بالخطأ)
    public function storeTeamProfile(Request $request)
    {
        $request->validate(['team_type' => 'required']);
        
        session(['setup_team_type' => $request->team_type]);

        return redirect()->route('setup.project');
    }

    // 5. واجهة إنشاء أول مشروع
    public function project()
    {
        return view('setup.project');
    }

    public function storeProject(Request $request)
    {
        $request->validate(['project_name' => 'required|string|max:255']);

        // 1. إنشاء مساحة العمل (Workspace) من بيانات الجلسة
        $workspace = \App\Models\Workspace::create([
            'name' => session('setup_workspace_name'),
            'owner_id' => auth()->id(),
        ]);

        // 2. إنشاء أول مشروع (Project)
        $workspace->projects()->create([
            'name' => $request->project_name,
            'status' => 'active', // الحالة الافتراضية
        ]);

        // 3. تنظيف الجلسة
        session()->forget(['setup_workspace_name', 'setup_team_type']);

        return redirect()->route('dashboard');
    }
}