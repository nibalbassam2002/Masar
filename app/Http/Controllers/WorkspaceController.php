<?php

namespace App\Http\Controllers;

use App\Models\TaskCategory;
use App\Models\Workspace;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    
    private function getWorkspace()
    {
        $user = auth()->user();
        return $user->workspaces()->first() 
               ?? Workspace::where('owner_id', $user->id)->first();
    }

        public function settingsGroups()
    {
        $workspace = $this->getWorkspace();

        if (!$workspace) {
            return redirect()->route('setup.workspace');
        }

        $groups = $workspace->taskCategories()->get(); 
        
        return view('settings.groups', compact('workspace', 'groups'));
    }

    public function storeGroup(Request $request)
    {
        $request->validate(['name' => 'required|string|max:50']);
        
        $workspace = $this->getWorkspace();
        
        $workspace->taskCategories()->create([
            'name' => $request->name,
            'color' => '#06b6d4'
        ]);

        return back()->with('success', 'Work Group added successfully.');
    }

    public function settingsMembers()
    {
        $workspace = $this->getWorkspace();

        if (!$workspace) {
            return redirect()->route('setup.workspace');
        }

        $members = $workspace->members()->latest()->get();
        
        return view('settings.members', compact('workspace', 'members'));
    }

    public function inviteMember(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'job_title' => 'required|string|max:50'
        ]);

        $workspace = $this->getWorkspace();
        $userToInvite = \App\Models\User::where('email', $request->email)->first();

        $workspace->members()->syncWithoutDetaching([
            $userToInvite->id => ['job_title' => $request->job_title, 'role' => 'member']
        ]);

        return back()->with('success', 'Team member added successfully!');
    }

    public function removeMember($userId)
    {
        $workspace = $this->getWorkspace();
        
        if($userId == auth()->id()) {
            return back()->with('error', 'You cannot remove yourself.');
        }

        $workspace->members()->detach($userId);
        return back()->with('success', 'Member removed.');
    }
}