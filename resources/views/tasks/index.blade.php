@extends('layouts.master')

@section('breadcrumbs')
    <span class="text-slate-900 font-semibold italic text-[11px] uppercase tracking-widest">Task Center</span>
@endsection

@section('content')
    <div class="max-w-[1400px] mx-auto px-8 py-8 space-y-8">

        <header class="flex flex-col md:flex-row justify-between items-end gap-6 pb-6 border-b border-slate-100">
            <div>
                <h1 class="heading-font text-3xl font-800 text-slate-900 tracking-tight">
                    {{ auth()->user()->isSuperAdmin() ? 'Global Mission Control' : 'Personal Backlog' }}
                </h1>
                <p class="text-[11px] text-slate-400 font-bold tracking-[0.2em] mt-1 uppercase">
                    {{ auth()->user()->isSuperAdmin() ? 'Monitoring all system-wide activities' : 'Manage your individual contributions' }}
                </p>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex bg-slate-100 p-1 rounded-xl shrink-0">
                    <a href="{{ route('tasks.index', ['filter' => 'active']) }}"
                        class="px-5 py-2 rounded-lg text-xs font-bold transition-all {{ $filter == 'active' ? 'bg-white shadow-sm text-cyan-600' : 'text-slate-500 hover:text-slate-700' }}">
                        Active Tasks
                    </a>
                    <a href="{{ route('tasks.index', ['filter' => 'completed']) }}"
                        class="px-5 py-2 rounded-lg text-xs font-bold transition-all {{ $filter == 'completed' ? 'bg-white shadow-sm text-cyan-600' : 'text-slate-500 hover:text-slate-700' }}">
                        Completed
                    </a>
                    <a href="{{ route('tasks.index', ['filter' => 'archived']) }}"
                        class="px-5 py-2 rounded-lg text-xs font-bold transition-all {{ $filter == 'archived' ? 'bg-white shadow-sm text-amber-600' : 'text-slate-500 hover:text-slate-700' }}">
                        Archived
                    </a>
                </div>

                <a href="{{ route('tasks.create') }}" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4" /></svg>
                    New Task
                </a>
            </div>
        </header>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Role / Mission</th>
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Project Context</th>
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Assignees</th>
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest w-48">Timeline</th>
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($tasks as $task)
                        @php
                            $isActuallyMe = $task->assignees->contains(auth()->id()) || $task->assignee_id === auth()->id();
                            $isManager = auth()->user()->isSuperAdmin() || ($task->project?->workspace?->owner_id === auth()->id());
                        @endphp

                        <tr class="group hover:bg-slate-50/40 transition-colors {{ $isActuallyMe ? 'bg-cyan-50/20' : '' }}">
                            <td class="py-6 px-8">
                                <div class="flex items-center gap-4">
                                    <div class="flex flex-col items-center gap-1">
                                        @if ($isActuallyMe)
                                            <span class="px-1.5 py-0.5 bg-cyan-600 text-white text-[8px] font-black rounded uppercase shadow-sm">My Task</span>
                                        @elseif ($isManager)
                                            <span class="px-1.5 py-0.5 bg-slate-800 text-white text-[8px] font-black rounded uppercase shadow-sm">Manager</span>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('tasks.show', $task->id) }}" class="text-sm font-bold text-slate-800 hover:text-cyan-600 leading-none transition-colors">{{ $task->title }}</a>
                                        <span class="block mt-1.5 text-[9px] font-bold text-slate-400 uppercase tracking-tighter">{{ $task->category }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="py-6 px-8">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-600">{{ $task->project?->name ?? 'Standalone' }}</span>
                                    <span class="text-[9px] text-slate-300 uppercase tracking-widest mt-1">Production</span>
                                </div>
                            </td>

                            <td class="py-6 px-8">
                                <div class="flex items-center gap-3">
                                    <div class="flex -space-x-2">
                                        @forelse($task->assignees as $u)
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background={{ $u->id === auth()->id() ? '06b6d4' : 'f1f5f9' }}&color={{ $u->id === auth()->id() ? 'fff' : '64748b' }}&bold=true"
                                                class="w-7 h-7 rounded-lg border-2 border-white shadow-sm" title="{{ $u->name }}">
                                        @empty
                                            @if($task->assignee_id)
                                                @php $legacyU = \App\Models\User::find($task->assignee_id); @endphp
                                                @if($legacyU)
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($legacyU->name) }}&background={{ $legacyU->id === auth()->id() ? '06b6d4' : 'f1f5f9' }}&color={{ $legacyU->id === auth()->id() ? 'fff' : '64748b' }}&bold=true" class="w-7 h-7 rounded-lg border-2 border-white shadow-sm">
                                                @endif
                                            @else
                                                <span class="text-[9px] text-slate-300 italic uppercase">Unassigned</span>
                                            @endif
                                        @endforelse
                                    </div>
                                    <span class="text-[10px] font-bold {{ $isActuallyMe ? 'text-cyan-600' : 'text-slate-400' }}">
                                        {{ $isActuallyMe ? 'Me' : 'Team' }}
                                    </span>
                                </div>
                            </td>

                            <td class="py-6 px-8">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter 
                                    @if($task->status == 'done') bg-emerald-50 text-emerald-600 
                                    @elseif($task->status == 'archived') bg-amber-50 text-amber-600 
                                    @else bg-cyan-50 text-cyan-600 @endif">
                                    {{ str_replace('_', ' ', $task->status) }}
                                </span>
                            </td>

                            <td class="py-6 px-8">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold {{ $task->due_date && \Carbon\Carbon::parse($task->due_date)->isPast() && $task->status != 'done' ? 'text-rose-500' : 'text-slate-500' }}">
                                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M, Y') : 'No Date' }}
                                    </span>
                                    <p class="text-[9px] font-black text-slate-300 uppercase mt-1">{{ $task->priority }}</p>
                                </div>
                            </td>

                            <td class="py-6 px-8 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('tasks.show', $task->id) }}" class="p-2 text-slate-300 hover:text-cyan-500 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>

                                    @if ($isManager)
                                        @if($filter == 'archived')
                                            <form action="{{ route('tasks.unarchive', $task->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="p-2 text-emerald-500 hover:bg-emerald-50 rounded-xl transition-all" title="Restore">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('tasks.edit', $task->id) }}" class="p-2 text-slate-300 hover:text-amber-500 transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                            </a>
                                            <form action="{{ route('tasks.archive', $task->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="p-2 text-slate-300 hover:text-amber-500 transition-all" title="Archive">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Delete permanently?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-300 hover:text-rose-500 transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-24 text-center opacity-30 italic font-bold uppercase tracking-widest text-xs">
                                No tasks found in this section
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection