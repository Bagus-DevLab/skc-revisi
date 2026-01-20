<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillConnect.id - @yield('title', 'Platform Pelatihan Kerja')</title>
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    {{-- Memanggil Component Navbar --}}
    <x-navbar />

    {{-- Konten Utama Halaman akan masuk di sini --}}
    <main class="flex-grow">
        {{ $slot }}
    </main>

    {{-- Memanggil Component Footer --}}
    <x-footer />

</body>
</html>