@extends('layouts.master')

@section('breadcrumbs')
    <span class="text-slate-500 font-medium">Overview</span>
@endsection

@section('content')
<div class="max-w-[1200px] mx-auto px-8 py-8 space-y-10">

    <!-- 1. Simple Header -->
    <header class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">System Overview</h1>
            <p class="text-xs text-slate-400 font-medium uppercase tracking-widest mt-1">Workspace: {{ $workspace->name }}</p>
        </div>
        <a href="{{ route('projects.index') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4"/></svg>
            New Project
        </a>
    </header>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($stats as $stat)
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center {{ $stat['color'] }}">
                    <i data-lucide="{{ $stat['icon'] }}" class="w-4 h-4"></i>
                </div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">{{ $stat['label'] }}</p>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 leading-none">{{ $stat['value'] }}</h3>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest">Recent Activity</h3>
                <a href="{{ route('projects.index') }}" class="text-[10px] font-bold text-cyan-600 uppercase hover:underline">View All Projects</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <tr>
                            <th class="py-3 px-6">Project</th>
                            <th class="py-3 px-6">Status</th>
                            <th class="py-3 px-6 text-right">Activity</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recent_projects as $project)
                        <tr class="hover:bg-slate-50/50 cursor-pointer transition-all" onclick="window.location.href='{{ route('projects.show', $project->id) }}'">
                            <td class="py-4 px-6">
                                <p class="text-sm font-semibold text-slate-700 leading-none">{{ $project->name }}</p>
                                <p class="text-[10px] text-slate-400 mt-1">{{ $project->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 bg-cyan-50 text-cyan-600 rounded-md text-[9px] font-bold uppercase tracking-tighter">
                                    {{ $project->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <div class="w-16 h-1 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="bg-cyan-500 h-full" style="width: {{ $project->progress }}%"></div>
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-500">{{ $project->progress }}%</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center text-slate-400 text-xs italic font-medium">No projects found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-slate-900 p-8 rounded-[2.5rem] text-white shadow-xl relative overflow-hidden group">
                <div class="relative z-10 space-y-6">
                    <div>
                        <p class="text-[10px] font-black text-cyan-400 uppercase tracking-[0.2em] mb-4">Quick Start</p>
                        <h4 class="text-lg font-bold leading-tight">Ready to expand your Masar?</h4>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded-full bg-cyan-500/20 flex items-center justify-center text-cyan-400 text-[10px] font-bold">1</div>
                            <p class="text-xs text-slate-300 font-medium">Add your core team members.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded-full bg-white/5 flex items-center justify-center text-slate-500 text-[10px] font-bold">2</div>
                            <p class="text-xs text-slate-400 font-medium">Break down projects into tasks.</p>
                        </div>
                    </div>

                    <a href="{{ route('projects.index') }}" class="block text-center py-3 bg-white text-slate-900 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-cyan-500 hover:text-white transition-all">
                        Invite Team
                    </a>
                </div>
                <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-cyan-500/10 rounded-full blur-3xl transition-all group-hover:bg-cyan-500/20"></div>
            </div>
        </div>

    </div>
</div>
@endsection