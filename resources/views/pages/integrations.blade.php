<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Integrations | Masar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body class="bg-[#fcfcfd] text-slate-900 antialiased" style="font-family: 'Inter', sans-serif;">

    <nav class="p-4 lg:p-6 border-b border-slate-100 bg-white sticky top-0 z-50">
        <div class="max-w-[1200px] mx-auto flex justify-between items-center">
            
            <!-- اللوجو -->
            <a href="/" class="flex items-center gap-1 group">
                <span class="text-lg lg:text-xl font-[900] tracking-tighter uppercase text-indigo-600">Masar</span>
            </a>
            
            <!-- زر الرجوع المصلح -->
            <a href="/" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full hover:bg-slate-50 transition-all group">
                <!-- أيقونة السهم -->
                <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M11 17l-5-5m0 0l5-5m-5 5h12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="text-[10px] lg:text-xs font-black uppercase text-slate-400 group-hover:text-indigo-600 transition-colors tracking-widest">
                    Back to Home
                </span>
            </a>

        </div>
    </nav>

    <main class="py-12 lg:py-20 px-6">
        <!-- Hero Section -->
        <div class="max-w-[1000px] mx-auto text-center mb-12 lg:mb-20">
            <h1 class="text-3xl lg:text-5xl font-extrabold text-slate-900 tracking-tight mb-4 leading-tight">Integrations</h1>
            <p class="text-base lg:text-lg text-slate-500 max-w-2xl mx-auto leading-relaxed">
                Connect your workspace with the tools you already use to centralize your workflow.
            </p>
        </div>

        <!-- Grid: 1 col on mobile, 2 on tablet, 3 on desktop -->
        <div class="max-w-[1000px] mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- GitHub Card -->
            <div class="bg-white p-6 lg:p-8 rounded-[2rem] lg:rounded-3xl border border-slate-100 shadow-sm hover:border-indigo-200 hover:shadow-md transition-all group">
                <div class="w-12 h-12 bg-slate-50 rounded-2xl mb-6 flex items-center justify-center group-hover:bg-indigo-50 transition-colors">
                </div>
                <h3 class="font-bold text-lg mb-2">GitHub</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Sync pull requests and issues directly with your mission boards.</p>
            </div>

            <!-- Slack Card -->
            <div class="bg-white p-6 lg:p-8 rounded-[2rem] lg:rounded-3xl border border-slate-100 shadow-sm hover:border-indigo-200 hover:shadow-md transition-all group">
                <div class="w-12 h-12 bg-slate-50 rounded-2xl mb-6 flex items-center justify-center group-hover:bg-indigo-50 transition-colors">
                </div>
                <h3 class="font-bold text-lg mb-2">Slack</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Receive instant notifications in your channels when tasks are updated.</p>
            </div>

            <!-- Google Drive Card -->
            <div class="bg-white p-6 lg:p-8 rounded-[2rem] lg:rounded-3xl border border-slate-100 shadow-sm hover:border-indigo-200 hover:shadow-md transition-all group">
                <div class="w-12 h-12 bg-slate-50 rounded-2xl mb-6 flex items-center justify-center group-hover:bg-indigo-50 transition-colors">
                </div>
                <h3 class="font-bold text-lg mb-2">Google Drive</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Attach documents and assets directly from your cloud storage.</p>
            </div>

        </div>
    </main>

    <footer class="py-12 text-center border-t border-slate-100">
        <p class="text-[9px] lg:text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em]">
            © 2025 Masar Systems. All Rights Reserved.
        </p>
    </footer>

</body>
</html>