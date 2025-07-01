<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css'])
    <script defer>
        const token = localStorage.getItem('admin_token');
        if (!token) window.location.href = '/guide/login';
    </script>
</head>

<body class="flex bg-gray-100 min-h-screen">
    <!-- Sidebar -->
    <aside class="w-72 bg-white shadow-lg flex flex-col justify-between fixed h-full">
        <div class="p-6 flex flex-col items-center">
            <img src="{{ asset('storage/appImages/logo.png') }}" alt="Logo" class="w-20 mb-4">
            <nav class="flex mt-10 flex-col w-full gap-3">
                <button onclick="showSection('dashboard')" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg">Dashboard</button>
                <button onclick="showSection('guides')" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg">Guides</button>
                <button onclick="showSection('items')" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg">Items</button>
            </nav>
        </div>
        <div class="p-6">
         <div class="flex gap-2">
            <button class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg mt-4">Profile</button>
            <button onclick="logout()" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg mt-4">Logout</button>
         </div>
            <p class=" mt-3 text-[8px] text-center">&copy; 2025 Engage Lanka, a subsidiary of Softmaster Technologies (Pvt) Ltd. All rights reserved.</p>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 ml-64 p-10">
        <!-- Dashboard Section -->
        <section id="dashboardSection" class="px-5">
            <h1 class="text-2xl font-bold">Statistic</h1>
            <div class="bg-white mt-5 flex justify-center py-5 rounded-lg shadow">
            <div class="flex flex-wrap gap-8">
            <!-- Guide Count Widget -->
            <div class="flex flex-col items-center justify-center">
                <div class="relative w-32 h-32 mb-2">
                    <svg class="w-full h-full" viewBox="0 0 100 100">
                        <circle
                            class="text-blue-300"
                            stroke="currentColor"
                            stroke-width="8"
                            fill="transparent"
                            r="44"
                            cx="50"
                            cy="50"
                        />
                        <circle
                            class="text-blue-600"
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

            <div class="flex flex-col items-center justify-center">
                 <div class="relative w-32 h-32 mb-2">
                     <svg class="w-full h-full" viewBox="0 0 100 100">
                         <circle class="text-cyan-300 " stroke="currentColor" stroke-width="8" fill="transparent" r="44" cx="50" cy="50"/>
                         <circle class="text-cyan-600" stroke="currentColor" stroke-width="8" fill="transparent" r="44" cx="50" cy="50"
                             stroke-dasharray="276.46"
                             stroke-dashoffset="{{ 276.46 - ($monthlyNewGuides/$guideMax)*276.46 }}"
                             stroke-linecap="round"
                             style="transition: stroke-dashoffset 0.6s;"/>
                     </svg>
                     <div class="absolute inset-0 flex flex-col items-center justify-center">
                         <span class="text-3xl font-extrabold text-blue-700">{{ $monthlyNewGuides }}</span>
                         <span class="text-xs text-gray-500">This Month</span>
                     </div>
                 </div>
                 <span class="text-gray-600 font-semibold">New Guides</span>
             </div>
            
            <!-- Visit Count Widget -->
            <div class="flex flex-col items-center justify-center">
                <div class="relative w-32 h-32 mb-2">
                    <svg class="w-full h-full" viewBox="0 0 100 100">
                        <circle class="text-green-300" stroke="currentColor" stroke-width="8" fill="transparent" r="44" cx="50" cy="50"/>
                        <circle class="text-green-600" stroke="currentColor" stroke-width="8" fill="transparent" r="44" cx="50" cy="50"
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
                        <circle class="text-purple-300" stroke="currentColor" stroke-width="8" fill="transparent" r="44" cx="50" cy="50"/>
                        <circle class="text-purple-600" stroke="currentColor" stroke-width="8" fill="transparent" r="44" cx="50" cy="50"
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

            <!-- Total Tourist Count Widget -->
            <div class="flex flex-col items-center justify-center">
                <div class="relative w-32 h-32 mb-2">
                    <svg class="w-full h-full" viewBox="0 0 100 100">
                        <circle class="text-yellow-300" stroke="currentColor" stroke-width="8" fill="transparent" r="44" cx="50" cy="50"/>
                        <circle class="text-yellow-600" stroke="currentColor" stroke-width="8" fill="transparent" r="44" cx="50" cy="50"
                            stroke-dasharray="276.46"
                            stroke-dashoffset="{{ 276.46 - ($touristCount/1000)*276.46 }}"
                            stroke-linecap="round"
                            style="transition: stroke-dashoffset 0.6s;"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-extrabold text-yellow-700">{{ $touristCount }}</span>
                        <span class="text-xs text-gray-500">Tourists</span>
                    </div>
                </div>
                <span class="text-gray-600 font-semibold">Total Tourists</span>
            </div>

            <!-- Monthly Tourist Count Widget -->
            <div class="flex flex-col items-center justify-center">
                <div class="relative w-32 h-32 mb-2">
                    <svg class="w-full h-full" viewBox="0 0 100 100">
                        <circle class="text-orange-300" stroke="currentColor" stroke-width="8" fill="transparent" r="44" cx="50" cy="50"/>
                        <circle class="text-orange-600" stroke="currentColor" stroke-width="8" fill="transparent" r="44" cx="50" cy="50"
                            stroke-dasharray="276.46"
                            stroke-dashoffset="{{ 276.46 - ($monthlyTouristCount/100)*276.46 }}"
                            stroke-linecap="round"
                            style="transition: stroke-dashoffset 0.6s;"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-extrabold text-orange-700">{{ $monthlyTouristCount }}</span>
                        <span class="text-xs text-gray-500">This Month</span>
                    </div>
                </div>
                <span class="text-gray-600 font-semibold">Monthly Tourists</span>
            </div>
        </div>
        </div>

        <h1 class="text-2xl mt-10 font-bold text-gray-800">Top Guides</h1>
        <div class="mt-5 bg-white rounded-lg shadow p-6">
            <div class="space-y-4">
                @foreach($topGuides as $index => $guide)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full {{ $index === 0 ? 'bg-yellow-400' : ($index === 1 ? 'bg-gray-300' : ($index === 2 ? 'bg-yellow-600' : 'bg-gray-200')) }}">
                                @if($guide->profile_photo)
                                    <img src="{{ asset('storage/' . $guide->profile_photo) }}" 
                                         alt="{{ $guide->full_name }}" 
                                         class="w-full h-full rounded-full object-cover">
                                @else
                                    <span class="text-white font-bold">{{ $index + 1 }}</span>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $guide->full_name }}</h3>
                                <p class="text-sm text-gray-500">Total Tourists: {{ $guide->total_pax }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-sm font-medium text-green-600">
                                {{ number_format(($guide->total_pax / $touristCount) * 100, 1) }}% of total
                            </div>
                            <a href="/admin/guide/{{ $guide->id }}/update" 
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                View Profile
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mt-10">Tourist Visits - Last 12 Months</h2>
        <div class="mt-5 bg-white rounded-lg shadow-lg p-6">
            <div class="relative w-full" style="height: 400px;">
                <canvas id="touristChart"></canvas>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mt-10">New Guides - Last 12 Months</h2>
        <div class="mt-5 bg-white rounded-lg shadow-lg p-6">
            <div class="relative w-full" style="height: 400px;">
                <canvas id="guideChart"></canvas>
            </div>
        </div>

        <div class="mt-10 bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Generate Monthly Report</h2>
            <div class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Month and Year</label>
                    <input 
                        type="month" 
                        id="reportDate" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                        value="{{ date('Y-m') }}"
                    >
                </div>
                <div class="flex gap-2">
                    <button 
                        onclick="generatePDFReport()"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 flex items-center gap-2"
                    >
                        <i class="fas fa-file-pdf"></i>
                        PDF Report
                    </button>
                    <button 
                        onclick="generateExcelReport()"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center gap-2"
                    >
                        <i class="fas fa-file-excel"></i>
                        Excel Report
                    </button>
                </div>
            </div>
        </div>
        </section>

        <!-- Guides Section -->
        <section id="guidesSection" class="hidden">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="/admin/add-guide" class="px-4 py-2 bg-black text-white rounded-lg">Add Guide</a>
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
            <div id="searchStatus"></div>
            <div id="searchResults" class=""></div>
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
                                <span>Tourist Count:</span>
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
        </section>

        <!-- Items Section -->
        <section id="itemsSection" class="hidden">
            <div class="flex gap-4">
                <a href="/admin/add-item" class="px-4 py-2 bg-black text-white rounded-lg">Add Items</a>
                <a href="/admin/update/item" class="px-4 py-2 bg-black text-white rounded-lg">Edit Items</a>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

     if (!localStorage.getItem('admin_token')) {
        window.location.href = '/';
     }
     
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('touristChart');
        const monthlyData = @json($monthlyData ?? []);
        
        if (!ctx || !monthlyData?.length) {
            console.error('Chart initialization failed');
            return;
        }

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthlyData.map(data => data.month),
                datasets: [{
                    label: 'Tourist Count',
                    data: monthlyData.map(data => data.tourist_count),
                    backgroundColor: 'rgba(52, 211, 153, 0.5)',
                    borderColor: 'rgb(52, 211, 153)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Monthly Tourist Visits'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Tourists'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                }
            }
        });
    });
    </script>

    <script>
    // Add this after your tourist chart script
    document.addEventListener('DOMContentLoaded', function() {
        const guideCtx = document.getElementById('guideChart');
        const monthlyGuideData = @json($monthlyGuideData ?? []);
        
        if (!guideCtx || !monthlyGuideData?.length) {
            console.error('Guide chart initialization failed');
            return;
        }

        new Chart(guideCtx, {
            type: 'line',
            data: {
                labels: monthlyGuideData.map(data => data.month),
                datasets: [{
                    label: 'New Guides',
                    data: monthlyGuideData.map(data => data.guide_count),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Monthly New Guide Registrations'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of New Guides'
                        }
                    }
                }
            }
        });
    });
    </script>

    <script>
        function logout() {
                    localStorage.removeItem('admin_token');
                    window.location.href = '/admin/login'; // or your login route
                }
        function goToProfile() {
         window.location.href = '/admin/profile;'
        }

        function showSection(id) {
            document.getElementById('dashboardSection').style.display = id === 'dashboard' ? 'grid' : 'none';
            document.getElementById('guidesSection').style.display = id === 'guides' ? 'block' : 'none';
            document.getElementById('itemsSection').style.display = id === 'items' ? 'block' : 'none';
        }

        // Default section on load
        window.addEventListener('DOMContentLoaded', () => {
            showSection('dashboard');
            refreshDashboard();
        });

        async function refreshDashboard() {
            try {
                const res = await fetch('/api/admin/dashboard-stats', {
                    headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
                });
                const data = await res.json();
                document.getElementById('guideCount').textContent = data.guideCount;
                document.getElementById('visitCount').textContent = data.visitCount;
                document.getElementById('monthlyVisitCount').textContent = data.monthlyVisitCount;
            } catch (e) {
                console.error('Error loading stats', e);
            }
        }

        // Search Functionality
        document.getElementById('searchForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const q = document.getElementById('searchInput').value;
        const status = document.getElementById('searchStatus');
        const results = document.getElementById('searchResults');
        status.innerHTML = 'Searching...';
        results.innerHTML = '';
        
        try {
            const res = await fetch(`/api/admin/guide/search?q=${encodeURIComponent(q)}`, {
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });
            const data = await res.json();
            status.innerHTML = '';
            
            // Add close button container
            results.innerHTML = `
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-blue-800">Search Results</h3>
                    <button 
                        onclick="closeSearchResults()"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-full p-2 transition-colors duration-200"
                        title="Close Results">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    ${!data.guides || !data.guides.length 
                        ? '<div class="col-span-2 text-center text-yellow-600 font-semibold">No guides found.</div>'
                        : data.guides.map(guide => `
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
                        `).join('')}
                </div>`;
        } catch (err) {
            status.innerHTML = '<span class="text-red-500">Search failed.</span>';
        }
    });

        function closeSearchResults() {
            const results = document.getElementById('searchResults');
            const status = document.getElementById('searchStatus');
            const searchInput = document.getElementById('searchInput');
            
            results.innerHTML = '';
            status.innerHTML = '';
            searchInput.value = '';
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

        // Add to your existing script section
        async function generatePDFReport() {
            const date = document.getElementById('reportDate').value;
            if (!date) {
                alert('Please select a month and year');
                return;
            }

            try {
                const response = await fetch(`/api/admin/report/pdf?date=${date}`, {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    const blob = await response.blob();
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `report-${date}.pdf`;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    a.remove();
                } else {
                    throw new Error('Failed to generate PDF');
                }
            } catch (error) {
                alert('Failed to generate PDF report');
                console.error(error);
            }
        }

        async function generateExcelReport() {
            const date = document.getElementById('reportDate').value;
            if (!date) {
                alert('Please select a month and year');
                return;
            }

            try {
                const response = await fetch(`/api/admin/report/excel?date=${date}`, {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    }
                });

                if (response.ok) {
                    const blob = await response.blob();
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `report-${date}.xlsx`;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    a.remove();
                } else {
                    throw new Error('Failed to generate Excel file');
                }
            } catch (error) {
                alert('Failed to generate Excel report');
                console.error(error);
            }
        }

         // Function to refresh dashboard data
        async function refreshDashboard() {
        try {
            // Get updated stats
            const response = await fetch('/api/admin/dashboard-stats', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            
            // Update stat widgets
            document.querySelector('.text-blue-700').textContent = data.guideCount;
            document.querySelector('.text-green-700').textContent = data.visitCount;
            document.querySelector('.text-purple-700').textContent = data.monthlyVisitCount;

            // Refresh guide table
            const guidesResponse = await fetch('/api/admin/guides', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            const guidesData = await guidesResponse.json();
            
            // Update table body
            const tableBody = document.querySelector('tbody');
            if (tableBody && guidesData.guides) {
                tableBody.innerHTML = guidesData.guides.map(guide => `
                    <tr>
                        <td class="px-6 py-4">
                            ${guide.profile_photo 
                                ? `<img src="/storage/${guide.profile_photo}" alt="Profile" class="w-12 h-12 rounded-full object-cover border-2 border-blue-200 shadow">`
                                : `<div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-xl">?</div>`
                            }
                        </td>
                        <td class="px-6 py-4 font-semibold text-blue-900">${guide.full_name}</td>
                        <td id="guide-row-${guide.id}" class="px-6 py-4 font-mono text-gray-700">${guide.id}</td>
                        <td class="px-6 py-4 text-center text-blue-700 font-bold">${guide.visits_count || 0}</td>
                        <td class="px-6 py-4 text-center text-yellow-500 font-bold">${guide.redemptions_sum_points || 0}</td>
                        <td class="px-6 py-4 flex gap-2 justify-center items-center">
                            <span>Tourist Count:</span>
                            <input type="number" min="1" value="1"
                                class="w-20 px-2 py-1 border border-blue-200 rounded focus:ring-2 focus:ring-blue-400"
                                id="visit_count_${guide.id}"
                                placeholder="Count">
                            <button
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg font-semibold shadow transition"
                                onclick="addVisit(${guide.id})"
                                type="button">
                                Add Visit for Today
                            </button>
                            <a href="/admin/guide/${guide.id}/update"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg font-semibold shadow transition ml-2">
                                View Profile
                            </a>
                        </td>
                    </tr>
                `).join('');
            }
            
        } catch (error) {
            console.error('Error refreshing dashboard:', error);
        }
    }

        // Refresh every 30 seconds
        setInterval(refreshDashboard, 5000);

        // Also refresh after adding visits
        function addVisit(guideId) {
            const countInput = document.getElementById('visit_count_' + guideId);
            const count = parseInt(countInput.value) || 1;
            const token = localStorage.getItem('admin_token');
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
                    visit_date: today
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success || data.status === 'success') {
                    alert('Visit(s) added for today!');
                    refreshDashboard(); // Refresh after successful addition
                } else {
                    alert(data.message || 'Failed to add visit.');
                }
            })
            .catch(() => alert('Network error.'));
        }
    </script>
</body>

</html>
