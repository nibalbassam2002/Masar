<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masar | Project OS</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfcfd;
        }

        .custom-scroll::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</head>

<!-- أضفنا x-data هنا لكي تتحكم في كل الصفحة -->
<body class="antialiased bg-[#fcfcfd] text-slate-900" x-data="{ isCompact: false, isSidebarOpen: false }">
    
    <div class="relative flex h-screen overflow-hidden">

        <!-- 1. الخلفية المظلمة للموبايل -->
        <div x-show="isSidebarOpen" 
             @click="isSidebarOpen = false" 
             class="fixed inset-0 bg-slate-900/60 z-[60] lg:hidden backdrop-blur-sm"
             x-transition:enter="transition opacity-0"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-cloak>
        </div>

        <!-- 2. القائمة الجانبية (Sidebar) -->
        <!-- تم تعديل الكلاسات لتصبح متجاوبة -->
        <aside 
            :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-[70] w-72 bg-white border-r border-slate-100 transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0 shrink-0 flex flex-col h-full shadow-2xl lg:shadow-none"
            :style="window.innerWidth > 1024 ? (isCompact ? 'width: 5rem' : 'width: 18rem') : ''"
        >
            @include('layouts.partials.sidebar')
        </aside>

        <!-- 3. المحتوى الرئيسي -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- الناف بار (Navbar) -->
            @include('layouts.partials.navbar')

            <!-- محتوى الصفحات -->
            <main class="flex-1 overflow-y-auto custom-scroll bg-[#fcfcfd]">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>