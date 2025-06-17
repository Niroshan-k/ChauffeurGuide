<!-- filepath: /Applications/XAMPP/xamppfiles/htdocs/ChauffeurGuide_RewardPlatform/resources/views/Admin/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Guide Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-50 via-yellow-50 to-blue-100 min-h-screen flex">
    <!-- Main Content -->
    <main class="flex-1 p-10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-blue-700 mb-2">Welcome, Admin!</h1>
                <p class="text-gray-600">Manage guides, view details, and search for users below.</p>
            </div>

            <div class="mt-4 md:mt-0">
                <form id="searchForm" class="flex items-center gap-2">
                    <div class="relative flex-1">
                        <input
                            type="text"
                            id="searchInput"
                            class="w-72 px-5 py-3 pl-12 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 transition text-lg"
                            placeholder="Search by name or ID..."
                            autocomplete="off">
                        <svg class="w-6 h-6 absolute left-3 top-1/2 transform -translate-y-1/2 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <path d="M21 21l-4.35-4.35" />
                        </svg>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-xl transition">
                        Search
                    </button>
                </form>
            </div>
        </div>
        <a href="/admin/add-guide" class="flex items-center gap-2 px-4 py-2 rounded-lg text-gray-600 hover:bg-blue-50 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4" />
            </svg>
            Add Guide
        </a>
        <!-- Search Status -->
        <div id="searchStatus" class="text-center mb-4"></div>
        <!-- User Cards -->
        <div id="searchResults" class="grid grid-cols-1 md:grid-cols-2 gap-6"></div>
    </main>
    <script>
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const searchStatus = document.getElementById('searchStatus');
        const token = localStorage.getItem('admin_token');

        // Optionally, load all guides on page load
        window.addEventListener('DOMContentLoaded', () => {
            searchGuides('');
        });

        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            searchGuides(searchInput.value.trim());
        });

        async function searchGuides(query) {
            searchResults.innerHTML = '';
            searchStatus.innerHTML = '';
            if (!query) {
                searchStatus.innerHTML = '<span class="text-gray-500">Showing all guides.</span>';
            } else {
                searchStatus.innerHTML = `
                    <span class="flex items-center justify-center gap-2 text-blue-500">
                        <svg class="animate-spin h-5 w-5 text-blue-500" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                        Searching...
                    </span>
                `;
            }
            try {
                const url = query ?
                    '/api/admin/guide/search?q=' + encodeURIComponent(query) :
                    '/api/admin/guides';
                const response = await fetch(url, {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                searchStatus.innerHTML = '';
                if (!response.ok) {
                    searchStatus.innerHTML = `<span class="text-red-500">${data.message || 'Search failed.'}</span>`;
                    return;
                }
                if (!data.guides || data.guides.length === 0) {
                    searchStatus.innerHTML = `<span class="text-yellow-600 font-semibold">No guides found.</span>`;
                    return;
                }
                // Render user cards
                searchResults.innerHTML = data.guides.map(guide => `
                    <div class="bg-white/90 rounded-2xl shadow-lg p-6 flex flex-col gap-3 hover:shadow-2xl transition cursor-pointer border border-blue-100"
                         onclick="window.location.href='/admin/guide/${guide.id}/update'">
                        <div class="flex items-center gap-4 mb-2">
                            ${guide.profile_photo
                                ? `<img src="/storage/${guide.profile_photo}" alt="Profile" class="w-16 h-16 rounded-full object-cover border-2 border-blue-300">`
                                : `<div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-2xl">?</div>`
                            }
                            <div>
                                <div class="text-xl font-bold text-blue-800">${guide.full_name}</div>
                                <div class="text-gray-600 text-sm">ID: <span class="font-mono">${guide.id}</span></div>
                                <div class="text-gray-500 text-xs">${guide.email || ''}</div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1 text-gray-700 text-sm">
                            <div><span class="font-semibold">Mobile:</span> ${guide.mobile_number || '-'}</div>
                            <div><span class="font-semibold">WhatsApp:</span> ${guide.whatsapp_number || '-'}</div>
                        </div>
                        <button class="mt-3 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition">View Profile</button>
                    </div>
                `).join('');
            } catch (err) {
                searchStatus.innerHTML = `<span class="text-red-500">Network error.</span>`;
            }
        }
    </script>
</body>

</html>