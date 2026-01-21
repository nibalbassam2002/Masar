<nav class="h-24 bg-white/80 backdrop-blur-md border-b border-slate-100 px-6 lg:px-10 flex items-center justify-between sticky top-0 z-40 flex-shrink-0">
    
    <div class="flex items-center gap-4">
        <button @click="openMobile = true" class="lg:hidden p-2 text-slate-500 hover:bg-slate-50 rounded-xl transition-all">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
        <div class="flex flex-col">
            <div class="hidden sm:flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">
                <span>Pages</span>
                <span class="text-slate-200">/</span>
                <span class="text-cyan-600">Dashboard</span>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-4 lg:gap-8">
        <!-- البحث -->
        <div class="hidden md:flex relative group">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 group-focus-within:text-cyan-500 transition-colors"></i>
            <input type="text" placeholder="Search projects..." class="bg-slate-50 border border-slate-100 rounded-2xl pl-12 pr-6 py-2.5 text-sm w-64 focus:bg-white focus:ring-4 focus:ring-cyan-500/5 transition-all outline-none font-medium">
        </div>

        <!-- الإشعارات -->
        <button class="w-11 h-11 flex items-center justify-center text-slate-500 hover:bg-cyan-50 hover:text-cyan-600 rounded-2xl transition-all relative group">
            <i data-lucide="bell" class="w-5 h-5 group-hover:animate-bounce"></i>
            <span class="absolute top-3 right-3 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white"></span>
        </button>

        <!-- قائمة المستخدم المنسدلة (التي كانت مفقودة) -->
        <div class="relative group ml-2">
            <button class="flex items-center gap-3 p-1.5 pr-4 rounded-2xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-cyan-500 overflow-hidden shadow-lg shadow-cyan-100">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=06b6d4&color=fff" class="w-full h-full object-cover">
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-sm font-black text-slate-800 leading-none mb-1">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] font-bold text-cyan-600 uppercase tracking-tighter">Super Admin</p>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-hover:rotate-180 transition-transform"></i>
            </button>

            <!-- القائمة المنسدلة -->
            <div class="absolute right-0 mt-2 w-60 bg-white border border-slate-100 rounded-[24px] shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden translate-y-2 group-hover:translate-y-0">
                <div class="p-5 border-b border-slate-50 bg-slate-50/50">
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1">Account Info</p>
                    <p class="text-sm font-bold text-slate-700 truncate">{{ auth()->user()->email }}</p>
                </div>
                <div class="p-2">
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-600 hover:bg-cyan-50 hover:text-cyan-600 rounded-xl transition-colors">
                        <i data-lucide="settings" class="w-4 h-4"></i> Profile Settings
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-600 hover:bg-cyan-50 hover:text-cyan-600 rounded-xl transition-colors">
                        <i data-lucide="shield-check" class="w-4 h-4"></i> Security
                    </a>
                </div>
                <div class="p-2 border-t border-slate-50">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold text-rose-500 hover:bg-rose-50 rounded-xl transition-colors">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>