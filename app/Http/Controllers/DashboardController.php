<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workspace;
use App\Models\Project;

class DashboardController extends Controller
{
public function index()
{
    $user = auth()->user();
    $workspace = $user->workspaces()->first() ?? \App\Models\Workspace::where('owner_id', $user->id)->first();

    if (!$workspace) { return redirect()->route('setup.workspace'); }

    $isOwner = ($workspace->owner_id === $user->id);
    
    // 1. مشاريع القيادة 
    $managedProjects = \App\Models\Project::whereHas('workspace', function($q) use ($user) {
        $q->where('owner_id', $user->id);
    })->orWhereHas('users', function($q) use ($user) {
        $q->where('user_id', $user->id)->where('project_user.role', 'lead'); 
    })->get();

    $managedProjectIds = $managedProjects->pluck('id');

    // 2. المشاريع المشاركة
    $participatingProjects = $user->projects()
        ->whereNotIn('projects.id', $managedProjectIds)
        ->get();

    // 3. منطق الفريق وحمل العمل (للقائد فقط)
    $teamWorkload = collect();
    if ($isOwner) {
        // جلب المالك والأعضاء في مجموعة واحدة فريدة بدون تكرار
        $teamWorkload = $workspace->members()->withPivot('job_title')->get();
        $teamWorkload->push($workspace->owner);
        $teamWorkload = $teamWorkload->unique('id');

        // حساب عدد المهام النشطة لكل عضو في مشاريع هذه المساحة
        foreach($teamWorkload as $member) {
            $member->active_tasks_count = \App\Models\Task::whereHas('assignees', function($q) use ($member) {
                $q->where('user_id', $member->id);
            })
            ->whereIn('project_id', $managedProjectIds)
            ->whereNotIn('status', ['done', 'archived'])
            ->count();
        }
    }

    // 4. إحصائيات عامة
    $activeCount = \App\Models\Task::whereIn('project_id', $managedProjectIds)->whereNotIn('status', ['done', 'archived'])->count();
    $doneCount = \App\Models\Task::whereIn('project_id', $managedProjectIds)->where('status', 'done')->count();
    
    // 5. المهام الحرجة
    $criticalMissions = \App\Models\Task::whereIn('project_id', $managedProjectIds->merge($participatingProjects->pluck('id')))
        ->whereNotIn('status', ['done', 'archived'])
        ->where(function($q) {
            $q->where('due_date', '<', now())->orWhere('priority', 'urgent');
        })->take(3)->get();

    return view('dashboard', compact(
        'workspace', 'isOwner', 'managedProjects', 'participatingProjects', 
        'criticalMissions', 'teamWorkload', 'activeCount', 'doneCount'
    ));
}
}