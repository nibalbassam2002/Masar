@extends('layouts.master')

@section('breadcrumbs')
    <a href="{{ route('projects.index') }}" class="hover:text-cyan-600 transition-colors">Projects</a>
    <span class="mx-1 opacity-30">/</span>
    <a href="{{ route('projects.show', $project->id) }}" class="hover:text-cyan-600 transition-colors">{{ $project->name }}</a>
    <span class="mx-1 opacity-30">/</span>
    <span class="text-slate-900 font-semibold">Assign Task</span>
@endsection

@section('content')
<div class="max-w-[1300px] mx-auto px-8 py-6" x-data="{ subtasks: [''] }">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap');
        .heading-font { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { font-family: 'Inter', sans-serif; color: #1e293b; background-color: #fcfcfd; }
        
        .premium-input {
            @apply w-full bg-slate-50 border border-slate-100 rounded-2xl p-3.5 text-sm font-medium text-slate-700 focus:ring-4 focus:ring-cyan-500/5 focus:bg-white focus:border-cyan-500 transition-all outline-none placeholder:text-slate-300;
        }
        .label-premium {
            @apply block text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1;
        }
    </style>

    <form action="{{ route('tasks.store', $project->id) }}" method="POST">
        @csrf

        <!-- Header Area: العنوان وزر الحفظ -->
        <header class="flex items-center justify-between mb-8 pb-6 border-b border-slate-100">
            <div>
                <h1 class="heading-font text-2xl font-800 text-slate-900 tracking-tight">Assign New Task</h1>
                <p class="text-xs text-slate-400 font-medium mt-1 tracking-widest">Target clarity and team velocity</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('projects.show', $project->id) }}" class="text-xs font-bold text-slate-400 uppercase tracking-widest px-4 hover:text-slate-600 transition-all">Cancel</a>
                <button type="submit" class="bg-cyan-500 text-white px-8 py-3 rounded-xl text-[11px] font-black uppercase tracking-widest shadow-lg shadow-cyan-100 hover:bg-cyan-600 active:scale-95 transition-all">
                    Assign Task
                </button>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <!-- الجهة اليسرى: المحتوى الأساسي والمهام الفرعية (8 أعمدة) -->
            <div class="col-span-12 lg:col-span-8 space-y-6">
                
                <!-- Main Task Description -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <div class="space-y-8">
                        <div>
                            <label class="label-premium text-cyan-600">Task Summary</label>
                            <input type="text" name="title" required autofocus placeholder="What needs to be achieved?"
                                   class="w-full bg-transparent border-none p-0 text-3xl font-bold text-slate-900 placeholder:text-slate-200 outline-none focus:ring-0">
                        </div>

                        <div class="pt-6 border-t border-slate-50">
                            <label class="label-premium">Detailed Requirements</label>
                            <textarea name="description" rows="10" 
                                      class="w-full bg-slate-50 rounded-2xl p-5 text-sm text-slate-600 border-none focus:ring-4 focus:ring-cyan-500/5 focus:bg-white outline-none transition-all placeholder:text-slate-300"
                                      placeholder="Define technical steps or acceptance criteria..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Sub-tasks: القائمة التفاعلية -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="heading-font text-base font-bold text-slate-900 uppercase tracking-wider">Sub-tasks Checklist</h3>
                        <span class="text-[10px] font-bold text-slate-300 tracking-widest ">Breakdown of steps</span>
                    </div>
                    
                    <div class="space-y-3">
                        <template x-for="(subtask, index) in subtasks" :key="index">
                            <div class="flex items-center gap-3 bg-slate-50 p-3.5 rounded-xl border border-slate-100/50 group">
                                <div class="w-4 h-4 rounded border-2 border-slate-200 shrink-0 group-hover:border-cyan-400 transition-colors"></div>
                                <input type="text" name="subtasks[]" x-model="subtasks[index]" placeholder="Add a sub-task step..." 
                                       class="bg-transparent border-none p-0 text-xs font-medium w-full outline-none text-slate-600 placeholder:text-slate-300">
                                <button type="button" @click="subtasks.splice(index, 1)" x-show="subtasks.length > 1" class="text-slate-300 hover:text-rose-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5"/></svg>
                                </button>
                            </div>
                        </template>
                        
                        <button type="button" @click="subtasks.push('')" 
                                class="inline-flex items-center text-[10px] font-bold text-cyan-600 uppercase tracking-widest mt-2 ml-1 hover:text-cyan-700 transition-colors group">
                            <svg class="w-3.5 h-3.5 mr-1 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="3"/></svg>
                            Add another step
                        </button>
                    </div>
                </div>
            </div>

            <!-- الجهة اليمنى: الإعدادات الجانبية (4 أعمدة) -->
            <div class="col-span-12 lg:col-span-4 space-y-5">
                <div class="bg-white p-7 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-8">
                    
                    <!-- Assignee -->
                    <div class="space-y-3">
                        <label class="label-premium">Assignee</label>
                        <div class="relative group">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 w-7 h-7 bg-cyan-500 rounded-lg flex items-center justify-center text-[10px] text-white font-black shadow-sm shadow-cyan-200">
                                NI
                            </div>
                            <select name="assignee_id" required 
                                    class="w-full bg-slate-50 border border-slate-50 rounded-2xl py-3.5 pl-14 pr-4 text-xs font-bold text-slate-700 appearance-none focus:ring-4 focus:ring-cyan-500/5 focus:bg-white focus:border-cyan-500 transition-all outline-none">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == auth()->id() ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Work Group -->
                    <div class="space-y-3">
                        <label class="label-premium">Work Group</label>
                        <div class="grid grid-cols-1 gap-2">
                            @foreach($categories as $category)
                            <label class="relative flex items-center px-4 py-3 bg-slate-50 rounded-2xl cursor-pointer border border-transparent hover:border-cyan-200 transition-all group">
                                <input type="radio" name="category" value="{{ $category }}" class="sr-only peer" {{ $loop->first ? 'checked' : '' }}>
                                <div class="w-4 h-4 rounded-full border-2 border-slate-300 peer-checked:border-cyan-500 peer-checked:bg-cyan-500 transition-all"></div>
                                <span class="ml-3 text-xs font-bold text-slate-500 peer-checked:text-slate-900">{{ $category }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Timeline Group -->
                    <div class="pt-6 border-t border-slate-50 space-y-4">
                        <label class="label-premium text-slate-900">Project Timeline</label>
                        <div class="grid grid-cols-1 gap-3">
                            <div class="group flex items-center bg-slate-50 rounded-2xl border border-transparent focus-within:border-cyan-500 focus-within:bg-white transition-all px-4 py-2">
                                <div class="text-slate-400 group-focus-within:text-cyan-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="flex-1 ml-3">
                                    <span class="block text-[8px] font-black uppercase tracking-widest text-slate-400">Start Date</span>
                                    <input type="date" name="start_date" class="w-full bg-transparent border-none p-0 text-xs font-bold text-slate-700 focus:ring-0 outline-none">
                                </div>
                            </div>

                            <div class="group flex items-center bg-slate-50 rounded-2xl border border-transparent focus-within:border-rose-400 focus-within:bg-white transition-all px-4 py-2">
                                <div class="text-rose-400/60 group-focus-within:text-rose-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div class="flex-1 ml-3">
                                    <span class="block text-[8px] font-black uppercase tracking-widest text-rose-500/70">Deadline</span>
                                    <input type="date" name="due_date" required class="w-full bg-transparent border-none p-0 text-xs font-bold text-slate-700 focus:ring-0 outline-none">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Priority & Est. Time -->
                    <div class="pt-6 border-t border-slate-50 grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="label-premium">Priority</label>
                            <select name="priority" class="w-full bg-slate-50 border-none rounded-2xl py-3 px-4 text-xs font-bold text-slate-700 focus:ring-4 focus:ring-cyan-500/5 focus:bg-white transition-all outline-none">
                                <option value="low">Low</option>
                                <option value="medium" selected>Normal</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection