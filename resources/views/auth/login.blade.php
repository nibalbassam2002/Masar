<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Masar</title>
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
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(139, 92, 246, 0.05) 0px, transparent 50%);
        }

        .input-style {
            width: 100%;
            padding: 0.85rem 1.25rem;
            border-radius: 0.75rem;
            background-color: #f8fafc;
            font-size: 0.8rem;
            font-weight: 600;
            outline: none;
            border: 1.5px solid #f1f5f9;
            transition: all 0.2s ease;
        }

        .input-style:focus {
            border-color: #6366f1;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }
    </style>
</head>

<body class="mesh-gradient min-h-screen flex flex-col antialiased">

    <nav class="p-4 lg:p-6 flex justify-between items-center w-full max-w-[1400px] mx-auto shrink-0">
        <a href="/" class="flex items-center gap-0 group">
            <img src="{{ asset('image/logo.png') }}" alt="Masar" class="w-10 h-10 lg:w-12 lg:h-12 object-contain">
            <span class="text-lg font-[900] tracking-tighter uppercase text-indigo-600 ml-[-4px]">Masar</span>
        </a>
        <div class="text-[11px] lg:text-sm font-bold text-slate-400">
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Register</a>
        </div>
    </nav>

    <!-- items-start ترفع المحتوى للأعلى في الموبايل -->
    <main class="flex-1 flex items-start lg:items-center justify-center p-4 lg:p-8">

        <!-- mt-4 لترك مسافة بسيطة من الأعلى في الموبايل -->
        <div
            class="w-full max-w-[1000px] mt-4 lg:mt-0 grid grid-cols-1 lg:grid-cols-2 bg-white rounded-[2rem] lg:rounded-[2.5rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.1)] overflow-hidden border border-slate-100">

            <!-- الصورة تظهر فقط في الشاشات الكبيرة -->
            <div class="hidden lg:flex relative bg-slate-50 p-10 items-center justify-center overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-indigo-100 rounded-full blur-[80px] opacity-40 -translate-y-1/2 translate-x-1/2">
                </div>
                <img src="{{ asset('image/6171704.png') }}" alt="Login illustration"
                    class="relative max-w-[80%] object-contain">
            </div>

            <div class="p-8 lg:p-12 flex flex-col justify-center bg-white">
                <div class="max-w-sm mx-auto w-full">
                    <header class="mb-6 lg:mb-8 text-left">
                        <h2 class="text-2xl lg:text-3xl font-[900] text-slate-900 mb-1">Welcome back.</h2>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Sign in to Masar</p>
                    </header>

                    <form action="{{ route('login') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ request('project_id') }}">

                        <div>
                            <label class="block text-[10px] font-extrabold uppercase text-slate-400 mb-1.5 ml-1">Email
                                Address</label>
                            <input type="email" name="email" required placeholder="name@company.com"
                                class="input-style">
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1.5 ml-1">
                                <label
                                    class="block text-[10px] font-extrabold uppercase text-slate-400">Password</label>
                                <a href="#"
                                    class="text-[10px] font-black text-indigo-600 hover:text-indigo-700">forget password?</a>
                            </div>
                            <input type="password" name="password" required placeholder="*******" class="input-style">
                        </div>

                        <div class="flex items-center gap-2 px-1">
                            <input type="checkbox" id="remember"
                                class="w-3.5 h-3.5 rounded border-slate-300 text-indigo-600">
                            <label for="remember" class="text-[11px] font-bold text-slate-500 cursor-pointer">Stay
                                signed in</label>
                        </div>

                        <button type="submit"
                            class="w-full bg-indigo-600 text-white py-4 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 active:scale-95">
                            Continue
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
                        class="w-full mt-6 flex items-center justify-center gap-3 py-3 rounded-xl border border-slate-100 text-[11px] font-bold text-slate-600 hover:bg-slate-50 transition-all">
                        <img src="https://www.svgrepo.com/show/355037/google.svg" class="h-4 w-4" alt="Google">
                       Continue with Google
                    </button>
                </div>
            </div>
        </div>
    </main>

    <footer class="p-6 text-center shrink-0">
        <p class="text-[9px] font-bold uppercase tracking-[0.3em] text-slate-300">© 2025 Masar Engineering Lab.</p>
    </footer>

</body>

</html>
