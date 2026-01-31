@extends('layouts.master')

@section('breadcrumbs')
    <span class="text-slate-400">Settings</span>
    <span class="mx-2 opacity-30">/</span>
    <span class="text-slate-900 font-semibold italic text-[11px] uppercase tracking-widest">My Groups</span>
@endsection

@section('content')
    <div class="max-w-[1000px] mx-auto px-8 py-10">

        <header class="mb-12">
            <h1 class="heading-font text-3xl font-[800] text-slate-900 tracking-tight">Workspace Groups</h1>
            <p class="text-slate-500 mt-2 font-medium italic">Create and manage your own team categories for your projects.
            </p>
        </header>

        <div class="grid lg:grid-cols-3 gap-12">

            <div class="lg:col-span-1">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <h3 class="text-[11px] font-bold text-slate-900 uppercase tracking-widest mb-6">Create New Group</h3>

                    <form action="{{ route('settings.groups.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Group
                                Name</label>
                            <input type="text" name="name" required placeholder="e.g. My Dev Team"
                                class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all">
                        </div>
                        <button type="submit" class="w-full btn-primary !py-4 justify-center shadow-cyan-100">Add to My
                            List</button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div
                    class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50/50 border-b border-slate-100">
                            <tr>
                                <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Group
                                    Name (Created by Me)</th>
                                <th
                                    class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($groups as $group)
                                <tr class="group hover:bg-slate-50/30 transition-all">
                                    <td class="py-5 px-8">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-2 h-2 rounded-full bg-cyan-500 shadow-[0_0_8px_rgba(6,182,212,0.4)]">
                                            </div>
                                            <div>
                                                <span
                                                    class="text-sm font-bold text-slate-700 capitalize">{{ $group->name }}</span>

                                                <!-- إظهار اسم مساحة العمل للسوبر آدمن فقط لتمييز التكرار -->
                                                @if (auth()->user()->isSuperAdmin())
                                                    <span class="block text-[8px] font-black text-slate-300 uppercase mt-1">
                                                        Workspace: {{ $group->workspace?->name ?? 'Global' }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5 px-8 text-right">
                                        <form action="{{ route('settings.groups.destroy', $group->id) }}" method="POST"
                                            onsubmit="return confirm('Delete this group?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="text-slate-300 hover:text-rose-500 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" stroke-width="2.5">
                                                    <path
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                               
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
