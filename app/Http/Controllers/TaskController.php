<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TaskNote; 
use App\Models\TaskAttachment; 

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

        // 1. جلب أعضاء المشروع أو المساحة
        if ($project) {
            $users = $project->users;
        } else {
            $users = $workspace->members;
        }

        // 2. الذكاء هنا: دمج "أنتِ" (الأدمن) مع القائمة لكي تظهري دائماً
        // نستخدم push لإضافة المستخدم الحالي، ثم unique لضمان عدم التكرار
        $users = $users->push($user)->unique('id');

        $projects = $workspace->projects;
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

        public function updateStatus(Request $request)
    {
        $task = \App\Models\Task::findOrFail($request->id);

        // الأمان الصارم: فقط صاحب المهمة هو من يحركها
        if ($task->assignee_id !== auth()->id()) {
            return response()->json(['success' => false, 'error' => 'Only the assignee can move this task.'], 403);
        }

        $task->update(['status' => $request->status]);
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
       public function show(Task $task)
{
    // جلب كل البيانات المرتبطة بالمهمة في طلب واحد لضمان السرعة (Eager Loading)
    $task->load(['project', 'assignee', 'notes.user', 'subtasks', 'attachments.user']);
    
    // جلب كل أعضاء المشروع لكي نتمكن من الإشارة إليهم أو رؤيتهم
    $users = $task->project->users;

    return view('tasks.show', compact('task', 'users'));
}


// app/Http/Controllers/TaskController.php

public function quickView(Task $task)
{
    $user = auth()->user();
    $isLeader = ($task->project->workspace->owner_id === $user->id);

    return response()->json([
        'title' => $task->title,
        'category' => $task->category,
        'notes' => $task->notes()->with('user')->get()->map(function($note) use ($isLeader) {
            return [
                'id' => $note->id,
                'content' => $note->content,
                'user_name' => $note->user->name,
                'is_mine' => $note->user_id === auth()->id(),
                'can_delete' => ($note->user_id === auth()->id() || $isLeader), // المالك أو الأدمن يحذف
                'time' => $note->created_at->diffForHumans()
            ];
        }),
        'attachments' => $task->attachments()->get()->map(function($file) {
            return [
                'name' => $file->file_name,
                'url' => asset('storage/' . $file->file_path),
                'type' => $file->file_type
            ];
        })
    ]);
}

public function storeNote(Request $request, Task $task)
{
    // السماح برفع نص أو ملف أو كلاهما
    if (!$request->content && !$request->hasFile('file')) {
        return response()->json(['success' => false], 422);
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

    return response()->json(['success' => true]);
}

public function destroyNote(TaskNote $note)
{
    // التأكد من الصلاحية: صاحب الملاحظة أو مدير المشروع
    if ($note->user_id === auth()->id() || $note->task->project->workspace->owner_id === auth()->id()) {
        $note->delete();
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false], 403);
}

    
}