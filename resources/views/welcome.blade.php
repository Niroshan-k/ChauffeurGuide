<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athreya Ayurveda Ashram</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @import url('https://fonts.cdnfonts.com/css/sageffine');
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #bbf7d0 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-radius: 15px;
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        .bg-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(34, 197, 94, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(101, 163, 13, 0.1) 0%, transparent 50%);
        }
    </style>
</head>
<body class="min-h-screen bg-pattern">
    <!-- Header -->
    <header class="fixed w-full bg-white backdrop-blur-sm shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="p-3 rounded-2xl">
                        <img src="{{ asset('storage/appImages/logo.png') }}" alt="Athreya Logo" class="h-12 w-auto">
                    </div>
                </div>
                <div>
                    <a href="https://instagram.com" target="_blank" 
                       class="group bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white rounded-full px-6 py-3 flex items-center gap-3 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fa-brands fa-instagram text-xl group-hover:rotate-12 transition-transform"></i>
                        <span class="font-semibold">Follow Us</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 relative overflow-hidden">
        <!-- Background Decorations -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-20 left-10 w-72 h-72 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 floating-animation"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 floating-animation" style="animation-delay: -2s;"></div>
            <div class="absolute -bottom-32 left-1/2 transform -translate-x-1/2 w-96 h-96 bg-lime-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 floating-animation" style="animation-delay: -4s;"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 py-16 lg:py-24">
            <!-- Hero Section -->
            <div class="text-center mb-16">
                <div class="inline-block mb-6">
                    <span class="bg-gradient-to-r from-green-600 to-green-300 bg-clip-text text-transparent text-sm font-semibold tracking-wide uppercase">
                        Welcome to
                    </span>
                </div>
                
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight" style="font-family: 'Sageffine', serif;">
                    <span class="bg-gradient-to-r from-green-700 via-green-600 to-green-400 bg-clip-text text-transparent">
                        Athreya Ayurveda
                    </span>
                    <br>
                    <span class="text-gray-800">Ashram</span>
                </h1>
                
                <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Experience authentic Ayurvedic healing and wellness in a serene environment. 
                    <span class="text-green-600 font-semibold">Choose your portal below</span> to begin your journey.
                </p>
            </div>

            <!-- Portal Cards -->
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Admin Portal -->
                <div class="group card-hover">
                    <a href="/admin/login" class="block">
                        <div class="relative bg-white rounded-3xl p-8 shadow-xl border border-gray-100 overflow-hidden">
                            <div class="relative z-10">
                                <div class="flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 to-green-300 rounded-2xl mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                    <i class="fas fa-user-shield text-3xl text-white"></i>
                                </div>
                                
                                <h3 class="text-2xl font-bold text-gray-800 mb-4">Admin Portal</h3>
                                <p class="text-gray-600 mb-6 leading-relaxed">
                                    Manage ashram operations, oversee guide activities, and maintain system configurations with comprehensive administrative tools.
                                </p>
                                
                                <div class="flex items-center text-green-600 font-semibold group-hover:text-green-700 transition-colors">
                                    <span>Access Admin Panel</span>
                                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Guide Portal -->
                <div class="group card-hover">
                    <a href="/guide/login" class="block">
                        <div class="relative bg-white rounded-3xl p-8 shadow-xl border border-gray-100 overflow-hidden">
                            <div class="relative z-10">
                                <div class="flex items-center justify-center w-20 h-20 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                    <i class="fas fa-user-tie text-3xl text-white"></i>
                                </div>
                                
                                <h3 class="text-2xl font-bold text-gray-800 mb-4">Guide Portal</h3>
                                <p class="text-gray-600 mb-6 leading-relaxed">
                                    Access your personalized dashboard, view your profile, track points, and redeem rewards through our guide management system.
                                </p>
                                
                                <div class="flex items-center text-amber-600 font-semibold group-hover:text-amber-700 transition-colors">
                                    <span>Access Guide Panel</span>
                                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Features Section -->
            <div class="mt-20 text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-12">Why Choose Athreya?</h2>
                <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <div class="group">
                        <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl mb-4 mx-auto group-hover:scale-110 transition-transform">
                            <i class="fas fa-leaf text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Authentic Ayurveda</h3>
                        <p class="text-gray-600">Traditional healing practices passed down through generations</p>
                    </div>
                    
                    <div class="group">
                        <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl mb-4 mx-auto group-hover:scale-110 transition-transform">
                            <i class="fas fa-users text-2xl text-blue-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Expert Guidance</h3>
                        <p class="text-gray-600">Experienced practitioners dedicated to your wellness journey</p>
                    </div>
                    
                    <div class="group">
                        <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl mb-4 mx-auto group-hover:scale-110 transition-transform">
                            <i class="fas fa-spa text-2xl text-purple-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Holistic Wellness</h3>
                        <p class="text-gray-600">Complete mind, body, and spirit rejuvenation programs</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <footer class="relative z-10 bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Company Info -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <span class="text-xl font-bold">Athreya Ayurveda Ashram</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed">
                        Authentic Ayurvedic healing and wellness solutions for mind, body, and spirit rejuvenation.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Quick Links</h3>
                    <div class="space-y-2">
                        <a href="/admin/login" class="block text-gray-400 hover:text-green-400 transition-colors">Admin Portal</a>
                        <a href="/guide/login" class="block text-gray-400 hover:text-green-400 transition-colors">Guide Portal</a>
                        <a href="https://instagram.com" target="_blank" class="block text-gray-400 hover:text-green-400 transition-colors">Instagram</a>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Contact</h3>
                    <div class="space-y-2 text-gray-400">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-envelope text-green-400"></i>
                            <span>info@athreyaayurveda.com</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-phone text-green-400"></i>
                            <span>+94 77 596 6226</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-map-marker-alt text-green-400"></i>
                            <span>Wellness Center, Nature Valley</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    &copy; 2025 Engage Lanka, a subsidiary of Softmaster Technologies (Pvt) Ltd. All rights reserved.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>