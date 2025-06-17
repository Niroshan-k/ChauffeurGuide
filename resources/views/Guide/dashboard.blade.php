<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guide Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-yellow-100 via-blue-50 to-yellow-200 flex items-center justify-center">
    <div class="w-full max-w-3xl mx-auto my-12 rounded-3xl shadow-2xl bg-white/80 backdrop-blur-lg p-8">
        <!-- Profile Section -->
        <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
            <!-- Profile Card -->
            <div class="flex-1 flex flex-col items-center bg-gradient-to-b from-yellow-200 to-yellow-50 rounded-2xl shadow-lg p-8">
                <div id="profilePhoto" class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-5xl overflow-hidden mb-4 shadow-lg border-4 border-yellow-300"></div>
                <h2 id="guideName" class="text-3xl font-extrabold text-yellow-700 mb-2 text-center"></h2>
                <div class="flex flex-col gap-2 w-full mt-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span id="email" class="text-gray-700"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm0 12a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2zm12-12a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zm0 12a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span id="mobileNumber" class="text-gray-700"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 1.343-3 3 0 2.25 3 6 3 6s3-3.75 3-6c0-1.657-1.343-3-3-3z"/><circle cx="12" cy="11" r="3"/></svg>
                        <span id="dateOfBirth" class="text-gray-700"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 12a4 4 0 01-8 0V8a4 4 0 018 0v4z"/><path d="M12 16v2m0 0h-2m2 0h2"/></svg>
                        <span id="whatsappNumber" class="text-gray-700"></span>
                    </div>
                </div>
            </div>
            <!-- Redemption & Redeem Form -->
            <div class="flex-1 flex flex-col gap-8">
                <div class="bg-gradient-to-r from-blue-100 to-blue-50 rounded-2xl shadow-lg p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h3 class="text-xl font-bold text-blue-700">Redemption Info</h3>
                    </div>
                    <div class="flex flex-col gap-2">
                        <div>
                            <span class="font-semibold text-gray-700">Points:</span>
                            <span id="points" class="ml-2 text-lg text-blue-800 font-bold"></span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-700">Redeemed At:</span>
                            <span id="redeemedAt" class="ml-2"></span>
                        </div>
                    </div>
                </div>
                <!-- Redeem Points Form -->
                <div class="bg-gradient-to-r from-yellow-100 to-yellow-200 rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4 text-yellow-700 text-center flex items-center justify-center gap-2">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Redeem Points
                    </h3>
                    <form id="redeemForm" class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Points to Redeem</label>
                            <input type="number" min="1" id="redeemPoints" class="w-full px-4 py-3 border-2 border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 transition" placeholder="Enter points..." required>
                        </div>
                        <div id="redeemError" class="text-red-600 text-sm font-semibold"></div>
                        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 rounded-lg shadow transition">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 9V7a5 5 0 00-10 0v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2z"/><path d="M12 17v.01"/></svg>
                                Redeem
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div id="error" class="text-red-500 text-center mt-6"></div>
    </div>
    <script>
        // Get guideId from URL: /guide/dashboard/{id}
        const urlParts = window.location.pathname.split('/');
        const guideId = urlParts[urlParts.length - 1];
        const token = localStorage.getItem('guide_token');
        const errorDiv = document.getElementById('error');

        async function fetchGuideProfile() {
            if (!token) {
                errorDiv.textContent = 'You must be logged in as guide.';
                return;
            }
            try {
                const response = await fetch(`/api/guide/${guideId}/dashboard`, {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (!response.ok) {
                    errorDiv.textContent = data.message || 'Failed to fetch profile.';
                    return;
                }
                // Assuming your API returns all guide fields and redemption as { redemption: {...} }
                const guide = data;
                const redemption = data.redemption || {};

                document.getElementById('guideName').textContent = guide.full_name || '';
                document.getElementById('mobileNumber').textContent = guide.mobile_number || '-';
                document.getElementById('dateOfBirth').textContent = guide.date_of_birth || '-';
                document.getElementById('email').textContent = guide.email || '-';
                document.getElementById('whatsappNumber').textContent = guide.whatsapp_number || '-';

                if (guide.profile_photo) {
                    document.getElementById('profilePhoto').innerHTML =
                        `<img src="/storage/${guide.profile_photo}" alt="Profile" class="w-32 h-32 rounded-full object-cover">`;
                } else {
                    document.getElementById('profilePhoto').innerHTML = `<span>?</span>`;
                }

                document.getElementById('points').textContent = redemption.points ?? '-';
                document.getElementById('redeemedAt').textContent = redemption.redeemed_at ?? '-';
            } catch (err) {
                errorDiv.textContent = 'Network error';
            }
        }

        document.getElementById('redeemForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            document.getElementById('redeemError').textContent = '';
            const points = parseInt(document.getElementById('redeemPoints').value, 10);

            if (isNaN(points) || points < 1) {
                document.getElementById('redeemError').textContent = 'Please enter a valid number of points.';
                return;
            }

            try {
                const response = await fetch(`/api/guide/${guideId}/redeem`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ points })
                });
                const data = await response.json();
                if (!response.ok) {
                    document.getElementById('redeemError').textContent = data.message || 'Redemption failed';
                } else {
                    document.getElementById('redeemError').textContent = '';
                    document.getElementById('redeemForm').reset();
                    alert('🎉 Points redeemed successfully!');
                    fetchGuideProfile();
                }
            } catch (err) {
                document.getElementById('redeemError').textContent = 'Network error';
            }
        });

        fetchGuideProfile();
    </script>
</body>
</html>