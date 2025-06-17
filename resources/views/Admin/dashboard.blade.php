<!-- filepath: /Applications/XAMPP/xamppfiles/htdocs/ChauffeurGuide_RewardPlatform/resources/views/Admin/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Guides</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <header class="flex items-center justify-between px-8 py-6 bg-white shadow">
        <button onclick="window.location.href='/admin/add-guide'" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Add Guide
        </button>
    </header>
    <main class="px-8 py-6">
        <div class="max-w-3xl mx-auto mt-8 mb-4">
            <form id="searchForm" class="flex gap-2">
                <input type="text" id="searchInput" class="flex-1 px-4 py-2 border-2 border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition" placeholder="Search guides by name or ID...">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">Search</button>
            </form>
            <div id="searchResults" class="mt-4"></div>
        </div>
        <h2 class="text-2xl font-bold mb-6 text-blue-700">All Guides</h2>
        <div id="guidesList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>
        <div id="error" class="text-red-500 mt-4"></div>
    </main>
    <script>
        const token = localStorage.getItem('admin_token');
        const guidesList = document.getElementById('guidesList');
        const errorDiv = document.getElementById('error');
        let allGuides = [];

        async function fetchGuides() {
            if (!token) {
                errorDiv.textContent = 'You must be logged in as admin.';
                return;
            }
            try {
                const response = await fetch('/api/admin/guides', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (!response.ok) {
                    errorDiv.textContent = data.message || 'Failed to fetch guides.';
                    return;
                }
                allGuides = data.guides;
                renderGuides(allGuides);
            } catch (err) {
                errorDiv.textContent = 'Network error';
            }
        }

        function renderGuides(guides) {
            guidesList.innerHTML = '';
            if (!guides.length) {
                guidesList.innerHTML = '<div class="col-span-full text-center text-gray-500">No guides found.</div>';
                return;
            }
            guides.forEach(guide => {
                guidesList.innerHTML += `
                    <div class="bg-white rounded-lg shadow p-6 flex items-center space-x-4 cursor-pointer hover:bg-blue-50 transition"
                         onclick="window.location.href='/admin/guide/${guide.id}/update'">
                        <div>
                            ${guide.profile_photo 
                                ? `<img src="/storage/${guide.profile_photo}" alt="Profile" class="w-16 h-16 rounded-full object-cover">`
                                : `<div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-2xl">?</div>`
                            }
                        </div>
                        <div>
                            <div class="font-bold text-lg">${guide.full_name}</div>
                            <div class="text-gray-600">ID: ${guide.id}</div>
                            <div class="text-gray-500 text-sm">${guide.email || ''}</div>
                        </div>
                    </div>
                `;
            });
        }

        document.getElementById('searchForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const query = document.getElementById('searchInput').value.trim();
            const token = localStorage.getItem('admin_token');
            const resultsDiv = document.getElementById('searchResults');
            resultsDiv.innerHTML = '';

            if (!query) {
                resultsDiv.innerHTML = '<div class="text-gray-500">Please enter a name or ID to search.</div>';
                return;
            }

            try {
                const response = await fetch(`/api/admin/guides/search?q=${encodeURIComponent(query)}`, {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (!response.ok || !data.guides.length) {
                    resultsDiv.innerHTML = '<div class="text-red-500">No guides found.</div>';
                    return;
                }
                // Show results
                resultsDiv.innerHTML = data.guides.map(guide => `
                    <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4 mb-2 cursor-pointer hover:bg-blue-50 transition"
                         onclick="window.location.href='/admin/guides/${guide.id}/edit'">
                        ${guide.profile_photo
                            ? `<img src="/storage/${guide.profile_photo}" alt="Profile" class="w-12 h-12 rounded-full object-cover">`
                            : `<div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-xl">?</div>`
                        }
                        <div>
                            <div class="font-bold">${guide.full_name}</div>
                            <div class="text-gray-600 text-sm">ID: ${guide.id}</div>
                            <div class="text-gray-500 text-xs">${guide.email || ''}</div>
                        </div>
                    </div>
                `).join('');
            } catch (err) {
                resultsDiv.innerHTML = '<div class="text-red-500">Network error.</div>';
            }
        });

        fetchGuides();
    </script>
</body>
</html>