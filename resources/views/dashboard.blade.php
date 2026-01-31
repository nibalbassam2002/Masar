@extends('layouts.master')

@section('content')
<div class="bg-[#fcfcfd]">
<div class="max-w-[1600px] mx-auto px-10 py-10">
<header class="flex justify-between items-center mb-12">
            <div>
                <h1 class="heading-font text-4xl font-800 text-slate-900 tracking-tight">
                    Mission <span class="text-cyan-500">Control</span>
                </h1>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.3em] mt-2">
                    {{ $isOwner ? 'Executive Insights' : 'My Performance Hub' }} / {{ $workspace->name }}
                </p>
            </div>
            <div class="flex gap-4">
                <div class="bg-white px-6 py-3 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full {{ $isOwner ? 'bg-cyan-500 animate-pulse' : 'bg-emerald-500' }}">
                    </div>
                    <span class="text-[10px] font-black uppercase text-slate-500 tracking-widest">
                        Role:
                        {{ auth()->user()->isSuperAdmin() ? 'Super Admin' : ($isOwner ? 'Workspace Owner' : 'Team Member') }}
                    </span>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                <span class="text-[9px] font-black uppercase text-cyan-400 tracking-[0.2em]">Projects Managed</span>
                <h3 class="text-6xl font-800 mt-4 tracking-tighter">{{ $managedProjects->count() }}</h3>
            </div>
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
                <span class="text-[9px] font-black text-slate-400 tracking-[0.2em]">Active Missions</span>
                <h3 class="text-6xl font-800 text-slate-900 mt-4 tracking-tighter">{{ $activeCount }}</h3>
            </div>
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm text-center">
                <span class="text-[9px] font-black text-emerald-500 tracking-[0.2em]">Completed</span>
                <h3 class="text-6xl font-800 text-slate-900 mt-4 tracking-tighter">{{ $doneCount }}</h3>
            </div>
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm text-center">
                <span class="text-[9px] font-black text-rose-500 tracking-[0.2em]">Critical Risk</span>
                <h3 class="text-6xl font-800 text-rose-600 mt-4 tracking-tighter">{{ $criticalMissions->count() }}</h3>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-10">

            <div class="col-span-12 lg:col-span-8 space-y-10">
                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/20">
                        <h3 class="text-sm font-black uppercase tracking-widest text-slate-900 italic">Managed Projects
                        </h3>
                        <span
                            class="px-3 py-1 bg-cyan-500 text-white text-[8px] font-black rounded-full uppercase">{{ $managedProjects->count() }}
                            Active</span>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @forelse($managedProjects as $proj)
                            @php
                                $total = $proj->tasks()->whereNull('parent_id')->count();
                                $done = $proj->tasks()->whereNull('parent_id')->where('status', 'done')->count();
                                $percent = $total > 0 ? round(($done / $total) * 100) : 0;
                            @endphp
                            <div
                                class="p-8 hover:bg-slate-50/50 transition-all flex items-center justify-between group">
                                <div class="flex-1">
                                    <h4
                                        class="text-lg font-800 text-slate-800 group-hover:text-cyan-600 transition-colors">
                                        {{ $proj->name }}</h4>
                                    <div class="flex items-center gap-6 mt-4">
                                        <div class="flex-1 bg-slate-100 h-1 rounded-full overflow-hidden">
                                            <div class="bg-cyan-500 h-full rounded-full"
                                                style="width: {{ $percent }}%"></div>
                                        </div>
                                        <span class="text-xs font-black text-slate-900">{{ $percent }}%</span>
                                    </div>
                                </div>
                                <a href="{{ route('projects.show', $proj->id) }}"
                                    class="ml-10 w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        stroke-width="3">
                                        <path d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        @empty
                            <p class="p-10 text-center text-xs text-slate-300 italic uppercase">No projects currently
                                managed.</p>
                        @endforelse
                    </div>
                </div>

                @if ($participatingProjects->count() > 0)
                    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
                        <div class="p-8 border-b border-slate-50">
                            <h3 class="text-sm font-black uppercase tracking-widest text-slate-400 italic">Participating
                                In</h3>
                        </div>
                        <div class="divide-y divide-slate-50">
                            @foreach ($participatingProjects as $proj)
                                <div class="p-8 hover:bg-slate-50 transition-all flex items-center justify-between">
                                    <h4 class="text-lg font-800 text-slate-500">{{ $proj->name }}</h4>
                                    <a href="{{ route('projects.show', $proj->id) }}"
                                        class="text-[10px] font-black text-cyan-600 uppercase hover:underline">View
                                        board →</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-span-12 lg:col-span-4 space-y-10">

                @if ($teamWorkload->isNotEmpty())
                    <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm">
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-900 mb-8">Workforce Load
                        </h3>
                        <div class="space-y-6">
                            @foreach ($teamWorkload as $member)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background={{ $member->id == auth()->id() ? '0f172a' : 'f1f5f9' }}&color={{ $member->id == auth()->id() ? 'fff' : '64748b' }}&bold=true"
                                            class="w-10 h-10 rounded-2xl shadow-sm border-2 border-white ring-4 ring-slate-50/50">
                                        <div>
                                            <p class="text-sm font-bold text-slate-800 leading-none">
                                                {{ $member->id == auth()->id() ? 'Me' : explode(' ', $member->name)[0] }}
                                            </p>
                                            <p
                                                class="text-[8px] font-black text-slate-300 uppercase mt-2 tracking-widest">
                                                {{ $member->pivot?->job_title ?? ($member->id == ($workspace->owner_id ?? 0) ? 'Founder' : 'Staff') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="bg-cyan-50 px-3 py-1.5 rounded-xl border border-cyan-100 flex items-center gap-2">
                                        <span
                                            class="text-sm font-black text-cyan-600">{{ $member->active_tasks_count }}</span>
                                        <span class="text-[8px] font-bold text-cyan-400 uppercase">Tasks</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="bg-rose-50 p-8 rounded-[3rem] border border-rose-100">
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-rose-600 mb-6 flex items-center">
                        <span class="w-2 h-2 bg-rose-500 rounded-full mr-2 animate-ping"></span> Critical Deadlines
                    </h3>
                    <div class="space-y-4">
                        @forelse($criticalMissions as $m)
                            <div
                                class="bg-white p-5 rounded-2xl shadow-sm border border-rose-100 hover:scale-[1.02] transition-all">
                                <span class="text-[8px] font-black text-rose-400 uppercase">
                                    {{ $m->project?->name ?? 'General Task' }}
                                </span>
                                <h4 class="text-xs font-bold text-slate-800 mt-1 leading-tight">{{ $m->title }}
                                </h4>
                                <div class="mt-4 flex justify-between items-center">
                                    <span class="text-[9px] font-bold text-rose-500 uppercase italic">Due:
                                        {{ \Carbon\Carbon::parse($m->due_date)->format('d M') }}</span>
                                    <a href="{{ route('tasks.show', $m->id) }}"
                                        class="text-[8px] font-black text-cyan-600 uppercase hover:underline">Resolve
                                        →</a>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-[10px] text-rose-300 font-bold italic py-4 uppercase">No
                                immediate risks</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection