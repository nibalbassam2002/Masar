<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Masar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            letter-spacing: -0.02em; 
        }
        .mesh-gradient {
            background-color: #ffffff;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(139, 92, 246, 0.05) 0px, transparent 50%);
        }
        .input-style {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1.5px solid #f1f5f9;
        }
        .input-style:focus {
            background: #ffffff;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
        }
    </style>
</head>
<body class="mesh-gradient h-screen flex flex-col antialiased overflow-hidden">

    <!-- Top Navigation -->
    <nav class="p-4 lg:p-5 flex justify-between items-center w-full max-w-[1400px] mx-auto shrink-0">
        <a href="/" class="flex items-center gap-0 group">
            <img src="{{ asset('image/logo.png') }}" alt="Masar" class="w-8 h-8 object-contain">
            <span class="text-lg font-[900] tracking-tighter uppercase text-indigo-600 ml-[-4px]">Masar</span>
        </a>
        <div class="text-xs font-bold text-slate-400">
            Already a member? <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 transition-colors">Sign in</a>
        </div>
    </nav>

    <main class="flex-1 flex items-center justify-center p-4 min-h-0">
        <!-- تم ضبط الارتفاع الأقصى لضمان الظهور بالكامل -->
        <div class="w-full max-w-[1000px] h-full max-h-[660px] grid lg:grid-cols-2 bg-white rounded-[2.5rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.08)] overflow-hidden border border-slate-100">
            
            <!-- Left Side: Visual -->
            <div class="relative bg-slate-50 p-6 flex items-center justify-center overflow-hidden">
                <div class="absolute top-0 right-0 w-80 h-80 bg-indigo-100/40 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
                
                <div class="relative w-full h-full flex flex-col items-center justify-center text-center">
                    <div class="relative group w-full h-full flex items-center justify-center">
                        <div class="absolute inset-0 bg-indigo-500/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition duration-700"></div>
                        <img src="{{ asset('image/6164736.png') }}" 
                             alt="Join Masar" 
                             class="relative max-w-[85%] max-h-[85%] object-contain transform hover:scale-105 transition duration-700">
                    </div>
                </div>
            </div>

            <!-- Right Side: Register Form -->
            <div class="p-8 lg:p-12 flex flex-col justify-center bg-white overflow-hidden">
                <div class="max-w-sm mx-auto w-full">
                    <!-- Title Section -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-[900] tracking-tight text-slate-900 mb-1">Join <span class="text-indigo-600">Masar.</span></h2>
                        <p class="text-slate-400 text-[10px] font-[800] uppercase tracking-[0.2em]">Create your workspace today</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST" class="space-y-3.5">
                        @csrf
                        
                        <!-- Full Name -->
                        <div class="space-y-1">
                            <label class="block text-[9px] font-[800] uppercase tracking-widest text-slate-400 ml-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. John Doe"
                                   class="w-full px-5 py-3 rounded-xl bg-slate-50 text-xs font-semibold outline-none input-style">
                            @error('name') <p class="text-red-500 text-[9px] mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-1">
                            <label class="block text-[9px] font-[800] uppercase tracking-widest text-slate-400 ml-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@company.com"
                                   class="w-full px-5 py-3 rounded-xl bg-slate-50 text-xs font-semibold outline-none input-style">
                            @error('email') <p class="text-red-500 text-[9px] mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Password Group -->
                        <div class="grid grid-cols-2 gap-3">
                            <div class="space-y-1">
                                <label class="block text-[9px] font-[800] uppercase tracking-widest text-slate-400 ml-1">Password</label>
                                <input type="password" name="password" required placeholder="••••••••"
                                       class="w-full px-4 py-3 rounded-xl bg-slate-50 text-xs font-semibold outline-none input-style">
                            </div>
                            <div class="space-y-1">
                                <label class="block text-[9px] font-[800] uppercase tracking-widest text-slate-400 ml-1">Confirm</label>
                                <input type="password" name="password_confirmation" required placeholder="••••••••"
                                       class="w-full px-4 py-3 rounded-xl bg-slate-50 text-xs font-semibold outline-none input-style">
                            </div>
                        </div>

                        <!-- Terms -->
                        <div class="flex items-center gap-2 px-1 py-1">
                            <input type="checkbox" id="terms" required class="w-3.5 h-3.5 rounded border-slate-200 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                            <label for="terms" class="text-[10px] font-bold text-slate-500 cursor-pointer">
                                I agree to the <span class="text-indigo-600 hover:underline">Terms & Privacy</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full bg-slate-900 text-white py-3.5 rounded-xl font-[900] text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 shadow-lg shadow-slate-100 transition-all duration-300 active:scale-[0.98]">
                            Create Account
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="mt-6 relative">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                        <div class="relative flex justify-center text-[9px] font-black uppercase tracking-[0.2em]"><span class="bg-white px-4 text-slate-300">Quick Join</span></div>
                    </div>

                    <!-- Google Signup -->
                    <div class="mt-5">
                        <button class="w-full flex items-center justify-center gap-3 py-3 rounded-xl border border-slate-100 bg-white text-[11px] font-bold text-slate-600 hover:bg-slate-50 transition-all">
                            <img src="https://www.svgrepo.com/show/355037/google.svg" class="h-3.5 w-3.5" alt="Google">
                             with Google
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>