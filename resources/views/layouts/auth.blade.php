<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AurumPay - Secure Login</title>
    @vite('resources/css/app.css')
</head>
{{-- 
    RESPONSIVE FIXES:
    - min-h-screen: Forces full height so vertical centering works
    - flex items-center justify-center: Centers the box perfectly
    - p-4: Adds "safety padding" so the box never touches the phone edges
--}}
<body class="min-h-screen bg-background text-white flex items-center justify-center p-4">
    
    {{-- This container limits the width on large screens but allows full width on mobile --}}
    <div class="w-full max-w-md">
        @yield("content")
    </div>

</body>
</html>