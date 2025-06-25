<!-- filepath: /Applications/XAMPP/xamppfiles/htdocs/ChauffeurGuide_RewardPlatform/resources/views/Admin/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
@include('layouts.header')

<body class="bg-gradient-to-br from-blue-50 via-yellow-50 to-blue-100 min-h-screen flex">
    <!-- Main Content -->
    <main class="flex-1 p-10">
        <div class="flex mt-24 flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div class="flex items-center gap-4">
                <a href="/admin/add-guide" class="flex items-center gap-2 px-4 py-3 bg-black rounded-lg text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4" />
                </svg>
                Add Guide
                </a>
                <a href="/admin/add-item" class="flex items-center gap-2 px-4 py-3 bg-black rounded-lg text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" />
                    </svg>
                    Add Items
                </a>
                <a href="/admin/update/item" class="flex items-center gap-2 px-4 py-3 bg-black rounded-lg text-white transition">
                    Edit Items
                </a>
            </div>
        
            <div class="mt-4 md:mt-0">
                <form id="searchForm" class="flex items-center gap-2">
                    <div class="relative flex-1">
                        <input
                            type="text"
                            id="searchInput"
                            class="w-72 px-5 py-2 pl-12 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 transition text-lg"
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
        <div class="flex flex-wrap gap-8 mt-8">
            <!-- Guide Count Widget -->
            <div class="flex flex-col items-center justify-center">
                <div class="relative w-32 h-32 mb-2">
                    <svg class="w-full h-full" viewBox="0 0 100 100">
                        <circle
                            class="text-blue-100"
                            stroke="currentColor"
                            stroke-width="8"
                            fill="transparent"
                            r="44"
                            cx="50"
                            cy="50"
                        />
                        <circle
                            class="text-blue-500"
                            stroke="currentColor"
                            stroke-width="8"
                            fill="transparent"
                            r="44"
                            cx="50"
                            cy="50"
                            stroke-dasharray="276.46"
                            stroke-dashoffset="{{ 276.46 - (min($guideCount, $guideMax ?? 100) / ($guideMax ?? 100)) * 276.46 }}"
                            stroke-linecap="round"
                            style="transition: stroke-dashoffset 0.6s;"
                        />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-extrabold text-blue-700">{{ $guideCount }}</span>
                        <span class="text-xs text-gray-500">Guides</span>
                    </div>
                </div>
                <span class="text-gray-600 font-semibold">Total Guides</span>
            </div>
            <!-- Visit Count Widget -->
            <div class="flex flex-col items-center justify-center">
                <div class="relative w-32 h-32 mb-2">
                    <svg class="w-full h-full" viewBox="0 0 100 100">
                        <circle class="text-green-100" stroke="currentColor" stroke-width="8" fill="transparent" r="44" cx="50" cy="50"/>
                        <circle class="text-green-500" stroke="currentColor" stroke-width="8" fill="transparent" r="44" cx="50" cy="50"
                            stroke-dasharray="276.46"
                            stroke-dashoffset="{{ 276.46 - ($visitCount/100)*276.46 }}"
                            stroke-linecap="round"
                            style="transition: stroke-dashoffset 0.6s;"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-extrabold text-green-700">{{ $visitCount }}</span>
                        <span class="text-xs text-gray-500">Visits</span>
                    </div>
                </div>
                <span class="text-gray-600 font-semibold">Total Visits</span>
            </div>
            <!-- Monthly Visit Count Widget -->
            <div class="flex flex-col items-center justify-center">
                <div class="relative w-32 h-32 mb-2">
                    <svg class="w-full h-full" viewBox="0 0 100 100">
                        <circle class="text-purple-100" stroke="currentColor" stroke-width="8" fill="transparent" r="44" cx="50" cy="50"/>
                        <circle class="text-purple-500" stroke="currentColor" stroke-width="8" fill="transparent" r="44" cx="50" cy="50"
                            stroke-dasharray="276.46"
                            stroke-dashoffset="{{ 276.46 - ($monthlyVisitCount/100)*276.46 }}"
                            stroke-linecap="round"
                            style="transition: stroke-dashoffset 0.6s;"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-extrabold text-purple-700">{{ $monthlyVisitCount }}</span>
                        <span class="text-xs text-gray-500">This Month</span>
                    </div>
                </div>
                <span class="text-gray-600 font-semibold">Monthly Visits</span>
            </div>
        </div>

        <!-- Search Status -->
        <div id="searchStatus" class="text-center mb-4"></div>
        <!-- User Cards -->
        <div id="searchResults" class="grid grid-cols-1 md:grid-cols-2 gap-6"></div>

        <!-- Guide Table Dashboard Widget -->
        <div class="overflow-x-auto rounded-2xl shadow-lg bg-white/90 mt-10">
            <table class="min-w-full divide-y divide-blue-100">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xl font-bold text-blue-700 uppercase tracking-wider">Profile</th>
                        <th class="px-6 py-4 text-left text-xl font-bold text-blue-700 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-left text-xl font-bold text-blue-700 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-center text-xl font-bold text-blue-700 uppercase tracking-wider">Visits</th>
                        <th class="px-6 py-4 text-center text-xl font-bold text-blue-700 uppercase tracking-wider">Points</th>
                        <!-- <th class="px-6 py-4 text-center text-xl font-bold text-blue-700 uppercase tracking-wider">Pax count</th> -->
                        <th class="px-6 py-4 text-center text-xl font-bold text-blue-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-blue-50">
                    @foreach($guides as $guide)
                        <tr>
                            <td class="px-6 py-4">
                                @if($guide->profile_photo)
                                    <img src="{{ asset('storage/' . $guide->profile_photo) }}" alt="Profile" class="w-12 h-12 rounded-full object-cover border-2 border-blue-200 shadow">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-xl">?</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-semibold text-blue-900">{{ $guide->full_name }}</td>
                            <td id="guide-row-{{ $guide->id }}" class="px-6 py-4 font-mono text-gray-700">{{ $guide->id }}</td>
                            <td class="px-6 py-4 text-center text-blue-700 font-bold">
                                {{ $guide->visits_count ?? 0 }}
                            </td>
                            <td class="px-6 py-4 text-center text-yellow-500 font-bold">
                                {{ $guide->redemptions->sum('points') ?? 0 }}
                            </td>
                            
                            <td class="px-6 py-4 flex gap-2 justify-center items-center">
                                <input type="number" min="1" value="1"
                                    class="w-20 px-2 py-1 border border-blue-200 rounded focus:ring-2 focus:ring-blue-400"
                                    id="visit_count_{{ $guide->id }}"
                                    placeholder="Count">
                                <button
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg font-semibold shadow transition"
                                    onclick="addVisit({{ $guide->id }})"
                                    type="button"
                                >
                                    Add Visit for Today
                                </button>
                                <a href="{{ url('/admin/guide/' . $guide->id . '/update') }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg font-semibold shadow transition ml-2">
                                    View Profile
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
    <script>
        if (!localStorage.getItem('admin_token')) {
            window.location.href = '/guide/login'; // Change '/login' to your actual login route if different
        }
    </script>
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
                console.log("shwing all guides..");
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
                <div class="bg-white/90 rounded-2xl shadow-lg p-6 flex flex-col gap-3 hover:shadow-2xl transition border border-blue-100">
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
                    <div class="flex items-center justify-between">
                        <button
                            class="mt-3 bg-blue-600 hover:bg-blue-700 text-white font-bold px-3 py-2 rounded-lg transition"
                            onclick="window.location.href='/admin/guide/${guide.id}/update'">
                            View Profile
                        </button>
                        <button
                            onclick="scrollToGuide(${guide.id})"
                            class="mt-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-3 py-2 rounded-lg transition">
                            Show in Table
                        </button>
                    </div>
                </div>
            `).join('');
            } catch (err) {
                console.log(err);
            }
        }

        function addVisit(guideId) {
            const countInput = document.getElementById('visit_count_' + guideId);
            const count = parseInt(countInput.value) || 1;
            const token = localStorage.getItem('admin_token');
            // Always send today's date in YYYY-MM-DD format
            const today = new Date().toISOString().slice(0, 10);

            fetch('/api/admin/visits', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    guide_id: guideId,
                    pax_count: count,
                    visit_date: today // Always today's date
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success || data.status === 'success') {
                    alert('Visit(s) added for today!');
                } else {
                    alert(data.message || 'Failed to add visit.');
                }
            })
            .catch(() => alert('Network error.'));
        }
        function scrollToGuide(guideId) {
            const row = document.getElementById('guide-row-' + guideId);
            if (row) {
                row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                row.classList.add('ring', 'ring-4', 'ring-yellow-400', 'transition');
                setTimeout(() => row.classList.remove('ring', 'ring-4', 'ring-yellow-400'), 1500);
            } else {
                alert('Guide not found in table.');
            }
        }
    </script>
</body>

</html>