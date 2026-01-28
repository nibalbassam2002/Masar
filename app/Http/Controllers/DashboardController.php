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
    
    // جلب كل المشاريع التي يشارك فيها المستخدم (سواء قائد أو عضو)
    $projects = \App\Models\Project::where(function($query) use ($user) {
        $query->whereHas('users', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->orWhereHas('workspace', function($q) use ($user) {
            $q->where('owner_id', $user->id);
        });
    })->get();

    $projectIds = $projects->pluck('id');
    
    $stats = [
        ['label' => 'Total Projects', 'value' => $projects->count(), 'icon' => 'folder', 'color' => 'text-blue-500'],
        ['label' => 'Active Tasks', 'value' => \App\Models\Task::whereIn('project_id', $projectIds)->where('status', '!=', 'done')->count(), 'icon' => 'clock', 'color' => 'text-amber-500'],
        ['label' => 'Tasks Done', 'value' => \App\Models\Task::whereIn('project_id', $projectIds)->where('status', 'done')->count(), 'icon' => 'check-circle', 'color' => 'text-emerald-500'],
        ['label' => 'Team Members', 'value' => \DB::table('project_user')->whereIn('project_id', $projectIds)->distinct()->count('user_id') ?: 1, 'icon' => 'users', 'color' => 'text-indigo-500'],
    ];

    $recent_projects = $projects->take(5);

    return view('dashboard', compact('stats', 'recent_projects'));
}
}