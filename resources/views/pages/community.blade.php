<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community | Masar Intelligence</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #ffffff; }
        .comm-card { 
            background: #f8fafc; 
            border: 1px solid #f1f5f9; 
            border-radius: 32px; 
            padding: 48px; 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
        }
        .comm-card:hover { 
            background: #ffffff;
            border-color: #6366f1; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
            transform: translateY(-4px);
        }
    </style>
</head>
<body class="text-slate-900 antialiased">

    <nav class="h-20 flex items-center justify-between px-10 max-w-7xl mx-auto">
        <a href="/" class="text-xl font-bold tracking-tighter text-indigo-600 uppercase">Masar <span class="text-slate-300 font-medium">Community</span></a>
    </nav>

    <main class="max-w-6xl mx-auto py-24 px-8">
        <div class="max-w-3xl mb-32">
            <h1 class="text-6xl font-extrabold tracking-tight text-slate-900 mb-8 leading-[1.1]">Built by teams, <br> for <span class="text-indigo-600">teams.</span></h1>
            <p class="text-xl text-slate-500 leading-relaxed">Join a global network of engineers, project leads, and founders who are defining the next generation of project management.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 mb-32">
            <div class="comm-card">
                <div class="text-[10px] font-black uppercase text-indigo-600 mb-6 tracking-[0.2em]">Real-time Discussion</div>
                <h3 class="text-2xl font-bold mb-4">Engineering Discord</h3>
                <p class="text-slate-500 leading-relaxed mb-8">Connect directly with our core engineering team and other power users. Share workflows, request features, and get instant help.</p>
                <a href="#" class="inline-flex items-center font-bold text-indigo-600 hover:gap-3 transition-all">Join the server <span class="ml-2">→</span></a>
            </div>

            <!-- GitHub/Open Source -->
            <div class="comm-card">
                <div class="text-[10px] font-black uppercase text-slate-400 mb-6 tracking-[0.2em]">Contribution</div>
                <h3 class="text-2xl font-bold mb-4">Open Infrastructure</h3>
                <p class="text-slate-500 leading-relaxed mb-8">Masar believes in transparency. Contribute to our documentation, build custom integrations, or report issues on our public repository.</p>
                <a href="#" class="inline-flex items-center font-bold text-slate-900 hover:gap-3 transition-all">Explore GitHub <span class="ml-2">→</span></a>
            </div>
        </div>

        <section class="border-t border-slate-100 pt-24 mb-32">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-16 gap-6">
                <h2 class="text-3xl font-bold tracking-tight">Upcoming Events</h2>
                <p class="text-slate-400 font-medium">Virtual workshops and local meetups.</p>
            </div>

            <div class="space-y-6">
                <div class="flex flex-col md:flex-row justify-between p-8 border border-slate-100 rounded-[2rem] hover:bg-slate-50 transition-colors group">
                    <div class="flex gap-8 items-center">
                        <div class="text-center shrink-0">
                            <span class="block text-2xl font-black text-indigo-600 leading-none">12</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Feb</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 transition-colors">Scaling Workspaces for 100+ Members</h4>
                            <p class="text-sm text-slate-500 mt-1 uppercase tracking-widest font-medium">Online Workshop</p>
                        </div>
                    </div>
                    <button class="mt-4 md:mt-0 px-6 py-2 border border-slate-200 rounded-xl text-xs font-black uppercase hover:bg-white hover:border-indigo-600 transition-all">Register</button>
                </div>

                <!-- Event 2 -->
                <div class="flex flex-col md:flex-row justify-between p-8 border border-slate-100 rounded-[2rem] hover:bg-slate-50 transition-colors">
                    <div class="flex gap-8 items-center">
                        <div class="text-center shrink-0">
                            <span class="block text-2xl font-black text-slate-300 leading-none">05</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Mar</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-900">Masar Engineering Lab: API v2 Preview</h4>
                            <p class="text-sm text-slate-500 mt-1 uppercase tracking-widest font-medium">Developer Keynote</p>
                        </div>
                    </div>
                    <button class="mt-4 md:mt-0 px-6 py-2 border border-slate-200 rounded-xl text-xs font-black uppercase hover:bg-white hover:border-indigo-600 transition-all">Notify me</button>
                </div>
            </div>
        </section>

        <!-- Final CTA -->
        <div class="text-center py-20 bg-indigo-600 rounded-[3rem] text-white shadow-2xl shadow-indigo-200">
            <h2 class="text-4xl font-bold mb-6">Ready to shape the future?</h2>
            <p class="text-indigo-100 mb-10 max-w-xl mx-auto">Our community is the heartbeat of Masar. We build based on your feedback and real-world needs.</p>
            <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-10 py-4 rounded-2xl font-black uppercase tracking-widest hover:scale-105 transition-all inline-block shadow-lg">Start Building Today</a>
        </div>
    </main>

    <footer class="py-12 text-center border-t border-slate-100">
        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-300">© 2025 Masar Engineering Hub</p>
    </footer>

</body>
</html>