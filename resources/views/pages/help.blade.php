<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center | Masar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#fcfcfd]">
    <main class="py-32 px-8 max-w-5xl mx-auto">
        <div class="text-center mb-24">
            <h1 class="text-5xl font-black tracking-tight mb-6">How can we help?</h1>
            <p class="text-slate-500 text-lg">Search our knowledge base or browse common topics below.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <a href="#" class="p-10 bg-white border border-slate-100 rounded-3xl hover:border-indigo-600 transition shadow-sm">
                <h3 class="font-bold text-xl mb-2">Account & Access</h3>
                <p class="text-slate-500 text-sm">Managing passwords, invitations, and workspace profile settings.</p>
            </a>
            <a href="#" class="p-10 bg-white border border-slate-100 rounded-3xl hover:border-indigo-600 transition shadow-sm">
                <h3 class="font-bold text-xl mb-2">Project Coordination</h3>
                <p class="text-slate-500 text-sm">How to delegate sub-tasks and manage team workload efficiently.</p>
            </a>
            <a href="#" class="p-10 bg-white border border-slate-100 rounded-3xl hover:border-indigo-600 transition shadow-sm">
                <h3 class="font-bold text-xl mb-2">Data & Analytics</h3>
                <p class="text-slate-500 text-sm">Understanding project insights and performance metrics.</p>
            </a>
            <a href="#" class="p-10 bg-white border border-slate-100 rounded-3xl hover:border-indigo-600 transition shadow-sm text-center flex flex-col justify-center bg-indigo-600">
                <h3 class="font-bold text-xl mb-2 text-white">Contact Support</h3>
                <p class="text-indigo-100 text-sm">Talk to our engineering team directly.</p>
            </a>
        </div>
    </main>
</body>
</html>