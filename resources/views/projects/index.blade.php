@extends('layouts.master')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    
    <style>
        /* استخدام خط Inter العالمي - مريح جداً للعين وطبيعي */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; color: #1e293b; }
    </style>

    <!-- Page Header -->
    <header class="flex items-center justify-between mb-12 pb-6 border-b border-slate-100">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Projects</h1>
            <p class="text-sm text-slate-500 mt-1">Manage your team's workspace and productivity.</p>
        </div>
        
        <button onclick="openModal()" 
                class="bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-all flex items-center gap-2 shadow-md shadow-cyan-100 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 4v16m8-8H4"/></svg>
            New Project
        </button>
    </header>

    <!-- Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($projects as $project)
        <a href="{{ route('projects.show', $project->id) }}" class="bg-white rounded-3xl border border-slate-200/60 p-8 hover:border-cyan-400 hover:shadow-xl transition-all duration-300 flex flex-col group relative">
            
            <div class="flex justify-between items-center mb-6">
                <span class="text-xs font-medium text-slate-400">{{ $project->created_at->format('M d, Y') }}</span>
                <span class="px-3 py-1 bg-cyan-50 text-cyan-600 rounded-full text-[11px] font-bold">
                    {{ ucfirst($project->status) }}
                </span>
            </div>

            <div class="mb-10">
                <h3 class="text-xl font-bold text-slate-900 group-hover:text-cyan-600 transition-colors mb-2">
                    {{ $project->name }}
                </h3>
                <p class="text-[14px] text-slate-500 leading-relaxed line-clamp-3">
                    {{ $project->description ?? 'No description provided for this project. Start by adding milestones and goals to help your team stay on track.' }}
                </p>
            </div>

            <div class="mt-auto pt-6 border-t border-slate-50">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                         <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=06b6d4&color=fff" 
                              class="w-8 h-8 rounded-full shadow-sm" title="Project Owner">
                        <span class="text-xs font-medium text-slate-400 ">Solo workspace</span>
                    </div>
                    <span class="text-xs font-bold text-slate-400">{{ $project->progress ?? 0 }}%</span>
                </div>

                <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                    <div class="bg-cyan-500 h-full rounded-full transition-all duration-1000 shadow-sm" 
                         style="width: {{ $project->progress ?? 0 }}%"></div>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full py-20 text-center bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
             <h3 class="text-lg font-semibold text-slate-900">Your project list is empty</h3>
             <p class="text-sm text-slate-400 mt-1">Create your first project to get started.</p>
        </div>
        @endforelse
    </div>

    <!-- Modal: New Project -->
<div id="newProjectModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
    <!-- خلفية ضبابية خفيفة جداً -->
    <div class="absolute inset-0 bg-slate-900/30 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
    
    <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md p-10 transform transition-all scale-95 opacity-0 duration-300 border border-slate-50" id="modalContainer">
        
        <!-- Header Section -->
        <div class="text-center mb-10">
            <!-- Icon -->
            <div class="w-12 h-12 bg-cyan-50 text-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            
            <!-- Title & Subtitle (التعديل هنا) -->
            <h3 class="text-2xl font-bold text-slate-900 tracking-tight mb-2">New Project</h3>
            <p class="text-[14px] text-slate-400 font-medium leading-relaxed max-w-[240px] mx-auto">
                Define your goals and start building with your team today.
            </p>
        </div>
        
        <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="space-y-1.5">
                <label class="text-[11px] font-bold text-slate-400 tracking-widest ml-1">Project Name</label>
                <input type="text" name="name" required placeholder="e.g. Design System"
                       class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none text-sm font-semibold focus:ring-4 focus:ring-cyan-500/10 focus:bg-white outline-none transition-all placeholder:text-slate-300">
            </div>

            <div class="space-y-1.5">
                <label class="text-[11px] font-bold text-slate-400 tracking-widest ml-1">Description</label>
                <textarea name="description" rows="3" placeholder="What are the goals?"
                          class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none text-sm font-semibold focus:ring-4 focus:ring-cyan-500/10 focus:bg-white outline-none transition-all placeholder:text-slate-300"></textarea>
            </div>
            
            <div class="flex items-center gap-4 pt-4">
                <button type="button" onclick="closeModal()" 
                        class="flex-1 py-4 text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-2 px-8 py-4 bg-cyan-500 text-white rounded-2xl text-sm font-bold shadow-lg shadow-cyan-100 hover:bg-cyan-600 transition-all active:scale-95">
                    Create Project
                </button>
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
        setTimeout(() => { modal.classList.add('hidden'); }, 200);
    }
</script>
@endsection