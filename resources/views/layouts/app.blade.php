<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>AurumPay Dashboard</title>
</head>

<body class="min-h-screen pl-64 bg-background flex flex-col">

    {{-- Fixed Sidebar --}}
    <x-sidebar />

    {{-- Main area shifted right --}}
    <main class="flex-1 flex flex-col">

        {{-- Navbar --}}
        <x-navbar />
        @yield('content')
   

    </main>

</body>
</html>
