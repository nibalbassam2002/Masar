<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center | Masar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body class="bg-[#fcfcfd] text-slate-900 antialiased">

    <!-- Navbar المضافة لسهولة التنقل -->
    <nav class="h-20 flex items-center justify-between px-6 lg:px-10 max-w-6xl mx-auto sticky top-0 bg-[#fcfcfd]/80 backdrop-blur-md z-50">
        <a href="/" class="text-xl font-bold tracking-tighter text-indigo-600 uppercase">Masar</a>
        
        <a href="/" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full hover:bg-slate-100 transition-all group">
            <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M11 17l-5-5m0 0l5-5m-5 5h12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="text-[10px] lg:text-xs font-black uppercase text-slate-400 group-hover:text-indigo-600 transition-colors tracking-widest">Home</span>
        </a>
    </nav>

    <main class="py-12 lg:py-24 px-6 lg:px-8 max-w-5xl mx-auto">
        <div class="text-center mb-16 lg:mb-24">
            <h1 class="text-3xl lg:text-6xl font-black tracking-tight mb-6 leading-tight">How can we help?</h1>
            <p class="text-slate-500 text-base lg:text-lg max-w-2xl mx-auto leading-relaxed">Search our knowledge base or browse common topics below.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
            <a href="#" class="p-8 lg:p-10 bg-white border border-slate-100 rounded-3xl hover:border-indigo-600 transition shadow-sm hover:shadow-md">
                <h3 class="font-bold text-xl mb-2">Account & Access</h3>
                <p class="text-slate-500 text-sm">Managing passwords, invitations, and workspace profile settings.</p>
            </a>
            <a href="#" class="p-8 lg:p-10 bg-white border border-slate-100 rounded-3xl hover:border-indigo-600 transition shadow-sm hover:shadow-md">
                <h3 class="font-bold text-xl mb-2">Project Coordination</h3>
                <p class="text-slate-500 text-sm">How to delegate sub-tasks and manage team workload efficiently.</p>
            </a>
            <a href="#" class="p-8 lg:p-10 bg-white border border-slate-100 rounded-3xl hover:border-indigo-600 transition shadow-sm hover:shadow-md">
                <h3 class="font-bold text-xl mb-2">Data & Analytics</h3>
                <p class="text-slate-500 text-sm">Understanding project insights and performance metrics.</p>
            </a>
            <a href="#" class="p-8 lg:p-10 border-none rounded-3xl transition shadow-xl text-center flex flex-col justify-center bg-indigo-600 hover:bg-indigo-700">
                <h3 class="font-bold text-xl mb-2 text-white">Contact Support</h3>
                <p class="text-indigo-100 text-sm">Talk to our engineering team directly.</p>
            </a>
        </div>
    </main>

    <footer class="py-12 text-center">
        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-300">© 2025 Masar Engineering Lab</p>
    </footer>

</body>
</html>