<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/alpinejs" defer></script>
    <title>AurumPay Dashboard</title>
</head>

<body 
    class="min-h-screen bg-background flex flex-col md:pl-64 transition-all duration-300 font-sans" 
    x-data="{ mobileMenuOpen: false }"
>

    {{-- MOBILE BRAND HEADER (Optional: Shows 'AurumPay' on top of phone screens) --}}
    <div class="md:hidden bg-black text-white p-4 border-b border-gray-800 flex items-center justify-between">
        <span class="text-xl font-bold tracking-wide">AurumPay</span>
    </div>

    {{-- SIDEBAR (Slides in/out) --}}
    <div 
        class="fixed inset-y-0 left-0 z-50 w-64 transition-transform duration-300 transform border-r border-gray-800 bg-black"
        :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
    >
        <x-sidebar />
    </div>

    {{-- BLACK OVERLAY (Closes menu when clicked) --}}
    <div 
        x-show="mobileMenuOpen" 
        @click="mobileMenuOpen = false"
        x-transition.opacity
        class="fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden"
        style="display: none;"
    ></div>

    {{-- MAIN CONTENT AREA --}}
    <main class="flex-1 flex flex-col">
        
        {{-- WE ARE BACK TO USING THE COMPONENT --}}
        <x-navbar />
        
        @yield('content')
    </main>

</body>
</html>