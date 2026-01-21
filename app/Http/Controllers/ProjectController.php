<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Workspace;

class ProjectController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $workspace = $user->workspaces()->first();
    
    // التعديل هنا: نستخدم oldest() بدلاً من latest()
    $projects = $workspace ? $workspace->projects()->oldest()->get() : collect([]);

    return view('projects.index', compact('projects', 'workspace'));
}

    // حفظ مشروع جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $workspace = auth()->user()->workspaces()->first();

        $workspace->projects()->create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'active',
            'progress' => 0,
        ]);

        return back()->with('success', 'Project created successfully!');
    }
}