<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy | Masar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#fcfcfd] text-slate-900 antialiased">

    <!-- Navigation -->
    <nav class="h-20 flex items-center justify-between px-6 lg:px-10 max-w-6xl mx-auto">
        <a href="/" class="text-xl font-bold tracking-tighter text-indigo-600 uppercase">Masar</a>
        
        <a href="/" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full hover:bg-white hover:shadow-sm transition-all group">
            <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M11 17l-5-5m0 0l5-5m-5 5h12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="text-[10px] lg:text-xs font-black uppercase text-slate-400 group-hover:text-indigo-600 transition-colors tracking-widest">Back to Home</span>
        </a>
    </nav>

    <main class="py-10 lg:py-20 px-4 lg:px-6">
        <!-- الحاوية الرئيسية المتجاوبة -->
        <div class="max-w-[800px] mx-auto bg-white p-8 lg:p-20 rounded-[2rem] lg:rounded-[3.5rem] border border-slate-100 shadow-sm">
            
            <header class="mb-12 lg:mb-16 border-b border-slate-50 pb-8 lg:pb-10">
                <h1 class="text-3xl lg:text-5xl font-[900] text-slate-900 mb-4 tracking-tight">Privacy Policy</h1>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase tracking-widest rounded-md">Effective: Jan 2025</span>
                </div>
            </header>

            <div class="space-y-10 lg:space-y-12">
                <!-- Section 1 -->
                <section>
                    <h2 class="text-lg lg:text-xl font-bold text-slate-900 mb-4 flex items-center gap-3">
                        <span class="w-6 h-6 bg-slate-100 rounded-full flex items-center justify-center text-xs">1</span>
                        Data Infrastructure & Security
                    </h2>
                    <p class="text-slate-500 text-sm lg:text-base leading-relaxed text-left lg:text-justify">
                        Security is our absolute priority. All project data and mission logs within Masar are stored on dedicated, encrypted servers. We do not sell or share project data with third-party analytics providers. Your team's information is isolated at the database level.
                    </p>
                </section>
                
                <!-- Section 2 -->
                <section>
                    <h2 class="text-lg lg:text-xl font-bold text-slate-900 mb-4 flex items-center gap-3">
                        <span class="w-6 h-6 bg-slate-100 rounded-full flex items-center justify-center text-xs">2</span>
                        Ownership of Data
                    </h2>
                    <p class="text-slate-500 text-sm lg:text-base leading-relaxed text-left lg:text-justify">
                        The workspace creator (Founder/Admin) retains full ownership of all data uploaded to projects. We provide automated tools for full data export and permanent deletion. When you delete a mission or a project, it is purged from our production servers within 24 hours.
                    </p>
                </section>

                <!-- Section 3 -->
                <section>
                    <h2 class="text-lg lg:text-xl font-bold text-slate-900 mb-4 flex items-center gap-3">
                        <span class="w-6 h-6 bg-slate-100 rounded-full flex items-center justify-center text-xs">3</span>
                        Data Collection
                    </h2>
                    <p class="text-slate-500 text-sm lg:text-base leading-relaxed text-left lg:text-justify">
                        We collect minimal information required for operation: account credentials, workspace preferences, and technical logs to ensure platform stability. We do not use tracking cookies for advertising.
                    </p>
                </section>

                <!-- Contact Section -->
                <section class="pt-8 border-t border-slate-50">
                    <h2 class="text-lg font-bold text-slate-900 mb-3">Contact Engineering Hub</h2>
                    <p class="text-sm text-slate-500">If you have technical questions regarding these terms, contact us at:</p>
                    <a href="mailto:support@masar.com" class="text-indigo-600 font-bold text-sm hover:underline">support@masar.com</a>
                </section>
            </div>

            <footer class="mt-16 pt-8 border-t border-slate-50 text-center lg:text-left">
                <a href="/" class="inline-flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-indigo-600 transition-colors uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Back to Home
                </a>
            </footer>
        </div>
    </main>

    <footer class="py-12 text-center">
        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-300">© 2025 Masar Engineering Lab</p>
    </footer>

</body>
</html>