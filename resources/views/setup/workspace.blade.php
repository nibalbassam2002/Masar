<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup your Workspace | Masar</title>
    
    <!-- تم إصلاح استدعاء Vite هنا -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F9FAFB] antialiased">

    <!-- Progress Bar رفيع جداً -->
    <div class="fixed top-0 left-0 w-full h-1 bg-gray-100">
        <div class="h-full bg-indigo-600 transition-all duration-500" style="width: 33%"></div>
    </div>

    <main class="min-h-screen flex flex-col items-center justify-center p-6">
        
        <div class="w-full max-w-md">
            <!-- أيقونة بسيطة ونظيفة -->
            <div class="w-16 h-16 bg-white border border-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>

            <!-- النصوص -->
            <div class="text-center mb-10">
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Let's name your workspace</h1>
                <p class="text-gray-500 mt-2 text-sm leading-relaxed">
                    This is the home for all your projects and team members. 
                </p>
            </div>

            <!-- النموذج -->
            <form action="{{ route('setup.workspace') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-2 ml-1">Workspace Name</label>
                    <input type="text" name="workspace_name" required 
                           placeholder="e.g. Marketing Team or Alpha Project"
                           class="w-full px-5 py-4 rounded-xl border border-gray-200 bg-white text-gray-900 font-medium outline-none focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50/50 transition-all">
                </div>

                <button type="submit" class="w-full bg-gray-950 text-white py-4.5 rounded-xl font-bold text-sm tracking-wide hover:bg-indigo-600 transition-all shadow-lg shadow-gray-200/50 active:scale-[0.98]">
                    Next: Team Details →
                </button>
            </form>

            <!-- رقم الخطوة -->
            <div class="mt-12 text-center">
                <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.2em]">Step 1 of 3</p>
            </div>
        </div>

    </main>

</body>
</html>