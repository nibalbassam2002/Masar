<div class="h-full flex flex-col relative bg-white">
    
    <!-- 1. زر تصغير السايد بار: تم إنزاله وتوسيطه بدقة (Top-11) -->
    <button @click="isCompact = !isCompact" 
            class="hidden lg:flex absolute -right-3 top-24 w-6 h-6 bg-white border border-slate-200 rounded-full items-center justify-center text-slate-400 hover:text-cyan-500 shadow-md z-[60] transition-all hover:scale-110 active:scale-95">
        <svg :class="isCompact ? 'rotate-180' : ''" class="w-3.5 h-3.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <!-- 2. Branding Section -->
    <div class="p-6 h-28 flex items-center border-b border-slate-50 shrink-0">
        <div class="flex items-center gap-4">
            <!-- إطار الشعار الفخم -->
            <div class="w-11 h-11 bg-white rounded-2xl flex items-center justify-center border-2 border-cyan-400 shadow-lg shadow-cyan-100/50 shrink-0 transform transition-transform group-hover:scale-105">
                <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
            </div>
            
            <!-- اسم البراند باللون السيان المعتمد -->
            <div x-show="!isCompact" x-transition.opacity class="flex flex-col">
                <span class="text-2xl font-[900] text-cyan-600 tracking-tighter uppercase leading-none">Masar</span>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-2 ml-0.5">Management</span>
            </div>
        </div>
    </div>

    <!-- 3. Navigation Menu -->
    <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scroll">
        <!-- Dashboard Link -->
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-500 {{ request()->routeIs('dashboard') ? 'bg-cyan-500 text-white shadow-lg shadow-cyan-200 font-bold' : 'text-slate-500 hover:bg-slate-50' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" stroke-width="2"/></svg>
            <span x-show="!isCompact" class="text-sm">Dashboard</span>
        </a>
        
        <!-- Projects Link -->
        <a href="{{ route('projects.index') }}" 
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('projects.*') ? 'bg-cyan-500 text-white shadow-lg shadow-cyan-200 font-bold' : 'text-slate-500 hover:bg-slate-50' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span x-show="!isCompact" class="text-sm">Projects</span>
        </a>
    </nav>

    <!-- 4. Dynamic User Profile Section (الآن أصبح ذكياً) -->
    <div class="p-4 m-4 rounded-[24px] bg-slate-50 border border-slate-100 shrink-0">
        <div class="flex items-center gap-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=06b6d4&color=fff&bold=true" 
                 class="w-10 h-10 rounded-xl shadow-sm border border-white shrink-0">
            
            <div x-show="!isCompact" class="overflow-hidden text-left">
                <p class="text-sm font-black text-slate-800 truncate leading-none mb-1.5">{{ auth()->user()->name }}</p>
                <!-- جلب المسمى الوظيفي من قاعدة البيانات بدلاً من النص اليدوي -->
                <p class="text-[9px] font-bold text-cyan-600 uppercase tracking-widest truncate">
                    {{ auth()->user()->job_title ?? 'Workspace Member' }}
                </p>
            </div>
        </div>
    </div>
</div>