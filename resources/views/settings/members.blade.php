@extends('layouts.master')

@section('breadcrumbs')
    <span class="text-slate-400">Settings</span>
    <span class="mx-2 opacity-30">/</span>
    <span class="text-slate-900 font-semibold italic text-[11px] uppercase tracking-widest">Team Members</span>
@endsection

@section('content')
<div class="max-w-[1200px] mx-auto px-8 py-10">
    
    <!-- Page Header -->
    <header class="flex justify-between items-center mb-12">
        <div>
            <h1 class="heading-font text-3xl font-[800] text-slate-900 tracking-tight">Team Directory</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium italic">Manage who has access to this workspace.</p>
        </div>
        
        <!-- زر فتح المودال (نستخدم نظامنا الموحد) -->
        <button onclick="toggleModal('inviteMemberModal', true)" 
                class="btn-primary !px-8 !py-3.5 shadow-cyan-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4"/></svg>
            Invite Member
        </button>
    </header>

    <!-- Members Table -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Member Info</th>
                    <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Workspace Role</th>
                    <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <!-- المالك (صاحب الحساب) يظهر دائماً في الأعلى -->
                <tr class="bg-white">
                    <td class="py-6 px-8">
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($workspace->owner->name) }}&background=06b6d4&color=fff&bold=true" class="w-10 h-10 rounded-xl shadow-sm">
                            <div>
                                <p class="text-sm font-bold text-slate-900 leading-none">{{ $workspace->owner->name }}</p>
                                <p class="text-[11px] text-slate-400 mt-1.5 font-medium">{{ $workspace->owner->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-6 px-8">
                        <span class="text-[10px] font-black uppercase tracking-widest text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded">Workspace Owner</span>
                    </td>
                    <td class="py-6 px-8 text-xs font-bold text-emerald-500 uppercase tracking-tighter">Active Now</td>
                    <td class="py-6 px-8 text-right">—</td>
                </tr>

                <!-- باقي الأعضاء -->
                @forelse($members as $member)
                    @if($member->id != $workspace->owner_id)
                    <tr class="group hover:bg-slate-50/30 transition-all">
                        <td class="py-6 px-8">
                            <div class="flex items-center gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=f1f5f9&color=64748b" class="w-10 h-10 rounded-xl shadow-sm">
                                <div>
                                    <p class="text-sm font-bold text-slate-700 leading-none">{{ $member->name }}</p>
                                    <p class="text-[11px] text-slate-400 mt-1.5 font-medium">{{ $member->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-6 px-8">
                            <p class="text-xs font-bold text-slate-600">{{ $member->pivot->job_title ?? 'Collaborator' }}</p>
                        </td>
                        <td class="py-6 px-8 text-xs font-bold text-slate-400 uppercase tracking-tighter">Member</td>
                        <td class="py-6 px-8 text-right">
                            <form action="{{ route('settings.members.remove', $member->id) }}" method="POST" onsubmit="return confirm('Remove this member from workspace?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-slate-300 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endif
                @empty
                <!-- لا يوجد أعضاء حالياً -->
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Invite Member -->
<div id="inviteMemberModal" class="hidden fixed inset-0 z-[250] items-center justify-center p-6">
    <div class="absolute inset-0 bg-slate-950/40 backdrop-blur-sm" onclick="toggleModal('inviteMemberModal', false)"></div>
    <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-sm p-10 border border-slate-100 transform transition-all scale-95 opacity-0">
        <div class="text-center mb-8">
            <h3 class="heading-font text-2xl font-bold text-slate-900">Add Member</h3>
            <p class="text-xs text-slate-400 font-medium mt-1 uppercase tracking-widest">Connect your team</p>
        </div>
        <form action="{{ route('settings.members.invite') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="label-style">Member Email</label>
                <input type="email" name="email" required placeholder="colleague@company.com" class="input-field">
            </div>
            <div>
                <label class="label-style">Professional Role</label>
                <input type="text" name="job_title" required placeholder="e.g. Lead Designer" class="input-field">
            </div>
            <button type="submit" class="w-full btn-primary !py-4 justify-center">Invite to Masar</button>
        </form>
    </div>
</div>
@endsection