@extends('layouts.master')

@section('breadcrumbs')
    <a href="{{ route('tasks.index') }}">Tasks</a>
    <span class="mx-1 opacity-30">/</span>
    @if ($project)
        <a href="{{ route('projects.show', $project->id) }}">{{ $project->name }}</a>
    @else
        <span class="text-slate-400">New Assignment</span>
    @endif
    <span class="mx-1 opacity-30">/</span>
    <span class="text-slate-900 font-semibold">Assign</span>
@endsection

@section('content')
    <div class="max-w-[1300px] mx-auto px-8 py-6" x-data="{ subtasks: [''] }">

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <header class="flex items-center justify-between mb-8 pb-6 border-b border-slate-100">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight font-jakarta">Assign New Task</h1>
                    <p class="text-xs text-slate-400 font-medium mt-1 uppercase tracking-widest">Workspace:
                        {{ $workspace->name }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="javascript:history.back()"
                        class="text-xs font-bold text-slate-400 uppercase tracking-widest px-4 hover:text-slate-600">Cancel</a>
                    <button type="submit"
                        class="bg-cyan-500 text-white px-8 py-3 rounded-xl text-[11px] font-black uppercase tracking-widest shadow-lg shadow-cyan-100 hover:bg-cyan-600 hover:scale-[1.02] active:scale-95 transition-all">
                        Assign Task
                    </button>
                </div>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm space-y-8">
                        <div>
                            <label
                                class="block text-[10px] font-bold text-cyan-600 uppercase tracking-[0.2em] mb-3 ml-1">Task
                                Title</label>
                            <input type="text" name="title" required placeholder="What needs to be done?"
                                class="w-full bg-transparent border-none p-0 text-3xl font-bold text-slate-900 placeholder:text-slate-200 outline-none focus:ring-0">
                        </div>

                        <div class="pt-6 border-t border-slate-50">
                            <label
                                class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 block ml-1">Detailed
                                Description</label>
                            <textarea name="description" rows="12"
                                class="w-full bg-slate-50 rounded-xl p-4 text-sm text-slate-600 border-none focus:ring-2 focus:ring-cyan-500/10 focus:bg-white outline-none transition-all placeholder:text-slate-300"
                                placeholder="Define acceptance criteria..."></textarea>
                        </div>

                        <div class="space-y-3 pt-6 border-t border-slate-50">
                            <label
                                class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 ml-1">Sub-tasks
                                Checklist</label>

                            <template x-for="(subtask, index) in subtasks" :key="index">
                                <div
                                    class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100/50 group mb-3">
                                    <div
                                        class="w-5 h-5 rounded-lg border-2 border-slate-200 shrink-0 group-hover:border-cyan-400 transition-colors">
                                    </div>
                                    <input type="text" name="subtasks[]" x-model="subtasks[index]"
                                        placeholder="Add a step..."
                                        class="bg-transparent border-none p-0 text-sm font-medium w-full outline-none text-slate-600 placeholder:text-slate-200">
                                    <button type="button" @click="subtasks.splice(index, 1)" x-show="subtasks.length > 1"
                                        class="text-slate-300 hover:text-rose-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            stroke-width="3">
                                            <path d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <button type="button" @click="subtasks.push('')"
                                class="inline-flex items-center text-[10px] font-black text-cyan-600 uppercase tracking-widest mt-2 ml-2 hover:text-cyan-700 transition-all">
                                <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="3">
                                    <path d="M12 4v16m8-8H4" />
                                </svg>
                                Add another step
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Side: الإعدادات -->
                <div class="lg:col-span-4 space-y-5">
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-6">

                        @if (!$project)
                            <div class="pb-6 border-b border-slate-50">
                                <label
                                    class="block text-[10px] font-bold text-cyan-600 uppercase tracking-widest mb-2 ml-1">Target
                                    Project</label>
                                <select name="project_id" required
                                    class="w-full bg-slate-100/50 border-none rounded-xl p-3 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-cyan-500/10">
                                    <option value="" disabled selected>Select a project...</option>
                                    @foreach ($projects as $proj)
                                        <option value="{{ $proj->id }}">{{ $proj->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                        @endif

                        <div>
                            <label
                                class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block ml-1">Assignee</label>
                            <select name="assignee_id"
                                class="w-full bg-slate-50 border-none rounded-xl p-3 text-xs font-bold text-slate-700 outline-none">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="label-premium">Work Group</label>
                            <div class="grid grid-cols-1 gap-2">

                                <div class="space-y-2">
                                    <!-- استخدام المتغير الذي أرسلناه من الكنترولر -->
                                    @forelse($taskCategories as $category)
                                        <label
                                            class="relative flex items-center px-4 py-3 bg-slate-50 rounded-2xl cursor-pointer border border-transparent hover:border-cyan-200 transition-all group">
                                            <input type="radio" name="category" value="{{ $category->name }}"
                                                class="sr-only peer" {{ $loop->first ? 'checked' : '' }}>
                                            <div
                                                class="w-4 h-4 rounded-full border-2 border-slate-300 peer-checked:border-cyan-500 peer-checked:bg-cyan-500 transition-all">
                                            </div>
                                            <span
                                                class="ml-3 text-xs font-bold text-slate-500 peer-checked:text-slate-900 group-hover:text-slate-700 transition-colors">{{ $category->name }}</span>
                                        </label>
                                    @empty

                                        <p class="text-[10px] text-slate-400 italic px-4">No work groups defined yet.</p>
                                    @endforelse

                                    <a href="{{ route('settings.groups') }}"
                                        class="text-[10px] font-bold text-cyan-600 uppercase tracking-widest mt-4 ml-2 hover:text-cyan-700 block text-center border border-dashed border-cyan-100 p-3 rounded-xl hover:bg-cyan-50 transition-all">
                                        + Manage Work Groups
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-50 space-y-4">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Project
                                Timeline</label>
                            <div class="bg-slate-50 rounded-xl p-3">
                                <span class="block text-[8px] font-black text-slate-400 uppercase mb-1">Start Date</span>
                                <input type="date" name="start_date"
                                    class="w-full bg-transparent border-none p-0 text-xs font-bold text-slate-700 outline-none">
                            </div>
                            <div class="bg-slate-50 rounded-xl p-3">
                                <span class="block text-[8px] font-black text-rose-500 uppercase mb-1">Deadline</span>
                                <input type="date" name="due_date" required
                                    class="w-full bg-transparent border-none p-0 text-xs font-bold text-slate-700 outline-none">
                            </div>
                        </div>

                        <div class="pt-1 border-t border-slate-50 grid grid-cols-2 gap-3">
                            <div class="bg-slate-50 rounded-xl p-3">
                                <span class="block text-[8px] font-black text-slate-400 uppercase mb-1">Priority</span>
                                <select name="priority"
                                    class="w-full bg-transparent border-none p-0 text-xs font-bold text-slate-700 outline-none">
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
