@extends('layouts.master')

@section('breadcrumbs')
    <span class="text-slate-400">Settings</span>
    <span class="mx-2 opacity-30">/</span>
    <span class="text-slate-900 font-semibold italic text-[11px] uppercase tracking-widest">Team Members</span>
@endsection

@section('content')
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-10">

        {{-- Header --}}
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-6 mb-8 sm:mb-12">
            <div class="w-full sm:w-auto">
                <h1 class="heading-font text-2xl sm:text-3xl font-[800] text-slate-900 tracking-tight">Team Directory</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium italic">Manage workspace access and team leadership.</p>
            </div>

            @if ($isOwner)
                <button onclick="toggleModal('inviteMemberModal', true)" 
                    class="btn-primary inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-2.5 sm:py-3.5 shadow-cyan-100 w-full sm:w-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Invite Member</span>
                </button>
            @endif
        </header>

        {{-- Table Container with Horizontal Scroll --}}
        <div class="bg-white rounded-2xl sm:rounded-[2.5rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden">
            
            {{-- Wrapper for horizontal scroll on mobile --}}
            <div class="overflow-x-auto">
                <div class="min-w-[800px] lg:min-w-full">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="py-4 sm:py-5 px-4 sm:px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Member Info</th>
                                <th class="py-4 sm:py-5 px-4 sm:px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Department / Role</th>
                                <th class="py-4 sm:py-5 px-4 sm:px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Leadership Status</th>
                                <th class="py-4 sm:py-5 px-4 sm:px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">

                            @if ($isOwner)
                                {{-- Owner Row --}}
                                <tr class="bg-white">
                                    <td class="py-4 sm:py-6 px-4 sm:px-8">
                                        <div class="flex items-center gap-3 sm:gap-4">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($workspace->owner->name) }}&background=0f172a&color=fff&bold=true"
                                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl shadow-sm">
                                            <div class="min-w-0">
                                                <p class="text-xs sm:text-sm font-bold text-slate-900 leading-none truncate">{{ $workspace->owner->name }}</p>
                                                <p class="text-[10px] sm:text-[11px] text-slate-400 mt-1 sm:mt-1.5 font-medium truncate">{{ $workspace->owner->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 sm:py-6 px-4 sm:px-8">
                                        <span class="text-[10px] font-black uppercase text-slate-300 whitespace-nowrap">Workspace Owner</span>
                                    </td>
                                    <td class="py-4 sm:py-6 px-4 sm:px-8">
                                        <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-indigo-600 bg-indigo-50 px-2 sm:px-2 py-1 rounded whitespace-nowrap">Full Control</span>
                                    </td>
                                    <td class="py-4 sm:py-6 px-4 sm:px-8 text-right">—</td>
                                </tr>

                                {{-- Members --}}
                                @foreach ($members as $member)
                                    @if ($member->id != $workspace->owner_id)
                                        <tr class="group hover:bg-slate-50/30 transition-all">
                                            <td class="py-4 sm:py-6 px-4 sm:px-8">
                                                <div class="flex items-center gap-3 sm:gap-4">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=f1f5f9&color=64748b"
                                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl">
                                                    <div class="min-w-0">
                                                        <p class="text-xs sm:text-sm font-bold text-slate-700 leading-none truncate">{{ $member->name }}</p>
                                                        <p class="text-[10px] sm:text-[11px] text-slate-400 mt-1 sm:mt-1.5 font-medium truncate">{{ $member->email }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="py-4 sm:py-6 px-4 sm:px-8">
                                                @if ($member->pivot->job_title)
                                                    <button onclick="openAssignModal({{ $member->id }}, '{{ $member->pivot->job_title }}')"
                                                        class="text-[9px] sm:text-[10px] font-black uppercase text-cyan-600 bg-cyan-50 px-2 sm:px-2.5 py-1 rounded-md border border-cyan-100/50 hover:bg-cyan-100 transition-all whitespace-nowrap">
                                                        {{ $member->pivot->job_title }}
                                                    </button>
                                                @else
                                                    <button onclick="openAssignModal({{ $member->id }}, '')"
                                                        class="text-[8px] sm:text-[9px] font-black uppercase text-rose-500 bg-rose-50 px-1.5 sm:px-2 py-1 rounded-md border border-rose-100 hover:bg-rose-100 animate-pulse transition-all whitespace-nowrap">
                                                        Assign Group +
                                                    </button>
                                                @endif
                                            </td>

                                            <td class="py-4 sm:py-6 px-4 sm:px-8">
                                                @if ($member->pivot->role === 'lead' || $member->is_auto_lead)
                                                    <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-amber-600 bg-amber-50 px-2 sm:px-3 py-1 rounded-full border border-amber-100 whitespace-nowrap">Team Lead</span>
                                                @else
                                                    <span class="text-[9px] sm:text-[10px] font-bold uppercase text-slate-300 whitespace-nowrap">Member</span>
                                                @endif
                                            </td>

                                            <td class="py-4 sm:py-6 px-4 sm:px-8 text-right">
                                                <div class="flex justify-end items-center gap-2 sm:gap-4 transition-all">
                                                    <form action="{{ route('settings.members.role', $member->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="role" value="{{ $member->pivot->role === 'lead' ? 'member' : 'lead' }}">
                                                        <button type="submit"
                                                            class="text-[9px] sm:text-[10px] font-black uppercase text-cyan-600 hover:underline whitespace-nowrap">
                                                            {{ $member->pivot->role === 'lead' ? 'Demote' : 'Set as Lead' }}
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('settings.members.remove', $member->id) }}" method="POST" onsubmit="return confirm('Remove member?')" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-slate-300 hover:text-rose-500 transition-colors p-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                {{-- Restricted Access --}}
                                <tr>
                                    <td colspan="4" class="py-16 sm:py-32 px-4 text-center">
                                        <div class="opacity-20 flex flex-col items-center">
                                            <svg class="w-10 h-10 sm:w-12 sm:h-12 mb-3 sm:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="2" />
                                            </svg>
                                            <p class="text-[10px] sm:text-xs font-black uppercase tracking-widest">Restricted Access</p>
                                            <p class="text-[8px] sm:text-[10px] font-medium mt-1">Only the Workspace Owner can manage the Team Directory.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Invite Member Modal --}}
    <div id="inviteMemberModal" class="hidden fixed inset-0 z-[250] items-center justify-center p-4 sm:p-6">
        <div class="absolute inset-0 bg-slate-950/40 backdrop-blur-sm" onclick="toggleModal('inviteMemberModal', false)"></div>
        <div class="relative bg-white rounded-2xl sm:rounded-[2.5rem] shadow-2xl w-full max-w-sm p-6 sm:p-10 border border-slate-100 transform transition-all scale-95 opacity-0 max-h-[90vh] overflow-y-auto">
            <div class="text-center mb-6 sm:mb-8">
                <h3 class="heading-font text-xl sm:text-2xl font-bold text-slate-900">Add Member</h3>
                <p class="text-[10px] sm:text-xs text-slate-400 font-medium mt-1 uppercase tracking-widest">Connect your team</p>
            </div>
            
            <form action="{{ route('settings.members.invite') }}" method="POST" class="space-y-4 sm:space-y-6">
                @csrf
                <div>
                    <label class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase ml-1">Member Email</label>
                    <input type="email" name="email" required placeholder="colleague@company.com"
                        class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm outline-none focus:ring-4 focus:ring-cyan-500/5 focus:border-cyan-500 transition-all">
                </div>
                
                <div>
                    <label class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase ml-1">Assign to Group</label>
                    <div class="relative">
                        <select name="job_title" required 
                            class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base outline-none focus:ring-4 focus:ring-cyan-500/5 focus:border-cyan-500 transition-all appearance-none text-slate-700">
                            <option value="" disabled selected>Select a group...</option>
                            @foreach ($workspace->taskCategories as $group)
                                <option value="{{ $group->name }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    
                    {{-- Show groups as badges on mobile for better UX --}}
                    <div class="mt-3 flex flex-wrap gap-1 sm:hidden">
                        @foreach ($workspace->taskCategories as $group)
                            <span class="text-[8px] bg-slate-100 px-2 py-1 rounded-full text-slate-600">{{ $group->name }}</span>
                        @endforeach
                    </div>
                </div>
                
                <button type="submit" class="w-full btn-primary !py-3 sm:!py-4 justify-center text-sm sm:text-base">
                    Invite to Masar
                </button>
            </form>
        </div>
    </div>

    {{-- Assign Department Modal --}}
    <div id="assignDeptModal" class="hidden fixed inset-0 z-[300] items-center justify-center p-4 sm:p-6">
        <div class="absolute inset-0 bg-slate-950/40 backdrop-blur-sm" onclick="toggleModal('assignDeptModal', false)"></div>
        <div class="relative bg-white rounded-2xl sm:rounded-[2rem] shadow-2xl w-full max-w-xs p-6 sm:p-8 border border-slate-100 transform transition-all max-h-[90vh] overflow-y-auto">
            <h4 class="text-base sm:text-lg font-bold text-slate-900 mb-3 sm:mb-4 text-center">Update Department</h4>
            
            <form id="assignDeptForm" method="POST" class="space-y-3 sm:space-y-4">
                @csrf
                <div class="relative">
                    <select name="job_title" required 
                        class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm outline-none focus:border-cyan-500 appearance-none">
                        @foreach ($workspace->taskCategories as $group)
                            <option value="{{ $group->name }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-slate-900 text-white font-bold py-2.5 sm:py-3 rounded-xl hover:bg-cyan-600 transition-all text-xs sm:text-sm">
                    Save Department
                </button>
            </form>
        </div>
    </div>

    <script>
        function openAssignModal(userId, currentDept) {
            const form = document.getElementById('assignDeptForm');
            form.action = `/settings/members/${userId}/update-dept`;
            toggleModal('assignDeptModal', true);
        }
    </script>
@endsection