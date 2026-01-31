@extends('layouts.master')

@section('content')
<div class="min-h-screen bg-[#fcfcfd] pb-20">
    <div class="max-w-[1500px] mx-auto px-10 py-10">
        
]        <div class="flex items-center justify-between mb-10">
            <div class="flex items-center gap-5">
                <a href="{{ route('projects.show', $project->id) }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:text-cyan-600 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h1 class="heading-font text-2xl font-800 text-slate-900 tracking-tight">{{ $project->name }} Insights</h1>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8">
            
            <div class="col-span-12 lg:col-span-4 space-y-6">
                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden">
                    <span class="text-[9px] font-black uppercase tracking-widest text-cyan-400">Total Progress</span>
                    <h2 class="text-7xl font-800 mt-4 tracking-tighter">{{ $overallProgress }}%</h2>
                    <div class="w-full bg-white/10 h-1.5 rounded-full mt-6 overflow-hidden">
                        <div class="bg-cyan-500 h-full transition-all duration-1000" style="width: {{ $overallProgress }}%"></div>
                    </div>
                    
                    <div class="mt-8 pt-8 border-t border-white/5 flex justify-between items-center">
                        <div>
                            <span class="text-[8px] font-black text-rose-500 uppercase block">Overdue Missions</span>
                            <span class="text-2xl font-bold">{{ $overdueTasks }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-[8px] font-black text-slate-500 uppercase block">Total</span>
                            <span class="text-2xl font-bold text-slate-300">{{ $totalCount }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-4">
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Status Breakdown</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-4 bg-slate-50 rounded-2xl">
                            <span class="text-[8px] font-black text-slate-400 uppercase block">In Progress</span>
                            <span class="text-xl font-bold text-cyan-600">{{ $progressCount }}</span>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl">
                            <span class="text-[8px] font-black text-slate-400 uppercase block">Backlog</span>
                            <span class="text-xl font-bold text-slate-700">{{ $todoCount }}</span>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl">
                            <span class="text-[8px] font-black text-slate-400 uppercase block">In Review</span>
                            <span class="text-xl font-bold text-amber-500">{{ $reviewCount }}</span>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl">
                            <span class="text-[8px] font-black text-slate-400 uppercase block">Completed</span>
                            <span class="text-xl font-bold text-emerald-500">{{ $doneCount }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-8 space-y-8">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-8">Departmental Performance</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($categoryStats as $stat)
                            <div class="p-6 bg-slate-50 rounded-3xl border border-transparent hover:border-cyan-100 transition-all group">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="text-[9px] font-black text-cyan-600 uppercase tracking-widest">{{ $stat->category }}</span>
                                        <h4 class="text-sm font-extrabold text-slate-800 mt-1">{{ $stat->display_name }}</h4>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-lg font-black text-slate-900">{{ $stat->percent }}%</span>
                                        <span class="block text-[8px] font-black text-slate-400 uppercase">Completed</span>
                                    </div>
                                </div>
                                <div class="w-full bg-slate-200 h-1 rounded-full mt-4 overflow-hidden">
                                    <div class="bg-slate-900 h-full transition-all" style="width: {{ $stat->percent }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-8">Recent Project Activity</h3>
                    <div class="space-y-6">
                        @forelse($recentActivity as $log)
                            <div class="flex gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($log->user->name) }}&background=f1f5f9&color=64748b&bold=true" class="w-8 h-8 rounded-lg">
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <span class="text-[10px] font-black text-slate-900 uppercase">{{ $log->user->name }}</span>
                                        <span class="text-[9px] text-slate-300 font-bold uppercase">{{ $log->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed border-l-2 border-cyan-100 pl-3">
                                        <span class="text-cyan-600 font-black">@ {{ $log->task->title }}:</span> {{ $log->content }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center py-10 text-xs text-slate-300 italic uppercase">No heartbeat detected yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection