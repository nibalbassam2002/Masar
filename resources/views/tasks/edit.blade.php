@extends('layouts.master')

@section('breadcrumbs')
    <a href="{{ route('tasks.index') }}" class="hover:text-cyan-600">Tasks</a>
    <span class="mx-1 opacity-30">/</span>
    <span class="text-slate-900 font-semibold uppercase tracking-tighter">Edit Mission Details</span>
@endsection

@section('content')
    <div class="max-w-[1300px] mx-auto px-8 py-6" 
         x-data="{ subtasks: {{ json_encode($task->subtasks->pluck('title')->toArray() ?: []) }} }">

        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <header class="flex items-center justify-between mb-8 pb-6 border-b border-slate-100">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight font-jakarta">Mission Schedule & Details</h1>
                    <p class="text-xs text-slate-400 font-medium mt-1 uppercase tracking-widest italic">Modify timeline and requirements</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="javascript:history.back()" class="text-xs font-bold text-slate-400 uppercase tracking-widest px-4 hover:text-slate-600">Cancel</a>
                    <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-xl text-[11px] font-black uppercase tracking-widest shadow-lg hover:bg-cyan-600 transition-all">
                        Update Mission
                    </button>
                </div>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm space-y-8">
                        <div>
                            <label class="block text-[10px] font-bold text-cyan-600 uppercase tracking-[0.2em] mb-3 ml-1">Task Title</label>
                            <input type="text" name="title" value="{{ $task->title }}" required class="w-full bg-transparent border-none p-0 text-3xl font-bold text-slate-900 outline-none focus:ring-0">
                        </div>

                        <div class="pt-6 border-t border-slate-50">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 ml-1">Detailed Description</label>
                            <textarea name="description" rows="10" class="w-full bg-slate-50 rounded-xl p-4 text-sm text-slate-600 border-none focus:ring-2 focus:ring-cyan-500/10 focus:bg-white outline-none transition-all">{{ $task->description }}</textarea>
                        </div>

                        <div class="space-y-3 pt-6 border-t border-slate-50">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 ml-1">Existing Sub-tasks</label>
                            <template x-for="(subtask, index) in subtasks" :key="index">
                                <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100/50 group mb-3 opacity-60">
                                    <div class="w-5 h-5 rounded-lg border-2 border-slate-200 shrink-0"></div>
                                    <input type="text" name="subtasks[]" x-model="subtasks[index]" readonly class="bg-transparent border-none p-0 text-sm font-medium w-full outline-none text-slate-500 cursor-default">
                                </div>
                            </template>
                            @if($task->subtasks->isEmpty())
                                <p class="text-[10px] text-slate-300 italic ml-1">No sub-tasks defined for this mission yet.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-5">
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-6">
                        
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Assign Team</label>
                            <select name="assignee_ids[]" multiple required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-bold text-slate-700 outline-none focus:ring-4 focus:ring-cyan-500/5 min-h-[120px]">
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}" {{ in_array($u->id, $currentAssigneeIds) ? 'selected' : '' }}>{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="pt-6 border-t border-slate-50 space-y-4">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Mission Timeline</label>
                            <div class="bg-slate-50 rounded-xl p-3 border border-transparent focus-within:border-cyan-500 transition-all">
                                <span class="block text-[8px] font-black text-slate-400 uppercase mb-1">Start Date</span>
                                <input type="date" name="start_date" value="{{ $task->start_date }}" class="w-full bg-transparent border-none p-0 text-xs font-bold text-slate-700 outline-none">
                            </div>
                            <div class="bg-slate-50 rounded-xl p-3 border border-transparent focus-within:border-rose-400 transition-all">
                                <span class="block text-[8px] font-black text-rose-500 uppercase mb-1">Deadline</span>
                                <input type="date" name="due_date" value="{{ $task->due_date }}" required class="w-full bg-transparent border-none p-0 text-xs font-bold text-slate-700 outline-none">
                            </div>
                        </div>

                        <div class="pt-1 border-t border-slate-50">
                            <div class="bg-slate-50 rounded-xl p-3">
                                <span class="block text-[8px] font-black text-slate-400 uppercase mb-1">Priority Level</span>
                                <select name="priority" class="w-full bg-transparent border-none p-0 text-xs font-bold text-slate-700 outline-none">
                                    <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Normal</option>
                                    <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ $task->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection