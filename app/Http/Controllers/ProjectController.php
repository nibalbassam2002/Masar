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
    // جلب نوع الفلتر من الرابط، الافتراضي هو active
    $filter = $request->query('filter', 'active');

    // 1. مشاريع القيادة (التي أملك مساحتها)
    $workspace = $user->workspaces()->where('owner_id', $user->id)->first();
    
    if ($workspace) {
        $ledQuery = $workspace->projects();
        // تطبيق الفلتر
        if ($filter == 'archived') {
            $ledQuery->where('status', 'archived');
        } else {
            $ledQuery->where('status', '!=', 'archived');
        }
        $ledProjects = $ledQuery->oldest()->paginate(12, ['*'], 'led_page');
    } else {
        $ledProjects = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 12);
    }

    // 2. مشاريع المشاركة
    $myWorkspaceId = $workspace ? $workspace->id : 0;
    $partQuery = $user->projects()->where('workspace_id', '!=', $myWorkspaceId);
    
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

    // جلب المساحة بطريقة آمنة (عبر العلاقة أو عبر الـ owner_id مباشرة)
    $workspace = $user->workspaces()->first() 
                 ?? \App\Models\Workspace::where('owner_id', $user->id)->first();

    // إذا لم يجد مساحة، لا يمكن إنشاء مشروع، نوجهه للإعداد
    if (!$workspace) {
        return redirect()->route('setup.workspace')->with('error', 'Please setup a workspace first.');
    }

    // الآن ننشئ المشروع بسلام
    $workspace->projects()->create([
        'name' => $request->name, 
        'description' => $request->description, // أضفت الوصف ليكون كاملاً
        'status' => 'active', 
        'progress' => 0
    ]);

    return back()->with('success', 'Project created successfully!');
}

    public function show(Project $project)
    {
        // أضفنا tasks.assignees بدلاً من tasks.assignee
        $project->load(['workspace.owner', 'tasks.assignees', 'users', 'workspace.taskCategories']);

        $user = auth()->user();
        $isLeader = ($project->workspace->owner_id === $user->id);
        
        // جلب المهام المرتبطة بالمشروع فقط
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
            'job_title' => 'required' // أضفنا هذا الفاليديشن
        ]);

        // نضع التخصص في الرابط لكي يُحفظ عند التسجيل
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

    // حالة 1: هالة مسجلة دخول أصلاً
    if (auth()->check() && auth()->user()->email === $email) {
        $project->users()->syncWithoutDetaching([auth()->id()]);
        $project->workspace->members()->syncWithoutDetaching([auth()->id() => ['role' => 'member']]);
        return redirect()->route('projects.show', $project->id)->with('success', 'Joined successfully!');
    }

    // حالة 2: هالة تملك حساباً ولكنها لم تسجل دخولها
    if ($user) {
        return redirect()->route('login', ['email' => $email, 'project_id' => $project->id])
                         ->with('info', 'Please login to join the project.');
    }

    // حالة 3: هالة مستخدمة جديدة تماماً
    return redirect()->route('register', ['email' => $email, 'project_id' => $project->id]);
}
/**
 * أرشفة المشروع بالكامل (بما فيه من مهام)
 */
public function archive(Project $project)
{
    // 1. التأكد أن صاحب المساحة هو من يقوم بالأرشفة
    if ($project->workspace->owner_id !== auth()->id()) {
        return back()->with('error', 'Only the Project Owner can archive this project.');
    }

    // 2. تحديث حالة المشروع إلى مؤرشف
    $project->update(['status' => 'archived']);

    // 3. ذكاء الأرشفة الشاملة: أرشفة كل المهام التابعة لهذا المشروع (أساسية وفرعية)
    // نستخدم update(['status' => 'archived']) لتجميد كل المهام فوراً
    $project->tasks()->update(['status' => 'archived']);

    return redirect()->route('projects.index', ['filter' => 'archived'])
                     ->with('success', 'Project and all its tasks have been suspended.');
}

/**
 * استعادة المشروع والمهام للحالة النشطة
 */
public function unarchive(Project $project)
{
    // 1. التأكد من الصلاحية
    if ($project->workspace->owner_id !== auth()->id()) {
        return back()->with('error', 'Unauthorized action.');
    }

    // 2. إعادة المشروع للحالة النشطة
    $project->update(['status' => 'active']);

    // 3. إعادة كل المهام التابعة له لحالة "todo" لكي تظهر في الكانبان مجدداً
    $project->tasks()->update(['status' => 'todo']);

    return redirect()->route('projects.index')->with('success', 'Project and tasks restored to active list.');
}
public function analytics(Project $project)
{
    if (auth()->id() !== $project->workspace->owner_id) {
        abort(403, 'Unauthorized. Only the Project Owner can access analytics.');
    }

    $project->load(['tasks.assignees', 'users', 'workspace.members', 'tasks.notes.user']);
    $user = auth()->user();
    if ($project->workspace->owner_id !== $user->id) { return abort(403); }

    $project->load(['tasks.assignees', 'tasks.creator', 'workspace.members']);

    // 1. الحسابات العامة (المهام الكبيرة فقط)
    $allTasks = $project->tasks()->whereNull('parent_id')->get();
    $totalCount = $allTasks->count();
    
    $doneCount = $allTasks->where('status', 'done')->count();
    $progressCount = $allTasks->where('status', 'in_progress')->count();
    $todoCount = $allTasks->where('status', 'todo')->count();
    $reviewCount = $allTasks->where('status', 'review')->count();

    // نسبة الإنجاز الكلية
    $overallProgress = $totalCount > 0 ? round(($doneCount / $totalCount) * 100) : 0;
    
    // المواعيد المتأخرة
    $overdueTasks = $allTasks->where('status', '!=', 'done')
                             ->where('due_date', '<', now()->format('Y-m-d'))->count();

    // 2. توزيع الأقسام (تجميع ذكي)
    $categoryStats = $allTasks->groupBy('category')->map(function($tasks, $category) use ($project) {
        $lead = $project->workspace->members()->wherePivot('role', 'lead')->wherePivot('job_title', $category)->first();
        $firstTask = $tasks->first();
        
        // تحديد الاسم (قائد > مكلف > منشئ)
        if ($lead) { $name = $lead->name; }
        elseif ($firstTask->assignees->isNotEmpty()) { $name = $firstTask->assignees->first()->name; }
        else { $name = $firstTask->creator->name; }

        return (object)[
            'category' => $category,
            'display_name' => $name,
            'total' => $tasks->count(),
            'done' => $tasks->where('status', 'done')->count(),
            'percent' => round(($tasks->where('status', 'done')->count() / $tasks->count()) * 100)
        ];
    });

    // 3. نبض المشروع (التعليقات)
    $recentActivity = \App\Models\TaskNote::whereHas('task', function($q) use ($project) {
        $q->where('project_id', $project->id);
    })->with('user', 'task')->latest()->take(10)->get();

    return view('projects.analytics', compact(
        'project', 'totalCount', 'doneCount', 'progressCount', 'todoCount', 'reviewCount',
        'overallProgress', 'categoryStats', 'recentActivity', 'overdueTasks'
    ));
}
}