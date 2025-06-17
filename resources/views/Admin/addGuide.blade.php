<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Guide</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-lg bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-blue-700 text-center">Add Guide</h2>
        <form id="addGuideForm" class="space-y-4" enctype="multipart/form-data">
            <div>
                <label class="block text-gray-700">Full Name</label>
                <input type="text" name="full_name" class="w-full px-3 py-2 border rounded" required>
            </div>
            <div>
                <label class="block text-gray-700">Mobile Number</label>
                <input type="text" name="mobile_number" class="w-full px-3 py-2 border rounded" required>
            </div>
            <div>
                <label class="block text-gray-700">Date of Birth</label>
                <input type="date" name="date_of_birth" class="w-full px-3 py-2 border rounded">
            </div>
            <div>
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" class="w-full px-3 py-2 border rounded">
            </div>
            <div>
                <label class="block text-gray-700">WhatsApp Number</label>
                <input type="text" name="whatsapp_number" class="w-full px-3 py-2 border rounded">
            </div>
            <div>
                <label class="block text-gray-700">Profile Photo</label>
                <input type="file" name="profile_photo" accept="image/*" class="w-full">
            </div>
            <div id="error" class="text-red-500 text-sm"></div>
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Add Guide</button>
        </form>
    </div>
    <script>

        document.getElementById('addGuideForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            document.getElementById('error').textContent = '';
            const form = e.target;
            const formData = new FormData(form);

            // Get the admin token from localStorage
            const token = localStorage.getItem('admin_token');
            if (!token) {
                document.getElementById('error').textContent = 'You must be logged in as admin.';
                return;
            }

            try {
                const response = await fetch('/api/admin/guides', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const data = await response.json();
                if (!response.ok) {
                    document.getElementById('error').textContent = data.message || 'Failed to add guide';
                } else {
                    alert('Guide added successfully!');
                    form.reset();
                }
            } catch (err) {
                document.getElementById('error').textContent = 'Network error';
            }
        });
    </script>
</body>
</html>