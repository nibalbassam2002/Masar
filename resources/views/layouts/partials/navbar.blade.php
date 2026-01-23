<nav class="h-16 bg-white border-b border-slate-100 px-8 flex items-center justify-between shrink-0 sticky top-0 z-40">
    
    <!-- Left: Search Bar (نحيف واحترافي) -->
    <div class="flex-1 max-w-md">
        <div class="relative group">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 group-focus-within:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Search tasks or files..." class="w-full bg-slate-50 border-none rounded-xl py-2 pl-10 pr-4 text-xs font-medium focus:ring-4 focus:ring-cyan-500/5 focus:bg-white transition-all outline-none">
        </div>
    </div>

    <!-- Right: Notifications & User Dropdown -->
    <div class="flex items-center gap-2">
        
        <!-- Notifications -->
        <button class="p-2 text-slate-400 hover:text-cyan-600 hover:bg-slate-50 rounded-xl transition-all relative mr-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 border-2 border-white rounded-full"></span>
        </button>

        <!-- Vertical Divider -->
        <div class="h-8 w-px bg-slate-100 mx-2"></div>

        <!-- User Profile Dropdown (نستخدم Alpine.js للتفاعل) -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" @click.away="open = false" 
                    class="flex items-center gap-3 p-1.5 pr-3 rounded-2xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 group">
                <div class="w-9 h-9 rounded-xl bg-cyan-500 overflow-hidden shadow-lg shadow-cyan-100 flex-shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=06b6d4&color=fff&bold=true" class="w-full h-full object-cover">
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-xs font-black text-slate-900 leading-none mb-1">{{ auth()->user()->name }}</p>
                    <p class="text-[9px] font-bold text-cyan-600 uppercase tracking-widest truncate">
                    {{ auth()->user()->job_title ?? 'Workspace Member' }}
                </p>
                </div>
                <svg :class="open ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3"/></svg>
            </button>

            <!-- Dropdown Content: النسخة الفخمة -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-cloak
                 class="absolute right-0 mt-3 w-56 bg-white border border-slate-100 rounded-[24px] shadow-2xl z-50 overflow-hidden py-2">
                
                <div class="px-5 py-4 border-b border-slate-50 mb-2 bg-slate-50/50">
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1">Email Address</p>
                    <p class="text-xs font-bold text-slate-700 truncate">{{ auth()->user()->email }}</p>
                </div>

                <a href="#" class="flex items-center gap-3 px-5 py-3 text-xs font-bold text-slate-600 hover:bg-cyan-50 hover:text-cyan-600 transition-all">
                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profile Settings
                </a>

                <a href="#" class="flex items-center gap-3 px-5 py-3 text-xs font-bold text-slate-600 hover:bg-cyan-50 hover:text-cyan-600 transition-all">
                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Security
                </a>

                <div class="h-px bg-slate-50 my-2 mx-4"></div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-xs font-bold text-rose-500 hover:bg-rose-50 transition-all">
                        <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>