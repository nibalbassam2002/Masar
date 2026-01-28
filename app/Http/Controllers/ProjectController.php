<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Mail\ProjectInvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{

        public function index()
    {
        $user = auth()->user();

        // 1. مشاريع القيادة (التي أملك مساحتها)
        $workspace = $user->workspaces()->where('owner_id', $user->id)->first();
        
        // نستخدم paginate لضمان دعم التعدد الضخم (30 مشروع وأكثر) ولتجنب خطأ total()
        $ledProjects = $workspace 
            ? $workspace->projects()->oldest()->paginate(12, ['*'], 'led_page')
            : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 12);

        // 2. مشاريع المشاركة (التي دعيت إليها ولست المالك)
        $myWorkspaceId = $workspace ? $workspace->id : 0;
        $participatingProjects = $user->projects()
            ->where('workspace_id', '!=', $myWorkspaceId)
            ->oldest()
            ->paginate(12, ['*'], 'part_page');

        return view('projects.index', compact('ledProjects', 'participatingProjects'));
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
        $user = auth()->user();
        $isLeader = ($project->workspace->owner_id === $user->id);

        // الكل يرى كل المهام لضمان الشفافية كما طلبتِ
        $tasks = $project->tasks()->oldest()->get();
        
        // جلب كل أعضاء المشروع لرؤيتهم في القائمة
        $team = $project->users; 
        $users = \App\Models\User::all(); // للمودال فقط

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
    $request->validate(['email' => 'required|email']);

    // رابط ذكي جديد
    $url = route('invitation.accept', ['project' => $project->id, 'email' => $request->email]);

    try {
        \Illuminate\Support\Facades\Mail::to($request->email)
            ->send(new \App\Mail\ProjectInvitationMail($project, $url));

        return back()->with('success', 'Invitation link sent successfully!');
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
}