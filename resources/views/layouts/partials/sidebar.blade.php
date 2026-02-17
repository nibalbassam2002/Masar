<div x-show="isSidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="isSidebarOpen = false"
    class="fixed inset-0 bg-slate-900/60 z-[50] lg:hidden backdrop-blur-sm" x-cloak>
</div>

<aside :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-[60] {{ $isCompact ?? false ? 'w-20' : 'w-72' }} bg-white border-r border-slate-100 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shrink-0 flex flex-col h-full shadow-2xl lg:shadow-none"
    :style="isCompact ? 'width: 5rem' : 'width: 18rem'">
    <button @click="isCompact = !isCompact"
        class="hidden lg:flex absolute -right-3 top-11 w-6 h-6 bg-white border border-slate-200 rounded-full items-center justify-center text-slate-400 hover:text-cyan-500 shadow-sm z-[60] transition-all">
        <svg :class="isCompact ? 'rotate-180' : ''" class="w-3.5 h-3.5 transition-transform" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>

    <button @click="isSidebarOpen = false"
        class="lg:hidden absolute right-4 top-10 p-2 text-slate-400 hover:text-rose-500 transition-all">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" />
        </svg>
    </button>

    <div class="p-6 h-28 flex items-center border-b border-slate-50 shrink-0">
        <div class="flex items-center gap-4">
            <div
                class="w-11 h-11 bg-white rounded-2xl flex items-center justify-center border-2 border-cyan-400 shadow-lg shadow-cyan-100/50 shrink-0">
                <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain">
            </div>
            <div x-show="!isCompact" x-transition.opacity class="flex flex-col">
                <span class="text-2xl font-[900] text-cyan-600 tracking-tighter uppercase leading-none">Masar</span>
                <span class="text-[9px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-2">Management</span>
            </div>
        </div>
    </div>

    <nav class="flex-1 px-4 py-8 space-y-8 overflow-y-auto custom-scroll">
        <div>
            <p x-show="!isCompact" class="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-300 mb-4">
                Core</p>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('dashboard') ? 'bg-cyan-50 text-cyan-600 font-bold' : 'text-slate-500 hover:bg-slate-50' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>

                    <span x-show="!isCompact" class="text-sm">Dashboard</span>
                </a>

                <a href="{{ route('projects.index') }}"
                    class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('projects.*') ? 'bg-cyan-50 text-cyan-600 font-bold' : 'text-slate-500 hover:bg-slate-50' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                            stroke-width="2" />
                    </svg>
                    <span x-show="!isCompact" class="text-sm">Projects</span>
                </a>

                <a href="{{ route('tasks.index') }}"
                    class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('tasks.*') ? 'bg-cyan-50 text-cyan-600 font-bold' : 'text-slate-500 hover:bg-slate-50' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 114 0"
                            stroke-width="2" />
                    </svg>
                    <span x-show="!isCompact" class="text-sm">Tasks List</span>
                </a>
            </div>
        </div>

        <div>
            <p x-show="!isCompact" class="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-300 mb-4">
                Administration</p>
            <div class="space-y-1">
                <a href="{{ route('settings.groups') }}"
                    class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('settings.groups') ? 'bg-cyan-50 text-cyan-600 font-bold' : 'text-slate-500 hover:bg-slate-50' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                            stroke-width="2" />
                    </svg>
                    <span x-show="!isCompact" class="text-sm font-semibold">Work Groups</span>
                </a>

                <a href="{{ route('settings.members') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('settings.members') ? 'bg-cyan-50 text-cyan-600' : 'text-slate-500 hover:bg-slate-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span x-show="!isCompact" class="text-sm font-semibold">Team Members</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- User Profile Section -->
    <div class="p-4 m-4 rounded-[24px] bg-slate-50 border border-slate-100 shrink-0">
        <div class="flex items-center gap-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=06b6d4&color=fff&bold=true"
                class="w-10 h-10 rounded-xl shadow-sm border border-white">

            <div x-show="!isCompact" class="overflow-hidden text-left">
                <p class="text-sm font-black text-slate-800 truncate leading-none mb-1.5">{{ auth()->user()->name }}
                </p>
                <p class="text-[9px] font-bold text-cyan-600 uppercase tracking-widest truncate">
                    @php $currentWorkspace = auth()->user()->workspaces()->first(); @endphp
                    {{ $currentWorkspace ? auth()->user()->roleInWorkspace($currentWorkspace->id) : 'Guest' }}
                </p>
            </div>
        </div>
    </div>
</aside>
