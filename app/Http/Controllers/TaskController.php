<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\TaskNote;
use App\Models\TaskAttachment;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
{
    $user = auth()->user();
    $filter = $request->query('filter', 'active');
    $query = Task::with(['project.workspace', 'assignees'])
        ->whereNull('parent_id') 
        ->where(function($q) use ($user) {
            $q->whereHas('assignees', function($inner) use ($user) {
                $inner->where('user_id', $user->id);
            })
            ->orWhere('assignee_id', $user->id)
            ->orWhereHas('project.workspace', function($w) use ($user) {
                $w->where('owner_id', $user->id);
            });
        });

   
    if ($filter == 'completed') {
       
        $query->where('status', 'done');
    } elseif ($filter == 'archived') {
       
        $query->where('status', 'archived');
    } else {
       
        $query->whereNotIn('status', ['done', 'archived']);
    }

    $tasks = $query->latest()->get();

    return view('tasks.index', compact('tasks', 'filter'));
}

    public function create(Project $project = null)
    {
        $user = auth()->user();
        $ownedWorkspace = \App\Models\Workspace::where('owner_id', $user->id)->first();
        $projects = Project::whereHas('workspace', function($q) use ($user) {
            $q->where('owner_id', $user->id);
        })->get();

        if ($ownedWorkspace) {
            $users = $ownedWorkspace->members()->withPivot('job_title')->get();
        } else {
            $users = collect([$user]); 
        }

        $users = $users->push($user)->unique('id');
        $taskCategories = \App\Models\TaskCategory::where('creator_id', $user->id)->get();
        $workspace = $ownedWorkspace ?? $user->workspaces()->first();

        return view('tasks.create', compact('project', 'projects', 'users', 'workspace', 'taskCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'title' => 'required|string|max:255',
            'assignee_ids' => 'required|array',
        ]);

        $task = Task::create([
            'project_id' => $request->project_id,
            'title' => $request->title,
            'description' => $request->description,
            'creator_id' => auth()->id(),
            'status' => 'todo',
            'category' => $request->category,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
        ]);

        $task->assignees()->attach($request->assignee_ids);
        return redirect()->route('projects.show', $request->project_id)->with('success', 'Mission assigned!');
    }

    public function show(Task $task)
    {
        $task->load(['project.workspace', 'assignees', 'notes.user', 'subtasks.assignees', 'attachments', 'parent']);
        $user = auth()->user();
        $isWorkspaceOwner = ($task->project->workspace->owner_id === $user->id);
        $isSubTaskOwner = $task->assignees->contains($user->id);

        
        if ($task->parent_id) {
            return view('tasks.subtask_view', compact('task', 'isSubTaskOwner', 'isWorkspaceOwner'));
        }


        $userWorkspaceInfo = $task->project->workspace->members()->where('user_id', $user->id)->first();
        $roleInWorkspace = $userWorkspaceInfo ? $userWorkspaceInfo->pivot->role : 'member';
        $userDept = $userWorkspaceInfo ? $userWorkspaceInfo->pivot->job_title : '';
        $isLead = ($roleInWorkspace === 'lead' && strtolower($userDept) === strtolower($task->category));
        
        $canManageBreakdown = $isWorkspaceOwner || $isLead;
        $teamMembers = $task->project->workspace->members()->wherePivot('job_title', $task->category)->get();

        return view('tasks.show', compact('task', 'canManageBreakdown', 'teamMembers', 'isWorkspaceOwner'));
    }

    public function updateStatus(Request $request)
    {
        $task = Task::findOrFail($request->id);
        $user = auth()->user();

        
        if ($task->parent_id) {
            if (!$task->assignees->contains($user->id) && $task->project->workspace->owner_id !== $user->id) {
                return response()->json(['success' => false, 'error' => 'Only the assignee can close this step.'], 403);
            }
        }

        $task->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }

    public function storeSubTask(Request $request, Task $task)
    {
        $request->validate(['title' => 'required|string', 'assignee_id' => 'required|exists:users,id']);

        $subTask = $task->subtasks()->create([
            'project_id' => $task->project_id,
            'title' => $request->title,
            'creator_id' => auth()->id(),
            'status' => 'todo',
            'category' => $task->category,
            'due_date' => $task->due_date,
            'priority' => 'medium'
        ]);

        $subTask->assignees()->attach($request->assignee_id);
        return back()->with('success', 'Sub-task delegated!');
    }

    public function storeNote(Request $request, Task $task)
{
    
    if (!$request->content && !$request->hasFile('file')) {
        return back()->with('error', 'Please provide either a message or a file.');
    }


    if ($request->content) {
        $task->notes()->create([
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);
    }


    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('attachments', 'public');
        $task->attachments()->create([
            'user_id' => auth()->id(),
            'file_path' => $path,
            'file_name' => $request->file('file')->getClientOriginalName(),
            'file_type' => $request->file('file')->getClientOriginalExtension(),
        ]);
    }

    return back()->with('success', 'Update submitted successfully!');
}

public function archive(Task $task)
{
    $user = auth()->user();
    $workspace = $task->project->workspace;
    $isSubTask = !is_null($task->parent_id);

    $userWorkspaceInfo = $workspace->members()->where('user_id', $user->id)->first();
    $role = $userWorkspaceInfo ? $userWorkspaceInfo->pivot->role : 'member';
    $userDept = $userWorkspaceInfo ? $userWorkspaceInfo->pivot->job_title : '';

    $isWorkspaceOwner = ($workspace->owner_id === $user->id);
    
    if ($isSubTask) {
        $isActualLead = ($role === 'lead' && strtolower($userDept) === strtolower($task->category));
        if (!$isActualLead && !$isWorkspaceOwner) {
            return back()->with('error', 'Only Section Leads can archive sub-tasks.');
        }
    } else {
        if (!$isWorkspaceOwner) {
            return back()->with('error', 'Only the Workspace Owner can archive main tasks.');
        }
    }

    $task->update(['status' => 'archived']);

    return back()->with('success', 'Task has been archived and suspended.');
}

public function unarchive(Task $task)
{
    $user = auth()->user();
    $workspace = $task->project->workspace;
    $isSubTask = !is_null($task->parent_id);

    $userWorkspaceInfo = $workspace->members()->where('user_id', $user->id)->first();
    $role = $userWorkspaceInfo ? $userWorkspaceInfo->pivot->role : 'member';
    $userDept = $userWorkspaceInfo ? $userWorkspaceInfo->pivot->job_title : '';
    $isWorkspaceOwner = ($workspace->owner_id === $user->id);

    if ($isSubTask) {
        $isActualLead = ($role === 'lead' && strtolower($userDept) === strtolower($task->category));
        if (!$isActualLead && !$isWorkspaceOwner) {
            return back()->with('error', 'Only Section Leads can restore sub-tasks.');
        }
    } else {
        if (!$isWorkspaceOwner) {
            return back()->with('error', 'Only the Workspace Owner can restore main tasks.');
        }
    }

    $task->update(['status' => 'todo']);

    return back()->with('success', 'Task has been restored to active list.');
}
public function edit(Task $task)
{
    $user = auth()->user();
    $workspace = $task->project->workspace;

    $users = $workspace->members()->withPivot('job_title')->get();
    $users = $users->push($workspace->owner)->unique('id');

    $taskCategories = \App\Models\TaskCategory::where('creator_id', $user->id)->get();

    $currentAssigneeIds = $task->assignees->pluck('id')->toArray();

    return view('tasks.edit', compact('task', 'users', 'taskCategories', 'workspace', 'currentAssigneeIds'));
}

public function update(Request $request, Task $task)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'assignee_ids' => 'required|array',
        'due_date' => 'required|date',
        'start_date' => 'nullable|date', 
    ]);

    $task->update([
        'title' => $request->title,
        'description' => $request->description,
        'category' => $request->category,
        'start_date' => $request->start_date, 
        'due_date' => $request->due_date,
        'priority' => $request->priority,
    ]);

    $task->assignees()->sync($request->assignee_ids);

    return redirect()->route('tasks.index')->with('success', 'Mission timeline and details updated!');
}
 public function destroy(Task $task)
    {
        if ($task->project->workspace->owner_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized deletion.');
        }

        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted permanently.');
    }
}