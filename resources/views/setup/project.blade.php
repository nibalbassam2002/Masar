<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create your first project | Masar</title>
    
    <!-- تأكد من بقاء Vite بهذا الشكل لتجنب الأخطاء -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F9FAFB] antialiased">

    <!-- Progress Bar (مكتمل بنسبة 100%) -->
    <div class="fixed top-0 left-0 w-full h-1.5 bg-gray-100 z-50">
        <div class="h-full bg-emerald-500 transition-all duration-1000 shadow-[0_0_10px_rgba(16,185,129,0.3)]" style="width: 100%"></div>
    </div>

    <main class="min-h-screen flex flex-col items-center justify-center p-6">
        
        <div class="w-full max-w-md">
            
            <!-- البطاقة المركزية الموحدة -->
            <div class="bg-white border border-gray-100 rounded-[2.5rem] p-10 md:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.02)]">
                
                <!-- أيقونة بناء المشروع -->
                <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>

                <!-- النصوص -->
                <div class="text-center mb-10">
                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">What are you working on?</h1>
                    <p class="text-gray-500 mt-2 text-sm leading-relaxed">
                        Every big achievement starts with a single project. Let's name your first one.
                    </p>
                </div>

                <!-- النموذج -->
                <form action="{{ route('setup.project') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-2 ml-1">Project Name</label>
                        <input type="text" name="project_name" required 
                               placeholder="e.g. Website Redesign or Mobile App"
                               class="w-full px-5 py-4 rounded-xl border border-gray-200 bg-white text-gray-900 font-medium outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50/50 transition-all">
                    </div>

                    <button type="submit" class="w-full bg-gray-950 text-white py-4.5 rounded-xl font-bold text-sm tracking-wide hover:bg-emerald-600 transition-all shadow-lg shadow-gray-200/50 active:scale-[0.98] flex items-center justify-center gap-2">
                        Finish Setup & Launch
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </button>
                </form>

            </div>

            <!-- الخطوات -->
            <div class="mt-12 text-center">
                <div class="flex items-center justify-center gap-2 mb-3">
                     <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                     <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Ready to start</span>
                </div>
                <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.2em]">Step 3 of 3</p>
            </div>
        </div>

    </main>

</body>
</html>