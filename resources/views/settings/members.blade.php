@extends('layouts.master')

@section('breadcrumbs')
    <span class="text-slate-400">Settings</span>
    <span class="mx-2 opacity-30">/</span>
    <span class="text-slate-900 font-semibold italic text-[11px] uppercase tracking-widest">Team Members</span>
@endsection

@section('content')
    <div class="max-w-[1200px] mx-auto px-8 py-10">

        <header class="flex justify-between items-center mb-12">
            <div>
                <h1 class="heading-font text-3xl font-[800] text-slate-900 tracking-tight">Team Directory</h1>
                <p class="text-sm text-slate-500 mt-1 font-medium italic">Manage workspace access and team leadership.</p>
            </div>

            @if ($isOwner)
                <button onclick="toggleModal('inviteMemberModal', true)" class="btn-primary !px-8 !py-3.5 shadow-cyan-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path d="M12 4v16m8-8H4" />
                    </svg>
                    Invite Member
                </button>
            @endif
        </header>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Member Info
                        </th>
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Department /
                            Role</th>
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Leadership
                            Status</th>
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">

                    @if ($isOwner)
                        <tr class="bg-white">
                            <td class="py-6 px-8">
                                <div class="flex items-center gap-4">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($workspace->owner->name) }}&background=0f172a&color=fff&bold=true"
                                        class="w-10 h-10 rounded-xl shadow-sm">
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 leading-none">
                                            {{ $workspace->owner->name }}</p>
                                        <p class="text-[11px] text-slate-400 mt-1.5 font-medium">
                                            {{ $workspace->owner->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-6 px-8">
                                <span class="text-[10px] font-black uppercase text-slate-300">Workspace Owner</span>
                            </td>
                            <td class="py-6 px-8">
                                <span
                                    class="text-[10px] font-black uppercase tracking-widest text-indigo-600 bg-indigo-50 px-2 py-1 rounded">Full
                                    Control</span>
                            </td>
                            <td class="py-6 px-8 text-right">—</td>
                        </tr>

                        @foreach ($members as $member)
                            @if ($member->id != $workspace->owner_id)
                                <tr class="group hover:bg-slate-50/30 transition-all">
                                    <td class="py-6 px-8">
                                        <div class="flex items-center gap-4">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=f1f5f9&color=64748b"
                                                class="w-10 h-10 rounded-xl">
                                            <div>
                                                <p class="text-sm font-bold text-slate-700 leading-none">{{ $member->name }}
                                                </p>
                                                <p class="text-[11px] text-slate-400 mt-1.5 font-medium">
                                                    {{ $member->email }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-6 px-8">
                                        @if ($member->id == $workspace->owner_id)
                                            <span class="text-[10px] font-black uppercase text-slate-400">All
                                                Departments</span>
                                        @else
                                            @if ($member->pivot->job_title)
                                                <button
                                                    onclick="openAssignModal({{ $member->id }}, '{{ $member->pivot->job_title }}')"
                                                    class="text-[10px] font-black uppercase text-cyan-600 bg-cyan-50 px-2.5 py-1 rounded-md border border-cyan-100/50 hover:bg-cyan-100 transition-all">
                                                    {{ $member->pivot->job_title }}
                                                </button>
                                            @else
                                                <button onclick="openAssignModal({{ $member->id }}, '')"
                                                    class="text-[9px] font-black uppercase text-rose-500 bg-rose-50 px-2 py-1 rounded-md border border-rose-100 hover:bg-rose-100 animate-pulse transition-all">
                                                    Assign Group +
                                                </button>
                                            @endif
                                        @endif
                                    </td>

                                    <td class="py-6 px-8">
                                        @if ($member->pivot->role === 'lead' || $member->is_auto_lead)
                                            <span
                                                class="text-[10px] font-black uppercase tracking-widest text-amber-600 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">Team
                                                Lead</span>
                                        @else
                                            <span class="text-[10px] font-bold uppercase text-slate-300">Member</span>
                                        @endif
                                    </td>

                                    <td class="py-6 px-8 text-right">
                                        <div class="flex justify-end items-center gap-4 transition-all">
                                            <form action="{{ route('settings.members.role', $member->id) }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="role"
                                                    value="{{ $member->pivot->role === 'lead' ? 'member' : 'lead' }}">
                                                <button type="submit"
                                                    class="text-[10px] font-black uppercase text-cyan-600 hover:underline">
                                                    {{ $member->pivot->role === 'lead' ? 'Demote' : 'Set as Lead' }}
                                                </button>
                                            </form>

                                            <form action="{{ route('settings.members.remove', $member->id) }}"
                                                method="POST" onsubmit="return confirm('Remove member?')">
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
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="py-32 text-center">
                                <div class="opacity-20 flex flex-col items-center">
                                    <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                            stroke-width="2" />
                                    </svg>
                                    <p class="text-xs font-black uppercase tracking-widest">Restricted Access</p>
                                    <p class="text-[10px] font-medium mt-1">Only the Workspace Owner can manage the Team
                                        Directory.</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div id="inviteMemberModal" class="hidden fixed inset-0 z-[250] items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-950/40 backdrop-blur-sm" onclick="toggleModal('inviteMemberModal', false)">
        </div>
        <div
            class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-sm p-10 border border-slate-100 transform transition-all scale-95 opacity-0">
            <div class="text-center mb-8">
                <h3 class="heading-font text-2xl font-bold text-slate-900">Add Member</h3>
                <p class="text-xs text-slate-400 font-medium mt-1 uppercase tracking-widest">Connect your team</p>
            </div>
            <form action="{{ route('settings.members.invite') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Member Email</label>
                    <input type="email" name="email" required placeholder="colleague@company.com"
                        class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm outline-none focus:ring-4 focus:ring-cyan-500/5 focus:border-cyan-500 transition-all">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Assign to Group</label>
                    <select name="job_title" required
                        class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm outline-none focus:ring-4 focus:ring-cyan-500/5 focus:border-cyan-500 transition-all">
                        <option value="" disabled selected>Select a group...</option>
                        @foreach ($workspace->taskCategories as $group)
                            <option value="{{ $group->name }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full btn-primary !py-4 justify-center">Invite to Masar</button>
            </form>
        </div>
    </div>
<div id="assignDeptModal" class="hidden fixed inset-0 z-[300] items-center justify-center p-6">
    <div class="absolute inset-0 bg-slate-950/40 backdrop-blur-sm" onclick="toggleModal('assignDeptModal', false)"></div>
    <div class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-xs p-8 border border-slate-100 transform transition-all">
        <h4 class="text-lg font-bold text-slate-900 mb-4 text-center">Update Department</h4>
        
        <form id="assignDeptForm" method="POST" class="space-y-4">
            @csrf
            <select name="job_title" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm outline-none focus:border-cyan-500">
                @foreach ($workspace->taskCategories as $group)
                    <option value="{{ $group->name }}">{{ $group->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="w-full bg-slate-900 text-white font-bold py-3 rounded-xl hover:bg-cyan-600 transition-all">
                Save Department
            </button>
        </form>
    </div>
</div>

<script>
    function openAssignModal(userId, currentDept) {
        const form = document.getElementById('assignDeptForm');
        // تغيير رابط الفورم ليرسل البيانات للعضو الصحيح
        form.action = `/settings/members/${userId}/update-dept`;
        
        // فتح المودال
        toggleModal('assignDeptModal', true);
    }
</script>
@endsection
