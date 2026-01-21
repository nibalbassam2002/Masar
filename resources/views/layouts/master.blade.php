<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masar | Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 antialiased">

    <div x-data="{ isCompact: false, openMobile: false }" class="relative flex h-screen overflow-hidden">
        
        <!-- خلفية سوداء للجوال فقط -->
        <div x-show="openMobile" 
             x-cloak
             @click="openMobile = false" 
             class="fixed inset-0 bg-slate-900/50 z-[45] lg:hidden backdrop-blur-sm transition-opacity">
        </div>

        <!-- Sidebar Section -->
        <aside 
            :class="{
                'w-72': !isCompact,
                'w-20': isCompact,
                'translate-x-0': openMobile,
                '-translate-x-full': !openMobile
            }"
            class="fixed inset-y-0 left-0 z-50 bg-white border-r border-slate-100 transition-all duration-300 transform lg:translate-x-0 lg:static shadow-2xl lg:shadow-none flex flex-col h-full">
            @include('layouts.partials.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
            @include('layouts.partials.navbar')

            <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script> lucide.createIcons(); </script>
</body>
</html>