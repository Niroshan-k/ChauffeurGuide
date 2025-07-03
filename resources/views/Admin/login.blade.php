<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Athreya Ayurveda</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .login-gradient {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #bbf7d0 100%);
        }
        
        .card-shadow {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .input-focus {
            transition: all 0.3s ease;
        }
        
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .bg-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(34, 197, 94, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(101, 163, 13, 0.1) 0%, transparent 50%);
        }
    </style>
</head>

<body class="min-h-screen bg-pattern login-gradient">
    <!-- Background Decorations -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-10 w-72 h-72 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 floating-animation"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-emerald-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 floating-animation" style="animation-delay: -2s;"></div>
        <div class="absolute -bottom-32 left-1/2 transform -translate-x-1/2 w-96 h-96 bg-lime-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 floating-animation" style="animation-delay: -4s;"></div>
    </div>

    <!-- Back to Home Button -->
    <a href="/" class="fixed left-6 top-6 z-20 group bg-white/90 backdrop-blur-sm hover:bg-white text-gray-700 hover:text-gray-900 rounded-2xl px-6 py-3 flex items-center gap-3 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
        <i class="fa-solid fa-arrow-left text-lg group-hover:-translate-x-1 transition-transform"></i>
        <span class="font-semibold">Back to Home</span>
    </a>

    <!-- Main Content -->
    <main class="relative z-10 min-h-screen flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">
            <!-- Logo and Header -->
            <div class="text-center mb-8">
                <div class="inline-block bg-white/80 backdrop-blur-sm p-4 rounded-3xl shadow-lg mb-6">
                    <div class="bg-gradient-to-br from-green-100 to-emerald-100 p-3 rounded-2xl">
                        <i class="fas fa-user-shield text-3xl text-green-600"></i>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Portal</h1>
                <p class="text-gray-600">Secure access to administrative controls</p>
            </div>

            <!-- Login Form Card -->
            <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-white/20">
                <form id="loginForm" class="space-y-6">
                    <!-- Email Input -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope text-green-600 mr-2"></i>
                            Email Address
                        </label>
                        <div class="relative">
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   class="input-focus w-full px-4 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-400 focus:border-green-400 text-gray-900 placeholder-gray-500 transition-all duration-300" 
                                   placeholder="Enter your email address"
                                   required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                <i class="fas fa-at text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock text-green-600 mr-2"></i>
                            Password
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="input-focus w-full px-4 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-400 focus:border-green-400 text-gray-900 placeholder-gray-500 transition-all duration-300" 
                                   placeholder="Enter your password"
                                   required>
                            <button type="button" 
                                    id="togglePassword"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Error Message -->
                    <div id="error" class="text-red-500 text-sm font-medium bg-red-50 rounded-lg p-3 hidden"></div>

                    <!-- Login Button -->
                    <button type="submit" 
                            id="loginBtn"
                            class="w-full bg-gradient-to-r from-green-500 to-green-200 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center gap-3">
                        <span id="loginBtnText">
                            <i class="fas fa-shield-alt mr-2"></i>
                            Secure Login
                        </span>
                        <svg id="loginSpinner" class="hidden animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                    </button>
                </form>

                <!-- Additional Info -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-4">
                            <i class="fas fa-info-circle text-green-500 mr-1"></i>
                            Use your administrator credentials to access the admin dashboard
                        </p>
                        <div class="flex items-center justify-center gap-4 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-shield-alt text-green-500"></i>
                                Encrypted
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-lock text-blue-500"></i>
                                Secure
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-user-shield text-purple-500"></i>
                                Admin Only
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Forgot your credentials? 
                    <a href="#" class="text-green-600 hover:text-green-700 font-semibold transition-colors">
                        Contact IT Support
                    </a>
                </p>
            </div>
        </div>
    </main>
    <script>
        // Password toggle functionality
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });

        // Login form submission
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const errorEl = document.getElementById('error');
            const loginBtn = document.getElementById('loginBtn');
            const loginBtnText = document.getElementById('loginBtnText');
            const loginSpinner = document.getElementById('loginSpinner');
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            // Reset error state
            errorEl.classList.add('hidden');
            errorEl.textContent = '';
            
            // Set loading state
            loginBtn.disabled = true;
            loginBtnText.textContent = 'Authenticating...';
            loginSpinner.classList.remove('hidden');
            
            try {
                const response = await fetch('/api/admin/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    // Show error
                    errorEl.textContent = data.message || 'Login failed. Please check your credentials and try again.';
                    errorEl.classList.remove('hidden');
                    
                    // Reset button state
                    loginBtn.disabled = false;
                    loginBtnText.innerHTML = '<i class="fas fa-shield-alt mr-2"></i>Secure Login';
                    loginSpinner.classList.add('hidden');
                } else {
                    // Success - store token and redirect
                    localStorage.setItem('admin_token', data.token);
                    
                    // Show success state briefly
                    loginBtnText.innerHTML = '<i class="fas fa-check mr-2"></i>Access Granted!';
                    loginBtn.classList.remove('from-green-500', 'to-emerald-600');
                    loginBtn.classList.add('from-green-600', 'to-green-700');
                    
                    // Redirect after a short delay
                    setTimeout(() => {
                        window.location.href = '/admin/dashboard';
                    }, 1000);
                }
            } catch (err) {
                // Network error
                errorEl.textContent = 'Network error. Please check your connection and try again.';
                errorEl.classList.remove('hidden');
                
                // Reset button state
                loginBtn.disabled = false;
                loginBtnText.innerHTML = '<i class="fas fa-shield-alt mr-2"></i>Secure Login';
                loginSpinner.classList.add('hidden');
            }
        });

        // Add focus animations to inputs
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('scale-105');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('scale-105');
            });
        });

        // Check if admin is already logged in (uncomment if needed)
        // if (localStorage.getItem('admin_token')) {
        //     window.location.href = '/admin/dashboard';
        // }
    </script>
    <!-- Footer -->
    <footer class="relative z-10 bg-white/80 backdrop-blur-sm border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-6">
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    &copy; 2025 Engage Lanka, a subsidiary of Softmaster Technologies (Pvt) Ltd. All rights reserved.
                </p>
                <div class="mt-2 flex items-center justify-center gap-4 text-xs text-gray-500">
                    <a href="#" class="hover:text-green-600 transition-colors">Privacy Policy</a>
                    <span>•</span>
                    <a href="#" class="hover:text-green-600 transition-colors">Terms of Service</a>
                    <span>•</span>
                    <a href="#" class="hover:text-green-600 transition-colors">Admin Support</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>