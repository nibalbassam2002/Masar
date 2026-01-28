<?php

namespace App\Http\Controllers;

use App\Models\TaskCategory;
use App\Models\Workspace;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    
    private function getWorkspace()
    {
        $user = auth()->user();
        return $user->workspaces()->first() 
               ?? Workspace::where('owner_id', $user->id)->first();
    }

        public function settingsGroups()
    {
        $workspace = $this->getWorkspace();

        if (!$workspace) {
            return redirect()->route('setup.workspace');
        }

        $groups = $workspace->taskCategories()->get(); 
        
        return view('settings.groups', compact('workspace', 'groups'));
    }

    public function storeGroup(Request $request)
    {
        $request->validate(['name' => 'required|string|max:50']);
        
        $workspace = $this->getWorkspace();
        
        $workspace->taskCategories()->create([
            'name' => $request->name,
            'color' => '#06b6d4'
        ]);

        return back()->with('success', 'Work Group added successfully.');
    }

    public function settingsMembers()
    {
        $workspace = $this->getWorkspace();

        if (!$workspace) {
            return redirect()->route('setup.workspace');
        }

        $members = $workspace->members()->latest()->get();
        
        return view('settings.members', compact('workspace', 'members'));
    }

    public function inviteMember(Request $request)
{
    $request->validate(['email' => 'required|email', 'job_title' => 'required']);

    $workspace = $this->getWorkspace();
    
    // نحدد أي مشروع سيتم دعوته إليه (سنختار المشروع الأول في المساحة كمثال)
    $project = $workspace->projects()->first();

    if (!$project) {
        return back()->with('error', 'Please create a project first before inviting members.');
    }

    // توليد رابط التسجيل الذكي
    $url = url('/register') . '?email=' . urlencode($request->email) . '&project_id=' . $project->id;

    try {
        // إرسال الإيميل (هذا السطر هو الذي كان ينقصكِ هنا)
        \Illuminate\Support\Facades\Mail::to($request->email)
            ->send(new \App\Mail\ProjectInvitationMail($project, $url));

        // إذا كان المستخدم مسجلاً في الموقع أصلاً، نربطه فوراً
        $user = \App\Models\User::where('email', $request->email)->first();
        if ($user) {
            $project->users()->syncWithoutDetaching([$user->id]);
            // تحديث المسمى الوظيفي في الجدول الوسيط
            $workspace->members()->updateExistingPivot($user->id, ['job_title' => $request->job_title]);
        }

        return back()->with('success', 'Invitation link sent successfully to ' . $request->email);
    } catch (\Exception $e) {
        return back()->with('error', 'Mail Error: ' . $e->getMessage());
    }
}

    public function removeMember($userId)
    {
        $workspace = $this->getWorkspace();
        
        if($userId == auth()->id()) {
            return back()->with('error', 'You cannot remove yourself.');
        }

        $workspace->members()->detach($userId);
        return back()->with('success', 'Member removed.');
    }
}