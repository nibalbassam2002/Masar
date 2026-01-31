<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Integrations | Masar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body class="bg-[#fcfcfd] text-slate-900" style="font-family: 'Inter', sans-serif;">

    <nav class="p-6 border-b border-slate-100 bg-white sticky top-0 z-50">
        <div class="max-w-[1200px] mx-auto flex justify-between items-center">
            <a href="/" class="text-xl font-bold tracking-tighter uppercase text-indigo-600">Masar</a>
        </div>
    </nav>

    <main class="py-20 px-6">
        <div class="max-w-[1000px] mx-auto text-center mb-20">
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">Integrations</h1>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto">Connect your workspace with the tools you already use to centralize your workflow.</p>
        </div>

        <div class="max-w-[1000px] mx-auto grid md:grid-cols-3 gap-6">
            <!-- Card -->
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:border-indigo-200 transition-all">
                <h3 class="font-bold text-lg mb-2">GitHub</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Sync pull requests and issues directly with your mission boards.</p>
            </div>
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:border-indigo-200 transition-all">
                <h3 class="font-bold text-lg mb-2">Slack</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Receive instant notifications in your channels when tasks are updated.</p>
            </div>
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:border-indigo-200 transition-all">
                <h3 class="font-bold text-lg mb-2">Google Drive</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Attach documents and assets directly from your cloud storage.</p>
            </div>
        </div>
    </main>

    <footer class="py-12 text-center border-t border-slate-100">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">© 2025 Masar Systems. All Rights Reserved.</p>
    </footer>
</body>
</html>