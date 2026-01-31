<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What's your focus? | Masar</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .focus-radio:checked + .focus-content {
            border-color: #4f46e5;
            background-color: #f8faff;
            box-shadow: 0 0 0 1px #4f46e5;
        }
        .focus-radio:checked + .focus-content .icon-box {
            background-color: #4f46e5;
            color: white;
        }
    </style>
</head>
<body class="bg-[#F9FAFB] antialiased">

    <div class="fixed top-0 left-0 w-full h-1 bg-gray-100 z-50">
        <div class="h-full bg-indigo-600 transition-all duration-700" style="width: 66%"></div>
    </div>

    <main class="min-h-screen flex flex-col items-center justify-center p-6">
        
        <div class="w-full max-w-2xl"> 
            
            <div class="bg-white border border-gray-100 rounded-[2.5rem] p-8 md:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.02)]">
                
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>

                <div class="text-center mb-10">
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">How will you use Masar?</h1>
                    <p class="text-gray-500 mt-3 text-sm leading-relaxed max-w-xs mx-auto">
                        Tell us about your team to help us customize your experience.
                    </p>
                </div>

                <form action="{{ route('setup.team') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        
                        <label class="cursor-pointer">
                            <input type="radio" name="team_type" value="development" class="hidden focus-radio" checked>
                            <div class="focus-content p-5 border border-gray-100 rounded-2xl text-center transition-all hover:border-indigo-200 group">
                                <div class="icon-box w-10 h-10 mx-auto mb-3 bg-gray-50 text-gray-400 rounded-xl flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                                </div>
                                <span class="block text-sm font-bold text-gray-700">Dev</span>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="team_type" value="creative" class="hidden focus-radio">
                            <div class="focus-content p-5 border border-gray-100 rounded-2xl text-center transition-all hover:border-indigo-200 group">
                                <div class="icon-box w-10 h-10 mx-auto mb-3 bg-gray-50 text-gray-400 rounded-xl flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                                </div>
                                <span class="block text-sm font-bold text-gray-700">Creative</span>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="team_type" value="business" class="hidden focus-radio">
                            <div class="focus-content p-5 border border-gray-100 rounded-2xl text-center transition-all hover:border-indigo-200 group">
                                <div class="icon-box w-10 h-10 mx-auto mb-3 bg-gray-50 text-gray-400 rounded-xl flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <span class="block text-sm font-bold text-gray-700">Business</span>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="team_type" value="education" class="hidden focus-radio">
                            <div class="focus-content p-5 border border-gray-100 rounded-2xl text-center transition-all hover:border-indigo-200 group">
                                <div class="icon-box w-10 h-10 mx-auto mb-3 bg-gray-50 text-gray-400 rounded-xl flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                                </div>
                                <span class="block text-sm font-bold text-gray-700">Education</span>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="team_type" value="personal" class="hidden focus-radio">
                            <div class="focus-content p-5 border border-gray-100 rounded-2xl text-center transition-all hover:border-indigo-200 group">
                                <div class="icon-box w-10 h-10 mx-auto mb-3 bg-gray-50 text-gray-400 rounded-xl flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <span class="block text-sm font-bold text-gray-700">Personal</span>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="team_type" value="other" class="hidden focus-radio">
                            <div class="focus-content p-5 border border-gray-100 rounded-2xl text-center transition-all hover:border-indigo-200 group">
                                <div class="icon-box w-10 h-10 mx-auto mb-3 bg-gray-50 text-gray-400 rounded-xl flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01"/></svg>
                                </div>
                                <span class="block text-sm font-bold text-gray-700">Other</span>
                            </div>
                        </label>

                    </div>

                    <button type="submit" class="w-full bg-gray-950 text-white py-4.5 rounded-xl font-bold text-sm tracking-wide hover:bg-indigo-600 transition-all shadow-lg shadow-gray-100 active:scale-[0.98]">
                        Continue Setup →
                    </button>
                </form>

            </div>

            <div class="mt-12 text-center">
                <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.2em]">Step 2 of 3</p>
            </div>
        </div>

    </main>

</body>
</html>