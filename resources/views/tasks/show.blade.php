@extends('layouts.master')

@section('breadcrumbs')
    <a href="{{ route('tasks.index') }}">Tasks</a>
    <span class="mx-1 opacity-30">/</span>
    <span class="text-slate-900 font-bold uppercase tracking-widest text-[10px]">{{ $task->title }}</span>
@endsection

@section('content')
<div class="max-w-[1000px] mx-auto px-8 py-10">
    <div class="grid grid-cols-12 gap-12">
        <div class="col-span-12 lg:col-span-8 space-y-10">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <span class="px-2 py-0.5 bg-cyan-50 text-cyan-600 rounded text-[9px] font-black uppercase tracking-widest border border-cyan-100">
                        {{ $task->category }}
                    </span>
                    <span class="text-[10px] font-bold text-slate-400">{{ $task->project->name }}</span>
                </div>
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">{{ $task->title }}</h1>
            </div>

            <!-- الوصف -->
            <div class="prose prose-slate max-w-none">
                <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-4">Description</h3>
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm text-slate-600 leading-relaxed text-sm">
                    {!! nl2br(e($task->description ?? 'No detailed description provided.')) !!}
                </div>
            </div>

            <!-- الـ Checklist (السب تاسك) -->
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Sub-tasks Checklist</h3>
                    <span class="text-[10px] font-bold text-cyan-600 bg-cyan-50 px-2 py-0.5 rounded-md">
                        {{ $task->subtasks->count() }} Steps
                    </span>
                </div>

                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm divide-y divide-slate-50">
                    @forelse($task->subtasks as $sub)
                    <div class="flex items-center gap-4 p-5 group">
                        <div class="w-5 h-5 rounded-lg border-2 border-slate-200 flex items-center justify-center group-hover:border-cyan-500 transition-colors">
                            <div class="w-2 h-2 bg-cyan-500 rounded-sm opacity-0 group-hover:opacity-20"></div>
                        </div>
                        <span class="text-sm font-semibold text-slate-700">{{ $sub->title }}</span>
                    </div>
                    @empty
                    <p class="p-10 text-center text-slate-300 text-xs italic">No sub-tasks defined for this mission.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- الجهة اليمنى: الميتاداتا (4 أعمدة) -->
        <div class="col-span-12 lg:col-span-4 space-y-6">
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-8">
                
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Assignee</label>
                    <div class="flex items-center gap-3 pt-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($task->assignee->name) }}&background=06b6d4&color=fff&bold=true" class="w-8 h-8 rounded-xl">
                        <span class="text-sm font-bold text-slate-800">{{ $task->assignee->name }}</span>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Priority</label>
                    <div class="flex items-center gap-2 pt-2">
                        <div class="w-2 h-2 rounded-full {{ $task->priority == 'urgent' ? 'bg-red-500' : 'bg-cyan-500' }}"></div>
                        <span class="text-sm font-bold text-slate-700 capitalize">{{ $task->priority }}</span>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Deadline</label>
                    <p class="text-sm font-bold text-slate-700 pt-2">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('F d, Y') : 'Not set' }}</p>
                </div>

                <div class="pt-6 border-t border-slate-50">
                    <a href="{{ route('tasks.edit', $task->id) }}" class="flex items-center justify-center w-full py-4 bg-slate-900 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-cyan-600 transition-all shadow-xl">
                        Edit Mission
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection