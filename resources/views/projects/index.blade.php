@extends('layouts.master')

@section('breadcrumbs')
    <span class="text-slate-900 font-semibold  text-[11px] uppercase tracking-widest">Projects Registry</span>
@endsection

@section('content')
    <div class="max-w-[1400px] mx-auto px-8 py-10 space-y-10">
        
        <header class="flex flex-col md:flex-row justify-between items-end gap-6 pb-6 border-b border-slate-100">
            <div>
                <h1 class="heading-font text-3xl font-800 text-slate-900 tracking-tight">
                    {{ auth()->user()->isSuperAdmin() ? 'Global Administration' : 'My Project Board' }}
                </h1>
                <p class="text-[11px] text-slate-400 font-bold tracking-[0.2em] mt-1 ">
                    {{ auth()->user()->isSuperAdmin() ? 'Central Registry of all workspace activities' : 'Manage your led and participating projects' }}
                </p>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex bg-slate-100 p-1 rounded-xl shrink-0">
                    <a href="{{ route('projects.index', ['filter' => 'active']) }}"
                        class="px-5 py-2 rounded-lg text-xs font-bold transition-all {{ $filter != 'archived' ? 'bg-white shadow-sm text-cyan-600' : 'text-slate-500 hover:text-slate-700' }}">
                        Active
                    </a>
                    <a href="{{ route('projects.index', ['filter' => 'archived']) }}"
                        class="px-5 py-2 rounded-lg text-xs font-bold transition-all {{ $filter == 'archived' ? 'bg-white shadow-sm text-amber-600' : 'text-slate-500 hover:text-slate-700' }}">
                        Archived
                    </a>
                </div>

                @if(!auth()->user()->isSuperAdmin())
                    <button onclick="toggleModal('createProjectModal', true)" class="bg-slate-900 text-white px-6 py-3 rounded-xl text-[10px] font-black  tracking-widest shadow-lg hover:bg-cyan-600 transition-all">
                        + New Project
                    </button>
                @endif
            </div>
        </header>

        <!-- القسم الرئيسي -->
        <section class="space-y-8">
            <div class="flex items-center gap-3 px-2">
                <div class="w-2 h-2 rounded-full {{ $filter == 'archived' ? 'bg-amber-500' : 'bg-cyan-500' }} shadow-lg"></div>
                <h3 class="text-sm font-black  tracking-widest text-slate-900 ">
                    {{ auth()->user()->isSuperAdmin() ? 'All System Projects' : ($filter == 'archived' ? 'Archived Vault' : 'Projects I Lead') }}
                </h3>
                <span class="text-[10px] font-black text-slate-300 bg-slate-50 px-2 py-0.5 rounded border border-slate-100">
                    {{ $ledProjects->total() }} Projects
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($ledProjects as $project)
                    @php
                        $totalT = $project->tasks()->whereNull('parent_id')->count();
                        $doneT = $project->tasks()->whereNull('parent_id')->where('status', 'done')->count();
                        $perc = $totalT > 0 ? round(($doneT / $totalT) * 100) : 0;
                        $isOwner = auth()->id() === $project->workspace->owner_id || auth()->user()->isSuperAdmin();
                    @endphp
                    
                    <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-xl transition-all group relative overflow-hidden flex flex-col justify-between h-full">
                        
                        @if($isOwner)
                            <div class="absolute top-6 right-6 z-20">
                                <form action="{{ route($filter == 'archived' ? 'projects.unarchive' : 'projects.archive', $project->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" 
                                            class="w-10 h-10 rounded-xl flex items-center justify-center transition-all shadow-sm border border-slate-50 
                                            {{ $filter == 'archived' ? 'bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white' : 'bg-slate-50 text-slate-300 hover:bg-amber-500 hover:text-white' }}"
                                            title="{{ $filter == 'archived' ? 'Restore Project' : 'Archive Project' }}">
                                        @if($filter == 'archived')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                        @endif
                                    </button>
                                </form>
                            </div>
                        @endif

                        <div>
                            <div class="mb-6">
                                <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:text-cyan-600 transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2z" stroke-width="2"/></svg>
                                </div>
                            </div>

                            <h4 class="text-xl font-800 text-slate-900 mb-2 group-hover:text-cyan-600 transition-colors leading-tight capitalize">{{ $project->name }}</h4>
                            <p class="text-xs text-slate-400 font-medium line-clamp-2 mb-8 leading-relaxed">{{ $project->description ?? 'No description provided.' }}</p>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <div class="flex justify-between text-[10px] font-black  tracking-tighter">
                                    <span class="text-slate-400 ">Project Health</span>
                                    <span class="text-slate-900">{{ $perc }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 h-1 rounded-full overflow-hidden">
                                    <div class="bg-cyan-500 h-full transition-all duration-1000" style="width: {{ $perc }}%"></div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                                <div class="flex -space-x-2">
                                    @foreach($project->users->take(3) as $u)
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=f1f5f9&color=64748b&bold=true" class="w-7 h-7 rounded-lg border-2 border-white shadow-sm">
                                    @endforeach
                                </div>
                                
                                <a href="{{ route('projects.show', $project->id) }}" class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center hover:bg-cyan-600 transition-all shadow-lg shadow-slate-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-24 text-center opacity-30  font-bold  tracking-widest text-xs">No entries found</div>
                @endforelse
            </div>
            <div class="mt-8">{{ $ledProjects->links() }}</div>
        </section>

        @if(!auth()->user()->isSuperAdmin() && $participatingProjects->count() > 0)
            <section class="space-y-8 pt-12 border-t border-slate-100">
                <div class="flex items-center gap-3 px-2">
                    <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                    <h3 class="text-sm font-black  tracking-widest text-slate-400 ">Shared With Me</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 opacity-90">
                    @foreach($participatingProjects as $project)
                        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm flex flex-col justify-between h-full group">
                            <div><h4 class="text-lg font-800 text-slate-700 mb-4 capitalize">{{ $project->name }}</h4></div>
                            <div class="flex justify-between items-center pt-6 border-t border-slate-50">
                                <span class="text-[9px] font-black text-slate-300 uppercase">Contributor</span>
                                <a href="{{ route('projects.show', $project->id) }}" class="text-[10px] font-black text-cyan-600 hover:underline uppercase">Enter Board →</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

    </div>

    <div id="createProjectModal" class="hidden fixed inset-0 z-[500] items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="toggleModal('createProjectModal', false)"></div>
        <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md p-10 border border-slate-100 transform transition-all">
            <h3 class="heading-font text-2xl font-800 text-slate-900 mb-6">Start New Mission</h3>
            <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Project Name</label>
                    <input type="text" name="name" required class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all">
                </div>
                <button type="submit" class="w-full btn-primary !py-4 justify-center">Deploy Project</button>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id, show) {
            const el = document.getElementById(id);
            if(show) { el.classList.replace('hidden', 'flex'); }
            else { el.classList.replace('flex', 'hidden'); }
        }
    </script>
@endsection