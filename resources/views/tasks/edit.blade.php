@extends('layouts.master')

@section('breadcrumbs')
    <a href="{{ route('tasks.index') }}" class="hover:text-cyan-600 transition-colors">Tasks</a>
    <span class="mx-1 opacity-30">/</span>
    <a href="{{ route('projects.show', $task->project_id) }}"
        class="hover:text-cyan-600 transition-colors">{{ $task->project->name }}</a>
    <span class="mx-1 opacity-30">/</span>
    <span class="text-slate-900 font-semibold italic">Edit Task</span>
@endsection

@section('content')
    <div class="max-w-[1300px] mx-auto px-8 py-6" x-data="{ subtasks: {{ json_encode($task->subtasks->pluck('title')->toArray() ?: ['']) }} }">

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap');

            .heading-font {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }

            body {
                font-family: 'Inter', sans-serif;
                color: #1e293b;
                background-color: #fcfcfd;
            }

            .premium-input {
                @apply w-full bg-slate-50 border border-slate-100 rounded-2xl p-3.5 text-sm font-medium text-slate-700 focus:ring-4 focus:ring-cyan-500/5 focus:bg-white focus:border-cyan-500 transition-all outline-none;
            }

            .label-premium {
                @apply block text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1;
            }
        </style>

        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Header: Action Bar -->
            <header class="flex items-center justify-between mb-8 pb-6 border-b border-slate-100">
                <div>
                    <h1 class="heading-font text-2xl font-800 text-slate-900 tracking-tight">Update Mission Details</h1>
                    <p class="text-xs text-slate-400 font-medium mt-1 uppercase tracking-widest italic">Refining project
                        path</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('projects.show', $task->project_id) }}"
                        class="text-xs font-bold text-slate-400 uppercase tracking-widest px-4 hover:text-slate-600 transition-all">Discard</a>
                    <button type="submit"
                        class="bg-cyan-500 text-white px-8 py-3 rounded-xl text-[11px] font-black uppercase tracking-widest shadow-lg shadow-cyan-100 hover:bg-cyan-600 transition-all active:scale-95">
                        Save Changes
                    </button>
                </div>
            </header>

            <div class="grid grid-cols-12 gap-10">

                <!-- الجهة اليسرى: المحتوى (8 أعمدة) -->
                <div class="col-span-12 lg:col-span-8 space-y-6">

                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                        <div class="space-y-8">
                            <!-- عنوان المهمة -->
                            <div>
                                <label class="label-premium text-cyan-600">Task Summary</label>
                                <input type="text" name="title" value="{{ $task->title }}" required
                                    class="w-full bg-transparent border-none p-0 text-3xl font-bold text-slate-900 placeholder:text-slate-200 outline-none focus:ring-0">
                            </div>

                            <!-- الوصف التفصيلي -->
                            <div class="pt-6 border-t border-slate-50">
                                <label class="label-premium">Detailed Requirements</label>
                                <textarea name="description" rows="10"
                                    class="w-full bg-slate-50 rounded-2xl p-5 text-sm text-slate-600 border-none focus:ring-4 focus:ring-cyan-500/5 focus:bg-white outline-none transition-all">{{ $task->description }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Sub-tasks Section -->
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="heading-font text-base font-bold text-slate-900 uppercase tracking-wider">Sub-tasks
                                Checklist</h3>
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest italic">Breakdown of
                                steps</span>
                        </div>

                        <div class="space-y-3">
                            <template x-for="(subtask, index) in subtasks" :key="index">
                                <div
                                    class="flex items-center gap-3 bg-slate-50 p-3.5 rounded-xl border border-slate-100/50 group">
                                    <div
                                        class="w-4 h-4 rounded border-2 border-slate-200 shrink-0 group-hover:border-cyan-400">
                                    </div>
                                    <input type="text" name="subtasks[]" x-model="subtasks[index]"
                                        class="bg-transparent border-none p-0 text-xs font-medium w-full outline-none text-slate-600">
                                    <button type="button" @click="subtasks.splice(index, 1)" x-show="subtasks.length > 1"
                                        class="text-slate-300 hover:text-rose-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            stroke-width="2.5">
                                            <path d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <button type="button" @click="subtasks.push('')"
                                class="inline-flex items-center text-[10px] font-bold text-cyan-600 uppercase tracking-widest mt-4 ml-1 hover:text-cyan-700 transition-all">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="3">
                                    <path d="M12 4v16m8-8H4" />
                                </svg>
                                Add another step
                            </button>
                        </div>
                    </div>
                </div>

                <!-- الجهة اليمنى: الإعدادات الجانبية (4 أعمدة) -->
                <div class="col-span-12 lg:col-span-4 space-y-5">
                    <div class="bg-white p-7 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-8">

                        <!-- المسؤول -->
                        <div>
                            <label class="label-premium">Assignee</label>
                            <div class="relative group">
                                <div
                                    class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6 bg-cyan-500 rounded-lg flex items-center justify-center text-[9px] text-white font-black">
                                    NI
                                </div>
                                <select name="assignee_id" required
                                    class="w-full bg-slate-50 border-none rounded-2xl py-3.5 pl-12 pr-4 text-xs font-bold text-slate-700 appearance-none focus:ring-4 focus:ring-cyan-500/5 focus:bg-white focus:border-cyan-500 transition-all outline-none">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $task->assignee_id == $user->id ? 'selected' : '' }}>{{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Work Group Section (Dynamic & Context Aware) -->
                        <div>
                            <label class="label-premium">Work Group</label>
                            <div class="grid grid-cols-1 gap-2 mt-3">
                                @forelse($taskCategories as $category)
                                    <label
                                        class="relative flex items-center justify-between px-4 py-3.5 bg-slate-50 rounded-2xl cursor-pointer border border-transparent hover:border-cyan-200 transition-all group">
                                        <div class="flex items-center">
                                            <!-- الدائرة الملونة الخاصة بالتصنيف -->
                                            <div class="w-2 h-2 rounded-full mr-3"
                                                style="background-color: {{ $category->color ?? '#06b6d4' }}"></div>
                                            <span
                                                class="text-xs font-bold text-slate-600 group-hover:text-slate-900 transition-colors">
                                                {{ $category->name }}
                                            </span>
                                        </div>

                                        <!-- الراديو بوتن: نضع شرط التحقق ليكون مختاراً إذا كان يطابق تصنيف المهمة -->
                                        <input type="radio" name="category" value="{{ $category->name }}"
                                            class="w-4 h-4 text-cyan-500 border-slate-300 focus:ring-cyan-500"
                                            {{ $task->category == $category->name ? 'checked' : '' }}>
                                    </label>
                                @empty
                                    <div class="p-4 border-2 border-dashed border-slate-100 rounded-2xl text-center">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">No
                                            categories defined</p>
                                        <a href="{{ route('settings.groups') }}"
                                            class="text-[10px] text-cyan-600 underline font-black">Add Groups</a>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- التواريخ (مؤطرة بشكل بشري) -->
                        <div class="pt-6 border-t border-slate-50 space-y-4">
                            <div
                                class="group flex items-center bg-slate-50 rounded-2xl p-3 border border-transparent focus-within:border-cyan-500 focus-within:bg-white transition-all">
                                <div class="flex-1 ml-3">
                                    <span class="block text-[8px] font-black uppercase tracking-widest text-slate-400">Start
                                        Date</span>
                                    <input type="date" name="start_date" value="{{ $task->start_date }}"
                                        class="w-full bg-transparent border-none p-0 text-xs font-bold text-slate-700 focus:ring-0 outline-none">
                                </div>
                            </div>

                            <div
                                class="group flex items-center bg-slate-50 rounded-2xl p-3 border border-transparent focus-within:border-rose-400 focus-within:bg-white transition-all">
                                <div class="flex-1 ml-3">
                                    <span
                                        class="block text-[8px] font-black uppercase tracking-widest text-rose-500/70">Deadline</span>
                                    <input type="date" name="due_date" value="{{ $task->due_date }}" required
                                        class="w-full bg-transparent border-none p-0 text-xs font-bold text-slate-700 focus:ring-0 outline-none">
                                </div>
                            </div>
                        </div>

                        <!-- الأولوية والساعات -->
                        <div class="pt-6 border-t border-slate-50 grid grid-cols-2 gap-4">
                            <div>
                                <label class="label-premium">Priority</label>
                                <select name="priority" class="premium-input text-xs font-bold appearance-none">
                                    <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Normal
                                    </option>
                                    <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ $task->priority == 'urgent' ? 'selected' : '' }}>Critical
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
