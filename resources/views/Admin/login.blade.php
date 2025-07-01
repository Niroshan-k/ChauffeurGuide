<!-- filepath: /Applications/XAMPP/xamppfiles/htdocs/ChauffeurGuide_RewardPlatform/resources/views/Admin/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css'])
</head>
<main class="min-h-screen flex items-center justify-center">
    <a href="/" class="fixed left-5 top-5 flex bg-black text-white text-2xl rounded-full items-center gap-3 px-3 py-2">
            <i class="fa-solid fa-angle-left"></i>
            <p>Back</p>
    </a>
    
    <div class="w-full max-w-md p-8">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Admin Login</h2>
        <form id="loginForm" class="space-y-5">
            <div>
                <label class="block text-gray-700 mb-1" for="email">Email:</label>
                <input type="email" id="email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div>
                <label class="block text-gray-700 mb-1" for="password">Password:</label>
                <input type="password" id="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded transition duration-150">
                Login
            </button>
        </form>
        <div id="error" class="text-red-600 mt-4 text-center"></div>
    </div>
    <script>
        // if (localStorage.getItem('admin_token')) {
        //     window.location.href = '/admin/dashboard';
        // }

        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            document.getElementById('error').textContent = '';
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
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
                    document.getElementById('error').textContent = data.message || 'Login failed';
                } else {
                    // Store the token in localStorage
                    localStorage.setItem('admin_token', data.token);
                    window.location.href = '/admin/dashboard'; 
                }
            } catch (err) {
                document.getElementById('error').textContent = 'Network error';
            }
        });
    </script>
</main>
<footer>
    <div class="mt-8 pb-8 text-center text-gray-600">
        &copy; 2025 Engage Lanka, a subsidiary of Softmaster Technologies (Pvt) Ltd. All rights reserved.
    </div>
</footer>
</html>