@extends('layouts.master')

@section('content')
<div class="max-w-[1600px] mx-auto space-y-8">

    <!-- Header Area -->
    <div class="flex justify-between items-end mb-6">
        <div>
            <h1 class="text-3xl font-[900] text-slate-900 tracking-tight">Overview</h1>
            <p class="text-slate-500 font-medium">Workspace: <span class="text-indigo-600 font-bold">{{ $workspace_name }}</span></p>
        </div>
    </div>
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($stats as $stat)
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm group hover:shadow-md transition-all">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-cyan-50 rounded-lg text-cyan-500">
                    <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-md">{{ $stat['change'] }}</span>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">{{ $stat['label'] }}</p>
            <h3 class="text-2xl font-black text-slate-900">{{ $stat['value'] }}</h3>
        </div>
        @endforeach
    </div>

    <!-- Main Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Recent Projects Table -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800">Recent Projects</h3>
                <button class="text-xs font-bold text-cyan-600 hover:underline">View All</button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[600px]">
                    <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase">
                        <tr>
                            <th class="py-4 px-8">Project Details</th>
                            <th class="py-4 px-8">Status</th>
                            <th class="py-4 px-8 text-right">Progress</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recent_projects as $project)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-5 px-8">
                                <p class="font-bold text-sm text-slate-800">{{ $project->name }}</p>
                                <p class="text-xs text-slate-400">Created {{ $project->created_at->format('M d, Y') }}</p>
                            </td>
                            <td class="py-5 px-8">
                                <span class="px-3 py-1 bg-cyan-50 text-cyan-600 rounded-full text-[10px] font-bold uppercase">
                                    {{ $project->status }}
                                </span>
                            </td>
                            <td class="py-5 px-8">
                                <div class="flex items-center justify-end gap-3">
                                    <div class="w-24 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-cyan-500 h-full w-[0%]"></div> <!-- نسبة الإنجاز تبدأ بـ 0 -->
                                    </div>
                                    <span class="text-xs font-bold text-slate-700">0%</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-20 text-center text-slate-400 italic">
                                No projects found. Start by creating one!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Column (Milestones) -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
            <h3 class="font-bold text-slate-800 mb-8">Next Steps</h3>
            <div class="space-y-8">
                <div class="relative pl-8 border-l-2 border-indigo-500 pb-4">
                    <div class="absolute -left-[9px] top-0 w-4 h-4 bg-white border-2 border-indigo-500 rounded-full shadow-sm"></div>
                    <p class="text-sm font-bold text-slate-800 leading-none">Add Team Members</p>
                    <p class="text-[10px] text-slate-400 mt-1">Invite your colleagues</p>
                </div>
                <div class="relative pl-8 border-l-2 border-slate-200 pb-4">
                    <div class="absolute -left-[9px] top-0 w-4 h-4 bg-white border-2 border-slate-200 rounded-full shadow-sm"></div>
                    <p class="text-sm font-bold text-slate-800 leading-none">Create Tasks</p>
                    <p class="text-[10px] text-slate-400 mt-1">Break down your project</p>
                </div>
            </div>
            <button class="mt-8 w-full py-4 bg-slate-900 text-white rounded-2xl text-sm font-[900] uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg shadow-indigo-100">
                + Add New Task
            </button>
        </div>
    </div>
</div>
@endsection