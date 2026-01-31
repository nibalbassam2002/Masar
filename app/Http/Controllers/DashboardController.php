<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workspace;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->isSuperAdmin()) {
            $isOwner = true;
            $workspace = (object)['name' => 'Global Control Hub', 'owner_id' => $user->id];
            
            $managedProjects = Project::with('workspace')->latest()->get();
            $participatingProjects = collect(); 
            $managedProjectIds = $managedProjects->pluck('id');

            $activeCount = Task::whereNull('parent_id')->whereNotIn('status', ['done', 'archived'])->count();
            $doneCount = Task::whereNull('parent_id')->where('status', 'done')->count();
            
            $criticalMissions = Task::whereNull('parent_id')
                ->whereNotIn('status', ['done', 'archived'])
                ->where(function($q) {
                    $q->where('due_date', '<', now())->orWhere('priority', 'urgent');
                })->with('project')->latest()->take(3)->get();

            $teamWorkload = User::withCount(['tasks' => function($q) {
                $q->whereNotIn('status', ['done', 'archived']);
            }])->orderBy('tasks_count', 'desc')->take(6)->get();
            
            foreach($teamWorkload as $member) {
                $member->active_tasks_count = $member->tasks_count;
            }

           
            $workspaceGroups = Task::whereNull('parent_id')
                ->select('category', DB::raw('count(*) as count'))
                ->groupBy('category')->get();

            return view('dashboard', compact(
                'workspace', 'isOwner', 'managedProjects', 'participatingProjects', 
                'criticalMissions', 'teamWorkload', 'activeCount', 'doneCount', 'workspaceGroups'
            ));
        }

      
        $workspace = $user->workspaces()->first() ?? Workspace::where('owner_id', $user->id)->first();

        if (!$workspace) { 
            return redirect()->route('setup.workspace'); 
        }

        $isOwner = ($workspace->owner_id === $user->id);
        
        $managedProjects = Project::whereHas('workspace', function($q) use ($user) {
            $q->where('owner_id', $user->id);
        })->orWhereHas('users', function($q) use ($user) {
            $q->where('user_id', $user->id)->where('project_user.role', 'lead'); 
        })->get();

        $managedProjectIds = $managedProjects->pluck('id');

        $participatingProjects = $user->projects()
            ->whereNotIn('projects.id', $managedProjectIds)
            ->get();

        $teamWorkload = collect();
        if ($isOwner) {
            $teamWorkload = $workspace->members()->withPivot('job_title')->get();
            $teamWorkload->push($workspace->owner);
            $teamWorkload = $teamWorkload->unique('id');

            foreach($teamWorkload as $member) {
                $member->active_tasks_count = Task::whereHas('assignees', function($q) use ($member) {
                    $q->where('user_id', $member->id);
                })
                ->whereIn('project_id', $managedProjectIds)
                ->whereNotIn('status', ['done', 'archived'])
                ->count();
            }
        }

        $activeCount = Task::whereIn('project_id', $managedProjectIds)->whereNotIn('status', ['done', 'archived'])->count();
        $doneCount = Task::whereIn('project_id', $managedProjectIds)->where('status', 'done')->count();
        
        $criticalMissions = Task::whereNull('parent_id')
    ->whereHas('project') 
    ->whereNotIn('status', ['done', 'archived'])
    ->where(function($q) {
        $q->where('due_date', '<', now())->orWhere('priority', 'urgent');
    })
    ->with('project') 
    ->latest()
    ->take(3)
    ->get();

        $workspaceGroups = Task::whereIn('project_id', $managedProjectIds)
            ->whereNull('parent_id')
            ->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')->get();

        return view('dashboard', compact(
            'workspace', 'isOwner', 'managedProjects', 'participatingProjects', 
            'criticalMissions', 'teamWorkload', 'activeCount', 'doneCount', 'workspaceGroups'
        ));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $user = auth()->user();

        if (empty($query)) return response()->json(['projects' => [], 'tasks' => []]);

        $projectsQuery = \App\Models\Project::where('name', 'like', "%{$query}%");
        if (!$user->isSuperAdmin()) {
            $projectsQuery->whereHas('workspace', fn($q) => $q->where('owner_id', $user->id))
                        ->orWhereHas('users', fn($q) => $q->where('user_id', $user->id));
        }
        $projects = $projectsQuery->take(5)->get(['id', 'name']);

        $tasksQuery = \App\Models\Task::where('title', 'like', "%{$query}%")->whereNull('parent_id');
        if (!$user->isSuperAdmin()) {
            $tasksQuery->where(fn($q) => 
                $q->whereHas('assignees', fn($inner) => $inner->where('user_id', $user->id))
                ->orWhere('creator_id', $user->id)
            );
        }
        $tasks = $tasksQuery->take(5)->get(['id', 'title']);

        return response()->json([
            'projects' => $projects,
            'tasks' => $tasks
        ]);
    }
}