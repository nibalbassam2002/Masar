@extends('layouts.master')

@section('breadcrumbs')
    <a href="{{ route('projects.index') }}" class="hover:text-cyan-600">Projects</a>
    <span class="mx-1 opacity-30">/</span>

    @if (isset($project) && $project)
        <a href="{{ route('projects.show', $project->id) }}" class="hover:text-cyan-600">{{ $project->name }}</a>
    @else
        <span class="text-slate-400 italic font-normal">Global Task</span>
    @endif

    <span class="mx-1 opacity-30">/</span>
    <span class="text-slate-900 font-semibold uppercase tracking-tighter">New Task</span>
@endsection

@section('content')
    <div class="max-w-[1300px] mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6" x-data="{ subtasks: [''] }">

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <header class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 sm:mb-8 pb-6 border-b border-slate-100">
                <div>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight font-jakarta">Assign New Task</h1>
                    <p class="text-[10px] sm:text-xs text-slate-400 font-medium mt-1 uppercase tracking-widest">Workspace:
                        {{ $workspace->name }}</p>
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <a href="javascript:history.back()"
                        class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-widest px-3 sm:px-4 py-2 hover:text-slate-600">Cancel</a>
                    <button type="submit"
                        class="bg-cyan-500 text-white px-6 sm:px-8 py-2 sm:py-3 rounded-xl text-[10px] sm:text-[11px] font-black uppercase tracking-widest shadow-lg shadow-cyan-100 hover:bg-cyan-600 hover:scale-[1.02] active:scale-95 transition-all whitespace-nowrap">
                        Assign Task
                    </button>
                </div>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">

                <!-- العمود الأيمن (النموذج الرئيسي) - يظهر أولاً في الموبايل -->
                <div class="lg:col-span-8 space-y-6 order-1 lg:order-1">
                    <div class="bg-white p-5 sm:p-6 lg:p-8 rounded-2xl border border-slate-100 shadow-sm space-y-6 sm:space-y-8">
                        <!-- حقل العنوان -->
                        <div>
                            <label
                                class="block text-[9px] sm:text-[10px] font-bold text-cyan-600 uppercase tracking-[0.2em] mb-2 sm:mb-3 ml-1">Task
                                Title</label>
                            <input type="text" name="title" required placeholder="What needs to be done?"
                                class="w-full bg-transparent border-none p-0 text-xl sm:text-2xl lg:text-3xl font-bold text-slate-900 placeholder:text-slate-200 outline-none focus:ring-0">
                        </div>

                        <!-- حقل الوصف -->
                        <div class="pt-4 sm:pt-6 border-t border-slate-50">
                            <label
                                class="block text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 sm:mb-4 ml-1">Detailed
                                Description</label>
                            <textarea name="description" rows="8 sm:10 lg:12"
                                class="w-full bg-slate-50 rounded-xl p-3 sm:p-4 text-sm text-slate-600 border-none focus:ring-2 focus:ring-cyan-500/10 focus:bg-white outline-none transition-all placeholder:text-slate-300"
                                placeholder="Define acceptance criteria..."></textarea>
                        </div>

                        <!-- المهام الفرعية -->
                        <div class="space-y-3 pt-4 sm:pt-6 border-t border-slate-50">
                            <label
                                class="block text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 sm:mb-4 ml-1">Sub-tasks
                                Checklist</label>

                            <template x-for="(subtask, index) in subtasks" :key="index">
                                <div
                                    class="flex items-center gap-3 sm:gap-4 bg-slate-50 p-3 sm:p-4 rounded-2xl border border-slate-100/50 group mb-3">
                                    <div
                                        class="w-4 h-4 sm:w-5 sm:h-5 rounded-lg border-2 border-slate-200 shrink-0 group-hover:border-cyan-400 transition-colors">
                                    </div>
                                    <input type="text" name="subtasks[]" x-model="subtasks[index]"
                                        placeholder="Add a step..."
                                        class="bg-transparent border-none p-0 text-xs sm:text-sm font-medium w-full outline-none text-slate-600 placeholder:text-slate-200">
                                    <button type="button" @click="subtasks.splice(index, 1)" x-show="subtasks.length > 1"
                                        class="text-slate-300 hover:text-rose-500 transition-colors shrink-0">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            stroke-width="3">
                                            <path d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <button type="button" @click="subtasks.push('')"
                                class="inline-flex items-center text-[9px] sm:text-[10px] font-black text-cyan-600 uppercase tracking-widest mt-2 ml-2 hover:text-cyan-700 transition-all">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="3">
                                    <path d="M12 4v16m8-8H4" />
                                </svg>
                                Add another step
                            </button>
                        </div>
                    </div>
                </div>

                <!-- العمود الأيسر (الإعدادات) - يظهر ثانياً في الموبايل -->
                <div class="lg:col-span-4 space-y-5 order-2 lg:order-2">
                    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-100 shadow-sm space-y-5 sm:space-y-6">

                        <!-- اختيار المشروع -->
                        @if (!$project)
                            @if (!$project)
                                <div class="pb-5 sm:pb-6 border-b border-slate-50">
                                    <label
                                        class="block text-[9px] sm:text-[10px] font-bold text-cyan-600 uppercase tracking-widest mb-2 ml-1">Target
                                        Project</label>
                                    <select name="project_id" required
                                        class="w-full bg-slate-100/50 border-none rounded-xl p-2.5 sm:p-3 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-cyan-500/10">
                                        <option value="" disabled selected>Select one of your projects...</option>
                                        @foreach ($projects as $proj)
                                            <option value="{{ $proj->id }}">{{ $proj->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                            @endif
                        @else
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                        @endif

                        <!-- اختيار الأعضاء -->
                        <div>
                            <label
                                class="block text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Assign
                                Mission To (Select Team)</label>
                            <select name="assignee_ids[]" multiple required
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 sm:p-3 text-xs font-bold text-slate-700 outline-none focus:ring-4 focus:ring-cyan-500/5 min-h-[100px] sm:min-h-[120px]">
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}">
                                        {{ $u->name }} {{ $u->id === auth()->id() ? '(Me)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-[8px] sm:text-[9px] text-slate-400 mt-2 ml-1 italic">* Hold Ctrl (or Cmd) to select multiple
                                members</p>
                        </div>

                        <!-- مجموعات العمل -->
                        <div>
                            <label
                                class="block text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">
                                My Work Groups
                            </label>

                            <div class="space-y-2 mt-2 sm:mt-3">
                                @forelse($taskCategories as $category)
                                    <label
                                        class="relative flex items-center px-3 sm:px-4 py-2.5 sm:py-3 bg-slate-50 rounded-xl sm:rounded-2xl cursor-pointer border border-transparent hover:border-cyan-200 transition-all group">
                                        <input type="radio" name="category" value="{{ $category->name }}"
                                            class="sr-only peer" {{ $loop->first ? 'checked' : '' }}>
                                        <div
                                            class="w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full border-2 border-slate-300 peer-checked:border-cyan-500 peer-checked:bg-cyan-500 transition-all shrink-0">
                                        </div>
                                        <span class="ml-2 sm:ml-3 text-[11px] sm:text-xs font-bold text-slate-500 peer-checked:text-slate-900 break-words">
                                            {{ $category->name }}
                                        </span>
                                    </label>
                                @empty
                                    <div
                                        class="text-center py-3 sm:py-4 border-2 border-dashed border-slate-100 rounded-xl sm:rounded-2xl opacity-50">
                                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">No groups created yet</p>
                                    </div>
                                @endforelse

                                <a href="{{ route('settings.groups') }}"
                                    class="text-[9px] sm:text-[10px] font-bold text-cyan-600 uppercase tracking-widest mt-3 sm:mt-4 block text-center border border-dashed border-cyan-100 p-2.5 sm:p-3 rounded-xl hover:bg-cyan-50 transition-all">
                                    + Manage Work Groups
                                </a>
                            </div>
                        </div>

                        <!-- التواريخ -->
                        <div class="pt-4 sm:pt-6 border-t border-slate-50 space-y-3 sm:space-y-4">
                            <label class="block text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Project
                                Timeline</label>
                            <div class="bg-slate-50 rounded-xl p-2.5 sm:p-3">
                                <span class="block text-[7px] sm:text-[8px] font-black text-slate-400 uppercase mb-1">Start Date</span>
                                <input type="date" name="start_date"
                                    class="w-full bg-transparent border-none p-0 text-[11px] sm:text-xs font-bold text-slate-700 outline-none">
                            </div>
                            <div class="bg-slate-50 rounded-xl p-2.5 sm:p-3">
                                <span class="block text-[7px] sm:text-[8px] font-black text-rose-500 uppercase mb-1">Deadline</span>
                                <input type="date" name="due_date" required
                                    class="w-full bg-transparent border-none p-0 text-[11px] sm:text-xs font-bold text-slate-700 outline-none">
                            </div>
                        </div>

                        <!-- الأولوية -->
                        <div class="pt-1 border-t border-slate-50">
                            <div class="bg-slate-50 rounded-xl p-2.5 sm:p-3">
                                <span class="block text-[7px] sm:text-[8px] font-black text-slate-400 uppercase mb-1">Priority</span>
                                <select name="priority"
                                    class="w-full bg-transparent border-none p-0 text-[11px] sm:text-xs font-bold text-slate-700 outline-none">
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
    
    <script>
        document.querySelector('select[name="assignee_id"]').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const userDept = selectedOption.getAttribute('data-dept');

            if (userDept) {
                const deptRadio = document.querySelector(`input[name="category"][value="${userDept}"]`);
                if (deptRadio) deptRadio.checked = true;
            }
        });
    </script>
@endsection