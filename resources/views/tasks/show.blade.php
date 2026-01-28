@extends('layouts.master')

@section('breadcrumbs')
    <a href="{{ route('tasks.index') }}" class="hover:text-cyan-600 transition-colors">Tasks</a>
    <span class="mx-1 opacity-30">/</span>
    <a href="{{ route('projects.show', $task->project_id) }}" class="hover:text-cyan-600 transition-colors">{{ $task->project->name }}</a>
    <span class="mx-1 opacity-30">/</span>
    <span class="text-slate-900 font-semibold italic">{{ $task->title }}</span>
@endsection

@section('content')
<div class="max-w-[1400px] mx-auto px-8 py-6">
    
    <!-- 1. Header: معلومات سريعة عن المهمة -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 pb-6 border-b border-slate-100 gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-2 py-0.5 bg-cyan-50 text-cyan-600 rounded text-[9px] font-black uppercase tracking-widest border border-cyan-100">{{ $task->category }}</span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $task->project->name }}</span>
            </div>
            <h1 class="heading-font text-3xl font-800 text-slate-900 tracking-tight">{{ $task->title }}</h1>
        </div>

        <div class="flex items-center gap-3">
             <div class="px-4 py-2 bg-white border border-slate-200 rounded-xl flex items-center gap-3 shadow-sm">
                <div class="w-2 h-2 rounded-full {{ $task->status == 'done' ? 'bg-emerald-500' : 'bg-cyan-500 animate-pulse' }}"></div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">{{ str_replace('_', ' ', $task->status) }}</span>
             </div>
             <a href="{{ route('tasks.edit', $task->id) }}" class="btn-primary !py-2.5 text-[11px]">Update Mission</a>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        
        <!-- الجهة اليسرى: الملاحظات والنقاش (8 أعمدة) -->
        <div class="lg:col-span-8 space-y-12">
            
            <!-- Description Box -->
            <div class="space-y-4">
                <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Detailed Context</h3>
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm text-sm text-slate-600 leading-relaxed">
                    {!! nl2br(e($task->description ?? 'No detailed description provided for this mission.')) !!}
                </div>
            </div>

            <!-- Collaboration Feed (الملاحظات) -->
            <section class="space-y-6 pt-10 border-t border-slate-100">
                <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Team Collaboration</h3>
                
                <div class="space-y-4">
                    @forelse($task->notes as $note)
                        <div class="flex gap-4 p-6 bg-white border border-slate-100 rounded-3xl shadow-sm hover:shadow-md transition-all">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($note->user->name) }}&background=f1f5f9&color=64748b&bold=true" class="w-9 h-9 rounded-xl shadow-inner shrink-0">
                            <div class="flex-1">
                                <div class="flex justify-between items-center mb-1">
                                    <p class="text-xs font-bold text-slate-800">{{ $note->user->name }}</p>
                                    <span class="text-[9px] font-medium text-slate-300 italic">{{ $note->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-slate-500 leading-relaxed">{{ $note->content }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 border-2 border-dashed border-slate-100 rounded-[2.5rem] text-center opacity-40">
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 italic">No notes posted yet</p>
                        </div>
                    @endforelse
                </div>

                <!-- فورم الملاحظات -->
                <form action="{{ route('tasks.notes.store', $task->id) }}" method="POST" class="mt-8">
                    @csrf
                    <textarea name="content" rows="4" required class="input-field mb-4" placeholder="Request a change or provide an update..."></textarea>
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary !py-3 !px-8">Post Note</button>
                    </div>
                </form>
            </section>
        </div>

        <!-- الجهة اليمنى: الفريق والملفات والسب تاسك (4 أعمدة) -->
        <aside class="lg:col-span-4 space-y-6">
            
            <!-- 1. Assigned Member -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-4">
                <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400">Assigned Member</h4>
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($task->assignee->name) }}&background=06b6d4&color=fff&bold=true" class="w-10 h-10 rounded-xl shadow-sm border border-white">
                    <div>
                        <p class="text-sm font-bold text-slate-800 leading-none">{{ $task->assignee->name }}</p>
                        <p class="text-[10px] font-bold text-cyan-600 uppercase mt-1.5">{{ $task->assignee->job_title ?? 'Collaborator' }}</p>
                    </div>
                </div>
            </div>

            <!-- 2. Sub-tasks Checklist -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-6">
                <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400">Mission Progress</h4>
                <div class="space-y-3">
                    @foreach($task->subtasks as $sub)
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                            <div class="w-4 h-4 rounded border-2 border-slate-200"></div>
                            <span class="text-xs font-bold text-slate-600">{{ $sub->title }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 3. Attachments -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-6">
                <div class="flex items-center justify-between">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400">Files</h4>
                    <button class="text-cyan-600 text-[10px] font-black uppercase tracking-widest">+ Upload</button>
                </div>
                <div class="py-4 border-2 border-dashed border-slate-50 rounded-2xl text-center">
                    <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest leading-none">No shared files</p>
                </div>
            </div>

        </aside>
    </div>
</div>
@endsection