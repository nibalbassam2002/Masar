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
        .doc-card { background: white; border: 1px solid #e2e8f0; border-radius: 24px; padding: 40px; transition: all 0.3s ease; }
        .doc-card:hover { border-color: #6366f1; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="text-slate-900 antialiased">

    <!-- Simple Navigation -->
    <nav class="h-20 flex items-center justify-between px-10 max-w-6xl mx-auto">
        <a href="/" class="text-xl font-bold tracking-tighter text-indigo-600 uppercase">Masar <span class="text-slate-300 font-medium">Docs</span></a>
        <a href="{{ route('home') }}" class="text-xs font-black uppercase text-slate-400 hover:text-indigo-600 transition tracking-widest">Exit to Home</a>
    </nav>

    <main class="max-w-4xl mx-auto py-20 px-8">
        <!-- Hero Section -->
        <div class="mb-24">
            <h1 class="text-5xl font-extrabold tracking-tight text-slate-900 mb-6">The Architecture</h1>
            <p class="text-lg text-slate-500 leading-relaxed max-w-2xl">Masar is engineered around a four-tier logic. Understanding this hierarchy is essential for effective team coordination and project tracking.</p>
        </div>

        <!-- The 4 Tiers Grid -->
        <div class="grid gap-8 mb-24">
            <!-- Tier 1 -->
            <div class="doc-card flex gap-10 items-start">
                <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shrink-0 font-bold shadow-lg shadow-indigo-100">01</div>
                <div>
                    <h3 class="text-xl font-bold mb-3">Workspace Layer</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">The root container. Every member, project, and department lives here. As a Founder, you define the "Work Groups" (like Frontend or Marketing) that dictate how tasks are eventually delegated.</p>
                </div>
            </div>

            <!-- Tier 2 -->
            <div class="doc-card flex gap-10 items-start border-l-4 border-l-indigo-600">
                <div class="w-12 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center shrink-0 font-bold">02</div>
                <div>
                    <h3 class="text-xl font-bold mb-3">Project Stream</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Individual mission hubs. Each project has its own Kanban board. Members are invited to projects based on their professional role in the workspace.</p>
                </div>
            </div>

            <!-- Tier 3 & 4 -->
            <div class="grid md:grid-cols-2 gap-8">
                <div class="doc-card p-8">
                    <div class="text-[10px] font-black uppercase text-indigo-600 mb-4 tracking-widest">Level 03</div>
                    <h3 class="text-lg font-bold mb-2">Main Missions</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">High-level tasks created by the Admin. These appear on the Kanban and represent major project milestones.</p>
                </div>
                <div class="doc-card p-8 bg-slate-900 text-white border-none shadow-xl">
                    <div class="text-[10px] font-black uppercase text-cyan-400 mb-4 tracking-widest">Level 04</div>
                    <h3 class="text-lg font-bold mb-2 text-white">Work Packages (Sub-tasks)</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">The execution layer. Team Leads divide Main Missions into actionable steps for individual members to execute and deliver evidence.</p>
                </div>
            </div>
        </div>

        <!-- Role Permissions Table -->
        <section class="mb-32">
            <h2 class="text-2xl font-bold mb-10 tracking-tight">Access Permissions</h2>
            <div class="overflow-hidden border border-slate-100 rounded-3xl bg-white shadow-sm">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="p-6 text-[10px] font-black uppercase text-slate-400">Action</th>
                            <th class="p-6 text-[10px] font-black uppercase text-slate-400">Owner</th>
                            <th class="p-6 text-[10px] font-black uppercase text-slate-400">Team Lead</th>
                            <th class="p-6 text-[10px] font-black uppercase text-slate-400">Member</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm font-medium text-slate-600">
                        <tr>
                            <td class="p-6">Archive Projects</td>
                            <td class="p-6 text-indigo-600">Yes</td>
                            <td class="p-6 text-slate-300">No</td>
                            <td class="p-6 text-slate-300">No</td>
                        </tr>
                        <tr>
                            <td class="p-6">Delegate Sub-tasks</td>
                            <td class="p-6 text-indigo-600">Yes</td>
                            <td class="p-6 text-indigo-600">Yes</td>
                            <td class="p-6 text-slate-300">No</td>
                        </tr>
                        <tr>
                            <td class="p-6">Upload Evidence</td>
                            <td class="p-6 text-indigo-600">Yes</td>
                            <td class="p-6 text-indigo-600">Yes</td>
                            <td class="p-6 text-indigo-600">Yes</td>
                        </tr>
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