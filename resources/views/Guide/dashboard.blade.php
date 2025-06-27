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
    </style>
</head>

<body class="min-h-screen flex flex-col items-center">
    <!-- Header -->
    <header class="w-full bg-white fixed shadow py-4 px-8 flex items-center justify-between z-50">
        <div class="flex items-center gap-3">
            <img src="/storage/appImages/logo.png" alt="Logo" class="h-10">
        </div>
        <div class="flex items-center gap-4">
            <a href="https://instagram.com/yourprofile" target="_blank"
                class="bg-gradient-to-tr from-pink-500 via-red-500 to-yellow-500 text-white px-4 py-2 rounded-lg font-semibold shadowansition flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5zm4.25 3.25a5.25 5.25 0 1 1 0 10.5 5.25 5.25 0 0 1 0-10.5zm0 1.5a3.75 3.75 0 1 0 0 7.5 3.75 3.75 0 0 0 0-7.5zm5.25.75a1 1 0 1 1 0 2h-1.5a1 1 0 0 1 0-2h1.5z" />
                </svg>
                Instagram
            </a>
            <button onclick="logout()"
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold shadowansition">
                Logout
            </button>
        </div>
    </header>

    <main class="w-full flex flex-col items-center pt-32 px-5 sm:px-4">
        <div id="error" class="text-red-500 text-center mt-4 text-sm"></div>
        <!-- Profile Section -->
        <div id="profileSection" class="w-full max-w-2xl flex flex-col gap-8"></div>
        <!-- Redemption Section -->
        <div id="redemptionSection" class="w-full max-w-2xl mt-8"></div>
        <!-- Profile Update Section -->
        <div id="profileUpdateSection" class="w-full max-w-2xl mt-8"></div>
    </main>

    <footer class="w-full p-5 text-center">
        <p>Powered by Engage Lanka<sup class="text-small">SM</sup></p>
    </footer>

    <script>
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
            <div class="flex flex-col items-center border rounded-2xl shadow p-6">
                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-4xl overflow-hidden mb-4 shadow border-4 border-yellow-300">
                    ${guide.profile_photo ? `<img src="/storage/${guide.profile_photo}" class="w-full h-full object-cover rounded-full">` : '?'}
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-yellow-700 mb-2 text-center">Hello, ${guide.full_name}</h2>
                <div class="flex flex-col gap-3 w-full mt-4 text-sm sm:text-base">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope"></i>
                        <span class="text-gray-700 break-all">${guide.email}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-comment-sms"></i>
                        <span class="text-gray-700">${guide.mobile_number}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-cake-candles"></i>
                        <span class="text-gray-700">${guide.date_of_birth}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-brands fa-whatsapp"></i>
                        <span class="text-gray-700">${guide.whatsapp_number}</span>
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
                <div class="flex items-center gap-3 mb-3 py-3 px-4 border shadow border-gray-200 rounded-full">
                    <label for="item_${item.id}" class="flex-1 cursor-pointer text-xl">
                    ${item.name} <span class="text-gray-500">(${item.points} pts)</span>
                    </label>
                    <input type="checkbox" class="item-checkbox" id="item_${item.id}" value="${item.id}" data-points="${item.points}">
                </div>
            `;
            });

            document.getElementById('redemptionSection').innerHTML = `
            <div class=" border rounded-2xl shadow p-6 mb-8">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <h3 class="text-lg sm:text-xl font-bold text-blue-700">Redemption Info</h3>
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex flex-col gap-1 text-sm sm:text-base">
                    <div>
                        <span class="font-semibold text-gray-700">Points:</span>
                        <span id="guidePoints" class="ml-1 text-blue-800 font-bold">${pointsRemaining}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-700">Last Redeemed At:</span>
                        <span id="redeemedAt" class="ml-1 text-gray-700">${redeemedAt}</span>
                    </div>
                </div>
            </div>
            <div class="mx-auto border  rounded-2xl shadow p-8">
                <h2 class="text-xl font-bold text-blue-700 mb-6 text-center">Redeem Items <i class="fa-solid fa-gift"></i> </h2>
                <form id="redeemForm" class="space-y-4">
                    <div class="space-y-2">${itemsHtml}</div>
                    <div class="mt-4 flex items-center justify-between">
                        <div>
                            <span class="font-semibold text-gray-700">Total Selected:</span>
                            <span id="totalPoints" class="text-blue-700 font-bold">0</span> pts
                        </div>
                        <button type="submit" id="redeemBtn"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded-xl transition"
                            disabled>
                            Redeem
                        </button>
                    </div>
                    <div id="redeemStatus" class="text-center text-sm mt-2"></div>
                </form>
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
            <div class="mx-auto border rounded-2xl shadow mb-10 p-8 flex flex-col items-center gap-6">
                <div class="relative">
                    <img id="profilePhotoPreview" src="/storage/${guide.profile_photo || ''}" alt="Profile" class="w-24 h-24 rounded-full object-cover border-4 border-blue-200 shadow                    <label class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2 cursor-pointer shadowansition">
                        <input type="file" id="profile_photo" accept="image/*" class="hidden">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536M9 11l6 6M3 17v4h4l11-11a2.828 2.828 0 10-4-4L3 17z"/></svg>
                    </label>
                </div>
                <div class="w-full">
                    <label class="block text-gray-700 font-semibold mb-1">Full Name</label>
                    <input type="text" id="full_name" class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 transition" value="${guide.full_name}">
                </div>
                <div class="w-full flex flex-col items-center gap-2">
                    <button id="updateProfileBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition w-full flex items-center justify-center gap-2">
                        <span id="updateBtnText">Update</span>
                        <svg id="updateSpinner" class="hidden animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                    </button>
                    <div id="updateStatus" class="text-center text-sm"></div>
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