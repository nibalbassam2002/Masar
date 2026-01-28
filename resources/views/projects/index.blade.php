@extends('layouts.master')

@section('breadcrumbs')
    <span class="text-slate-900 font-bold uppercase tracking-[0.2em] text-[10px]">Portfolio Management</span>
@endsection

@section('content')
<div class="max-w-[1500px] mx-auto px-8 py-8 space-y-16">
    
    <!-- 1. Global Page Header -->
    <header class="flex flex-col md:flex-row justify-between items-center gap-6 border-b border-slate-100 pb-8">
        <div class="flex items-center gap-8 flex-1 w-full">
            <h1 class="heading-font text-3xl font-800 text-slate-900 tracking-tighter">Projects</h1>
            
            <!-- Quick Search Bar -->
            <div class="relative w-full max-w-sm group hidden md:block">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 group-focus-within:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="Jump to project..." 
                       class="w-full bg-slate-50 border-none text-xs font-semibold py-2.5 pl-11 pr-4 rounded-xl focus:ring-4 focus:ring-cyan-500/5 focus:bg-white transition-all outline-none">
            </div>
        </div>

        <button onclick="openModal()" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4"/></svg>
            New Project
        </button>
    </header>

    <!-- 2. Section: Projects I Lead (السيان الموحد) -->
    <section class="space-y-6">
        <div class="flex items-center gap-4">
            <h2 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Projects I Lead</h2>
            <span class="px-2 py-0.5 bg-cyan-50 text-cyan-600 rounded text-[9px] font-bold border border-cyan-100">{{ $ledProjects->total() }}</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @forelse($ledProjects as $project)
                <a href="{{ route('projects.show', $project->id) }}" class="group bg-white p-7 rounded-[2rem] border border-slate-200/60 shadow-sm hover:shadow-xl hover:border-cyan-400 hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:text-cyan-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="px-2.5 py-1 bg-cyan-50 text-cyan-600 rounded-lg text-[8px] font-black uppercase border border-cyan-100 tracking-tighter">Project Lead</span>
                    </div>

                    <h3 class="text-base font-bold text-slate-900 group-hover:text-cyan-600 transition-colors capitalize leading-tight">{{ $project->name }}</h3>
                    <p class="text-[11px] text-slate-400 line-clamp-2 mt-2 leading-relaxed">
                        {{ $project->description ?? 'Project workspace defined for team velocity.' }}
                    </p>
                    
                    <div class="mt-8 pt-4 border-t border-slate-50 flex items-center justify-between">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Progress</span>
                        <span class="text-[10px] font-black text-cyan-600">{{ $project->progress }}%</span>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-16 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem] bg-slate-50/30">
                    <p class="text-[11px] font-bold text-slate-300 uppercase tracking-widest leading-none">No personal projects founded yet</p>
                </div>
            @endforelse
        </div>
        <div class="pt-4">{{ $ledProjects->appends(['part_page' => $participatingProjects->currentPage()])->links() }}</div>
    </section>

    <!-- 3. Section: Participating Projects (الآن باللون السيان الموحد) -->
    <section class="space-y-6 pt-10 border-t border-slate-50">
        <div class="flex items-center gap-4">
            <h2 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Participating Projects</h2>
            <span class="px-2 py-0.5 bg-cyan-50 text-cyan-600 rounded text-[9px] font-bold border border-cyan-100">{{ $participatingProjects->total() }}</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @forelse($participatingProjects as $project)
                <a href="{{ route('projects.show', $project->id) }}" class="group bg-white p-7 rounded-[2rem] border border-slate-200/60 shadow-sm hover:shadow-xl hover:border-cyan-400 hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="flex justify-between items-start mb-6">
                        <!-- صورة المالك بدلاً من الإيموجي -->
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($project->workspace->owner->name) }}&background=06b6d4&color=fff&bold=true" class="w-9 h-9 rounded-xl shadow-sm border-2 border-white">
                        <span class="px-2.5 py-1 bg-slate-50 text-slate-500 rounded-lg text-[12px] font-black  border border-slate-100 tracking-tighter">partner</span>
                    </div>

                    <h3 class="text-base font-bold text-slate-900 group-hover:text-cyan-600 transition-colors capitalize leading-tight">{{ $project->name }}</h3>
                    <!-- معلومات المالك بلمسة بشرية -->
                    <div class="mt-2 flex items-center gap-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        <span class="opacity-50 ">Led by</span>
                        <span class="text-cyan-600">{{ $project->workspace->owner->name }}</span>
                    </div>
                    
                    <div class="mt-8 pt-4 border-t border-slate-50 flex items-center justify-between">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Team Status</span>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Active Member</span>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-16 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem] bg-slate-50/30">
                    <p class="text-[11px] font-bold text-slate-300 uppercase tracking-widest leading-none">You haven't been invited to external projects yet</p>
                </div>
            @endforelse
        </div>
        <div class="pt-4">{{ $participatingProjects->appends(['led_page' => $ledProjects->currentPage()])->links() }}</div>
    </section>

    @include('projects.partials.create-modal')
</div>
@endsection