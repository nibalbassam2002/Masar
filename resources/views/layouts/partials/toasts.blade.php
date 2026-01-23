@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-cloak
     class="fixed top-6 right-6 z-[999] flex items-center gap-4 bg-white border border-slate-100 p-4 rounded-2xl shadow-2xl transition-all">
    <div class="w-8 h-8 bg-cyan-50 text-cyan-500 rounded-lg flex items-center justify-center">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
    </div>
    <div>
        <p class="text-[10px] font-black uppercase text-cyan-600">Success</p>
        <p class="text-xs font-bold text-slate-700">{{ session('success') }}</p>
    </div>
</div>
@endif