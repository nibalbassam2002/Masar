<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masar | Engineering the Future of Project Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .nav-blur { background: rgba(255, 255, 255, 0.8); backdrop-filter: saturate(180%) blur(20px); }
        .bento-card { background: #ffffff; border: 1px solid #f1f5f9; transition: all 0.3s ease; }
        .bento-card:hover { border-color: #e2e8f0; box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05); }
        
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        .animate-bounce-slow { animation: bounce-slow 5s ease-in-out infinite; }
    </style>
</head>

<body class="bg-[#ffffff] text-[#020617] antialiased">

    <!-- Header & Navigation -->
    <nav class="fixed top-0 w-full z-[100] border-b border-slate-100 nav-blur">
        <div class="max-w-[1400px] mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-10">
                <!-- Branding -->
                <a href="/" class="flex items-center gap-0 group">
                    <div class="flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-15 h-15 object-contain block">
                    </div>
                    <span class="text-xl font-[800] tracking-tighter uppercase text-indigo-600 ml-[-4px]">Masar</span>
                </a>

                <!-- Main Menu -->
                <div class="hidden lg:flex items-center gap-8">
                    <div class="relative group">
                        <button class="flex items-center gap-1 text-[14px] font-semibold text-slate-500 hover:text-black transition-colors">
                            Features
                            <svg class="w-3.5 h-3.5 opacity-50 group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <div class="absolute top-full -left-4 w-48 pt-4 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                            <div class="bg-white border border-slate-100 shadow-xl rounded-xl p-2">
                                <a href="#" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 rounded-lg">Kanban Boards</a>
                                <a href="#" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 rounded-lg">Gantt Charts</a>
                                <a href="#" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 rounded-lg">Automation</a>
                            </div>
                        </div>
                    </div>

                    <div class="relative group">
                        <button class="flex items-center gap-1 text-[14px] font-semibold text-slate-500 hover:text-black transition-colors">
                            Solutions
                            <svg class="w-3.5 h-3.5 opacity-50 group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <div class="absolute top-full -left-4 w-48 pt-4 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                            <div class="bg-white border border-slate-100 shadow-xl rounded-xl p-2">
                                <a href="#" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 rounded-lg">Remote Teams</a>
                                <a href="#" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 rounded-lg">Engineering</a>
                                <a href="#" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 rounded-lg">Marketing</a>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="text-[14px] font-semibold text-slate-500 hover:text-black transition-colors">Docs</a>
                    <a href="#" class="text-[14px] font-semibold text-slate-500 hover:text-black transition-colors">Community</a>
                </div>
            </div>

            <!-- Auth Actions -->
            <div class="flex items-center gap-3">
                <a href="/login" class="text-[14px] font-bold px-4 text-slate-500 hover:text-indigo-600 transition">Log in</a>
                <a href="/register" class="bg-indigo-600 text-white px-6 py-2.5 rounded-full text-[14px] font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition whitespace-nowrap">
                    Sign up free
                </a>
            </div>
        </div>
    </nav>

    <main class="pt-16">
        <!-- Hero & Workspace Preview -->
        <section class="pt-12 pb-32 bg-white overflow-hidden">
            <div class="max-w-[1200px] mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="relative group">
                        <div class="absolute -inset-4 bg-indigo-500/5 rounded-[2.5rem] blur-2xl opacity-0 group-hover:opacity-100 transition duration-700"></div>
                        <div class="relative space-y-4">
                            <!-- Task Components -->
                            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-xl shadow-slate-200/50 w-full md:w-[380px] transform -rotate-2 hover:rotate-0 transition-all duration-500 z-30 relative">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="px-2.5 py-1 rounded-md bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase tracking-wider">In Progress</span>
                                    <div class="flex -space-x-2">
                                        <div class="w-7 h-7 rounded-full border-2 border-white bg-slate-200 overflow-hidden">
                                            <img src="https://i.pravatar.cc/100?u=1" alt="Avatar">
                                        </div>
                                        <div class="w-7 h-7 rounded-full border-2 border-white bg-slate-800 flex items-center justify-center text-[8px] text-white">+2</div>
                                    </div>
                                </div>
                                <h4 class="font-bold text-slate-900 mb-2">Redesign Dashboard UI/UX</h4>
                                <div class="flex items-center gap-4 text-slate-400">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                        <span class="text-xs">Oct 24</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                        <span class="text-xs">12</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-slate-50/50 border border-slate-100 p-5 rounded-2xl w-full md:w-[380px] absolute top-12 left-12 -z-10 opacity-60 md:block hidden transform rotate-3">
                                <div class="h-4 w-24 bg-slate-200 rounded-md mb-4"></div>
                                <div class="h-4 w-full bg-slate-100 rounded-md mb-2"></div>
                                <div class="h-4 w-2/3 bg-slate-100 rounded-md"></div>
                            </div>

                            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-lg w-full md:w-[320px] absolute -bottom-16 -right-4 md:flex hidden flex-col transform rotate-2 hover:translate-y-[-10px] transition-all">
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

                    <!-- Hero Content -->
                    <div>
                        <span class="text-indigo-600 font-bold text-sm tracking-widest uppercase mb-4 block">Centralized Control</span>
                        <h2 class="text-4xl md:text-5xl font-[800] text-slate-900 leading-[1.1] mb-8 tracking-tight">
                            Manage everything <br> without the <span class="text-slate-400 font-medium italic italic">chaos.</span>
                        </h2>
                        <p class="text-lg text-slate-500 mb-12 leading-relaxed">
                            Masar transforms complex projects into manageable tasks. Stay on top of your deadlines with
                            a visual workspace designed for clarity and speed.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
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

        <!-- Insights & Intelligence -->
        <section class="py-24 bg-slate-50 border-y border-slate-100 overflow-hidden">
            <div class="max-w-[1200px] mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-20 items-center">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-[11px] font-black tracking-widest uppercase mb-6">Performance Tracking</div>
                        <h2 class="text-4xl md:text-5xl font-[800] text-slate-900 leading-[1.1] mb-8 tracking-tighter">Data-driven <br> <span class="text-indigo-600">team intelligence.</span></h2>
                        <p class="text-lg text-slate-500 mb-10 leading-relaxed">
                            Masar doesn't just manage tasks; it monitors project health. Get real-time insights into
                            team velocity, identify bottlenecks, and ensure every deadline is met with confidence.
                        </p>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                                <div class="text-2xl font-black text-slate-900">94%</div>
                                <div class="text-xs text-slate-500 font-bold uppercase tracking-wider">On-time delivery</div>
                            </div>
                            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                                <div class="text-2xl font-black text-indigo-600">12+</div>
                                <div class="text-xs text-slate-500 font-bold uppercase tracking-wider">Active Sprints</div>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="bg-white rounded-3xl shadow-2xl border border-slate-100 p-8 relative z-10 transform hover:scale-[1.02] transition duration-500">
                            <h4 class="font-bold text-slate-900 mb-6 flex justify-between items-center text-sm">Team Workload <span class="text-[10px] bg-slate-100 px-2 py-1 rounded text-slate-500 uppercase tracking-tighter">Live View</span></h4>
                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs font-bold">
                                        <span class="text-slate-700">Sarah Connor</span>
                                        <span class="text-slate-400">85% Capacity</span>
                                    </div>
                                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden"><div class="h-full bg-indigo-600 w-[85%] rounded-full"></div></div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs font-bold">
                                        <span class="text-slate-700">James Wilson</span>
                                        <span class="text-slate-400">40% Capacity</span>
                                    </div>
                                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden"><div class="h-full bg-indigo-400 w-[40%] rounded-full"></div></div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs font-bold">
                                        <span class="text-slate-700">Alex Rivera</span>
                                        <span class="text-slate-400">100% Full</span>
                                    </div>
                                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden"><div class="h-full bg-red-500 w-[100%] rounded-full"></div></div>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -top-6 -right-6 bg-indigo-600 text-white p-6 rounded-3xl shadow-xl z-20 hidden md:block animate-bounce-slow">
                            <div class="text-xs font-bold opacity-80 mb-1 uppercase tracking-tighter">Project Health</div>
                            <div class="text-3xl font-black">Excellent</div>
                            <div class="mt-2 flex gap-1">
                                <div class="w-1 h-3 bg-white/30 rounded-full"></div>
                                <div class="w-1 h-5 bg-white/60 rounded-full"></div>
                                <div class="w-1 h-4 bg-white rounded-full"></div>
                                <div class="w-1 h-6 bg-white rounded-full"></div>
                            </div>
                        </div>
                        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-100 rounded-full blur-3xl opacity-50 -z-10"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Capabilities Showcase -->
        <section class="py-32 px-6 bg-white overflow-hidden">
            <div class="max-w-[1200px] mx-auto">
                <div class="text-center mb-24">
                    <h2 class="text-indigo-600 font-bold text-sm tracking-[0.4em] uppercase mb-4">Core Capabilities</h2>
                    <h3 class="text-5xl md:text-7xl font-[900] text-slate-900 tracking-tighter mb-6">Everything you need.</h3>
                    <p class="text-xl text-slate-500 max-w-2xl mx-auto">Masar is built for teams that demand precision and speed. No clutter, just the power you need to ship.</p>
                </div>

                <div class="grid lg:grid-cols-2 gap-20 items-center mb-32">
                    <div>
                        <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center mb-8 shadow-xl shadow-indigo-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-width="2.5" stroke-linecap="round" /></svg>
                        </div>
                        <h4 class="text-3xl font-[900] text-slate-900 mb-6">Infinite Project Views</h4>
                        <p class="text-lg text-slate-500 leading-relaxed mb-8">
                            Switch between Kanban, List, and Timeline views in a single click. Every team member can
                            work exactly how they think, while staying perfectly synced.
                        </p>
                        <div class="flex gap-4">
                            <span class="px-4 py-2 bg-slate-50 border border-slate-100 rounded-full text-xs font-bold text-slate-600">Kanban</span>
                            <span class="px-4 py-2 bg-slate-50 border border-slate-100 rounded-full text-xs font-bold text-slate-600">Gantt Charts</span>
                            <span class="px-4 py-2 bg-slate-50 border border-slate-100 rounded-full text-xs font-bold text-slate-600">Table View</span>
                        </div>
                    </div>
                    
                    <div class="relative bg-slate-50 rounded-[2.5rem] p-8 border border-slate-100">
                        <div class="bg-white rounded-2xl shadow-2xl p-6 border border-slate-100 transform rotate-2">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                                <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            </div>
                            <div class="space-y-4">
                                <div class="h-4 w-full bg-slate-50 rounded-lg"></div>
                                <div class="h-4 w-2/3 bg-slate-50 rounded-lg"></div>
                                <div class="h-4 w-3/4 bg-slate-50 rounded-lg"></div>
                            </div>
                        </div>

                        <!-- Developer Attribution -->
                        <div class="absolute -bottom-6 -left-10 bg-indigo-600 text-white p-5 rounded-3xl shadow-2xl flex items-center gap-4 animate-bounce-slow z-50">
                            <div class="w-12 h-12 rounded-full border-2 border-white/30 overflow-hidden shrink-0 shadow-inner">
                                <img src="{{ asset('image/your-profile.jpeg') }}" alt="Developer" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest opacity-70 mb-0.5">Developed By</p>
                                <p class="font-bold text-sm tracking-tight">nibal bassam abu toaiam</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid lg:grid-cols-2 gap-20 items-center">
                    <div class="order-2 lg:order-1 relative bg-slate-900 rounded-[2.5rem] p-12 overflow-hidden group">
                        <div class="flex items-end gap-3 h-48 relative z-10">
                            <div class="flex-1 bg-indigo-500 rounded-t-xl group-hover:h-[80%] transition-all duration-700 h-[40%]"></div>
                            <div class="flex-1 bg-indigo-400 rounded-t-xl group-hover:h-[60%] transition-all duration-700 h-[90%]"></div>
                            <div class="flex-1 bg-indigo-600 rounded-t-xl group-hover:h-[95%] transition-all duration-700 h-[30%]"></div>
                            <div class="flex-1 bg-indigo-300 rounded-t-xl group-hover:h-[45%] transition-all duration-700 h-[70%]"></div>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-8">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
                        </div>
                        <h4 class="text-3xl font-[900] text-slate-900 mb-6">Workload Intelligence</h4>
                        <p class="text-lg text-slate-500 leading-relaxed">
                            Prevent burnout before it starts. Masar analyzes team capacity and alerts you to
                            bottlenecks, ensuring projects stay on track without overloading your best performers.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final Conversion CTA -->
        <section class="py-32 px-6">
            <div class="max-w-[1200px] mx-auto relative overflow-hidden bg-slate-950 rounded-[3rem] p-12 md:p-24 text-center group">
                <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-600/20 rounded-full blur-[100px] group-hover:bg-indigo-600/30 transition-all duration-700"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px]"></div>

                <div class="relative z-10">
                    <h2 class="text-4xl md:text-6xl font-[900] text-white mb-8 tracking-tighter leading-[1.1]">Powerful project management, <br><span class="text-indigo-400">100% free for everyone.</span></h2>
                    <p class="text-lg text-slate-400 mb-12 max-w-xl mx-auto leading-relaxed">No subscriptions, no hidden fees, and no credit cards. Masar is built to empower teams and individuals to achieve more, completely free.</p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-6">
                        <a href="/register" class="w-full sm:w-auto bg-indigo-600 text-white px-10 py-5 rounded-2xl font-bold text-lg hover:bg-indigo-500 hover:scale-105 transition-all shadow-xl shadow-indigo-900/20">Get started now — It's free</a>
                        <a href="#" class="w-full sm:w-auto bg-white/5 border border-white/10 text-white px-10 py-5 rounded-2xl font-bold text-lg hover:bg-white/10 transition-all">View Documentation</a>
                    </div>

                    <div class="mt-10 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <p class="text-sm text-slate-500 font-bold uppercase tracking-widest italic">Free Forever • Unlimited Projects • Unlimited Users</p>
                    </div>
                </div>

                <div class="absolute top-10 right-10 hidden lg:block">
                    <div class="bg-indigo-500/10 border border-indigo-500/20 px-4 py-2 rounded-full backdrop-blur-md">
                        <span class="text-indigo-400 text-xs font-black tracking-widest uppercase">Open to Everyone</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Project Footer -->
    <footer class="pt-24 pb-12 px-6 border-t border-slate-100 bg-white">
        <div class="max-w-[1200px] mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start gap-16 mb-20">
                <div class="max-w-xs">
                    <a href="/" class="flex items-center gap-0 mb-6 group">
                        <div class="flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain block">
                        </div>
                        <span class="text-2xl font-[900] tracking-tighter uppercase text-indigo-600 ml-[-4px]">Masar</span>
                    </a>
                    <p class="text-slate-500 leading-relaxed text-sm italic">Empowering teams to reach their highest potential through clarity, speed, and intelligence.</p>
                    
                    <div class="flex gap-4 mt-8">
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition-all"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" /></svg></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition-all"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22v3.293c0 .319.192.694.805.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" /></svg></a>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-16 md:gap-24">
                    <div class="space-y-6">
                        <h5 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em]">Platform</h5>
                        <ul class="space-y-4">
                            <li><a href="#" class="text-sm text-slate-500 hover:text-indigo-600 transition-colors">Features</a></li>
                            <li><a href="#" class="text-sm text-slate-500 hover:text-indigo-600 transition-colors">Roadmap</a></li>
                            <li><a href="#" class="text-sm text-slate-500 hover:text-indigo-600 transition-colors">Integrations</a></li>
                        </ul>
                    </div>
                    <div class="space-y-6">
                        <h5 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em]">Resources</h5>
                        <ul class="space-y-4">
                            <li><a href="#" class="text-sm text-slate-500 hover:text-indigo-600 transition-colors">Documentation</a></li>
                            <li><a href="#" class="text-sm text-slate-500 hover:text-indigo-600 transition-colors">Community</a></li>
                            <li><a href="#" class="text-sm text-slate-500 hover:text-indigo-600 transition-colors">Help Center</a></li>
                        </ul>
                    </div>
                    <div class="space-y-6">
                        <h5 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em]">Legal</h5>
                        <ul class="space-y-4">
                            <li><a href="#" class="text-sm text-slate-500 hover:text-indigo-600 transition-colors">Privacy</a></li>
                            <li><a href="#" class="text-sm text-slate-500 hover:text-indigo-600 transition-colors">Terms</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="pt-12 border-t border-slate-50 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">© 2025 Masar. All rights reserved.</p>
                <div class="flex items-center gap-2 font-black text-slate-400">
                    <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                    <p class="text-[10px] uppercase tracking-widest">Systems Operational</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>