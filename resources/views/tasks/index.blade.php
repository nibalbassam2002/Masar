@extends('layouts.master')

@section('breadcrumbs')
    <span class="text-slate-900 font-semibold italic">My Assignments</span>
@endsection

@section('content')
    <div class="max-w-[1400px] mx-auto px-8 py-8 space-y-8">
        <header class="flex flex-col md:flex-row justify-between items-end gap-6 pb-6 border-b border-slate-100">
            <div>
                <h1 class="heading-font text-3xl font-800 text-slate-900 tracking-tight">Personal Backlog</h1>
                <p class="text-[11px] text-slate-400 font-bold  tracking-[0.2em] mt-1">Manage your individual contributions
                    across projects</p>
            </div>

            <div class="flex items-center gap-4">
                <!-- نظام تبديل الحالة الذكي -->
                <div class="flex bg-slate-100 p-1 rounded-xl shrink-0">
                    <!-- زر المهام النشطة -->
                    <a href="{{ route('tasks.index', ['filter' => 'active']) }}"
                        class="px-5 py-2 rounded-lg text-xs font-bold transition-all {{ $filter != 'completed' ? 'bg-white shadow-sm text-cyan-600' : 'text-slate-500 hover:text-slate-700' }}">
                        Active Tasks
                    </a>

                    <!-- زر المهام المكتملة -->
                    <a href="{{ route('tasks.index', ['filter' => 'completed']) }}"
                        class="px-5 py-2 rounded-lg text-xs font-bold transition-all {{ $filter == 'completed' ? 'bg-white shadow-sm text-cyan-600' : 'text-slate-500 hover:text-slate-700' }}">
                        Completed
                    </a>
                </div>

                <!-- زر إضافة مهمة جديدة -->
                <a href="{{ route('tasks.create') }}" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path d="M12 4v16m8-8H4" />
                    </svg>
                    New Task
                </a>
            </div>
        </header>
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Task Details
                        </th>
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Workspace /
                            Project</th>
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Timeline</th>
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($tasks as $task)
                        <tr class="group hover:bg-slate-50/40 transition-colors">

                            <!-- Task Title & Category -->
                            <td class="py-6 px-8">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-1.5 h-1.5 rounded-full {{ $task->priority == 'urgent' ? 'bg-rose-500 animate-pulse' : 'bg-cyan-500' }}">
                                    </div>
                                    <div>
                                        <!-- جعلنا الاسم رابطاً لصفحة العرض -->
                                        <a href="{{ route('tasks.show', $task->id) }}"
                                            class="text-sm font-bold text-slate-800 leading-none hover:text-cyan-600 transition-colors">
                                            {{ $task->title }}
                                        </a>
                                        <span
                                            class="inline-block mt-2 text-[9px] font-black uppercase tracking-tighter text-slate-400 bg-slate-50 px-2 py-0.5 rounded border border-slate-100">
                                            {{ $task->category }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Project Link -->
                            <td class="py-6 px-8">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-600">{{ $task->project->name ?? 'Deleted Project' }}</span>
                                    <span class="text-[9px] text-slate-400 uppercase tracking-widest mt-1">Production</span>
                                </div>
                            </td>

                            <!-- Status Badge -->
                            <td class="py-6 px-8">
                                <span
                                    class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter {{ $task->status == 'done' ? 'bg-emerald-50 text-emerald-600' : 'bg-cyan-50 text-cyan-600' }}">
                                    {{ str_replace('_', ' ', $task->status) }}
                                </span>
                            </td>

                            <!-- Deadline -->
                            <td class="py-6 px-8">
                                <div class="flex flex-col">
                                    <span
                                        class="text-xs font-bold {{ \Carbon\Carbon::parse($task->due_date)->isPast() ? 'text-rose-500' : 'text-slate-500' }}">
                                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M, Y') : 'Set Date' }}
                                    </span>
                                    <p class="text-[9px] font-bold text-slate-300 uppercase mt-1">{{ $task->priority }}
                                        priority</p>
                                </div>
                            </td>

                            <!-- خلية الإجراءات -->
                            <td class="py-6 px-8 text-right shrink-0">
                                <div class="flex justify-end items-center gap-3">

                                    <!-- زر عرض التفاصيل الجديد -->
                                    <a href="{{ route('tasks.show', $task->id) }}"
                                        class="w-9 h-9 flex items-center justify-center text-slate-400 hover:text-cyan-500 hover:bg-cyan-50 rounded-xl transition-all border border-transparent hover:border-cyan-100"
                                        title="View Details">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            stroke-width="2.2">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <!-- تعديل -->
                                    <a href="{{ route('tasks.edit', $task->id) }}"
                                        class="w-9 h-9 flex items-center justify-center text-slate-400 hover:text-primary-500 hover:bg-primary-50 rounded-xl transition-all border border-transparent hover:border-primary-100"
                                        title="Edit Task">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            stroke-width="2.5">
                                            <path
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>

                                    <!-- حذف -->
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                        onsubmit="return confirm('Archive this task?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-9 h-9 flex items-center justify-center text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-all border border-transparent hover:border-rose-100"
                                            title="Delete Task">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                stroke-width="2.5">
                                                <path
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-24 text-center">
                                <div class="flex flex-col items-center justify-center opacity-30">
                                    <div class="w-16 h-16 bg-slate-50 rounded-3xl flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 114 0"
                                                stroke-width="1.5" />
                                        </svg>
                                    </div>
                                    <p class="heading-font text-lg font-bold text-slate-900">Your list is clear</p>
                                    <p class="text-xs font-medium text-slate-400 mt-1 uppercase tracking-widest">No pending
                                        assignments found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
