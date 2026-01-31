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
    $user = auth()->user();

    $groups = $workspace->taskCategories()
                        ->where('creator_id', $user->id)
                        ->get(); 
    
    return view('settings.groups', compact('workspace', 'groups'));
}

public function storeGroup(Request $request)
{
    $request->validate(['name' => 'required|string|max:50']);
    
    $workspace = $this->getWorkspace();
    
    $workspace->taskCategories()->create([
        'name' => $request->name,
        'color' => '#06b6d4',
        'creator_id' => auth()->id() 
    ]);

    return back()->with('success', 'Your personal work group added.');
}

    public function settingsMembers()
    {
        $workspace = $this->getWorkspace();
        $user = auth()->user();

        if ($workspace->owner_id !== $user->id) {
            return view('settings.members', ['workspace' => $workspace, 'members' => collect(), 'isOwner' => false]);
        }

        $members = $workspace->members()->withPivot('role', 'job_title')->get();

        
        $groupsCount = $members->groupBy(function($m) {
            return $m->pivot->job_title ?? 'no_group';
        })->map->count();

        foreach ($members as $member) {
            $title = $member->pivot->job_title;
            $member->is_auto_lead = ($title && ($groupsCount[$title] ?? 0) === 1);
        }

        return view('settings.members', compact('workspace', 'members'))->with('isOwner', true);
    }
    public function updateMemberRole(Request $request, $userId)
    {
        $workspace = $this->getWorkspace();
        
        if ($workspace->owner_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $workspace->members()->updateExistingPivot($userId, [
            'role' => $request->role // 'lead' or 'member'
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
        return back()->with('error', 'Please create a project first before inviting members.');
    }

    $url = url('/register') . '?email=' . urlencode($request->email) . '&project_id=' . $project->id;

    try {
        \Illuminate\Support\Facades\Mail::to($request->email)
            ->send(new \App\Mail\ProjectInvitationMail($project, $url));

        $user = \App\Models\User::where('email', $request->email)->first();
        if ($user) {
            $project->users()->syncWithoutDetaching([$user->id]);
            $workspace->members()->updateExistingPivot($user->id, ['job_title' => $request->job_title]);
        }

        return back()->with('success', 'Invitation link sent successfully to ' . $request->email);
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
        
        if ($workspace->owner_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $request->validate(['job_title' => 'required|string']);

        $workspace->members()->updateExistingPivot($userId, [
            'job_title' => $request->job_title
        ]);

        return back()->with('success', 'Member department updated successfully.');
    }
}