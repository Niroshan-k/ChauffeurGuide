<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athreya</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<style>
    @import url('https://fonts.cdnfonts.com/css/sageffine');
</style>
<body class="min-h-screen flex flex-col">
<header class="bg-white flex justify-between items-center">
    <div class="px-4 py-3">
        <img src="{{ asset('storage/appImages/logo.png') }}" alt="Logo" class="h-10">
    </div>
    <div class="px-4 py-3 text-white">
        <a href="https://instagram.com" class="border bg-black rounded-full px-5 py-2 flex items-center gap-3">
            <i class="fa-brands fa-instagram text-2xl"></i>
            <p>Instagram</p>
        </a>
    </div>
</header>

<main class="flex-grow flex items-center justify-center p-4">
    <div class="rounded-xl p-10 max-w-2xl w-full">
        <h1 class="text-5xl md:text-8xl font-bold text-green-700 mb-8 text-center" style="font-family: 'Sageffine', sans-serif;">
            Welcome to Athreya Ayurveda Ashram!
        </h1>
        <div class="flex flex-col md:flex-row gap-6 justify-center">
            <a href="/admin/login"
               class="px-8 py-10 bg-green-600 text-white rounded-lg shadow-lg hover:bg-green-700 
                      transition duration-300 font-semibold text-lg text-center flex flex-col items-center justify-center gap-2">
                <i class="fas fa-user-shield"></i>
                Admin Portal
            </a>
            <a href="/guide/login"
               class="px-8 py-10 bg-yellow-500 text-white rounded-lg shadow-lg hover:bg-yellow-600 
                      transition duration-300 font-semibold text-lg text-center flex flex-col items-center justify-center gap-2">
                <i class="fas fa-user-tie"></i>
                Guide Portal
            </a>
        </div>
    </div>
</main>
<footer>
    <div class="mt-8 pb-8 text-center text-gray-600">
        &copy; 2025 Engage Lanka, a subsidiary of Softmaster Technologies (Pvt) Ltd. All rights reserved.
    </div>
</footer>
</body>
</html>