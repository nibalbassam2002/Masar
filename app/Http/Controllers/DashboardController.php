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
        $workspace = $user->workspaces()->first();

        if (!$workspace) return redirect()->route('setup.workspace');

        $projectIds = $workspace->projects()->pluck('id');
        
        $totalProjects = $workspace->projects()->count();
        $activeTasks = \App\Models\Task::whereIn('project_id', $projectIds)->where('status', '!=', 'done')->count();
        $doneTasks = \App\Models\Task::whereIn('project_id', $projectIds)->where('status', 'done')->count();
        $teamCount = \DB::table('project_user')->whereIn('project_id', $projectIds)->distinct()->count('user_id') ?: 1;

        $stats = [
            ['label' => 'Total Projects', 'value' => $totalProjects, 'icon' => 'folder', 'color' => 'text-blue-500'],
            ['label' => 'Active Tasks', 'value' => $activeTasks, 'icon' => 'clock', 'color' => 'text-amber-500'],
            ['label' => 'Tasks Done', 'value' => $doneTasks, 'icon' => 'check-circle', 'color' => 'text-emerald-500'],
            ['label' => 'Team Members', 'value' => $teamCount, 'icon' => 'users', 'color' => 'text-indigo-500'],
        ];

        $recent_projects = $workspace->projects()->oldest()->take(5)->get();

        return view('dashboard', compact('stats', 'recent_projects', 'workspace'));
    }
}