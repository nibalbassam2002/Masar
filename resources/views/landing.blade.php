<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masar | Engineering the Future of Project Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; overflow-x: hidden; } /* منع التمرير العرضي بسبب العناصر العائمة */
        .nav-blur { background: rgba(255, 255, 255, 0.8); backdrop-filter: saturate(180%) blur(20px); }
        .bento-card { background: #ffffff; border: 1px solid #f1f5f9; transition: all 0.3s ease; }
        .bento-card:hover { border-color: #e2e8f0; box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05); }
        @keyframes bounce-slow { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
        .animate-bounce-slow { animation: bounce-slow 5s ease-in-out infinite; }
    </style>
</head>

<body class="bg-[#ffffff] text-[#020617] antialiased">

    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-[100] border-b border-slate-100 nav-blur">
        <div class="max-w-[1400px] mx-auto px-4 lg:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-4 lg:gap-10">
                <a href="/" class="flex items-center gap-0 group">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-10 h-10 lg:w-15 lg:h-15 object-contain">
                    <span class="text-lg lg:text-xl font-[800] tracking-tighter uppercase text-indigo-600 ml-[-4px]">Masar</span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center gap-8">
                    <a href="#" class="text-[14px] font-semibold text-slate-500 hover:text-black transition">Solutions</a>
                    <a href="{{ route('docs') }}" class="text-[14px] font-semibold text-slate-500 hover:text-black transition">Docs</a>
                    <a href="{{route('community')}}" class="text-[14px] font-semibold text-slate-500 hover:text-black transition">Community</a>
                </div>
            </div>

            <div class="flex items-center gap-2 lg:gap-3">
                <a href="{{ route('login') }}" class="text-[13px] lg:text-[14px] font-bold px-2 lg:px-4 text-slate-500 hover:text-indigo-600 transition">Log in</a>
                <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 lg:px-6 py-2 lg:py-2.5 rounded-full text-[12px] lg:text-[14px] font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition whitespace-nowrap">
                    Sign up free
                </a>
            </div>
        </div>
    </nav>

    <main class="pt-16">
        <!-- Hero Section -->
        <section class="pt-12 pb-20 lg:pb-32 bg-white overflow-hidden">
            <div class="max-w-[1200px] mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center text-center lg:text-left">
                    
                    <!-- Visual Column (Stacks on top for mobile context or bottom) -->
                    <div class="order-2 lg:order-1 relative group">
                        <div class="absolute -inset-4 bg-indigo-500/5 rounded-[2.5rem] blur-2xl opacity-0 group-hover:opacity-100 transition duration-700"></div>
                        <div class="relative space-y-4">
                            <!-- Main Task Card -->
                            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-xl shadow-slate-200/50 w-full max-w-[380px] mx-auto transform -rotate-2 hover:rotate-0 transition-all duration-500 z-30 relative">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="px-2.5 py-1 rounded-md bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase tracking-wider">In Progress</span>
                                    <div class="flex -space-x-2">
                                        <div class="w-7 h-7 rounded-full border-2 border-white bg-slate-200 overflow-hidden"><img src="https://i.pravatar.cc/100?u=1" alt="Avatar"></div>
                                        <div class="w-7 h-7 rounded-full border-2 border-white bg-slate-800 flex items-center justify-center text-[8px] text-white">+2</div>
                                    </div>
                                </div>
                                <h4 class="font-bold text-slate-900 mb-2">Redesign Dashboard UI/UX</h4>
                                <div class="flex items-center justify-center lg:justify-start gap-4 text-slate-400">
                                    <span class="text-xs">Oct 24</span>
                                    <span class="text-xs">12</span>
                                </div>
                            </div>
                            <!-- Background Decorative Card (Hidden on Mobile) -->
                            <div class="bg-slate-50/50 border border-slate-100 p-5 rounded-2xl w-full max-w-[380px] absolute top-12 left-1/2 -translate-x-1/2 lg:left-12 lg:translate-x-0 -z-10 opacity-60 hidden md:block transform rotate-3"></div>
                            <!-- High Priority Card (Hidden on small mobile) -->
                            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-lg w-full max-w-[320px] absolute -bottom-16 right-0 lg:-right-4 hidden md:flex flex-col transform rotate-2 hover:translate-y-[-10px] transition-all">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                    <span class="text-[10px] font-bold text-red-500 uppercase">High Priority</span>
                                </div>
                                <p class="text-sm font-bold text-slate-800">Final API Integration</p>
                                <div class="mt-4 h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-indigo-600 w-3/4"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Text Column -->
                    <div class="order-1 lg:order-2">
                        <span class="text-indigo-600 font-bold text-sm tracking-widest uppercase mb-4 block">Centralized Control</span>
                        <h2 class="text-3xl md:text-5xl font-[800] text-slate-900 leading-[1.1] mb-8 tracking-tight">
                            Manage everything <br class="hidden lg:block"> without the <span class="text-slate-400 font-medium italic">chaos.</span>
                        </h2>
                        <p class="text-base lg:text-lg text-slate-500 mb-12 leading-relaxed">
                            Masar transforms complex projects into manageable tasks. Stay on top of your deadlines with a visual workspace designed for clarity and speed.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 text-left">
                            <div class="space-y-3">
                                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 font-bold text-lg">1</div>
                                <h4 class="font-bold text-slate-900">Flexible Views</h4>
                                <p class="text-sm text-slate-500">Switch between Kanban, List, and Timeline views in one click.</p>
                            </div>
                            <div class="space-y-3">
                                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 font-bold text-lg">2</div>
                                <h4 class="font-bold text-slate-900">Team Alignment</h4>
                                <p class="text-sm text-slate-500">Assign tasks, set priorities, and track progress in real-time.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Performance Section -->
        <section class="py-20 lg:py-24 bg-slate-50 border-y border-slate-100 overflow-hidden">
            <div class="max-w-[1200px] mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20 items-center text-center lg:text-left">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-[11px] font-black tracking-widest uppercase mb-6">Performance Tracking</div>
                        <h2 class="text-3xl lg:text-5xl font-[800] text-slate-900 leading-[1.1] mb-8 tracking-tighter">Data-driven <br> <span class="text-indigo-600">team intelligence.</span></h2>
                        <p class="text-base lg:text-lg text-slate-500 mb-10 leading-relaxed">Masar monitors project health. Get real-time insights into team velocity and identify bottlenecks.</p>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white p-4 lg:p-6 rounded-2xl border border-slate-200 shadow-sm">
                                <div class="text-xl lg:text-2xl font-black text-slate-900">94%</div>
                                <div class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">On-time delivery</div>
                            </div>
                            <div class="bg-white p-4 lg:p-6 rounded-2xl border border-slate-200 shadow-sm">
                                <div class="text-xl lg:text-2xl font-black text-indigo-600">12+</div>
                                <div class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Active Sprints</div>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="bg-white rounded-3xl shadow-2xl border border-slate-100 p-6 lg:p-8 relative z-10 transform hover:scale-[1.02] transition duration-500">
                            <h4 class="font-bold text-slate-900 mb-6 flex justify-between items-center text-sm">Team Workload</h4>
                            <div class="space-y-6 text-left">
                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs font-bold"><span class="text-slate-700">Sarah Connor</span><span class="text-slate-400">85%</span></div>
                                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden"><div class="h-full bg-indigo-600 w-[85%] rounded-full"></div></div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs font-bold"><span class="text-slate-700">James Wilson</span><span class="text-slate-400">40%</span></div>
                                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden"><div class="h-full bg-indigo-400 w-[40%] rounded-full"></div></div>
                                </div>
                            </div>
                        </div>
                        <!-- Project Health Tag (Desktop Only) -->
                        <div class="absolute -top-6 -right-6 bg-indigo-600 text-white p-6 rounded-3xl shadow-xl z-20 hidden lg:block animate-bounce-slow text-left">
                            <div class="text-xs font-bold opacity-80 mb-1 uppercase tracking-tighter">Project Health</div>
                            <div class="text-3xl font-black">Excellent</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Capabilities Section -->
        <section class="py-20 lg:py-32 px-6 bg-white overflow-hidden">
            <div class="max-w-[1200px] mx-auto">
                <div class="text-center mb-16 lg:mb-24">
                    <h2 class="text-indigo-600 font-bold text-sm tracking-[0.4em] uppercase mb-4">Core Capabilities</h2>
                    <h3 class="text-4xl lg:text-7xl font-[900] text-slate-900 tracking-tighter mb-6">Everything you need.</h3>
                    <p class="text-lg lg:text-xl text-slate-500 max-w-2xl mx-auto">Masar is built for teams that demand precision and speed.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20 items-center mb-20 lg:mb-32 text-center lg:text-left">
                    <div>
                        <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center mx-auto lg:mx-0 mb-8 shadow-xl shadow-indigo-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-width="2.5" stroke-linecap="round"/></svg>
                        </div>
                        <h4 class="text-2xl lg:text-3xl font-[900] text-slate-900 mb-6">Infinite Project Views</h4>
                        <p class="text-base lg:text-lg text-slate-500 leading-relaxed mb-8">Switch between Kanban, List, and Timeline views in a single click.</p>
                        <div class="flex flex-wrap justify-center lg:justify-start gap-2 lg:gap-4">
                            <span class="px-4 py-2 bg-slate-50 border border-slate-100 rounded-full text-[10px] font-bold text-slate-600 uppercase">Kanban</span>
                            <span class="px-4 py-2 bg-slate-50 border border-slate-100 rounded-full text-[10px] font-bold text-slate-600 uppercase">Table View</span>
                        </div>
                    </div>

                    <div class="relative bg-slate-50 rounded-[2.5rem] p-8 border border-slate-100">
                        <div class="bg-white rounded-2xl shadow-2xl p-6 border border-slate-100 transform rotate-2">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div><div class="w-3 h-3 rounded-full bg-amber-400"></div><div class="w-3 h-3 rounded-full bg-green-400"></div>
                            </div>
                            <div class="space-y-4">
                                <div class="h-4 w-full bg-slate-50 rounded-lg"></div>
                                <div class="h-4 w-2/3 bg-slate-50 rounded-lg"></div>
                            </div>
                        </div>
                        <!-- Profile Card (Adjusted for Mobile) -->
                        <div class="absolute -bottom-6 -left-4 lg:-left-10 bg-indigo-600 text-white p-4 lg:p-5 rounded-3xl shadow-2xl flex items-center gap-4 animate-bounce-slow z-50 max-w-[280px]">
                            <img src="{{ asset('image/your-profile.jpeg') }}" alt="Developer" class="w-10 h-10 lg:w-12 lg:h-12 rounded-full border-2 border-white/30 object-cover shrink-0">
                            <div class="text-left">
                                <p class="text-[8px] font-black uppercase tracking-widest opacity-70">Developed By</p>
                                <p class="font-bold text-xs lg:text-sm tracking-tight">nibal bassam abu toaiam</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Workload Logic Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20 items-center text-center lg:text-left">
                    <div class="order-2 lg:order-1 relative bg-slate-900 rounded-[2rem] lg:rounded-[2.5rem] p-8 lg:p-12 overflow-hidden group">
                        <div class="flex items-end gap-3 h-32 lg:h-48 relative z-10">
                            <div class="flex-1 bg-indigo-500 rounded-t-xl h-[40%]"></div>
                            <div class="flex-1 bg-indigo-400 rounded-t-xl h-[90%]"></div>
                            <div class="flex-1 bg-indigo-600 rounded-t-xl h-[30%]"></div>
                            <div class="flex-1 bg-indigo-300 rounded-t-xl h-[70%]"></div>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto lg:mx-0 mb-8">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <h4 class="text-2xl lg:text-3xl font-[900] text-slate-900 mb-6">Workload Intelligence</h4>
                        <p class="text-base lg:text-lg text-slate-500 leading-relaxed">Prevent burnout. Masar analyzes team capacity and alerts you to bottlenecks.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-10 lg:py-20 px-6">
            <div class="max-w-[1200px] mx-auto relative overflow-hidden bg-slate-950 rounded-[2rem] lg:rounded-[3rem] p-10 lg:p-24 text-center group">
                <div class="relative z-10">
                    <h2 class="text-2xl md:text-5xl lg:text-6xl font-[900] text-white mb-8 tracking-tighter leading-[1.1]">Powerful project management, <br class="hidden lg:block"><span class="text-indigo-400">100% free for everyone.</span></h2>
                    <p class="text-base lg:text-lg text-slate-400 mb-10 max-w-xl mx-auto">No subscriptions, no hidden fees. Built to empower teams completely free.</p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 lg:gap-6">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto bg-indigo-600 text-white px-8 lg:px-10 py-4 lg:py-5 rounded-2xl font-bold text-base lg:text-lg hover:bg-indigo-500 transition-all shadow-xl">Get started free</a>
                        <a href="#" class="w-full sm:w-auto bg-white/5 border border-white/10 text-white px-8 lg:px-10 py-4 lg:py-5 rounded-2xl font-bold text-base lg:text-lg hover:bg-white/10 transition-all">Documentation</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="pt-20 pb-12 px-6 border-t border-slate-100 bg-white">
        <div class="max-w-[1200px] mx-auto">
            <div class="flex flex-col lg:flex-row justify-between items-start gap-12 mb-16">
                <div class="max-w-xs text-left">
                    <a href="/" class="flex items-center gap-0 mb-6 group">
                        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                        <span class="text-2xl font-[900] tracking-tighter uppercase text-indigo-600 ml-[-4px]">Masar</span>
                    </a>
                    <p class="text-slate-500 text-sm italic">Empowering teams through clarity and speed.</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-12 lg:gap-24 text-left">
                    <div class="space-y-4">
                        <h5 class="text-xs font-black text-slate-900 uppercase tracking-widest">Platform</h5>
                        <ul class="space-y-2 text-sm text-slate-500">
                            <li><a href="#" class="hover:text-indigo-600 transition">Roadmap</a></li>
                            <li><a href="#" class="hover:text-indigo-600 transition">Integrations</a></li>
                        </ul>
                    </div>
                    <div class="space-y-4">
                        <h5 class="text-xs font-black text-slate-900 uppercase tracking-widest">Resources</h5>
                        <ul class="space-y-2 text-sm text-slate-500">
                            <li><a href="#" class="hover:text-indigo-600 transition">Documentation</a></li>
                            <li><a href="#" class="hover:text-indigo-600 transition">Help Center</a></li>
                        </ul>
                    </div>
                    <div class="space-y-4">
                        <h5 class="text-xs font-black text-slate-900 uppercase tracking-widest">Legal</h5>
                        <ul class="space-y-2 text-sm text-slate-500">
                            <li><a href="#" class="hover:text-indigo-600 transition">Privacy</a></li>
                            <li><a href="#" class="hover:text-indigo-600 transition">Terms</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-6">
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">© 2025 Masar. All rights reserved.</p>
                <div class="flex items-center gap-2 font-black text-slate-400 text-[10px] uppercase tracking-widest">
                    <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>Systems Operational
                </div>
            </div>
        </div>
    </footer>

</body>
</html>