<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer>
        const token = localStorage.getItem('admin_token');
        if (!token) window.location.href = '/guide/login';
    </script>
    <style>
        .nav-item.active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .nav-item.active .w-10 {
            background: rgba(255, 255, 255, 0.2);
        }

        .nav-item.active i {
            color: white;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Floating animation for stat cards */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        /* Gradient text effect */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body class="flex bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    <!-- Hamburger Button -->
    <button id="hamburger" class="fixed top-4 left-4 z-50 md:hidden bg-gradient-to-r from-blue-600 to-blue-700 text-white p-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Sidebar with toggle functionality -->
    <aside id="sidebar" class="w-72 bg-white/95 backdrop-blur-lg shadow-2xl flex flex-col justify-between fixed h-full transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-40 border-r border-blue-100">
        <!-- Close button for mobile -->
        <button id="closeSidebar" class="absolute top-4 right-4 md:hidden text-gray-500 hover:text-gray-700 transition-colors duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="p-6 flex flex-col border-b border-blue-100">
            <!-- Logo -->
            <div class="mb-2">
                <img src="/storage/appImages/logo.png" alt="Logo" class="w-40 h-auto">
                <h1 class="text-sm mt-2 text-gray-600"><i class="fas fa-user-shield mr-2"></i>Admin Panel</h1>
            </div>

        </div>

        <div class="flex-1 p-6">
            <nav class="space-y-2">
                <button onclick="showSection('dashboard')" class="nav-item active flex items-center w-full px-4 py-3 text-left rounded-xl transition-all duration-200 hover:bg-blue-50 hover:shadow-sm">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fa-solid fa-chart-simple text-blue-600"></i>
                    </div>
                    <span class="font-medium text-gray-700">Dashboard</span>
                </button>
                <button onclick="showSection('guides')" class="nav-item flex items-center w-full px-4 py-3 text-left rounded-xl transition-all duration-200 hover:bg-blue-50 hover:shadow-sm">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fa-solid fa-user-tie text-green-600"></i>
                    </div>
                    <span class="font-medium text-gray-700">Guides</span>
                </button>
                <button onclick="showSection('items')" class="nav-item flex items-center w-full px-4 py-3 text-left rounded-xl transition-all duration-200 hover:bg-blue-50 hover:shadow-sm">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fa-solid fa-gifts text-purple-600"></i>
                    </div>
                    <span class="font-medium text-gray-700">Items</span>
                </button>
            </nav>
        </div>
        <div class="p-6 border-t border-blue-100">
            <div class="space-y-3">
                <button onclick="logout()" class="w-full flex items-center px-4 py-3 text-left rounded-xl transition-all duration-200 hover:bg-red-50 hover:shadow-sm">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fa-solid fa-sign-out-alt text-red-600"></i>
                    </div>
                    <span class="font-medium text-red-700">Logout</span>
                </button>
            </div>
            <p class="mt-4 text-xs text-center text-gray-400">&copy; 2025 Engage Lanka, a subsidiary of Softmaster Technologies (Pvt) Ltd. All rights reserved.</p>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-white/60 bg-opacity-50 z-30 hidden md:hidden"></div>

    <!-- Main content with responsive margin -->
    <main id="mainContent" class="flex-1 md:ml-72 p-6 transition-all duration-300">
        <!-- Dashboard Section -->
        <section id="dashboardSection" class="space-y-8">
            <!-- Header -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome back, Admin</h1>
                        <p class="text-gray-600">Here's what's happening with your platform today.</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">{{ date('l, F j, Y') }}</p>
                        <p class="text-2xl font-bold text-blue-600" id="currentTime"></p>
                    </div>
                </div>
            </div>

            <!-- Statistics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Guides -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Guides</p>
                            <p class="text-3xl font-bold text-blue-700">{{ $guideCount }}</p>
                            <p class="text-xs text-green-600 mt-1">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +{{ $monthlyNewGuides }} this month
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-users text-white text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Visits -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Visits</p>
                            <p class="text-3xl font-bold text-green-700">{{ $visitCount }}</p>
                            <p class="text-xs text-green-600 mt-1">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +{{ $monthlyVisitCount }} this month
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-map-marker-alt text-white text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Tourists -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Tourists</p>
                            <p class="text-3xl font-bold text-purple-700">{{ $touristCount }}</p>
                            <p class="text-xs text-green-600 mt-1">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +{{ $monthlyTouristCount }} this month
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-globe text-white text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Revenue/Performance -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Performance</p>
                            <p class="text-3xl font-bold text-orange-700">{{ $performance }}</p>
                            <p class="text-xs text-green-600 mt-1">
                                <i class="fas fa-arrow-up mr-1"></i>
                                {{ $monthlyPerformance }}% this month
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-chart-line text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Guides Section -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Top Performing Guides</h2>
                    <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Last 30 days</span>
                </div>
                <div class="space-y-4">
                    @foreach($topGuides as $index => $guide)
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-2xl border border-gray-100 hover:shadow-md transition-all duration-200">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                @if($guide->profile_photo)
                                <img src="{{ asset('storage/' . $guide->profile_photo) }}"
                                    alt="{{ $guide->full_name }}"
                                    class="w-12 h-12 rounded-xl object-cover border-2 border-white shadow-lg">
                                @else
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center shadow-lg">
                                    <i class="fas fa-user text-gray-500"></i>
                                </div>
                                @endif
                                <div class="absolute -top-2 -right-2 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white
                                        {{ $index === 0 ? 'bg-gradient-to-br from-yellow-400 to-yellow-500' : 
                                           ($index === 1 ? 'bg-gradient-to-br from-gray-400 to-gray-500' : 
                                           ($index === 2 ? 'bg-gradient-to-br from-orange-400 to-orange-500' : 'bg-gradient-to-br from-blue-400 to-blue-500')) }}">
                                    {{ $index + 1 }}
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">{{ $guide->full_name }}</h3>
                                <p class="text-sm text-gray-600">{{ $guide->total_pax }} tourists served</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <div class="text-sm font-bold text-green-600">
                                    {{ $touristCount > 0 ? number_format(($guide->total_pax / $touristCount) * 100, 1) : 0 }}%
                                </div>
                                <div class="text-xs text-gray-500">of total</div>
                            </div>
                            <a href="/admin/guide/{{ $guide->id }}/update"
                                class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:shadow-lg transition-all duration-200 text-sm font-medium">
                                View <i class="fa-solid fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Tourist Visits Chart -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Tourist Visits Trend</h3>
                    <div class="relative h-80">
                        <canvas id="touristChart"></canvas>
                    </div>
                </div>

                <!-- New Guides Chart -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">New Guides Registration</h3>
                    <div class="relative h-80">
                        <canvas id="guideChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Reports Section -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Generate Reports</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Select Period</label>
                        <input
                            type="month"
                            id="reportDate"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            value="{{ date('Y-m') }}">
                    </div>
                    <div class="md:col-span-2">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button
                                onclick="generatePDFReport()"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 font-medium">
                                <i class="fas fa-file-pdf"></i>
                                Generate PDF Report
                            </button>
                            <button
                                onclick="generateExcelReport()"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 font-medium">
                                <i class="fas fa-file-excel"></i>
                                Generate Excel Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Guides Section -->
        <section id="guidesSection" class="hidden space-y-8">
            <!-- Header with Actions -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Manage Guides</h1>
                        <p class="text-gray-600">Add, edit, and monitor your tour guides</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button onclick="openAddGuideModal()" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 font-medium">
                            <i class="fa-solid fa-plus"></i>
                            Add New Guide
                        </button>

                        <!-- Search -->
                        <form id="searchForm" class="flex items-center gap-2">
                            <div class="relative">
                                <input
                                    type="text"
                                    id="searchInput"
                                    class="w-64 px-4 py-3 pl-12 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="Search guides..."
                                    autocomplete="off">
                                <i class="fa-solid fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl hover:shadow-lg transition-all duration-200 font-medium">
                                Search
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Search Results -->
            <div id="searchStatus"></div>
            <div id="searchResults"></div>

            <!-- Guides Table -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-white/20 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Guide</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Performance</th>
                                <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Quick Actions</th>
                                <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($guides as $guide)
                            <tr id="guide-row-{{ $guide->id }}" class="hover:bg-blue-50/50 transition-colors duration-200">
                                <!-- Guide Info -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        @if($guide->profile_photo)
                                        <img src="{{ asset('storage/' . $guide->profile_photo) }}" alt="Profile" class="w-12 h-12 rounded-xl object-cover border-2 border-white shadow-lg">
                                        @else
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center shadow-lg">
                                            <i class="fas fa-user text-gray-500"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-gray-800">{{ $guide->full_name }}</div>
                                            <div class="text-sm text-gray-500">ID: {{ $guide->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Contact Info -->
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        <div class="text-gray-800">{{ $guide->email ?? 'No email' }}</div>
                                        <div class="text-gray-500">{{ $guide->mobile_number ?? 'No phone' }}</div>
                                    </div>
                                </td>

                                <!-- Performance Stats -->
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-4">
                                        <div class="text-center">
                                            <div class="text-lg font-bold text-blue-600">{{ $guide->visits_count ?? 0 }}</div>
                                            <div class="text-xs text-gray-500">Visits</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-lg font-bold text-yellow-600">{{ $guide->redemptions->sum('points') ?? 0 }}</div>
                                            <div class="text-xs text-gray-500">Points</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Quick Actions -->
                                <td class="px-6 py-4 text-center">
                                    <button onclick="openAddVisitModal({{ $guide->id }})"
                                        class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl text-sm hover:shadow-lg transition-all duration-200 flex items-center space-x-2 mx-auto">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>Add Visit</span>
                                    </button>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ url('/admin/guide/' . $guide->id . '/update') }}"
                                        class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl text-sm hover:shadow-lg transition-all duration-200 inline-flex items-center space-x-2">
                                        <i class="fa-solid fa-eye"></i>
                                        <span>View</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add Guide Modal -->
            <div id="addGuideModal" class="fixed inset-0 bg-white/90 hidden flex items-center justify-center z-50">
                <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-blue-700">Add New Guide</h2>
                        <button onclick="closeAddGuideModal()" class="text-gray-500 hover:text-gray-700 text-2xl">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>

                    <form id="addGuideForm" class="space-y-5" enctype="multipart/form-data">
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
                            <input type="file" name="profile_photo" accept="image/*" class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 transition">
                        </div>
                        <div id="addGuideStatus" class="text-center text-sm"></div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition flex items-center justify-center gap-2">
                            <span id="addGuideBtnText">Add Guide</span>
                            <svg id="addGuideSpinner" class="hidden animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Items Section -->
        <section id="itemsSection" class="hidden space-y-8">
            <!-- Header with Add Item Button -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <h2 class="text-3xl font-bold gradient-text mb-2">Item Management</h2>
                        <p class="text-gray-600">Manage reward items and their point values</p>
                    </div>
                    <button onclick="openAddItemModal()" class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-semibold hover:shadow-lg transition-all duration-200">
                        <i class="fa-solid fa-plus"></i>
                        <span>Add New Item</span>
                    </button>
                </div>
            </div>

            <!-- Items Table -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-white/20 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800">All Items</h3>
                    <div id="itemStatus" class="text-center text-sm mt-2"></div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</th>
                                <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Points</th>
                                <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="itemsTableBody" class="bg-white divide-y divide-gray-100">
                            <!-- Items will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Add Item Modal -->
        <div id="addItemModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50">
            <div class="flex items-center justify-center h-full">
                <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full mx-4 relative">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-blue-700">Add New Item</h2>
                        <button onclick="closeAddItemModal()" class="text-gray-500 hover:text-gray-700 text-2xl transition-colors duration-200">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>

                    <form id="addItemModalForm" class="space-y-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Item Name</label>
                            <input type="text" name="name" id="modal_item_name" class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 transition" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Points</label>
                            <input type="number" name="points" id="modal_item_points" min="1" class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 transition" required>
                        </div>
                        <div id="addItemModalStatus" class="text-center text-sm"></div>
                        <div class="flex space-x-3">
                            <button type="button" onclick="closeAddItemModal()" class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors duration-200">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-medium hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                                <span id="addItemModalBtnText">Add Item</span>
                                <svg id="addItemModalSpinner" class="hidden animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" />
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Item Modal -->
        <div id="editItemModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50">
            <div class="flex items-center justify-center h-full">
                <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full mx-4 relative">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-blue-700">Edit Item</h2>
                        <button onclick="closeEditItemModal()" class="text-gray-500 hover:text-gray-700 text-2xl transition-colors duration-200">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>

                    <form id="editItemModalForm" class="space-y-6">
                        <input type="hidden" id="edit_item_id" name="id">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Item Name</label>
                            <input type="text" name="name" id="edit_item_name" class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 transition" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Points</label>
                            <input type="number" name="points" id="edit_item_points" min="1" class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 transition" required>
                        </div>
                        <div id="editItemModalStatus" class="text-center text-sm"></div>
                        <div class="flex space-x-3">
                            <button type="button" onclick="closeEditItemModal()" class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors duration-200">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-medium hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                                <span id="editItemModalBtnText">Update Item</span>
                                <svg id="editItemModalSpinner" class="hidden animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" />
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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


        // Add these functions to your existing script section
        function openAddGuideModal() {
            document.getElementById('addGuideModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeAddGuideModal() {
            document.getElementById('addGuideModal').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore scrolling
            document.getElementById('addGuideForm').reset();
            document.getElementById('addGuideStatus').innerHTML = '';
        }

        // Handle form submission
        document.getElementById('addGuideForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const btnText = document.getElementById('addGuideBtnText');
    const spinner = document.getElementById('addGuideSpinner');
    const status = document.getElementById('addGuideStatus');

    // Show loading state
    btnText.textContent = 'Adding...';
    spinner.classList.remove('hidden');
    status.innerHTML = '';

    try {
        const formData = new FormData(e.target);

        const response = await fetch('/api/admin/guides', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {
            status.innerHTML = '<span class="text-green-600">Guide added successfully!</span>';
            
            // Refresh both dashboard stats and guides table
            await refreshDashboard();
            await refreshGuidesTable(); // Add this line
            
            setTimeout(() => {
                closeAddGuideModal();
            }, 1500);
        } else {
            status.innerHTML = `<span class="text-red-600">${data.message || 'Failed to add guide'}</span>`;
        }
    } catch (error) {
        status.innerHTML = '<span class="text-red-600">Network error. Please try again.</span>';
        console.error('Error:', error);
    } finally {
        // Reset button state
        btnText.textContent = 'Add Guide';
        spinner.classList.add('hidden');
    }
});


// Add this new function to refresh only the guides table
async function refreshGuidesTable() {
    try {
        const guidesResponse = await fetch('/api/admin/guides', {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        });
        
        if (guidesResponse.ok) {
            const guidesData = await guidesResponse.json();
            
            // Update table body
            const tableBody = document.querySelector('#guidesSection tbody');
            if (tableBody && guidesData.guides) {
                tableBody.innerHTML = guidesData.guides.map(guide => `
                    <tr id="guide-row-${guide.id}" class="hover:bg-blue-50/50 transition-colors duration-200">
                        <!-- Guide Info -->
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                ${guide.profile_photo
                                    ? `<img src="/storage/${guide.profile_photo}" alt="Profile" class="w-12 h-12 rounded-xl object-cover border-2 border-white shadow-lg">`
                                    : `<div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center shadow-lg">
                                        <i class="fas fa-user text-gray-500"></i>
                                       </div>`
                                }
                                <div>
                                    <div class="font-bold text-gray-800">${guide.full_name}</div>
                                    <div class="text-sm text-gray-500">ID: ${guide.id}</div>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Contact Info -->
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <div class="text-gray-800">${guide.email || 'No email'}</div>
                                <div class="text-gray-500">${guide.mobile_number || 'No phone'}</div>
                            </div>
                        </td>
                        
                        <!-- Performance Stats -->
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-4">
                                <div class="text-center">
                                    <div class="text-lg font-bold text-blue-600">${guide.visits_count || 0}</div>
                                    <div class="text-xs text-gray-500">Visits</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-yellow-600">${guide.redemptions_sum_points || 0}</div>
                                    <div class="text-xs text-gray-500">Points</div>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Quick Actions -->
                        <td class="px-6 py-4 text-center">
                            <button onclick="openAddVisitModal(${guide.id})" 
                                    class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl text-sm hover:shadow-lg transition-all duration-200 flex items-center space-x-2 mx-auto">
                                <i class="fa-solid fa-plus"></i>
                                <span>Add Visit</span>
                            </button>
                        </td>
                        
                        <!-- Actions -->
                        <td class="px-6 py-4 text-center">
                            <a href="/admin/guide/${guide.id}/update"
                               class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl text-sm hover:shadow-lg transition-all duration-200 inline-flex items-center space-x-2">
                                <i class="fa-solid fa-eye"></i>
                                <span>View</span>
                            </a>
                        </td>
                    </tr>
                `).join('');
            }
        }
    } catch (error) {
        console.error('Error refreshing guides table:', error);
    }
}

        // Close modal when clicking outside
        document.getElementById('addGuideModal').addEventListener('click', (e) => {
            if (e.target.id === 'addGuideModal') {
                closeAddGuideModal();
            }
        });

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

        function logout() {
            localStorage.removeItem('admin_token');
            window.location.href = '/admin/login';
        }

        function goToProfile() {
            window.location.href = '/admin/profile;'
        }

        function showSection(id) { 
        // Hide all sections
        document.getElementById('dashboardSection').style.display = id === 'dashboard' ? 'block' : 'none';
        document.getElementById('guidesSection').style.display = id === 'guides' ? 'block' : 'none';
        document.getElementById('itemsSection').style.display = id === 'items' ? 'block' : 'none';

        // Update active states for all nav items
        document.querySelectorAll('.nav-item').forEach(item => {
            item.classList.remove('active');
        });

        // Load data for specific sections
        if (id === 'items') {
            loadItems(); // Add this line to load items when switching to items section
        }

        // Add active class to the clicked button
        const activeButton = document.querySelector(`button[onclick*="showSection('${id}')"]`);
        if (activeButton) {
            activeButton.classList.add('active');
        }

        // Close sidebar on mobile after navigation
        if (window.innerWidth < 768) {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('overlay').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

        async function refreshDashboard() {
            try {
                // Get updated stats (now includes guides data)
                const response = await fetch('/api/admin/dashboard-stats', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();

                // Update stat widgets
                const statisticsGrid = document.querySelector('#dashboardSection .grid');
                const statCards = statisticsGrid.querySelectorAll('.bg-white\\/80');

                if (statCards.length >= 4) {
                    // Total Guides (first card)
                    const guidesCard = statCards[0];
                    const guidesNumber = guidesCard.querySelector('.text-3xl.font-bold');
                    const guidesGrowth = guidesCard.querySelector('.text-xs.text-green-600');
                    if (guidesNumber) guidesNumber.textContent = data.guideCount || 0;
                    if (guidesGrowth) guidesGrowth.innerHTML = `<i class="fas fa-arrow-up mr-1"></i>+${data.monthlyNewGuides || 0} this month`;
                    
                    // Total Visits (second card)
                    const visitsCard = statCards[1];
                    const visitsNumber = visitsCard.querySelector('.text-3xl.font-bold');
                    const visitsGrowth = visitsCard.querySelector('.text-xs.text-green-600');
                    if (visitsNumber) visitsNumber.textContent = data.visitCount || 0;
                    if (visitsGrowth) visitsGrowth.innerHTML = `<i class="fas fa-arrow-up mr-1"></i>+${data.monthlyVisitCount || 0} this month`;
                    
                    // Total Tourists (third card)
                    const touristsCard = statCards[2];
                    const touristsNumber = touristsCard.querySelector('.text-3xl.font-bold');
                    const touristsGrowth = touristsCard.querySelector('.text-xs.text-green-600');
                    if (touristsNumber) touristsNumber.textContent = data.touristCount || 0;
                    if (touristsGrowth) touristsGrowth.innerHTML = `<i class="fas fa-arrow-up mr-1"></i>+${data.monthlyTouristCount || 0} this month`;
                    
                    // Performance (fourth card)
                    const performanceCard = statCards[3];
                    const performanceNumber = performanceCard.querySelector('.text-3xl.font-bold');
                    if (performanceNumber) performanceNumber.textContent = data.performance || '95%';
                }

                // Update guide table with guides data from dashboard stats
                const tableBody = document.querySelector('#guidesSection tbody');
                if (tableBody && data.guides) {
                    tableBody.innerHTML = data.guides.map(guide => `
                        <tr id="guide-row-${guide.id}" class="hover:bg-blue-50/50 transition-colors duration-200">
                            <!-- Guide Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    ${guide.profile_photo
                                        ? `<img src="/storage/${guide.profile_photo}" alt="Profile" class="w-12 h-12 rounded-xl object-cover border-2 border-white shadow-lg">`
                                        : `<div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center shadow-lg">
                                            <i class="fas fa-user text-gray-500"></i>
                                        </div>`
                                    }
                                    <div>
                                        <div class="font-bold text-gray-800">${guide.full_name}</div>
                                        <div class="text-sm text-gray-500">ID: ${guide.id}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Contact Info -->
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <div class="text-gray-800">${guide.email || 'No email'}</div>
                                    <div class="text-gray-500">${guide.mobile_number || 'No phone'}</div>
                                </div>
                            </td>
                            
                            <!-- Performance Stats -->
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-4">
                                    <div class="text-center">
                                        <div class="text-lg font-bold text-blue-600">${guide.visits_count || 0}</div>
                                        <div class="text-xs text-gray-500">Visits</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-lg font-bold text-yellow-600">${guide.redemptions_sum_points || 0}</div>
                                        <div class="text-xs text-gray-500">Points</div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Quick Actions -->
                            <td class="px-6 py-4 text-center">
                                <button onclick="openAddVisitModal(${guide.id})" 
                                        class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl text-sm hover:shadow-lg transition-all duration-200 flex items-center space-x-2 mx-auto">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>Add Visit</span>
                                </button>
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-4 text-center">
                                <a href="/admin/guide/${guide.id}/update"
                                class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl text-sm hover:shadow-lg transition-all duration-200 inline-flex items-center space-x-2">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>View</span>
                                </a>
                            </td>
                        </tr>
                    `).join('');
                }
                
                console.log('Dashboard refreshed successfully');
                
            } catch (error) {
                console.error('Error refreshing dashboard:', error);
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
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
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
                row.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
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

                // Update stat widgets with more specific selectors
                const statCards = document.querySelectorAll('.bg-white\\/80.backdrop-blur-sm.rounded-3xl.p-6');

                // Update each stat card individually
                if (statCards[0]) {
                    statCards[0].querySelector('.text-3xl.font-bold').textContent = data.guideCount;
                    statCards[0].querySelector('.text-xs.text-green-600').innerHTML = `<i class="fas fa-arrow-up mr-1"></i>+${data.monthlyNewGuides || 0} this month`;
                }

                if (statCards[1]) {
                    statCards[1].querySelector('.text-3xl.font-bold').textContent = data.visitCount;
                    statCards[1].querySelector('.text-xs.text-green-600').innerHTML = `<i class="fas fa-arrow-up mr-1"></i>+${data.monthlyVisitCount || 0} this month`;
                }

                if (statCards[2]) {
                    statCards[2].querySelector('.text-3xl.font-bold').textContent = data.touristCount;
                    statCards[2].querySelector('.text-xs.text-green-600').innerHTML = `<i class="fas fa-arrow-up mr-1"></i>+${data.monthlyTouristCount || 0} this month`;
                }

                if (statCards[3]) {
                    statCards[3].querySelector('.text-3xl.font-bold').textContent = data.performance || '95%';
                }

                // Refresh guide table
                const guidesResponse = await fetch('/api/admin/guides', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                const guidesData = await guidesResponse.json();

                // Update table body
                const tableBody = document.querySelector('#guidesSection tbody');
                if (tableBody && guidesData.guides) {
                    tableBody.innerHTML = guidesData.guides.map(guide => `
                        <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                            <!-- Guide Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    ${guide.profile_photo
                                        ? `<img src="/storage/${guide.profile_photo}" alt="Profile" class="w-12 h-12 rounded-xl object-cover border-2 border-white shadow-lg">`
                                        : `<div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center shadow-lg">
                                            <i class="fas fa-user text-gray-500"></i>
                                           </div>`
                                    }
                                    <div>
                                        <div class="font-bold text-gray-800">${guide.full_name}</div>
                                        <div class="text-sm text-gray-500">ID: ${guide.id}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Contact Info -->
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <div class="text-gray-800">${guide.email || 'No email'}</div>
                                    <div class="text-gray-500">${guide.mobile_number || 'No phone'}</div>
                                </div>
                            </td>
                            
                            <!-- Performance Stats -->
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-4">
                                    <div class="text-center">
                                        <div class="text-lg font-bold text-blue-600">${guide.visits_count || 0}</div>
                                        <div class="text-xs text-gray-500">Visits</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-lg font-bold text-yellow-600">${guide.redemptions.sum('points') || 0}</div>
                                        <div class="text-xs text-gray-500">Points</div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Quick Actions -->
                            <td class="px-6 py-4 text-center">
                                <button onclick="openAddVisitModal(${guide.id})" 
                                        class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl text-sm hover:shadow-lg transition-all duration-200 flex items-center space-x-2 mx-auto">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>Add Visit</span>
                                </button>
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-4 text-center">
                                <a href="/admin/guide/${guide.id}/update"
                                   class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl text-sm hover:shadow-lg transition-all duration-200 inline-flex items-center space-x-2">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>View</span>
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

        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburger');
            const sidebar = document.getElementById('sidebar');
            const closeSidebar = document.getElementById('closeSidebar');
            const overlay = document.getElementById('overlay');

            // Set initial state based on screen size
            function setInitialState() {
                if (window.innerWidth >= 768) {
                    // Desktop: sidebar should be visible
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    // Mobile: sidebar should be hidden
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }

            // Call on page load
            setInitialState();

            // Toggle sidebar (mobile only)
            function toggleSidebar() {
                if (window.innerWidth < 768) {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                    document.body.classList.toggle('overflow-hidden');
                }
            }

            // Close sidebar (mobile only)
            function closeSidebarFn() {
                if (window.innerWidth < 768) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }

            // Event listeners
            hamburger.addEventListener('click', toggleSidebar);
            closeSidebar.addEventListener('click', closeSidebarFn);
            overlay.addEventListener('click', closeSidebarFn);

            // Close sidebar when clicking on navigation items (mobile only)
            const navButtons = sidebar.querySelectorAll('button[onclick*="showSection"]');
            navButtons.forEach(button => {
                button.addEventListener('click', () => {
                    if (window.innerWidth < 768) {
                        closeSidebarFn();
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', () => {
                setInitialState();
            });
        });

        // Add time display
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
            const timeElement = document.getElementById('currentTime');
            if (timeElement) {
                timeElement.textContent = timeString;
            }
        }

        // Update time every second
        setInterval(updateTime, 1000);
        updateTime(); // Initial call

        // Modal functions
        function openAddVisitModal(guideId) {
            // Create modal if it doesn't exist
            if (!document.getElementById('addVisitModal')) {
                createAddVisitModal();
            }

            document.getElementById('visitGuideId').value = guideId;
            document.getElementById('visitDate').value = new Date().toISOString().split('T')[0];
            document.getElementById('paxCount').value = '';
            document.getElementById('visitNotes').value = '';
            document.getElementById('addVisitModal').classList.remove('hidden');
            document.getElementById('addVisitModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeAddVisitModal() {
            document.getElementById('addVisitModal').classList.add('hidden');
            document.getElementById('addVisitModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function createAddVisitModal() {
            const modalHTML = `
            <div id="addVisitModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[9999]">
                <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full mx-4 relative" onclick="event.stopPropagation()">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-blue-700">Add Visit</h2>
                        <button onclick="closeAddVisitModal()" class="text-gray-500 hover:text-gray-700 text-2xl transition-colors duration-200 p-2 rounded-full hover:bg-gray-100">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                    
                    <form id="addVisitForm">
                        <input type="hidden" id="visitGuideId" name="guide_id" value="">
                        
                        <div class="mb-6">
                            <label for="paxCount" class="block text-sm font-medium text-gray-700 mb-2">Number of Tourists (Pax)</label>
                            <input type="number" id="paxCount" name="pax_count" 
                                   class="w-full p-4 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                                   placeholder="Enter number of tourists" min="1" required>
                        </div>
                        
                        <div class="mb-6">
                            <label for="visitDate" class="block text-sm font-medium text-gray-700 mb-2">Visit Date</label>
                            <input type="date" id="visitDate" name="visit_date" 
                                   class="w-full p-4 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                                   required>
                        </div>
                        
                        <div class="mb-6">
                            <label for="visitNotes" class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                            <textarea id="visitNotes" name="notes" rows="3"
                                      class="w-full p-4 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                                      placeholder="Add any additional notes..."></textarea>
                        </div>
                        
                        <div class="flex space-x-3">
                            <button type="button" onclick="closeAddVisitModal()" 
                                    class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-2xl font-medium hover:bg-gray-200 transition-colors duration-200">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl font-medium hover:shadow-lg transition-all duration-200">
                                Add Visit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        `;
            document.body.insertAdjacentHTML('beforeend', modalHTML);

            // Add form submission handler
            document.getElementById('addVisitForm').addEventListener('submit', handleAddVisitSubmit);
        }

        async function handleAddVisitSubmit(e) {
            e.preventDefault();

            const formData = new FormData(e.target);
            const token = localStorage.getItem('admin_token');

            try {
                const response = await fetch('/api/admin/visits', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        guide_id: parseInt(formData.get('guide_id')),
                        pax_count: parseInt(formData.get('pax_count')),
                        visit_date: formData.get('visit_date'),
                        notes: formData.get('notes')
                    })
                });

                const data = await response.json();

                if (data.success || data.status === 'success') {
                    alert('Visit added successfully!');
                    closeAddVisitModal();
                    location.reload(); // Simple refresh for now
                } else {
                    alert(data.message || 'Failed to add visit');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Network error. Please try again.');
            }
        }

        // Modal close on outside click
        document.addEventListener('click', function(event) {
            const modals = ['addGuideModal', 'addVisitModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal && event.target === modal) {
                    if (modalId === 'addGuideModal') closeAddGuideModal();
                    if (modalId === 'addVisitModal') closeAddVisitModal();
                }
            });
        });

        const itemsList = document.getElementById('itemsList');
        const itemStatus = document.getElementById('itemStatus');

        function showItemsSection() {
            // Show the items section
            showSection('items');

            // Load items data
            loadItems();

            // Update navigation active state (this is now handled in showSection)
            // Remove the manual active state code since showSection handles it
        }

        async function loadItems() {
            const tableBody = document.getElementById('itemsTableBody');
            const statusDiv = document.getElementById('itemStatus');

            // Show loading state
            tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-gray-500 py-8">Loading items...</td></tr>';
            statusDiv.innerHTML = '';

            try {
                const response = await fetch('/api/admin/items', {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('admin_token'),
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    tableBody.innerHTML = `<tr><td colspan="5" class="text-center text-red-600 py-8">${data.message || 'Failed to load items.'}</td></tr>`;
                    return;
                }

                const items = data.items || data;
                renderItemsTable(items);

            } catch (err) {
                console.error('Error loading items:', err);
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-red-600 py-8">Network error. Please try again.</td></tr>';
            }
        }

        function renderItemsTable(items) {
            const tableBody = document.getElementById('itemsTableBody');

            if (!items || items.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-gray-500 py-8">No items found.</td></tr>';
                return;
            }

            tableBody.innerHTML = items.map(item => `
            <tr class="hover:bg-gray-50 transition-colors duration-200">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${item.id}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.name}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        ${item.points} pts
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                    ${new Date(item.created_at).toLocaleDateString()}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <div class="flex items-center justify-center space-x-2">
                        <button onclick="openEditItemModal(${item.id}, '${item.name}', ${item.points})" 
                                class="text-blue-600 hover:text-blue-900 transition-colors duration-200" 
                                title="Edit Item">
                            <i class="fa-solid fa-pen-to-square text-lg"></i>
                        </button>
                        <button onclick="deleteItem(${item.id})" 
                                class="text-red-600 hover:text-red-900 transition-colors duration-200" 
                                title="Delete Item">
                            <i class="fa-solid fa-trash text-lg"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
        }

        function openEditItemModal(id, name, points) {
            console.log('Opening edit modal for item:', id, name, points);
            
            const modal = document.getElementById('editItemModal');
            const idInput = document.getElementById('edit_item_id');
            const nameInput = document.getElementById('edit_item_name');
            const pointsInput = document.getElementById('edit_item_points');
            const statusDiv = document.getElementById('editItemModalStatus');
            
            if (modal && idInput && nameInput && pointsInput) {
                idInput.value = id;
                nameInput.value = name;
                pointsInput.value = points;
                
                if (statusDiv) {
                    statusDiv.innerHTML = '';
                }
                
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                // Focus on name input
                setTimeout(() => nameInput.focus(), 100);
            } else {
                console.error('Edit modal elements not found');
            }
        }

        // Modal functions
        function openAddItemModal() {
            const modal = document.getElementById('addItemModal');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                // Clear form
                const form = document.getElementById('addItemModalForm');
                if (form) {
                    form.reset();
                }
                
                // Clear status
                const status = document.getElementById('addItemModalStatus');
                if (status) {
                    status.innerHTML = '';
                }
                
                // Focus on first input
                const nameInput = document.getElementById('modal_item_name');
                if (nameInput) {
                    setTimeout(() => nameInput.focus(), 100);
                }
            }
        }

        function closeAddItemModal() {
            document.getElementById('addItemModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('addItemModalForm').reset();
            document.getElementById('addItemModalStatus').innerHTML = '';
        }

        function closeEditItemModal() {
            document.getElementById('editItemModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('editItemModalForm').reset();
            document.getElementById('editItemModalStatus').innerHTML = '';
        }

        async function deleteItem(id) {
            if (!confirm('Are you sure you want to delete this item?')) return;

            const statusDiv = document.getElementById('itemStatus');
            statusDiv.innerHTML = '<span class="text-blue-600">Deleting...</span>';

            try {
                const response = await fetch(`/api/admin/items/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('admin_token')}`,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    statusDiv.innerHTML = `<span class="text-red-600">${data.message || 'Delete failed.'}</span>`;
                    return;
                }

                statusDiv.innerHTML = '<span class="text-green-600">Item deleted successfully!</span>';

                // Refresh the table
                loadItems();

                // Clear status after 3 seconds
                setTimeout(() => {
                    statusDiv.innerHTML = '';
                }, 3000);

            } catch (err) {
                console.error('Error deleting item:', err);
                statusDiv.innerHTML = '<span class="text-red-600">Network error. Please try again.</span>';
            }
        }

        // Initialize form handlers when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Add item modal form handler
            const addItemModalForm = document.getElementById('addItemModalForm');
            if (addItemModalForm) {
                addItemModalForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const btnText = document.getElementById('addItemModalBtnText');
                    const spinner = document.getElementById('addItemModalSpinner');
                    const statusDiv = document.getElementById('addItemModalStatus');

                    // Show loading state
                    btnText.textContent = 'Adding...';
                    spinner.classList.remove('hidden');
                    statusDiv.innerHTML = '';

                    const formData = new FormData(this);
                    const token = localStorage.getItem('admin_token');

                    fetch('/api/admin/items', {
                            method: 'POST',
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                name: formData.get('name'),
                                points: parseInt(formData.get('points'))
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                statusDiv.innerHTML = '<span class="text-green-500">Item added successfully! <i class="fa-solid fa-circle-check"></i></span>';
                                loadItems(); // Refresh the table
                                setTimeout(() => {
                                    closeAddItemModal();
                                    this.reset();
                                }, 1500);
                            } else {
                                statusDiv.innerHTML = '<span class="text-red-500">Error adding item</span>';
                            }
                        })
                        .catch(error => {
                            console.error('Error adding item:', error);
                            statusDiv.innerHTML = '<span class="text-red-500">Error adding item</span>';
                        })
                        .finally(() => {
                            btnText.textContent = 'Add Item';
                            spinner.classList.add('hidden');
                        });
                });
            }

            // Edit item modal form handler
            const editItemModalForm = document.getElementById('editItemModalForm');
            if (editItemModalForm) {
                editItemModalForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const btnText = document.getElementById('editItemModalBtnText');
                    const spinner = document.getElementById('editItemModalSpinner');
                    const statusDiv = document.getElementById('editItemModalStatus');

                    // Show loading state
                    btnText.textContent = 'Updating...';
                    spinner.classList.remove('hidden');
                    statusDiv.innerHTML = '';

                    const formData = new FormData(this);
                    const token = localStorage.getItem('admin_token');
                    const itemId = formData.get('id');

                    fetch(`/api/admin/items/${itemId}`, {
                            method: 'PUT',
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                name: formData.get('name'),
                                points: parseInt(formData.get('points'))
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                statusDiv.innerHTML = '<span class="text-green-500">Item updated successfully! <i class="fa-solid fa-circle-check"></i></span>';
                                loadItems(); // Refresh the table
                                setTimeout(() => {
                                    closeEditItemModal();
                                }, 1500);
                            } else {
                                statusDiv.innerHTML = '<span class="text-red-500">Error updating item</span>';
                            }
                        })
                        .catch(error => {
                            console.error('Error updating item:', error);
                            statusDiv.innerHTML = '<span class="text-red-500">Error updating item</span>';
                        })
                        .finally(() => {
                            btnText.textContent = 'Update Item';
                            spinner.classList.add('hidden');
                        });
                });
            }

            // Modal close handlers
            const addItemModal = document.getElementById('addItemModal');
            if (addItemModal) {
                addItemModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeAddItemModal();
                    }
                });
            }

            const editItemModal = document.getElementById('editItemModal');
            if (editItemModal) {
                editItemModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeEditItemModal();
                    }
                });
            }
        });
    </script>