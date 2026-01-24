<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Mail\ProjectInvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{
    public function index() {
        $workspace = auth()->user()->workspaces()->first();
        $projects = $workspace ? $workspace->projects()->oldest()->get() : collect([]);
        return view('projects.index', compact('projects'));
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string|max:255']);
        $workspace = auth()->user()->workspaces()->first();
        $workspace->projects()->create(['name' => $request->name, 'status' => 'active', 'progress' => 0]);
        return back()->with('success', 'Project created!');
    }

    public function show(Project $project) {
        $users = User::all();
        $columns = [
            ['id' => 'todo', 'name' => 'Backlog', 'color' => 'bg-slate-400'],
            ['id' => 'in_progress', 'name' => 'In Progress', 'color' => 'bg-primary-500'],
            ['id' => 'review', 'name' => 'In Review', 'color' => 'bg-amber-400'],
            ['id' => 'done', 'name' => 'Completed', 'color' => 'bg-emerald-500'],
        ];
        return view('projects.show', compact('project', 'users', 'columns'));
    }

    public function inviteMember(Request $request, Project $project) {
        $url = url('/register') . '?email=' . urlencode($request->email) . '&project_id=' . $project->id;
        Mail::to($request->email)->send(new ProjectInvitationMail($project, $url));
        return back()->with('success', 'Invitation sent!');
    }
}