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

    // 1. عرض المجموعات الشخصية فقط
public function settingsGroups()
{
    $workspace = $this->getWorkspace();
    $user = auth()->user();

    // جلب فقط المجموعات التي "أنا" أنشأتها في هذه المساحة
    $groups = $workspace->taskCategories()
                        ->where('creator_id', $user->id)
                        ->get(); 
    
    // الصفحة الآن مفتوحة للكل (لا يوجد isOwner هنا)
    return view('settings.groups', compact('workspace', 'groups'));
}

// 2. حفظ المجموعة مع ربطها بالمستخدم
public function storeGroup(Request $request)
{
    $request->validate(['name' => 'required|string|max:50']);
    
    $workspace = $this->getWorkspace();
    
    // إنشاء المجموعة مع إضافة id المستخدم الحالي كـ creator_id
    $workspace->taskCategories()->create([
        'name' => $request->name,
        'color' => '#06b6d4',
        'creator_id' => auth()->id() // هذا هو السر
    ]);

    return back()->with('success', 'Your personal work group added.');
}

    public function settingsMembers()
    {
        $workspace = $this->getWorkspace();
        $user = auth()->user();

        if ($workspace->owner_id !== $user->id) {
            return view('settings.members', ['workspace' => $workspace, 'members' => collect(), 'isOwner' => false]);
        }

        // جلب الأعضاء مع التأكيد على جلب job_title
        $members = $workspace->members()->withPivot('role', 'job_title')->get();

        // حساب المجموعات بناءً على التخصص (job_title)
        // ملاحظة: إذا كان الـ job_title فارغاً سيتم تجميعهم معاً ولن يظهروا كقادة
        $groupsCount = $members->groupBy(function($m) {
            return $m->pivot->job_title ?? 'no_group';
        })->map->count();

        foreach ($members as $member) {
            $title = $member->pivot->job_title;
            // القائد التلقائي: هو الشخص الوحيد الذي يملك هذا التخصص في الفريق
            $member->is_auto_lead = ($title && ($groupsCount[$title] ?? 0) === 1);
        }

        return view('settings.members', compact('workspace', 'members'))->with('isOwner', true);
    }
    public function updateMemberRole(Request $request, $userId)
    {
        $workspace = $this->getWorkspace();
        
        // التأكد أن المالك فقط من يغير الرتب
        if ($workspace->owner_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $workspace->members()->updateExistingPivot($userId, [
            'role' => $request->role // 'lead' or 'member'
        ]);

        return back()->with('success', 'Member role updated successfully.');
    }
    public function toggleLead(Request $request, $userId)
    {
        $workspace = $this->getWorkspace();
        $role = $request->is_lead ? 'lead' : 'member';
        
        $workspace->members()->updateExistingPivot($userId, ['role' => $role]);
        return back()->with('success', 'Member role updated.');
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
        public function updateMemberDepartment(Request $request, $userId)
    {
        $workspace = $this->getWorkspace();
        
        // التأكد أن المالك فقط من يملك الصلاحية
        if ($workspace->owner_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $request->validate(['job_title' => 'required|string']);

        // تحديث القسم في الجدول الوسيط
        $workspace->members()->updateExistingPivot($userId, [
            'job_title' => $request->job_title
        ]);

        return back()->with('success', 'Member department updated successfully.');
    }
}