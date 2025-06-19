<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Guide Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<header class="w-full bg-white/90 fixed shadow-md py-4 px-8 flex items-center justify-between mb-8 z-50">
    <div class="flex items-center gap-3">
        <img src="{{ asset('storage/appImages/logo.png') }}" alt="Logo">
    </div>
    <div class="flex items-center gap-4">
        <a href="https://instagram.com/yourprofile" target="_blank" class="bg-gradient-to-tr from-pink-500 via-red-500 to-yellow-500 text-white px-4 py-2 rounded-lg font-semibold shadow transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5zm4.25 3.25a5.25 5.25 0 1 1 0 10.5 5.25 5.25 0 0 1 0-10.5zm0 1.5a3.75 3.75 0 1 0 0 7.5 3.75 3.75 0 0 0 0-7.5zm5.25.75a1 1 0 1 1 0 2h-1.5a1 1 0 0 1 0-2h1.5z"/>
            </svg>
            Instagram
        </a>
        <div>
            <button onclick="logout()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold shadow transition">
                Logout
            </button>
        </div>
        <script>
        function logout() {
            localStorage.removeItem('guide_token');
            window.location.href = '/guide/login'; // or your login route
        }
        </script>
    </div>
</header>

<body class="min-h-screen bg-gradient-to-br from-yellow-100 via-blue-50 to-yellow-200 flex justify-center px-2 sm:px-4">
    <div class="my-8 w-full rounded-3xl backdrop-blur p-5 sm:p-8">
        <!-- Profile Section -->
        <div class="flex flex-col mt-20 gap-6">
            <!-- Profile Card -->
            <div class="flex flex-col items-center bg-gradient-to-b from-yellow-200 to-yellow-50 rounded-2xl shadow-lg p-6">
                <div id="profilePhoto" class="w-28 h-28 sm:w-32 sm:h-32 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-4xl overflow-hidden mb-4 shadow-lg border-4 border-yellow-300"></div>
                <h2 id="guideName" class="text-2xl sm:text-3xl font-extrabold text-yellow-700 mb-2 text-center"></h2>
                <div class="flex flex-col gap-3 w-full mt-4 text-sm sm:text-base">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span id="email" class="text-gray-700 break-all"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm0 12a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2zm12-12a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zm0 12a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span id="mobileNumber" class="text-gray-700"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 8c-1.657 0-3 1.343-3 3 0 2.25 3 6 3 6s3-3.75 3-6c0-1.657-1.343-3-3-3z" />
                            <circle cx="12" cy="11" r="3" />
                        </svg>
                        <span id="dateOfBirth" class="text-gray-700"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M16 12a4 4 0 01-8 0V8a4 4 0 018 0v4z" />
                            <path d="M12 16v2m0 0h-2m2 0h2" />
                        </svg>
                        <span id="whatsappNumber" class="text-gray-700"></span>
                    </div>
                </div>
            </div>

            <!-- Redemption Info -->
            <div class="bg-gradient-to-r from-blue-100 to-blue-50 rounded-2xl shadow-lg p-6">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg sm:text-xl font-bold text-blue-700">Redemption Info</h3>
                </div>
                <div class="flex flex-col gap-1 text-sm sm:text-base">
                    <div>
                        <span class="font-semibold text-gray-700">Points:</span>
                        <span id="points" class="ml-1 text-blue-800 font-bold"></span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-700">Redeemed At:</span>
                        <span id="redeemedAt" class="ml-1 text-gray-700"></span>
                    </div>
                </div>
            </div>

            <!-- Redeem Form -->
            <div class="bg-gradient-to-r from-yellow-100 to-yellow-200 rounded-2xl shadow-lg p-6">
                <h3 class="text-lg sm:text-xl font-bold mb-4 text-yellow-700 text-center flex items-center justify-center gap-2">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Redeem Points
                </h3>
                <form id="redeemForm" class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1 text-sm sm:text-base">Points to Redeem</label>
                        <input type="number" min="1" id="redeemPoints" class="w-full px-4 py-2 border-2 border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 transition text-sm sm:text-base" placeholder="Enter points..." required>
                    </div>
                    <div id="redeemError" class="text-red-600 text-sm font-semibold"></div>
                    <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 rounded-lg shadow transition text-sm sm:text-base">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17 9V7a5 5 0 00-10 0v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2z" />
                                <path d="M12 17v.01" />
                            </svg>
                            Redeem
                        </span>
                    </button>
                </form>
            </div>
        </div>
        <div id="error" class="text-red-500 text-center mt-4 text-sm"></div>
        <!-- Profile Update Section -->
    <div id="guideProfile" class="mx-auto bg-white/90 rounded-2xl shadow-xl p-8 flex flex-col items-center gap-6">
        <!-- Profile Photo -->
        <div class="relative">
            <img id="profilePhotoPreview" src="/storage/${guide.profile_photo}" alt="Profile" class="w-24 h-24 rounded-full object-cover border-4 border-blue-200 shadow">
            <label class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2 cursor-pointer shadow transition">
                <input type="file" id="profile_photo" accept="image/*" class="hidden">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536M9 11l6 6M3 17v4h4l11-11a2.828 2.828 0 10-4-4L3 17z"/></svg>
            </label>
        </div>
        <!-- Name Input -->
        <div class="w-full">
            <label class="block text-gray-700 font-semibold mb-1">Full Name</label>
            <input type="text" id="full_name" class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 transition" value="Current Guide Name">
        </div>
        <!-- Update Button & Status -->
        <div class="w-full flex flex-col items-center gap-2">
            <button id="updateProfileBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition flex items-center justify-center gap-2">
                <span id="updateBtnText">Update</span>
                <svg id="updateSpinner" class="hidden animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
            </button>
            <div id="updateStatus" class="text-center text-sm"></div>
        </div>
    </div>
    </div>
</body>
 <script>
    if (!localStorage.getItem('guide_token')) {
        window.location.href = '/guide/login'; // Change '/login' to your actual login route if different
    }
</script>
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
                const photoUrl = `/storage/${guide.profile_photo}`;
                document.getElementById('profilePhoto').innerHTML =
                    `<img src="${photoUrl}" alt="Profile" class="w-32 h-32 rounded-full object-cover">`;
                document.getElementById('profilePhotoPreview').src = photoUrl; // <- This sets the update section image
                document.getElementById('full_name').value = guide.full_name || '';
            } else {
                document.getElementById('profilePhoto').innerHTML = `<span>?</span>`;
                document.getElementById('profilePhotoPreview').src = ''; // or a default image if you want
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
                body: JSON.stringify({
                    points
                })
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

    // Profile update script
    const guideToken = localStorage.getItem('guide_token');

    // Profile photo preview
    const profilePhotoInput = document.getElementById('profile_photo');
    const profilePhotoPreview = document.getElementById('profilePhotoPreview');
    profilePhotoInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePhotoPreview.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    document.getElementById('updateProfileBtn').addEventListener('click', async function() {
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

        try {
            const response = await fetch(`/api/admin/guides/${guideId}`, {
                method: 'POST', // Use POST with _method=PUT for Laravel if not using AJAX PUT
                headers: {
                    'Authorization': 'Bearer ' + guideToken,
                    'Accept': 'application/json'
                },
                body: (() => {
                    formData.append('_method', 'PUT');
                    return formData;
                })()
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

    fetchGuideProfile();
</script>

</html>