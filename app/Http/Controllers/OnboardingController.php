<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workspace;
use App\Models\Project;
use App\Models\User;

class OnboardingController extends Controller
{
    
    public function workspace()
    {
        return view('setup.workspace');
    }

    
    public function storeWorkspace(Request $request)
    {
        $request->validate(['workspace_name' => 'required|string|max:255']);
        session(['setup_workspace_name' => $request->workspace_name]);

        return redirect()->route('setup.team');
    }

   
    public function teamProfile()
    {
        return view('setup.team');
    }

  
    public function storeTeamProfile(Request $request)
    {
        $request->validate(['team_type' => 'required']);
        
       
        session(['setup_team_type' => $request->team_type]);

        return redirect()->route('setup.project');
    }

    
    public function project()
    {
        return view('setup.project');
    }

    
    public function storeProject(Request $request)
    {
        $user = auth()->user();
        $request->validate(['project_name' => 'required|string|max:255']);

        
        $workspace = Workspace::create([
            'name' => session('setup_workspace_name'),
            'owner_id' => $user->id,
        ]);

        $workspace->members()->attach($user->id, [
            'role' => 'owner', 
            'job_title' => 'Founder'
        ]);

        $teamType = session('setup_team_type');
        $defaults = match($teamType) {
            'development' => ['Frontend', 'Backend', 'QA / Testing', 'UI/UX'],
            'marketing'   => ['Content', 'Ads', 'Design', 'SEO'],
            default       => ['General', 'Admin'],
        };

        foreach($defaults as $name) {
            $workspace->taskCategories()->create([
                'name' => $name,
                'creator_id' => $user->id 
            ]);
        }

       
        $workspace->projects()->create([
            'name' => $request->project_name,
            'status' => 'active',
            'progress' => 0
        ]);

        session()->forget(['setup_workspace_name', 'setup_team_type']);

        return redirect()->route('dashboard')->with('success', 'Your workspace is ready!');
    }
}