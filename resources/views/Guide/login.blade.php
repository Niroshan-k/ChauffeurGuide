<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide Login - Athreya Ayurveda</title>
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
                radial-gradient(circle at 25% 25%, rgba(245, 158, 11, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(34, 197, 94, 0.1) 0%, transparent 50%);
        }
    </style>
</head>

<body class="min-h-screen bg-pattern login-gradient">
    <!-- Background Decorations -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-10 w-72 h-72 bg-amber-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 floating-animation"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 floating-animation" style="animation-delay: -2s;"></div>
        <div class="absolute -bottom-32 left-1/2 transform -translate-x-1/2 w-96 h-96 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 floating-animation" style="animation-delay: -4s;"></div>
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
                    <div class="bg-gradient-to-br from-amber-100 to-yellow-100 p-3 rounded-2xl">
                        <i class="fas fa-user-tie text-3xl text-amber-600"></i>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Guide Portal</h1>
                <p class="text-gray-600">Welcome back! Please sign in to your account</p>
            </div>

            <!-- Login Form Card -->
            <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-white/20">
                <form id="loginForm" class="space-y-6">
                    <!-- Mobile Number Input -->
                    <div class="space-y-2">
                        <label for="mobile_number" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-mobile-alt text-amber-600 mr-2"></i>
                            Mobile Number
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   id="mobile_number" 
                                   name="mobile_number" 
                                   class="input-focus w-full px-4 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-amber-400 focus:border-amber-400 text-gray-900 placeholder-gray-500 transition-all duration-300" 
                                   placeholder="Enter your mobile number"
                                   required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                <i class="fas fa-phone text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Error Message -->
                    <div id="error" class="text-red-500 text-sm font-medium bg-red-50 rounded-lg p-3 hidden"></div>

                    <!-- Login Button -->
                    <button type="submit" 
                            id="loginBtn"
                            class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-4 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center gap-3">
                        <span id="loginBtnText">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Sign In
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
                            <i class="fas fa-info-circle text-amber-500 mr-1"></i>
                            Use your registered mobile number to access your guide dashboard
                        </p>
                        <div class="flex items-center justify-center gap-4 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-shield-alt text-green-500"></i>
                                Secure Login
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-clock text-blue-500"></i>
                                24/7 Access
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Need help? 
                    <a href="#" class="text-amber-600 hover:text-amber-700 font-semibold transition-colors">
                        Contact Support
                    </a>
                </p>
            </div>
        </div>
    </main>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const errorEl = document.getElementById('error');
            const loginBtn = document.getElementById('loginBtn');
            const loginBtnText = document.getElementById('loginBtnText');
            const loginSpinner = document.getElementById('loginSpinner');
            const mobile_number = document.getElementById('mobile_number').value;
            
            // Reset error state
            errorEl.classList.add('hidden');
            errorEl.textContent = '';
            
            // Set loading state
            loginBtn.disabled = true;
            loginBtnText.textContent = 'Signing in...';
            loginSpinner.classList.remove('hidden');
            
            try {
                const response = await fetch('/api/guide/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ mobile_number })
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    // Show error
                    errorEl.textContent = data.message || 'Login failed. Please check your mobile number and try again.';
                    errorEl.classList.remove('hidden');
                    
                    // Reset button state
                    loginBtn.disabled = false;
                    loginBtnText.innerHTML = '<i class="fas fa-sign-in-alt mr-2"></i>Sign In';
                    loginSpinner.classList.add('hidden');
                } else {
                    // Success - store token and redirect
                    localStorage.setItem('guide_token', data.token);
                    
                    // Show success state briefly
                    loginBtnText.innerHTML = '<i class="fas fa-check mr-2"></i>Success!';
                    loginBtn.classList.remove('from-amber-500', 'to-yellow-600');
                    loginBtn.classList.add('from-green-500', 'to-green-600');
                    
                    // Redirect after a short delay
                    setTimeout(() => {
                        window.location.href = `/guide/dashboard/${data.user.id}`;
                    }, 1000);
                }
            } catch (err) {
                // Network error
                errorEl.textContent = 'Network error. Please check your connection and try again.';
                errorEl.classList.remove('hidden');
                
                // Reset button state
                loginBtn.disabled = false;
                loginBtnText.innerHTML = '<i class="fas fa-sign-in-alt mr-2"></i>Sign In';
                loginSpinner.classList.add('hidden');
            }
        });

        // Add input formatting for mobile number
        document.getElementById('mobile_number').addEventListener('input', function(e) {
            // Remove any non-digit characters
            let value = e.target.value.replace(/\D/g, '');
            
            // Limit to reasonable phone number length
            if (value.length > 15) {
                value = value.substring(0, 15);
            }
            
            e.target.value = value;
        });

        // Add focus animation to input
        const mobileInput = document.getElementById('mobile_number');
        mobileInput.addEventListener('focus', function() {
            this.parentElement.classList.add('scale-105');
        });
        
        mobileInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('scale-105');
        });
    </script>
    <!-- Footer -->
    <footer class="relative z-10 bg-white/80 backdrop-blur-sm border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-6">
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    &copy; 2025 Engage Lanka, a subsidiary of Softmaster Technologies (Pvt) Ltd. All rights reserved.
                </p>
                <div class="mt-2 flex items-center justify-center gap-4 text-xs text-gray-500">
                    <a href="#" class="hover:text-amber-600 transition-colors">Privacy Policy</a>
                    <span>•</span>
                    <a href="#" class="hover:text-amber-600 transition-colors">Terms of Service</a>
                    <span>•</span>
                    <a href="#" class="hover:text-amber-600 transition-colors">Support</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>