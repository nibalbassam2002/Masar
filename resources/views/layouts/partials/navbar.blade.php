<!-- التعديل: جعلنا px-4 للموبايل و px-8 للابتوب -->
<nav class="h-16 bg-white border-b border-slate-100 px-4 lg:px-8 flex items-center justify-between shrink-0 sticky top-0 z-40">

    <!-- 1. زر فتح القائمة الجانبية (يظهر فقط في الجوال) -->
    <button @click="isSidebarOpen = true" class="lg:hidden p-2 -ml-2 text-slate-500 hover:text-cyan-600 transition-all mr-2">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <!-- كود البحث الخاص بك (كامل كما هو) -->
    <div class="flex-1 max-w-md relative" x-data="{ 
        query: '', 
        results: { projects: [], tasks: [] }, 
        open: false,
        isSearching: false,
        search() {
            if (this.query.length < 2) { 
                this.results = { projects: [], tasks: [] }; 
                this.open = false; 
                return; 
            }
            this.isSearching = true;
            fetch(`/global-search?q=${this.query}`)
                .then(res => res.json())
                .then(data => {
                    this.results = data;
                    this.open = true;
                    this.isSearching = false;
                });
        }
    }">
        <div class="relative group">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 group-focus-within:text-cyan-500 transition-colors"
                fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <!-- تعديل: تقليل حجم النص قليلاً في الموبايل -->
            <input type="text" 
                   x-model="query" 
                   @input.debounce.300ms="search()" 
                   @focus="if(query.length > 1) open = true"
                   placeholder="Search..."
                   class="w-full bg-slate-50 border-none rounded-xl py-2 pl-10 pr-4 text-[10px] lg:text-xs font-medium focus:ring-4 focus:ring-cyan-500/5 focus:bg-white transition-all outline-none">
            
            <div x-show="isSearching" class="absolute right-3 top-1/2 -translate-y-1/2">
                <svg class="animate-spin h-3 w-3 text-cyan-500" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>

        <!-- قائمة نتائج البحث (كاملة كما هي) -->
        <div x-show="open" 
             x-cloak 
             @click.away="open = false" 
             class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-slate-100 z-[1000] overflow-hidden p-2">
            
            <template x-if="results.projects.length > 0">
                <div class="mb-2">
                    <span class="text-[9px] font-black text-slate-400 uppercase px-3 py-1 block tracking-widest">Projects</span>
                    <template x-for="project in results.projects" :key="project.id">
                        <a :href="'/projects/' + project.id" class="flex items-center gap-3 px-3 py-2 text-xs font-bold text-slate-700 hover:bg-cyan-50 hover:text-cyan-600 rounded-lg transition-all">
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                            <span x-text="project.name"></span>
                        </a>
                    </template>
                </div>
            </template>

            <template x-if="results.tasks.length > 0">
                <div>
                    <span class="text-[9px] font-black text-slate-400 uppercase px-3 py-1 block tracking-widest">Missions</span>
                    <template x-for="task in results.tasks" :key="task.id">
                        <a :href="'/tasks/' + task.id" class="flex items-center gap-3 px-3 py-2 text-xs font-bold text-slate-700 hover:bg-cyan-50 hover:text-cyan-600 rounded-lg transition-all">
                            <div class="w-1.5 h-1.5 rounded-full bg-cyan-400"></div>
                            <span x-text="task.title"></span>
                        </a>
                    </template>
                </div>
            </template>

            <template x-if="results.projects.length === 0 && results.tasks.length === 0">
                <div class="py-6 text-center text-slate-400 text-[10px] font-bold uppercase italic">
                    No matches found
                </div>
            </template>
        </div>
    </div>

    <div class="flex items-center gap-1 lg:gap-2">
        <!-- 2. نظام التنبيهات (كامل كما هو) -->
        <div class="relative group mr-1 lg:mr-4" x-data="{ open: false }">
            <button @click="open = !open" class="relative p-2 text-slate-400 hover:text-cyan-600 transition-all">
                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                @if($unreadCount > 0)
                    <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full border-2 border-white animate-pulse"></span>
                @endif
            </button>

            <div x-show="open" x-cloak @click.away="open = false" x-transition class="absolute right-0 mt-3 w-72 lg:w-80 bg-white rounded-[2rem] shadow-2xl border border-slate-100 z-[1000] overflow-hidden">
                <div class="p-4 lg:p-5 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                    <span class="text-[10px] font-black uppercase text-slate-900 tracking-widest">Inbox ({{ $unreadCount }})</span>
                </div>
                <div class="max-h-64 lg:max-h-80 overflow-y-auto custom-scroll">
                    @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                        <a href="{{ $notification->data['link'] ?? '#' }}" class="block p-4 lg:p-5 hover:bg-slate-50 border-b border-slate-50">
                            <p class="text-[10px] lg:text-[11px] text-slate-600 leading-relaxed font-medium">{{ $notification->data['message'] }}</p>
                        </a>
                    @empty
                        <div class="py-10 text-center opacity-30 italic text-[10px]">No alerts</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="h-8 w-px bg-slate-100 mx-1"></div>

        <!-- 3. Profile Dropdown (كامل كما هو مع تعديل بسيط للظهور) -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" @click.away="open = false"
                class="flex items-center gap-2 lg:gap-3 p-1 rounded-2xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 group">
                <div class="w-8 h-8 lg:w-9 lg:h-9 rounded-lg lg:rounded-xl bg-cyan-500 overflow-hidden shadow-lg shadow-cyan-100 flex-shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=06b6d4&color=fff&bold=true" class="w-full h-full object-cover">
                </div>
                <!-- تعديل: إخفاء النصوص في الموبايل وتركها في اللابتوب -->
                <div class="hidden lg:block text-left">
                    <p class="text-xs font-black text-slate-900 leading-none mb-1">{{ auth()->user()->name }}</p>
                    <p class="text-[9px] font-bold text-cyan-600 uppercase tracking-widest truncate max-w-[80px]">
                        Admin
                    </p>
                </div>
                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" /></svg>
            </button>

            <!-- القائمة المنسدلة للبروفايل (كاملة كما هي) -->
            <div x-show="open" x-cloak x-transition class="absolute right-0 mt-3 w-48 lg:w-56 bg-white border border-slate-100 rounded-[24px] shadow-2xl z-50 overflow-hidden py-2">
                <div class="px-5 py-3 border-b border-slate-50 mb-2 bg-slate-50/50">
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1">Email</p>
                    <p class="text-[10px] font-bold text-slate-700 truncate">{{ auth()->user()->email }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-xs font-bold text-rose-500 hover:bg-rose-50 transition-all text-left">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>