<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Masar | Create Account</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -0.02em;
        }

        .mesh-gradient {
            background-color: #ffffff;
            background-image:
                radial-gradient(at 0% 0%, rgba(6, 182, 212, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(99, 102, 241, 0.05) 0px, transparent 50%);
        }

        .input-field {
            width: 100%;
            padding: 0.8rem 1rem;
            border-radius: 0.75rem;
            background-color: #f8fafc;
            font-size: 0.8rem;
            font-weight: 600;
            outline: none;
            border: 1.5px solid #f1f5f9;
            transition: all 0.2s ease;
        }

        .input-field:focus {
            border-color: #06b6d4;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.1);
        }
    </style>
</head>

<body class="mesh-gradient min-h-screen flex flex-col antialiased">

    <nav class="p-4 lg:p-6 flex justify-between items-center w-full max-w-[1400px] mx-auto shrink-0">
        <a href="/" class="flex items-center gap-0 group">
            <img src="{{ asset('image/logo.png') }}" alt="Masar" class="w-10 h-10 lg:w-12 lg:h-12 object-contain">
            <span class="text-lg font-[900] tracking-tighter uppercase text-indigo-600 ml-[-4px]">Masar</span>
        </a>

        <div class="flex items-center gap-4 lg:gap-6">
            <a href="javascript:history.back()"
                class="flex items-center gap-1 text-[11px] lg:text-sm font-bold text-slate-400 hover:text-indigo-600 transition-all group">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 transform group-hover:-translate-x-1 transition-transform" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>

            <span class="h-3 w-[1px] bg-slate-200"></span>

            <div class="text-[11px] lg:text-sm font-bold">
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 underline-offset-4">Sign
                    in</a>
            </div>
        </div>
    </nav>

    <!-- items-start ترفع المحتوى للأعلى في الموبايل -->
    <main class="flex-1 flex items-start lg:items-center justify-center p-4 lg:p-8">

        <!-- mt-4 في الموبايل لرفع الفورم -->
        <div
            class="w-full max-w-[1000px] mt-4 lg:mt-0 grid grid-cols-1 lg:grid-cols-2 bg-white rounded-[2rem] lg:rounded-[3rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.08)] overflow-hidden border border-slate-100">

            <!-- الصورة تظهر في الشاشات الكبيرة فقط -->
            <div class="hidden lg:flex relative bg-slate-50 p-10 items-center justify-center">
                <div
                    class="absolute top-0 right-0 w-80 h-80 bg-indigo-100/50 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2">
                </div>
                <img src="{{ asset('image/6164736.png') }}" alt="Register illustration"
                    class="relative max-w-[80%] object-contain">
            </div>

            <div class="p-8 lg:p-14 flex flex-col justify-center bg-white">
                <div class="max-w-sm mx-auto w-full">
                    <header class="mb-6 lg:mb-8">
                        <h2 class="text-2xl lg:text-3xl font-[900] text-slate-900 mb-1 lg:mb-2">Create account.</h2>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Start your journey
                            with Masar</p>
                    </header>

                    <form action="{{ route('register') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ request('project_id') }}">

                        <div>
                            <label class="block text-[10px] font-extrabold uppercase text-slate-400 mb-1 ml-1">Full
                                Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                placeholder="John Doe" class="input-field">
                        </div>

                        <div>
                            <label
                                class="block text-[10px] font-extrabold uppercase text-slate-400 mb-1 ml-1">Email</label>
                            <input type="email" name="email" value="{{ request('email', old('email')) }}" required
                                placeholder="name@company.com" class="input-field">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label
                                    class="block text-[10px] font-extrabold uppercase text-slate-400 mb-1 ml-1">Password</label>
                                <input type="password" name="password" required placeholder="*******"
                                    class="input-field">
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-extrabold uppercase text-slate-400 mb-1 ml-1">Confirm</label>
                                <input type="password" name="password_confirmation" required placeholder="*******"
                                    class="input-field">
                            </div>
                        </div>

                        <div class="flex items-center gap-3 px-1">
                            <input type="checkbox" id="terms" required
                                class="w-4 h-4 rounded border-slate-200 text-cyan-600">
                            <label for="terms" class="text-[11px] font-bold text-slate-500 cursor-pointer">
                                I agree to the<span class="text-cyan-600 underline underline-offset-2">Terms &
                                    Privacy</span>
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full bg-indigo-600 text-white py-4 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 active:scale-95">
                            Create Account
                        </button>
                    </form>

                    <div class="mt-8 relative text-center">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-100"></div>
                        </div>
                        <span class="relative bg-white px-4 text-[9px] font-black text-slate-300 uppercase">Fast
                            Access</span>
                    </div>

                    <button
                        class="w-full mt-6 flex items-center justify-center gap-3 py-3 rounded-xl border border-slate-100 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all">
                        <img src="https://www.svgrepo.com/show/355037/google.svg" class="h-4 w-4" alt="Google">
                        Sign up with Google
                    </button>
                </div>
            </div>
        </div>
    </main>

    <footer class="p-6 text-center shrink-0">
        <p class="text-[9px] font-bold uppercase text-slate-300 tracking-[0.3em]">© 2025 Masar Engineering Lab.</p>
    </footer>
</body>

</html>
