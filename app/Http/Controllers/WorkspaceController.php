<?php

namespace App\Http\Controllers;

use App\Models\TaskCategory;
use App\Models\Workspace;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectInvitationMail;

class WorkspaceController extends Controller
{
    
    private function getWorkspace()
    {
        $user = auth()->user();
        
        if ($user->isSuperAdmin()) {
            return Workspace::first();
        }

        return $user->workspaces()->first() 
               ?? Workspace::where('owner_id', $user->id)->first();
    }

    
    public function settingsGroups()
    {
        $user = auth()->user();
        $workspace = $this->getWorkspace();

        if ($user->isSuperAdmin()) {
            $groups = TaskCategory::with('workspace')
                ->latest()
                ->get()
                ->unique(function ($item) {
                    return $item->name . $item->workspace_id;
                });

            return view('settings.groups', compact('workspace', 'groups'));
        }

        if (!$workspace) return redirect()->route('setup.workspace');

        $groups = $workspace->taskCategories()
                            ->where('creator_id', $user->id)
                            ->get(); 
        
        return view('settings.groups', compact('workspace', 'groups'));
    }

   
    public function storeGroup(Request $request)
    {
        $request->validate(['name' => 'required|string|max:50']);
        
        $user = auth()->user();
        $workspace = $this->getWorkspace();
        
        if (!$workspace) {
            return back()->with('error', 'No workspace found.');
        }

        $exists = $workspace->taskCategories()
                            ->where('name', $request->name)
                            ->where('creator_id', $user->id)
                            ->exists();

        if ($exists) {
            return back()->with('error', 'You already have a group with this name.');
        }

        $workspace->taskCategories()->create([
            'name' => $request->name,
            'color' => '#06b6d4',
            'creator_id' => $user->id
        ]);

        return back()->with('success', 'Group added successfully.');
    }


    public function destroyGroup($id)
    {
        $group = TaskCategory::findOrFail($id);
        
        if ($group->creator_id !== auth()->id() && !auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Unauthorized.');
        }

        $group->delete();
        return back()->with('success', 'Group deleted.');
    }


    public function settingsMembers()
{
    $workspace = $this->getWorkspace();
    $user = auth()->user();

    $isAdmin = $user->isSuperAdmin() || ($workspace && $workspace->owner_id === $user->id);

    if (!$isAdmin) {
        return view('settings.members', [
            'workspace' => $workspace,
            'members' => collect(),
            'isOwner' => false
        ]);
    }

    if ($user->isSuperAdmin()) {
        $members = $workspace->members()->withPivot('role', 'job_title')->get();
    } else {
        $members = $workspace->members()->withPivot('role', 'job_title')->get();
    }

    $groupsCount = $members->groupBy(function($m) {
        return $m->pivot->job_title ?? 'no_group';
    })->map->count();

    foreach ($members as $member) {
        $title = $member->pivot->job_title;
        $member->is_auto_lead = ($title && ($groupsCount[$title] ?? 0) === 1);
    }

    return view('settings.members', [
        'workspace' => $workspace,
        'members' => $members,
        'isOwner' => true // نرسلها true لكي تظهر الجداول والأزرار للآدمن
    ]);
}

   
    public function updateMemberRole(Request $request, $userId)
    {
        $workspace = $this->getWorkspace();
        
        if ($workspace->owner_id !== auth()->id() && !auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $workspace->members()->updateExistingPivot($userId, [
            'role' => $request->role 
        ]);

        return back()->with('success', 'Member role updated successfully.');
    }

   
    public function toggleLead(Request $request, $userId)
    {
        $workspace = $this->getWorkspace();
        $role = $request->is_lead ? 'lead' : 'member';
        
        $workspace->members()->updateExistingPivot($userId, ['role' => $role]);
        return back()->with('success', 'Member role updated.');
    }

  
    public function inviteMember(Request $request)
    {
        $request->validate(['email' => 'required|email', 'job_title' => 'required']);
        $workspace = $this->getWorkspace();
        
        $project = $workspace->projects()->first();

        if (!$project) {
            return back()->with('error', 'Please create a project first.');
        }

        $url = url('/register') . '?email=' . urlencode($request->email) . '&project_id=' . $project->id . '&job_title=' . urlencode($request->job_title);

        try {
            Mail::to($request->email)->send(new ProjectInvitationMail($project, $url));

            $user = User::where('email', $request->email)->first();
            if ($user) {
                $project->users()->syncWithoutDetaching([$user->id]);
                $workspace->members()->syncWithoutDetaching([$user->id => ['job_title' => $request->job_title, 'role' => 'member']]);
            }

            return back()->with('success', 'Invitation link sent successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Mail Error: ' . $e->getMessage());
        }
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

  
    public function updateMemberDepartment(Request $request, $userId)
    {
        $workspace = $this->getWorkspace();
        
        if ($workspace->owner_id !== auth()->id() && !auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Unauthorized.');
        }

        $request->validate(['job_title' => 'required|string']);

        $workspace->members()->updateExistingPivot($userId, [
            'job_title' => $request->job_title
        ]);

        return back()->with('success', 'Member department updated successfully.');
    }
}