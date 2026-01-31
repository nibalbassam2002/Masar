<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masar | Project OS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfcfd;
        }

        [x-cloak] {
            display: none !important;
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

<body class="antialiased bg-[#fcfcfd] text-slate-900 font-['Inter']">
    <div x-data="{ isCompact: false, openMobile: false }" class="relative flex h-screen overflow-hidden">

        <aside :class="{ 'w-64': !isCompact, 'w-20': isCompact }"
            class="bg-white border-r border-slate-100 flex flex-col h-full shrink-0 transition-all duration-300">
            @include('layouts.partials.sidebar')
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            @include('layouts.partials.navbar')

            <main class="flex-1 overflow-y-auto custom-scroll">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
