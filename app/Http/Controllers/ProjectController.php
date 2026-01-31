<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Mail\ProjectInvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{

public function index(Request $request)
{
    $user = auth()->user();
    $filter = $request->query('filter', 'active');
    if ($user->isSuperAdmin()) {
        $query = Project::with('workspace');

        
        if ($filter == 'archived') {
            $query->where('status', 'archived');
        } else {
            $query->where('status', '!=', 'archived');
        }

        $ledProjects = $query->oldest()->paginate(12, ['*'], 'led_page');
        $participatingProjects = collect(); 

        return view('projects.index', compact('ledProjects', 'participatingProjects', 'filter'));
    }

    $workspace = $user->workspaces()->where('owner_id', $user->id)->first();
    
    if ($workspace) {
        $ledQuery = $workspace->projects();
        if ($filter == 'archived') {
            $ledQuery->where('status', 'archived');
        } else {
            $ledQuery->where('status', '!=', 'archived');
        }
        $ledProjects = $ledQuery->oldest()->paginate(12, ['*'], 'led_page');
    } else {
        $ledProjects = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 12);
    }

    $myWorkspaceId = $workspace ? $workspace->id : 0;
    $partQuery = $user->projects()->where('projects.workspace_id', '!=', $myWorkspaceId);
    
    if ($filter == 'archived') {
        $partQuery->where('status', 'archived');
    } else {
        $partQuery->where('status', '!=', 'archived');
    }
    
    $participatingProjects = $partQuery->oldest()->paginate(12, ['*'], 'part_page');

    return view('projects.index', compact('ledProjects', 'participatingProjects', 'filter'));
}

   public function store(Request $request) 
{
    $request->validate(['name' => 'required|string|max:255']);

    $user = auth()->user();

  
    $workspace = $user->workspaces()->first() 
                 ?? \App\Models\Workspace::where('owner_id', $user->id)->first();

  
    if (!$workspace) {
        return redirect()->route('setup.workspace')->with('error', 'Please setup a workspace first.');
    }


    $workspace->projects()->create([
        'name' => $request->name, 
        'description' => $request->description,
        'status' => 'active', 
        'progress' => 0
    ]);

    return back()->with('success', 'Project created successfully!');
}

    public function show(Project $project)
    {
      
        $project->load(['workspace.owner', 'tasks.assignees', 'users', 'workspace.taskCategories']);

        $user = auth()->user();
        $isLeader = ($project->workspace->owner_id === $user->id);
        
     
        $tasks = $project->tasks()->oldest()->get();
        $team = $project->users; 
        $users = \App\Models\User::all(); 

        $columns = [
            ['id' => 'todo', 'name' => 'Backlog', 'color' => 'bg-slate-400'],
            ['id' => 'in_progress', 'name' => 'In Progress', 'color' => 'bg-cyan-500'],
            ['id' => 'review', 'name' => 'Review', 'color' => 'bg-amber-400'],
            ['id' => 'done', 'name' => 'Completed', 'color' => 'bg-emerald-500'],
        ];

        return view('projects.show', compact('project', 'users', 'columns', 'tasks', 'isLeader', 'team'));
    }

    public function inviteMember(Request $request, Project $project)
    {
        $request->validate([
            'email' => 'required|email',
            'job_title' => 'required' 
        ]);

       
        $url = url('/register') . '?email=' . urlencode($request->email) . 
            '&project_id=' . $project->id . 
            '&job_title=' . urlencode($request->job_title);

        try {
            \Illuminate\Support\Facades\Mail::to($request->email)
                ->send(new \App\Mail\ProjectInvitationMail($project, $url));
            return back()->with('success', 'Invitation sent!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
public function acceptInvitation(Request $request, Project $project)
{
    $email = $request->query('email');
    $user = \App\Models\User::where('email', $email)->first();

    
    if (auth()->check() && auth()->user()->email === $email) {
        $project->users()->syncWithoutDetaching([auth()->id()]);
        $project->workspace->members()->syncWithoutDetaching([auth()->id() => ['role' => 'member']]);
        return redirect()->route('projects.show', $project->id)->with('success', 'Joined successfully!');
    }

   
    if ($user) {
        return redirect()->route('login', ['email' => $email, 'project_id' => $project->id])
                         ->with('info', 'Please login to join the project.');
    }

    
    return redirect()->route('register', ['email' => $email, 'project_id' => $project->id]);
}

public function archive(Project $project)
{
    if ($project->workspace->owner_id !== auth()->id() && !auth()->user()->isSuperAdmin()) {
        return back()->with('error', 'Unauthorized action.');
    }

    $project->update(['status' => 'archived']);
    // أرشفة المهام التابعة له أيضاً
    $project->tasks()->update(['status' => 'archived']);

    return back()->with('success', 'Project moved to archive.');
}

public function unarchive(Project $project)
{
    if ($project->workspace->owner_id !== auth()->id() && !auth()->user()->isSuperAdmin()) {
        return back()->with('error', 'Unauthorized action.');
    }

    $project->update(['status' => 'active']);
    // إعادة المهام لحالة النشاط
    $project->tasks()->update(['status' => 'todo']);

    return back()->with('success', 'Project restored successfully.');
}
public function analytics(Project $project)
{
    $user = auth()->user();

    if ($user->isSuperAdmin() || $project->workspace->owner_id === $user->id) {
        
        // جلب البيانات المطلوبة للرسومات البيانية
        $project->load(['tasks.assignees', 'tasks.creator', 'workspace.members', 'tasks.notes.user']);

        $allTasks = $project->tasks()->whereNull('parent_id')->get();
        $totalCount = $allTasks->count();
        $doneCount = $allTasks->where('status', 'done')->count();
        $progressCount = $allTasks->where('status', 'in_progress')->count();
        $todoCount = $allTasks->where('status', 'todo')->count();
        $reviewCount = $allTasks->where('status', 'review')->count();

        $overallProgress = $totalCount > 0 ? round(($doneCount / $totalCount) * 100) : 0;
        $overdueTasks = $allTasks->where('status', '!=', 'done')
                                 ->where('due_date', '<', now()->format('Y-m-d'))->count();

        $categoryStats = $allTasks->groupBy('category')->map(function($tasks, $category) use ($project) {
            $lead = $project->workspace->members()->wherePivot('role', 'lead')->wherePivot('job_title', $category)->first();
            $firstTask = $tasks->first();
            
            if ($lead) { $name = $lead->name; }
            elseif ($firstTask->assignees->isNotEmpty()) { $name = $firstTask->assignees->first()->name; }
            else { $name = $firstTask->creator?->name ?? 'System'; }

            return (object)[
                'category' => $category,
                'display_name' => $name,
                'total' => $tasks->count(),
                'done' => $tasks->where('status', 'done')->count(),
                'percent' => round(($tasks->where('status', 'done')->count() / $tasks->count()) * 100)
            ];
        });

        $recentActivity = \App\Models\TaskNote::whereHas('task', function($q) use ($project) {
            $q->where('project_id', $project->id);
        })->with('user', 'task')->latest()->take(10)->get();

        return view('projects.analytics', compact(
            'project', 'totalCount', 'doneCount', 'progressCount', 'todoCount', 'reviewCount',
            'overallProgress', 'categoryStats', 'recentActivity', 'overdueTasks'
        ));

    } else {
        abort(403, 'Unauthorized access.');
    }
}
}