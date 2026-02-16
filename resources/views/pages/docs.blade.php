<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentation | Masar OS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #fcfcfd; }
        .doc-card { background: white; border: 1px solid #e2e8f0; border-radius: 24px; padding: 24px; transition: all 0.3s ease; }
        @media (min-width: 768px) { .doc-card { padding: 40px; } }
        .doc-card:hover { border-color: #6366f1; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="text-slate-900 antialiased">

    <!-- Navigation -->
    <nav class="h-20 flex items-center justify-between px-6 lg:px-10 max-w-6xl mx-auto">
        <a href="/" class="text-xl font-bold tracking-tighter text-indigo-600 uppercase">Masar <span class="text-slate-300 font-medium lg:inline hidden">Docs</span></a>
        
        <!-- زر الرجوع الموحد -->
        <a href="/" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full hover:bg-slate-100 transition-all group border border-slate-100 lg:border-none">
            <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M11 17l-5-5m0 0l5-5m-5 5h12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="text-[10px] lg:text-xs font-black uppercase text-slate-400 group-hover:text-indigo-600 transition-colors tracking-widest">Back</span>
        </a>
    </nav>

    <main class="max-w-4xl mx-auto py-12 lg:py-20 px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="mb-16 lg:mb-24">
            <h1 class="text-3xl lg:text-5xl font-extrabold tracking-tight text-slate-900 mb-6 leading-tight">The Architecture</h1>
            <p class="text-base lg:text-lg text-slate-500 leading-relaxed max-w-2xl">Masar is engineered around a four-tier logic. Understanding this hierarchy is essential for effective team coordination.</p>
        </div>

        <!-- The 4 Tiers Grid -->
        <div class="grid gap-6 lg:gap-8 mb-24">
            <!-- Tier 1 -->
            <div class="doc-card flex flex-col sm:flex-row gap-6 lg:gap-10 items-start">
                <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shrink-0 font-bold shadow-lg shadow-indigo-100">01</div>
                <div>
                    <h3 class="text-lg lg:text-xl font-bold mb-3">Workspace Layer</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">The root container. Every member, project, and department lives here. As a Founder, you define the "Work Groups".</p>
                </div>
            </div>

            <!-- Tier 2 -->
            <div class="doc-card flex flex-col sm:flex-row gap-6 lg:gap-10 items-start border-l-4 border-l-indigo-600">
                <div class="w-12 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center shrink-0 font-bold">02</div>
                <div>
                    <h3 class="text-lg lg:text-xl font-bold mb-3">Project Stream</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Individual mission hubs. Each project has its own Kanban board.</p>
                </div>
            </div>

            <!-- Tier 3 & 4 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                <div class="doc-card p-8">
                    <div class="text-[10px] font-black uppercase text-indigo-600 mb-4 tracking-widest">Level 03</div>
                    <h3 class="text-lg font-bold mb-2">Main Missions</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">High-level tasks created by the Admin. These represent major project milestones.</p>
                </div>
                <div class="doc-card p-8 bg-slate-900 text-white border-none shadow-xl">
                    <div class="text-[10px] font-black uppercase text-cyan-400 mb-4 tracking-widest">Level 04</div>
                    <h3 class="text-lg font-bold mb-2 text-white">Work Packages</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">The execution layer. Team Leads divide Main Missions into actionable steps.</p>
                </div>
            </div>
        </div>

        <!-- Role Permissions Table -->
        <section class="mb-32">
            <h2 class="text-2xl font-bold mb-10 tracking-tight">Access Permissions</h2>
            <div class="overflow-x-auto border border-slate-100 rounded-3xl bg-white shadow-sm">
                <table class="w-full text-left border-collapse min-w-[500px]">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="p-6 text-[10px] font-black uppercase text-slate-400">Action</th>
                            <th class="p-6 text-[10px] font-black uppercase text-slate-400">Owner</th>
                            <th class="p-6 text-[10px] font-black uppercase text-slate-400">Team Lead</th>
                            <th class="p-6 text-[10px] font-black uppercase text-slate-400">Member</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm font-medium text-slate-600">
                        <tr><td class="p-6">Archive Projects</td><td class="p-6 text-indigo-600">Yes</td><td class="p-6 text-slate-300">No</td><td class="p-6 text-slate-300">No</td></tr>
                        <tr><td class="p-6">Delegate Sub-tasks</td><td class="p-6 text-indigo-600">Yes</td><td class="p-6 text-indigo-600">Yes</td><td class="p-6 text-slate-300">No</td></tr>
                        <tr><td class="p-6">Upload Evidence</td><td class="p-6 text-indigo-600">Yes</td><td class="p-6 text-indigo-600">Yes</td><td class="p-6 text-indigo-600">Yes</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <footer class="py-12 text-center">
        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-300">© 2025 Masar Engineering Lab</p>
    </footer>
</body>
</html>