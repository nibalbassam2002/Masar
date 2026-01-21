<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workspace;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // جلب مساحة العمل التي يملكها المستخدم الحالي
        $workspace = Workspace::where('owner_id', $user->id)->first();

        // إذا لم يملك مساحة عمل بعد (حالة نادرة بعد الـ Onboarding)
        if (!$workspace) {
            return redirect()->route('setup.workspace');
        }

        // تحضير الإحصائيات (الآن أصبحت ديناميكية)
        $stats = [
            [
                'label' => 'Total Projects', 
                'value' => $workspace->projects()->count(), 
                'change' => '+1', 
                'icon' => 'folder'
            ],
            [
                'label' => 'Active Tasks', 
                'value' => '0', // سنبرمجها لاحقاً
                'change' => '0%', 
                'icon' => 'check-circle'
            ],
            [
                'label' => 'Team Members', 
                'value' => '1', // المستخدم نفسه حالياً
                'change' => '0%', 
                'icon' => 'users'
            ],
            [
                'label' => 'Budget Used', 
                'value' => '$0', 
                'change' => '0%', 
                'icon' => 'dollar-sign'
            ],
        ];

        // جلب آخر 5 مشاريع تم إنشاؤها
        $recent_projects = $workspace->projects()->latest()->take(5)->get();

        return view('dashboard', [
            'stats' => $stats,
            'recent_projects' => $recent_projects,
            'workspace_name' => $workspace->name
        ]);
    }
}