<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Guide</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-lg mx-auto mt-12 bg-white/90 rounded-3xl shadow-2xl p-8">
        <h2 class="text-2xl font-bold text-blue-700 mb-6 text-center">Add New Guide</h2>
        <form id="profileForm" class="space-y-5" enctype="multipart/form-data" method="POST">
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Full Name</label>
                <input type="text" name="full_name" class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 transition" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 transition" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Mobile Number</label>
                <input type="text" name="mobile_number" class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 transition" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">WhatsApp Number</label>
                <input type="text" name="whatsapp_number" class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 transition">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Date of Birth</label>
                <input type="date" name="date_of_birth" class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 transition">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Profile Photo</label>
                <input type="file" name="profile_photo" accept="image/*" class="w-full" required>
            </div>
            <div id="addGuideStatus" class="text-center text-sm"></div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition flex items-center justify-center gap-2">
                <span id="addGuideBtnText">Add Guide</span>
                <svg id="addGuideSpinner" class="hidden animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
            </button>
        </form>
    </div>
    <script>
        const addGuideForm = document.getElementById('profileForm');
        const addGuideStatus = document.getElementById('addGuideStatus');
        const addGuideBtnText = document.getElementById('addGuideBtnText');
        const addGuideSpinner = document.getElementById('addGuideSpinner');
        const token = localStorage.getItem('admin_token');

        addGuideForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            addGuideStatus.textContent = '';
            addGuideBtnText.textContent = 'Adding...';
            addGuideSpinner.classList.remove('hidden');

            const formData = new FormData(addGuideForm);

            try {
                const response = await fetch('/api/admin/guides', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const result = await response.json();
                addGuideBtnText.textContent = 'Add Guide';
                addGuideSpinner.classList.add('hidden');
                if (!response.ok) {
                    addGuideStatus.innerHTML = `<span class="text-red-600">${result.message || 'Failed to add guide.'}</span>`;
                    return;
                }
                addGuideStatus.innerHTML = `<span class="text-green-600 font-semibold">Guide added successfully! Redirecting...</span>`;
                setTimeout(() => {
                    window.location.href = '/admin/dashboard';
                }, 1200);
            } catch (err) {
                addGuideBtnText.textContent = 'Add Guide';
                addGuideSpinner.classList.add('hidden');
                addGuideStatus.innerHTML = `<span class="text-red-600">Network error.</span>`;
            }
        });
    </script>
</body>
</html>