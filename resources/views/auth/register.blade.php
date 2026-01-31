<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Masar | Create Account</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.02em; }
        .mesh-gradient {
            background-color: #ffffff;
            background-image: 
                radial-gradient(at 0% 0%, rgba(6, 182, 212, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(99, 102, 241, 0.05) 0px, transparent 50%);
        }
    </style>
</head>
<body class="mesh-gradient h-screen flex flex-col antialiased overflow-hidden">

    <!-- Top Navigation -->
    <nav class="p-4 lg:p-6 flex justify-between items-center w-full max-w-[1400px] mx-auto shrink-0">
        <a href="/" class="flex items-center gap-0 group">
            <img src="{{ asset('image/logo.png') }}" alt="Masar" class="w-12 h-12 object-contain">
            <span class="text-xl font-[900] tracking-tighter uppercase text-indigo-600 ml-[-4px]">Masar</span>
        </a>
        <div class="text-sm font-bold text-slate-400">
            Already a member? <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 transition-all underline-offset-4">Sign in</a>
        </div>
    </nav>

    <main class="flex-1 flex items-center justify-center p-4 min-h-0">
        <div class="w-full max-w-[1000px] h-full max-h-[720px] grid lg:grid-cols-2 bg-white rounded-[3rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.08)] overflow-hidden border border-slate-100">
            
            <!-- Left Side: Visual Identity -->
            <div class="relative bg-slate-50 p-10 flex items-center justify-center overflow-hidden">
                <div class="absolute top-0 right-0 w-80 h-80 bg-indigo-100/50 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
                
                <div class="relative w-full h-full flex flex-col items-center justify-center group">
                    <div class="absolute -inset-4 bg-cyan-500/5 rounded-[2.5rem] blur-2xl group-hover:bg-cyan-500/10 transition duration-700"></div>
                    <img src="{{ asset('image/6164736.png') }}" 
                         alt="Collaboration" 
                         class="relative max-w-full max-h-[85%] object-contain transform hover:scale-105 transition duration-700">
                </div>
            </div>

            <!-- Right Side: Smart Form -->
            <div class="p-10 lg:p-14 flex flex-col justify-center bg-white overflow-y-auto custom-scroll">
                <div class="max-w-sm mx-auto w-full">
                    
                    <header class="mb-10">
                        <h2 class="text-3xl font-[900] tracking-tight text-slate-900 mb-2">Create account.</h2>
                        <p class="text-slate-400 text-[11px] font-[800] uppercase tracking-[0.2em]">
                            {{ request('project_id') ? 'Joining Project Workspace' : 'Start your journey with Masar' }}
                        </p>
                    </header>

                    <form action="{{ route('register') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <input type="hidden" name="project_id" value="{{ request('project_id') }}">

                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-[800] uppercase tracking-widest text-slate-400 ml-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. John Doe"
                                   class="input-field">
                            @error('name') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-[800] uppercase tracking-widest text-slate-400 ml-1">Email Address</label>
                            <input type="email" name="email" value="{{ request('email', old('email')) }}" required placeholder="name@company.com"
                                   class="input-field">
                            @error('email') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-[800] uppercase tracking-widest text-slate-400 ml-1">Password</label>
                                <input type="password" name="password" required placeholder="••••••••"
                                       class="input-field">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-[800] uppercase tracking-widest text-slate-400 ml-1">Confirm</label>
                                <input type="password" name="password_confirmation" required placeholder="••••••••"
                                       class="input-field">
                            </div>
                            @error('password') <p class="col-span-2 text-red-500 text-[10px] font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center gap-3 px-1 py-2">
                            <input type="checkbox" id="terms" required class="w-4 h-4 rounded border-slate-200 text-cyan-600 focus:ring-cyan-500 cursor-pointer">
                            <label for="terms" class="text-[11px] font-bold text-slate-500 cursor-pointer">
                                I agree to the <span class="text-cyan-600 hover:underline">Terms & Privacy</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full btn-primary !py-4 justify-center bg-slate-900 hover:bg-cyan-600 shadow-xl shadow-slate-100">
                            Create Account
                        </button>
                    </form>

                    <div class="mt-8 relative text-center">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                        <span class="relative bg-white px-4 text-[10px] font-black uppercase tracking-[0.3em] text-slate-300">Fast Access</span>
                    </div>

                    <div class="mt-6">
                        <button type="button" class="w-full flex items-center justify-center gap-3 py-3.5 rounded-2xl border border-slate-100 bg-white text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all">
                            <img src="https://www.svgrepo.com/show/355037/google.svg" class="h-4 w-4" alt="Google">
                            Sign up with Google
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <footer class="p-6 text-center">
        <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-slate-300">© 2025 Masar Engineering Lab. Built for Teams.</p>
    </footer>

</body>
</html>