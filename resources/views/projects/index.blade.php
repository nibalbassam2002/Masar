@extends('layouts.master')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    <!-- Page Header -->
    <header class="flex items-center justify-between mb-10 pb-6 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Projects</h1>
            <p class="text-[13px] text-slate-400 font-medium mt-1 uppercase tracking-widest">Management System</p>
        </div>
        
        <!-- Updated Button Color to Cyan -->
        <button onclick="openModal()" 
                class="bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-3 rounded-xl text-[12px] font-black uppercase tracking-widest transition-all flex items-center gap-2 shadow-lg shadow-cyan-100 active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4"/></svg>
            New Project
        </button>
    </header>

    <!-- Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($projects as $project)
        <div class="bg-white rounded-[2rem] border border-slate-200/50 p-6 hover:border-cyan-300 hover:shadow-2xl hover:shadow-cyan-500/10 transition-all duration-500 flex flex-col group relative overflow-hidden">
            
            <!-- Project Status Tag -->
            <div class="flex justify-between items-center mb-6">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $project->created_at->format('M d, Y') }}</span>
                <span class="px-3 py-1 bg-cyan-50 text-cyan-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">
                    {{ $project->status }}
                </span>
            </div>

            <!-- Project Info -->
            <div class="mb-8">
                <h3 class="text-xl font-black text-slate-900 group-hover:text-cyan-600 transition-colors mb-2">
                    {{ $project->name }}
                </h3>
                <p class="text-[13px] text-slate-500 leading-relaxed line-clamp-2 font-medium">
                    {{ $project->description ?? 'No description provided. Click to add details and milestones.' }}
                </p>
            </div>

            <!-- Team & Progress Footer -->
            <div class="mt-auto pt-6 border-t border-slate-50">
                <div class="flex items-center justify-between mb-4">
                    <!-- Avatars -->
                    <div class="flex -space-x-2">
                        <img src="https://ui-avatars.com/api/?name=User&background=06b6d4&color=fff" class="w-8 h-8 rounded-full border-2 border-white shadow-sm">
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-50 flex items-center justify-center text-[10px] font-bold text-slate-400">+2</div>
                    </div>
                    <span class="text-[10px] font-black text-slate-400 uppercase">Progress: {{ $project->progress ?? 0 }}%</span>
                </div>

                <!-- Sleek Cyan Progress Bar -->
                <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                    <div class="bg-cyan-500 h-full rounded-full transition-all duration-1000 shadow-[0_0_8px_rgba(6,182,212,0.4)]" 
                         style="width: {{ $project->progress ?? 0 }}%"></div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-24 text-center bg-slate-50 rounded-[3rem] border-2 border-dashed border-slate-200">
             <div class="text-4xl mb-4 text-slate-300">📂</div>
             <h3 class="text-lg font-bold text-slate-900">No Projects Found</h3>
             <p class="text-sm text-slate-400">Start your first journey by clicking the button above.</p>
        </div>
        @endforelse
    </div>

    <!-- The "Human" Modal -->
    <div id="newProjectModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal()"></div>
        
        <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md p-10 transform transition-all scale-95 opacity-0 duration-300 border border-slate-100" id="modalContainer">
            <div class="mb-8 text-center">
                <div class="w-12 h-12 bg-cyan-50 text-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                </div>
                <h3 class="text-xl font-black text-slate-900">Create Project</h3>
                <p class="text-[13px] text-slate-400 font-medium mt-1">Organize your tasks and team members.</p>
            </div>
            
            <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Project Name</label>
                    <input type="text" name="name" required placeholder="e.g. Website Redesign"
                           class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none text-sm font-bold focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all">
                </div>
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Description</label>
                    <textarea name="description" rows="3" placeholder="What's the goal?"
                              class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none text-sm font-bold focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all"></textarea>
                </div>
                
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeModal()" class="flex-1 py-4 text-xs font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-all">Cancel</button>
                    <button type="submit" class="flex-1 bg-cyan-500 text-white py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-cyan-600 shadow-lg shadow-cyan-100 transition-all">Create Now</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal() {
        const modal = document.getElementById('newProjectModal');
        const container = document.getElementById('modalContainer');
        modal.classList.remove('hidden');
        setTimeout(() => { container.classList.remove('scale-95', 'opacity-0'); }, 10);
    }
    function closeModal() {
        const modal = document.getElementById('newProjectModal');
        const container = document.getElementById('modalContainer');
        container.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { modal.classList.add('hidden'); }, 300);
    }
</script>
@endsection