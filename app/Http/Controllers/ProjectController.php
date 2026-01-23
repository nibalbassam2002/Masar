<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\Workspace;
use App\Models\Task;
use App\Mail\ProjectInvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class ProjectController extends Controller
{
    /**
     * عرض قائمة المشاريع مرتبة بالأقدم أولاً (حسب طلبك)
     */
    public function index()
    {
        $user = Auth::user();
        $workspace = $user->workspaces()->first();
        
        $projects = $workspace ? $workspace->projects()->oldest()->get() : collect([]);

        return view('projects.index', compact('projects', 'workspace'));
    }

    /**
     * حفظ مشروع جديد من المودال
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $workspace = Auth::user()->workspaces()->first();

        $workspace->projects()->create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'active',
            'progress' => 0,
        ]);

        return back()->with('success', 'Project created successfully!');
    }

    /**
     * عرض لوحة الكانبان الخاصة بالمشروع
     */
    public function show(Project $project)
    {
        $users = User::all();

        $columns = [
            ['id' => 'todo', 'name' => 'Backlog', 'color' => 'bg-slate-400'],
            ['id' => 'in_progress', 'name' => 'In Progress', 'color' => 'bg-cyan-500'],
            ['id' => 'review', 'name' => 'Review', 'color' => 'bg-amber-400'],
            ['id' => 'done', 'name' => 'Completed', 'color' => 'bg-emerald-500'],
        ];

        return view('projects.show', compact('project', 'users', 'columns'));
    }

    /**
     * عرض صفحة إنشاء مهمة جديدة (ببيانات ديناميكية)
     */
    public function createTask(Project $project)
    {
        $users = User::all();
        $workspace = Auth::user()->workspaces()->first();

        // منطق الأقسام الذكي حسب نوع الصناعة
        $categories = match($workspace->industry ?? 'development') {
            'development', 'software' => ['Frontend', 'Backend', 'QA / Testing', 'DevOps', 'UI/UX Design'],
            'marketing' => ['SEO', 'Content Writing', 'Social Media', 'Ads Campaign', 'Graphic Design'],
            'business'  => ['Sales', 'HR', 'Finance', 'Legal', 'Operations'],
            default     => ['General', 'Planning', 'Urgent'],
        };

        return view('tasks.create', compact('project', 'users', 'categories'));
    }

    /**
     * حفظ المهمة الجديدة في قاعدة البيانات
     */
    public function storeTask(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'assignee_id' => 'required|exists:users,id',
            'category' => 'required',
            'priority' => 'required'
        ]);

        $project->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'assignee_id' => $request->assignee_id,
            'category' => $request->category,
            'priority' => $request->priority,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'estimated_hours' => $request->estimated_hours,
            'creator_id' => Auth::id(),
            'status' => 'todo'
        ]);

        return redirect()->route('projects.show', $project->id)
                         ->with('success', 'Task has been successfully assigned.');
    }

    /**
     * تحديث حالة المهمة عند السحب والإفلات (AJAX)
     */
    public function updateTaskStatus(Request $request)
    {
        $task = Task::findOrFail($request->id);
        $task->status = $request->status;
        $task->save();

        // تحديث نسبة إنجاز المشروع تلقائياً
        $project = $task->project;
        $total = $project->tasks()->count();
        $done = $project->tasks()->where('status', 'done')->count();
        $project->progress = ($total > 0) ? round(($done / $total) * 100) : 0;
        $project->save();

        return response()->json(['success' => true]);
    }
public function inviteMember(Request $request, Project $project)
{
    $request->validate(['email' => 'required|email']);

    // توليد الرابط الذكي
    $url = url('/register') . '?email=' . urlencode($request->email) . '&project_id=' . $project->id;

    try {
        // نمرر الـ $project والـ $url هنا بالترتيب
        \Illuminate\Support\Facades\Mail::to($request->email)
            ->send(new \App\Mail\ProjectInvitationMail($project, $url));

        return back()->with('success', 'Invitation link sent successfully!');
        
    } catch (\Exception $e) {
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
}

    /**
     * معالجة الضغط على رابط "Join Workspace" في الإيميل
     */
    public function acceptInvitation(Request $request, Project $project, $email)
    {
        if (!Auth::check()) {
            return redirect()->route('register', ['email' => $email, 'project_id' => $project->id]);
        }

        if (Auth::user()->email !== $email) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized invitation access.');
        }

        $project->users()->syncWithoutDetaching([Auth::id()]);

        return redirect()->route('projects.show', $project->id)->with('success', 'Welcome to the project!');
    }
}