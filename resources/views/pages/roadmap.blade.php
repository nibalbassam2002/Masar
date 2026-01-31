<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Roadmap | Masar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#fcfcfd] text-slate-900">
    <nav class="h-20 flex items-center justify-between px-10 max-w-7xl mx-auto border-b border-slate-100">
        <a href="/" class="text-xl font-bold tracking-tighter text-indigo-600">MASAR</a>
        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-900">Back to app</a>
    </nav>

    <main class="max-w-4xl mx-auto py-24 px-8">
        <header class="mb-20">
            <h1 class="text-5xl font-extrabold tracking-tight mb-4">Engineering Path</h1>
            <p class="text-slate-500 text-lg leading-relaxed">Our roadmap is a commitment to precision. We prioritize stability and team velocity over unnecessary features.</p>
        </header>

        <div class="space-y-24">
            <!-- Stage 1 -->
            <section class="grid md:grid-cols-4 gap-8">
                <div class="col-span-1">
                    <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">In Development</span>
                </div>
                <div class="col-span-3">
                    <h3 class="text-xl font-bold mb-4">AI Task Sequencing</h3>
                    <p class="text-slate-600 leading-relaxed">Automated prioritization engine that analyzes project deadlines and team capacity to suggest the most efficient work order.</p>
                </div>
            </section>

            <!-- Stage 2 -->
            <section class="grid md:grid-cols-4 gap-8">
                <div class="col-span-1">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Q3 2025</span>
                </div>
                <div class="col-span-3">
                    <h3 class="text-xl font-bold mb-4">Native Mobile Hub</h3>
                    <p class="text-slate-600 leading-relaxed">A focused mobile experience built for field updates and quick communication, maintaining full synchronization with the desktop dashboard.</p>
                </div>
            </section>

            <!-- Stage 3 -->
            <section class="grid md:grid-cols-4 gap-8 border-t border-slate-100 pt-16">
                <div class="col-span-1">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Planning</span>
                </div>
                <div class="col-span-3">
                    <h3 class="text-xl font-bold mb-4">Enterprise Customization</h3>
                    <p class="text-slate-600 leading-relaxed">Advanced workspace permissions and custom-branded client portals for external stakeholders.</p>
                </div>
            </section>
        </div>
    </main>
</body>
</html>