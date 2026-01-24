<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
       
        $filter = $request->query('filter', 'active');

        $query = \App\Models\Task::where('assignee_id', $user->id)
                    ->whereNull('parent_id')
                    ->with('project');

        // منطق الفلترة
        if ($filter == 'completed') {
            $query->where('status', 'done');
        } else {
            $query->where('status', '!=', 'done');
        }

        $tasks = $query->latest()->get();

        return view('tasks.index', compact('tasks', 'filter'));
    }

public function create(Project $project = null) 
{
    $user = auth()->user();
    
    $workspace = $user->workspaces()->first() 
                 ?? \App\Models\Workspace::where('owner_id', $user->id)->first();

    if (!$workspace) {
        return redirect()->route('setup.workspace');
    }

    $projects = $project ? collect([$project]) : $workspace->projects;
    $users = \App\Models\User::all();
    
    $taskCategories = $workspace->taskCategories;

    return view('tasks.create', compact('project', 'projects', 'users', 'workspace', 'taskCategories'));
}

    /**
     * حفظ المهمة الجديدة
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'assignee_id' => 'required|exists:users,id',
            'priority' => 'required'
        ]);

        Task::create(array_merge($request->all(), [
            'creator_id' => auth()->id(),
            'status' => 'todo'
        ]));

        return redirect()->route('projects.show', $request->project_id)
                         ->with('success', 'Task assigned successfully.');
    }

    public function edit(Task $task)
{
    $user = auth()->user();
    $workspace = $user->workspaces()->first();
    
    $taskCategories = $workspace->taskCategories; 
    
    $users = \App\Models\User::all();

    return view('tasks.edit', compact('task', 'users', 'taskCategories'));
}


public function update(Request $request, Task $task)
{
    // 1. تحديث المهمة الأساسية
    $task->update($request->all());

    // 2. تحديث المهام الفرعية (منطق بشري: نحذف القديم ونضيف الجديد لتسهيل العملية)
    if ($request->has('subtasks')) {
        // حذف المهام الفرعية القديمة لتعويضها بالجديدة
        $task->subtasks()->delete(); 
        
        foreach ($request->subtasks as $subTitle) {
            if (!empty($subTitle)) {
                $task->subtasks()->create([
                    'project_id' => $task->project_id,
                    'title' => $subTitle,
                    'creator_id' => auth()->id(),
                    'assignee_id' => $task->assignee_id,
                    'category' => $task->category,
                    'status' => 'todo'
                ]);
            }
        }
    }

    // 3. التوجيه المطلوب: العودة لقائمة المهام (Tasks List)
    return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
}

    /**
     * حذف المهمة
     */
    public function destroy(Task $task)
    {
        $projectId = $task->project_id;
        $task->delete();
        return redirect()->route('projects.show', $projectId)
                         ->with('success', 'Task has been removed.');
    }

    /**
     * تحديث الحالة (Drag & Drop)
     */
    public function updateStatus(Request $request)
    {
        $task = Task::findOrFail($request->id);
        $task->update(['status' => $request->status]);

        // تحديث بروجرس المشروع تلقائياً
        $project = $task->project;
        $total = $project->tasks()->count();
        $done = $project->tasks()->where('status', 'done')->count();
        $project->update(['progress' => ($total > 0) ? round(($done / $total) * 100) : 0]);

        return response()->json(['success' => true]);
    }

    /**
     * وظيفة مساعدة لجلب الأقسام بذكاء
     */
    private function getSmartCategories($workspace)
    {
        return match($workspace->industry ?? 'development') {
            'development', 'software' => ['Frontend', 'Backend', 'QA', 'DevOps', 'UI/UX'],
            'marketing' => ['SEO', 'Content', 'Social Media', 'Design'],
            'business'  => ['Sales', 'HR', 'Finance', 'Ops'],
            default     => ['General', 'Urgent', 'Admin'],
        };
    }
        public function show(\App\Models\Task $task)
    {
        // جلب المهمة مع أبنائها (السب تاسك)
        $task->load('subtasks'); 
        return view('tasks.show', compact('task'));
    }
}