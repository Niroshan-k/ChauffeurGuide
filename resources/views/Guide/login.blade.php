<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guide Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">Guide Login</h2>
        <form id="loginForm" class="space-y-4">
            <div>
                <label for="mobile_number" class="block text-gray-700">Mobile Number</label>
                <input type="text" id="mobile_number" name="mobile_number" class="w-full px-3 py-2 border rounded" required>
            </div>
            <div id="error" class="text-red-500 text-sm"></div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Login</button>
        </form>
    </div>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            document.getElementById('error').textContent = '';
            const mobile_number = document.getElementById('mobile_number').value;
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
                    document.getElementById('error').textContent = data.message || 'Login failed';
                } else {
                    // Store the token in localStorage
                    localStorage.setItem('guide_token', data.token);
                    window.location.href = '/guide/dashboard';
                }
            } catch (err) {
                document.getElementById('error').textContent = 'Network error';
            }
        });
    </script>
</body>
</html>