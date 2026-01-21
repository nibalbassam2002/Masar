<div class="h-full flex flex-col relative overflow-hidden bg-white">

    <!-- زر الإغلاق (X) للجوال - يظهر فقط في الشاشات الصغيرة -->
    <div class="lg:hidden absolute top-5 right-5 z-50">
        <button @click="openMobile = false"
            class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-2xl transition-all duration-200 bg-white shadow-sm border border-slate-100">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>
    </div>

    <!-- زر تصغير السايد بار (ديسكتوب فقط) -->
    <button @click="isCompact = !isCompact"
        class="hidden lg:flex fixed top-20 w-6 h-6 bg-white border border-slate-200 rounded-full items-center justify-center text-slate-400 hover:text-cyan-500 shadow-md z-[100] transition-all duration-300"
        :style="isCompact ? 'left: 68px;' : 'left: 276px;'">
        <i data-lucide="chevron-left" :class="isCompact ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"></i>
    </button>

    <!-- Branding Section -->
    <div class="p-6 h-24 flex items-center border-b border-slate-50 flex-shrink-0">
        <div class="flex items-center gap-4 min-w-[250px]">
            <div
                class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center border-2 border-cyan-400 shadow-lg shadow-cyan-100 flex-shrink-0">
                <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
            </div>
            <div x-show="!isCompact" x-transition.opacity class="flex flex-col">
                <span class="text-2xl font-black text-cyan-600 tracking-tighter">MASAR</span>
                <span class="text-[9px] text-slate-400 font-bold uppercase tracking-[0.3em]">Management</span>
            </div>
        </div>
    </div>

    <!-- Navigation Groups -->
    <div class="flex-1 overflow-y-auto py-8 px-4 space-y-10 custom-scrollbar">
        <div>
            <p x-show="!isCompact" class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-5 px-4">
                Main Menu</p>
            <nav class="space-y-2">
                <a href="/dashboard"
                    class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->is('dashboard') ? 'bg-cyan-500 text-white shadow-lg shadow-cyan-200' : 'text-slate-500 hover:bg-slate-50 hover:text-cyan-600' }}">
                    <i data-lucide="layout-grid" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="!isCompact" class="font-bold text-sm whitespace-nowrap">Dashboard</span>
                </a>

                <a href="{{ route('projects.index') }}"
                    class="flex items-center gap-4 px-4 py-3.5 text-slate-500 hover:bg-slate-50 hover:text-cyan-600 rounded-2xl transition-all group">
                    <i data-lucide="folder"
                        class="w-5 h-5 flex-shrink-0 group-hover:text-cyan-500 transition-colors"></i>
                    <span x-show="!isCompact" class="font-bold text-sm whitespace-nowrap">Projects</span>
                </a>

                <a href="#"
                    class="flex items-center gap-4 px-4 py-3.5 text-slate-500 hover:bg-slate-50 hover:text-cyan-600 rounded-2xl transition-all group">
                    <i data-lucide="check-square"
                        class="w-5 h-5 flex-shrink-0 group-hover:text-cyan-500 transition-colors"></i>
                    <span x-show="!isCompact" class="font-bold text-sm whitespace-nowrap">Tasks List</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- User Section الفخم بالأسفل -->
    <div class="p-4 m-4 rounded-[24px] bg-slate-50 border border-slate-100 flex-shrink-0 overflow-hidden shadow-sm">
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-cyan-500 font-black flex-shrink-0 shadow-sm">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div x-show="!isCompact" x-transition.opacity class="flex-1 min-w-0">
                <p class="text-sm font-black text-slate-800 truncate leading-none mb-1">{{ auth()->user()->name }}</p>
                <p class="text-[10px] font-bold text-cyan-600 uppercase tracking-tighter">Super Admin</p>
            </div>
        </div>
    </div>
</div>
