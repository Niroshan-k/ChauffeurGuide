<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Guide Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
        }
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        .overlay {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(2px);
        }
        .nav-btn.active {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        .nav-btn:not(.active) {
            background: transparent;
            color: #6b7280;
        }
        .section {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
            opacity: 0;
        }
        .nav-item:hover .submenu {
            max-height: 200px;
            opacity: 1;
        }
        .submenu-item {
            transform: translateX(-10px);
            opacity: 0;
            transition: all 0.3s ease-in-out;
        }
        .nav-item:hover .submenu-item {
            transform: translateX(0);
            opacity: 1;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Mobile Hamburger Button -->
    <button id="hamburger" class="fixed top-4 left-4 z-50 lg:hidden bg-white p-3 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-72 bg-white shadow-xl flex flex-col justify-between fixed h-full sidebar-transition transform -translate-x-full lg:translate-x-0 z-40">
        <!-- Close button for mobile -->
        <button id="closeSidebar" class="absolute top-4 right-4 lg:hidden text-gray-500 hover:text-gray-700 p-2 rounded-lg hover:bg-gray-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        <div class="p-6 flex flex-col items-center">
            <!-- Logo -->
            <div class="mb-8 p-4 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100">
                <img src="/storage/appImages/logo.png" alt="Logo" class="w-20 h-auto">
            </div>
            
            <!-- Navigation -->
            <nav class="flex flex-col w-full gap-3">
                <!-- Profile with Submenu -->
                <div class="nav-item relative">
                    <button onclick="showSection('profile')" id="profileBtn" class="nav-btn flex gap-3 items-center w-full px-6 py-4 rounded-xl hover:bg-blue-50 transition-all duration-200 font-medium">
                        <i class="fa-solid fa-user text-lg"></i>
                        <span>Profile</span>
                        <i class="fa-solid fa-chevron-right ml-auto text-sm opacity-50 transition-transform duration-200"></i>
                    </button>
                    <!-- Submenu -->
                    <div class="submenu ml-6 mt-2">
                        <button onclick="showSection('profileUpdate')" class="submenu-item nav-btn flex gap-3 items-center w-full px-4 py-3 rounded-lg hover:bg-indigo-50 transition-all duration-200 font-medium text-sm">
                            <i class="fa-solid fa-edit text-indigo-600"></i>
                            <span>Update Profile</span>
                        </button>
                    </div>
                </div>
                
                <!-- Redeem Items -->
                <button onclick="showSection('redemption')" id="redemptionBtn" class="nav-btn flex gap-3 items-center w-full px-6 py-4 rounded-xl hover:bg-blue-50 transition-all duration-200 font-medium">
                    <i class="fa-solid fa-gift text-lg"></i>
                    <span>Redeem Items</span>
                </button>
            </nav>
        </div>
        
        <!-- Bottom Section -->
        <div class="p-6 border-t border-gray-100">
            <div class="flex flex-col gap-3">
                <a href="https://instagram.com/yourprofile" target="_blank"
                   class="px-4 py-3 bg-gradient-to-r from-pink-500 to-red-500 text-white rounded-xl text-center font-semibold hover:from-pink-600 hover:to-red-600 transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="fa-brands fa-instagram"></i>
                    <span>Instagram</span>
                </a>
                <button onclick="logout()" class="px-4 py-3 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </div>
            <p class="mt-4 text-xs text-center text-gray-500">&copy; 2025 Engage Lanka</p>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 overlay z-30 hidden lg:hidden"></div>

    <!-- Main content with responsive margin -->
    <main id="mainContent" class="flex-1 lg:ml-72 min-h-screen transition-all duration-300">
        <div class="p-6 lg:p-10">
            <div id="error" class="text-red-500 text-center mt-4 text-sm"></div>
            
            <!-- Profile Section -->
            <div id="profileSection" class="section w-full max-w-5xl mx-auto"></div>
            
            <!-- Redemption Section -->
            <div id="redemptionSection" class="section w-full max-w-5xl mx-auto hidden"></div>
            
            <!-- Profile Update Section -->
            <div id="profileUpdateSection" class="section w-full max-w-5xl mx-auto hidden"></div>
        </div>
    </main>

    <script>
        // Section management
        function showSection(sectionName) {
            // Hide all sections
            document.getElementById('profileSection').classList.add('hidden');
            document.getElementById('redemptionSection').classList.add('hidden');
            document.getElementById('profileUpdateSection').classList.add('hidden');
            
            // Show selected section
            document.getElementById(sectionName + 'Section').classList.remove('hidden');
            
            // Update button states
            const buttons = document.querySelectorAll('.nav-btn');
            buttons.forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Highlight active button based on section name
            let activeBtnId;
            if (sectionName === 'profile') {
                activeBtnId = 'profileBtn';
            } else if (sectionName === 'redemption') {
                activeBtnId = 'redemptionBtn';
            } else if (sectionName === 'profileUpdate') {
                // For profile update, we want to highlight the profile button since it's in the submenu
                activeBtnId = 'profileBtn';
            }
            
            const activeBtn = document.getElementById(activeBtnId);
            if (activeBtn) {
                activeBtn.classList.add('active');
            }
            
            // Close sidebar on mobile after navigation
            if (window.innerWidth < 1024) {
                closeSidebarFn();
            }
        }

        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburger');
            const sidebar = document.getElementById('sidebar');
            const closeSidebar = document.getElementById('closeSidebar');
            const overlay = document.getElementById('overlay');

            // Set initial state based on screen size
            function setInitialState() {
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }

            setInitialState();

            function toggleSidebar() {
                if (window.innerWidth < 1024) {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                    document.body.classList.toggle('overflow-hidden');
                }
            }

            window.closeSidebarFn = function() {
                if (window.innerWidth < 1024) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }

            hamburger.addEventListener('click', toggleSidebar);
            closeSidebar.addEventListener('click', closeSidebarFn);
            overlay.addEventListener('click', closeSidebarFn);

            window.addEventListener('resize', setInitialState);

            // Set default active section
            showSection('profile');
        });

        function logout() {
            localStorage.removeItem('guide_token');
            window.location.href = '/guide/login';
        }

        // Get guide ID from URL
        const urlParts = window.location.pathname.split('/');
        const guideId = urlParts[urlParts.length - 1];
        const token = localStorage.getItem('guide_token');
        if (!token) window.location.href = '/guide/login';

        // Fetch and render dashboard data
        document.addEventListener('DOMContentLoaded', fetchGuideDashboard);

        async function fetchGuideDashboard() {
            try {
                const response = await fetch(`/api/guide/${guideId}/dashboard`, {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (!response.ok) {
                    document.getElementById('error').textContent = data.message || 'Failed to fetch profile';
                    return;
                }
                renderProfileSection(data.guide);
                renderRedemptionSection(data.guide, data.redemption, data.items);
                renderProfileUpdateSection(data.guide);
            } catch (error) {
                document.getElementById('error').textContent = 'Network error';
            }
        }

        function renderProfileSection(guide) {
            document.getElementById('profileSection').innerHTML = `
            <div class="bg-white rounded-3xl shadow-xl p-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">
                        <i class="fa-solid fa-user text-blue-600 mr-3"></i>Profile Information
                    </h1>
                    <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-purple-500 mx-auto rounded-full"></div>
                </div>
                
                <div class="flex flex-col lg:flex-row items-center gap-10">
                    <!-- Profile Photo -->
                    <div class="flex-shrink-0">
                        <div class="relative">
                            <div class="w-40 h-40 rounded-full bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center text-gray-400 text-4xl overflow-hidden shadow-2xl border-4 border-white">
                                ${guide.profile_photo ? 
                                    `<img src="/storage/${guide.profile_photo}" class="w-full h-full object-cover rounded-full">` : 
                                    '<i class="fa-solid fa-user text-6xl text-gray-400"></i>'
                                }
                            </div>
                            <div class="absolute -bottom-2 -right-2 bg-green-500 w-8 h-8 rounded-full border-4 border-white flex items-center justify-center">
                                <i class="fa-solid fa-check text-white text-sm"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profile Details -->
                    <div class="flex-1 w-full">
                        <div class="text-center lg:text-left mb-8">
                            <h2 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">
                                Hello, ${guide.full_name}!
                            </h2>
                            <p class="text-gray-500 text-lg">Welcome to your dashboard</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-envelope text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <span class="text-sm text-blue-600 font-semibold">Email</span>
                                        <p class="text-gray-800 font-bold break-all">${guide.email}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="group bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-phone text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <span class="text-sm text-green-600 font-semibold">Mobile</span>
                                        <p class="text-gray-800 font-bold">${guide.mobile_number}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="group bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fa-brands fa-whatsapp text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <span class="text-sm text-emerald-600 font-semibold">WhatsApp</span>
                                        <p class="text-gray-800 font-bold">${guide.whatsapp_number || 'Not provided'}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="group bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-2xl hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-birthday-cake text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <span class="text-sm text-purple-600 font-semibold">Date of Birth</span>
                                        <p class="text-gray-800 font-bold">${guide.date_of_birth || 'Not provided'}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        }

        function renderRedemptionSection(guide, redemption, items) {
            const points = redemption && redemption.points ? redemption.points : 0;
            const redeemedAt = redemption && redemption.redeemed_at ? redemption.redeemed_at : '-';
            const pointsRemaining = guide.pointsRemaining ?? 0;
            let itemsHtml = '';
            items.forEach(item => {
                itemsHtml += `
                <div class="group relative bg-white border-2 border-gray-200 rounded-2xl p-6 hover:border-purple-300 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <input type="checkbox" class="item-checkbox w-6 h-6 text-purple-600 rounded-lg border-2 border-gray-300 focus:ring-purple-500" id="item_${item.id}" value="${item.id}" data-points="${item.points}">
                                <div class="absolute inset-0 bg-purple-600 rounded-lg opacity-0 group-hover:opacity-10 transition-opacity"></div>
                            </div>
                            <label for="item_${item.id}" class="cursor-pointer">
                                <h3 class="text-lg font-bold text-gray-800 group-hover:text-purple-700 transition-colors">
                                    ${item.name}
                                </h3>
                                <p class="text-sm text-gray-500">Click to select this item</p>
                            </label>
                        </div>
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white px-4 py-2 rounded-xl font-bold text-lg shadow-md">
                            ${item.points} pts
                        </div>
                    </div>
                </div>
            `;
            });

            document.getElementById('redemptionSection').innerHTML = `
            <div class="space-y-8">
                <!-- Points Summary Card -->
                <div class="bg-white rounded-3xl shadow-xl p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">
                            <i class="fa-solid fa-star text-yellow-500 mr-3"></i>Points Summary
                        </h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-orange-500 mx-auto rounded-full"></div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="relative overflow-hidden bg-gradient-to-br from-yellow-300 via-yellow-400 to-yellow-500 text-white p-8 rounded-2xl shadow-lg">
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-yellow-100 text-sm font-medium">Available Points</p>
                                        <p id="guidePoints" class="text-4xl font-bold mt-2">${pointsRemaining}</p>
                                        <p class="text-yellow-200 text-sm mt-1">Ready to redeem</p>
                                    </div>
                                    <div class="w-16 h-16 bg-yellow-200 bg-opacity-50 rounded-full flex items-center justify-center">
                                        <i class="fa-solid fa-coins text-3xl"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-200 bg-opacity-20 rounded-full -translate-y-8 translate-x-8"></div>
                        </div>
                        
                        <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white p-8 rounded-2xl shadow-lg">
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-emerald-100 text-sm font-medium">Last Redeemed</p>
                                        <p id="redeemedAt" class="text-xl font-semibold mt-2">${redeemedAt}</p>
                                        <p class="text-emerald-200 text-sm mt-1">Recent activity</p>
                                    </div>
                                    <div class="w-16 h-16 bg-blue-500 bg-opacity-50 rounded-full flex items-center justify-center">
                                        <i class="fa-solid fa-gift text-3xl"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500 bg-opacity-20 rounded-full -translate-y-8 translate-x-8"></div>
                        </div>
                    </div>
                </div>

                <!-- Redemption Form -->
                <div class="bg-white rounded-3xl shadow-xl p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">
                            <i class="fa-solid fa-gift text-purple-600 mr-3"></i>Redeem Items
                        </h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-purple-500 to-pink-500 mx-auto rounded-full"></div>
                        <p class="text-gray-600 mt-4">Choose items to redeem with your points</p>
                    </div>
                    
                    <form id="redeemForm" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">${itemsHtml}</div>
                        
                        <div class="border-t-2 border-gray-100 pt-8">
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-2xl">
                                <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                                    <div class="text-center lg:text-left">
                                        <span class="text-lg font-semibold text-gray-700">Total Selected:</span>
                                        <div class="mt-2">
                                            <span id="totalPoints" class="text-3xl font-bold text-purple-700">0</span>
                                            <span class="text-gray-500 text-lg ml-1">points</span>
                                        </div>
                                    </div>
                                    <button type="submit" id="redeemBtn"
                                        class="w-full lg:w-auto bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold px-8 py-4 rounded-xl transition-all duration-200 disabled:from-gray-400 disabled:to-gray-500 disabled:cursor-not-allowed shadow-lg hover:shadow-xl transform hover:-translate-y-1"
                                        disabled>
                                        <i class="fa-solid fa-shopping-cart mr-2"></i>Redeem Items
                                    </button>
                                </div>
                                <div id="redeemStatus" class="text-center text-sm mt-4"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        `;

            // Add JS logic for redemption
            setTimeout(() => {
                const checkboxes = document.querySelectorAll('.item-checkbox');
                const totalPointsEl = document.getElementById('totalPoints');
                const redeemBtn = document.getElementById('redeemBtn');
                const redeemStatus = document.getElementById('redeemStatus');
                const minPointsToLeave = 10;

                function updateTotal() {
                    const guidePoints = parseInt(document.getElementById('guidePoints').textContent);
                    let total = 0;
                    checkboxes.forEach(cb => {
                        if (cb.checked) total += parseInt(cb.dataset.points);
                    });
                    totalPointsEl.textContent = total;

                    if (total > 0 && (guidePoints - total) >= minPointsToLeave) {
                        redeemBtn.disabled = false;
                        redeemStatus.textContent = '';
                    } else if (total > 0 && (guidePoints - total) < minPointsToLeave) {
                        redeemBtn.disabled = true;
                        redeemStatus.innerHTML = `<span class="text-red-600">You must leave at least ${minPointsToLeave} points. You can redeem up to ${guidePoints - minPointsToLeave} points worth of items.</span>`;
                    } else {
                        redeemBtn.disabled = true;
                        redeemStatus.textContent = '';
                    }
                }

                checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));

                document.getElementById('redeemForm').addEventListener('submit', async function (e) {
                    e.preventDefault();
                    redeemBtn.disabled = true;
                    redeemBtn.textContent = 'Processing...';
                    redeemStatus.textContent = '';

                    const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);

                    try {
                        const response = await fetch(`/api/guide/${guideId}/redeem`, {
                            method: 'POST',
                            headers: {
                                'Authorization': 'Bearer ' + token,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ item_ids: selected })
                        });

                        const result = await response.json();
                        redeemBtn.textContent = 'Redeem';

                        if (!response.ok) {
                            redeemStatus.innerHTML = `<span class="text-red-600">${result.message || 'Redemption failed.'}</span>`;
                            redeemBtn.disabled = false;
                            return;
                        }

                        redeemStatus.innerHTML = `<span class="text-green-600 font-semibold">Redemption successful!</span>`;
                        setTimeout(() => window.location.reload(), 1200);

                    } catch (err) {
                        redeemBtn.textContent = 'Redeem';
                        redeemStatus.innerHTML = `<span class="text-red-600">Network error.</span>`;
                        redeemBtn.disabled = false;
                    }
                });
            }, 100);
        }

        function renderProfileUpdateSection(guide) {
            document.getElementById('profileUpdateSection').innerHTML = `
            <div class="bg-white rounded-3xl shadow-xl p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">
                        <i class="fa-solid fa-edit text-indigo-600 mr-3"></i>Update Profile
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto rounded-full"></div>
                    <p class="text-gray-600 mt-4">Keep your profile information up to date</p>
                </div>
                
                <div class="max-w-3xl mx-auto space-y-8">
                    <!-- Profile Photo Section -->
                    <div class="flex flex-col items-center gap-6">
                        <div class="relative group">
                            <img id="profilePhotoPreview" src="/storage/${guide.profile_photo || ''}" alt="Profile" 
                                 class="w-40 h-40 rounded-full object-cover border-4 border-gray-200 shadow-xl group-hover:shadow-2xl transition-all duration-300">
                            <label class="absolute bottom-2 right-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full p-4 cursor-pointer shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-110">
                                <input type="file" id="profile_photo" accept="image/*" class="hidden">
                                <i class="fa-solid fa-camera text-xl"></i>
                            </label>

                        </div>
                        <p class="text-sm text-gray-500 text-center">Click the camera icon to change your profile photo</p>
                    </div>

                    <!-- Form Fields -->
                    <div class="space-y-6">
                        <div class="group">
                            <label class="block text-gray-700 font-semibold mb-3">
                                <i class="fa-solid fa-user mr-2 text-indigo-600"></i>Full Name
                            </label>
                            <input type="text" id="full_name" 
                                   class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all duration-200 text-lg group-hover:border-gray-300" 
                                   value="${guide.full_name}" placeholder="Enter your full name">
                        </div>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-gray-700 font-semibold mb-3">
                                    <i class="fa-solid fa-envelope mr-2 text-gray-400"></i>Email Address
                                </label>
                                <input type="email" 
                                       class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl bg-gray-50 text-gray-500 cursor-not-allowed" 
                                       value="${guide.email}" disabled>
                                <p class="text-xs text-gray-500 mt-2 flex items-center">
                                    <i class="fa-solid fa-lock mr-1"></i>
                                    Email address cannot be changed
                                </p>
                            </div>
                            
                            <div class="group">
                                <label class="block text-gray-700 font-semibold mb-3">
                                    <i class="fa-solid fa-phone mr-2 text-gray-400"></i>Mobile Number
                                </label>
                                <input type="text" 
                                       class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl bg-gray-50 text-gray-500 cursor-not-allowed" 
                                       value="${guide.mobile_number}" disabled>
                                <p class="text-xs text-gray-500 mt-2 flex items-center">
                                    <i class="fa-solid fa-shield-alt mr-1"></i>
                                    Contact admin to change this
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Update Button -->
                    <div class="flex flex-col items-center gap-4 pt-6">
                        <button id="updateProfileBtn" 
                                class="group relative w-full lg:w-auto bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-4 px-10 rounded-2xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center gap-3">
                            <span id="updateBtnText" class="flex items-center gap-2">
                                <i class="fa-solid fa-save"></i>
                                Update Profile
                            </span>
                            <svg id="updateSpinner" class="hidden animate-spin h-6 w-6 text-white" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                        </button>
                        <div id="updateStatus" class="text-center text-sm"></div>
                    </div>
                </div>
            </div>
        `;

            // Profile photo preview
            const profilePhotoInput = document.getElementById('profile_photo');
            const profilePhotoPreview = document.getElementById('profilePhotoPreview');
            profilePhotoInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        profilePhotoPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            document.getElementById('updateProfileBtn').addEventListener('click', async function () {
                const updateStatus = document.getElementById('updateStatus');
                const updateBtnText = document.getElementById('updateBtnText');
                const updateSpinner = document.getElementById('updateSpinner');

                updateStatus.textContent = '';
                updateBtnText.textContent = 'Updating...';
                updateSpinner.classList.remove('hidden');

                const name = document.getElementById('full_name').value;
                const photoFile = profilePhotoInput.files[0];

                const formData = new FormData();
                formData.append('full_name', name);
                if (photoFile) formData.append('profile_photo', photoFile);
                formData.append('_method', 'PUT');

                try {
                    const response = await fetch(`/api/admin/guides/${guideId}`, {
                        method: 'POST',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const result = await response.json();
                    updateBtnText.textContent = 'Update';
                    updateSpinner.classList.add('hidden');

                    if (!response.ok) {
                        updateStatus.innerHTML = `<span class="text-red-600">${result.message || 'Failed to update profile.'}</span>`;
                        return;
                    }
                    updateStatus.innerHTML = `<span class="text-green-600 font-semibold">Profile updated successfully!</span>`;
                } catch (err) {
                    updateBtnText.textContent = 'Update';
                    updateSpinner.classList.add('hidden');
                    updateStatus.innerHTML = `<span class="text-red-600">Network error.</span>`;
                }
            });
        }
    </script>
</body>

</html>