<!-- Modal: New Project (Premium Masar Style) -->
<div id="newProjectModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
    <!-- خلفية ضبابية خفيفة -->
    <div class="absolute inset-0 bg-slate-900/30 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>

    <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md p-10 transform transition-all scale-95 opacity-0 duration-300 border border-slate-50"
        id="modalContainer">

        <!-- Header Section -->
        <div class="text-center mb-10">
            <div class="w-12 h-12 bg-cyan-50 text-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M12 4v16m8-8H4" />
                </svg>
            </div>

            <h3 class="text-2xl font-bold text-slate-900 tracking-tight mb-2">New Project</h3>
            <p class="text-[14px] text-slate-400 font-medium leading-relaxed max-w-[240px] mx-auto">
                Define your goals and start building with your team today.
            </p>
        </div>

        <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Project Name</label>
                <input type="text" name="name" required placeholder="e.g. Design System"
                    class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none text-sm font-semibold focus:ring-4 focus:ring-cyan-500/10 focus:bg-white outline-none transition-all placeholder:text-slate-300">
            </div>

            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Description</label>
                <textarea name="description" rows="3" placeholder="What are the goals of this project?"
                    class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none text-sm font-semibold focus:ring-4 focus:ring-cyan-500/10 focus:bg-white outline-none transition-all placeholder:text-slate-300"></textarea>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-slate-50">
                <button type="button" onclick="closeModal()"
                    class="flex-1 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">
                    Cancel
                </button>
                <button type="submit" onclick="this.disabled=true; this.form.submit();"
                    class="flex-2 bg-cyan-500 text-white px-8 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest shadow-lg shadow-cyan-100 hover:bg-cyan-600 transition-all active:scale-95">
                    Create Now
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        const modal = document.getElementById('newProjectModal');
        const container = document.getElementById('modalContainer');
        modal.classList.remove('hidden');
        setTimeout(() => {
            container.classList.remove('scale-95', 'opacity-0');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('newProjectModal');
        const container = document.getElementById('modalContainer');
        container.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>