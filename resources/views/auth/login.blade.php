<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Masar</title>
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
            transition: all 0.2s ease-in-out;
            border: 1.5px solid #f1f5f9;
        }
        .input-style:focus {
            background: #ffffff;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }
    </style>
</head>
<body class="mesh-gradient h-screen flex flex-col antialiased overflow-hidden">

    <!-- Top Navigation -->
    <nav class="p-4 lg:p-5 flex justify-between items-center w-full max-w-[1400px] mx-auto shrink-0">
        <a href="/" class="flex items-center gap-0 group">
            <img src="{{ asset('image/logo.png') }}" alt="Masar" class="w-12 h-12 object-contain">
            <span class="text-lg font-[900] tracking-tighter uppercase text-indigo-600 ml-[-4px]">Masar</span>
        </a>
        <div class="text-xs font-bold text-slate-400">
            New here? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Create an account</a>
        </div>
    </nav>

    <main class="flex-1 flex items-center justify-center p-4 min-h-0">
        <div class="w-full max-w-[1000px] h-full max-h-[650px] grid lg:grid-cols-2 bg-white rounded-[2.5rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.1)] overflow-hidden border border-slate-100">
            
            <!-- Left Side: Image Focus -->
            <div class="relative bg-slate-50 p-6 lg:p-10 flex items-center justify-center overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-100 rounded-full blur-[80px] opacity-40 -translate-y-1/2 translate-x-1/2"></div>
                
                <!-- الصورة الآن بدون تحديد aspect ratio لتأخذ طولها الطبيعي وتكون كاملة -->
                <div class="relative w-full h-full flex items-center justify-center group">
                    <div class="absolute -inset-4 bg-indigo-500/5 rounded-[2rem] blur-2xl group-hover:bg-indigo-500/10 transition duration-500"></div>
                    <img src="{{ asset('image/6171704.png') }}" 
                         alt="Illustration" 
                         class="relative max-w-full max-h-full object-contain transform hover:scale-105 transition duration-700">
                </div>
            </div>

            <!-- Right Side: Login Form -->
            <div class="p-8 lg:p-12 flex flex-col justify-center bg-white">
                <div class="max-w-sm mx-auto w-full">
                    <h2 class="text-2xl font-[900] tracking-tight text-slate-900 mb-1">Welcome back.</h2>
                    <p class="text-slate-400 text-[10px] font-bold mb-8 uppercase tracking-widest">Sign in to your workspace</p>

                    <form action="{{ route('login') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ request('project_id') }}">
                        <div>
                            <label class="block text-[9px] font-[800] uppercase tracking-[0.2em] text-slate-400 mb-1.5 ml-1">Email Address</label>
                            <input type="email" name="email" required placeholder="name@company.com"
                                   class="w-full px-5 py-3.5 rounded-xl bg-slate-50 text-xs font-semibold outline-none input-style">
                            @error('email') <p class="text-red-500 text-[9px] mt-1 font-bold px-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1.5 ml-1">
                                <label class="block text-[9px] font-[800] uppercase tracking-[0.2em] text-slate-400">Password</label>
                                <a href="#" class="text-[9px] font-black uppercase tracking-[0.2em] text-indigo-600 hover:text-indigo-700">forget password?</a>
                            </div>
                            <input type="password" name="password" required placeholder="••••••••"
                                   class="w-full px-5 py-3.5 rounded-xl bg-slate-50 text-xs font-semibold outline-none input-style">
                        </div>

                        <div class="flex items-center gap-2 px-1">
                            <input type="checkbox" id="remember" class="w-3.5 h-3.5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                            <label for="remember" class="text-[11px] font-bold text-slate-500 cursor-pointer">Stay signed in</label>
                        </div>

                        <button type="submit" class="w-full bg-slate-950 text-white py-4 rounded-xl font-[900] text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 shadow-lg shadow-indigo-100 transition-all duration-300 transform active:scale-[0.98]">
                            Continue
                        </button>
                    </form>

                    <div class="mt-8 relative">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                        <div class="relative flex justify-center text-[9px] font-black uppercase tracking-[0.2em]"><span class="bg-white px-4 text-slate-300">Fast access</span></div>
                    </div>

                    <div class="mt-6">
                        <button class="w-full flex items-center justify-center gap-3 py-3.5 px-4 rounded-xl border-1.5 border-slate-100 bg-white text-[11px] font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                            <img src="https://www.svgrepo.com/show/355037/google.svg" class="h-3.5 w-3.5" alt="">
                            Continue with Google
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>