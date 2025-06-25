<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guide Details & Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
@include('layouts.header')
<body class="bg-gradient-to-br from-gray-50 to-blue-100 min-h-screen">
    <div class="max-w-6xl mx-auto py-12 px-6">
        <!-- Profile Section -->
        <div class="flex flex-col items-center mb-10">
            <div id="profilePhotoPreview" class="w-36 h-36 rounded-full mt-12 bg-gray-200 flex items-center justify-center text-gray-400 text-5xl overflow-hidden shadow-lg border-4 border-white"></div>
            <h2 class="text-3xl font-extrabold text-blue-800 mt-4" id="guideName">Guide Details</h2>
            <p class="text-gray-600 text-sm" id="guideId"></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Left Section -->
            <div class="bg-white rounded-3xl shadow-xl p-8 space-y-6">
                <h3 class="text-xl font-bold text-blue-700 mb-4">Edit Profile</h3>
                <form id="updateGuideForm" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="full_name" id="full_name" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mobile Number</label>
                        <input type="text" name="mobile_number" id="mobile_number" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" id="whatsapp_number" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Profile Photo</label>
                        <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="w-full mt-1 text-sm">
                    </div>
                    <div id="error" class="text-red-600 text-sm font-semibold"></div>
                    <div class="flex gap-4 mt-6">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl font-semibold">Update Guide</button>
                        <button type="button" id="removeGuideBtn" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 rounded-xl font-semibold">Remove Guide</button>
                    </div>
                </form>
            </div>

            <!-- Right Section -->
            <div class="space-y-10">
                <!-- Add Visit -->
                <div class="bg-white rounded-3xl shadow-xl p-8">
                    <h3 class="text-xl font-bold text-blue-700 mb-4 text-center">Add Visit</h3>
                    <form id="addVisitForm" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Visit Date</label>
                            <input type="date" name="visit_date" id="visit_date" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tourist Count</label>
                            <input type="number" name="pax_count" id="pax_count" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400" min="1" required>
                        </div>
                        <div id="visitError" class="text-red-600 text-sm font-semibold"></div>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-xl font-semibold mt-2">Add Visit</button>
                    </form>
                </div>

                <!-- Redemption Info -->
                <div class="bg-white rounded-3xl shadow-xl p-8">
                    <h3 class="text-xl font-bold text-blue-700 mb-4 text-center">Redemption Info</h3>
                    <div class="space-y-3 text-gray-700">
                        <div>
                            <span class="font-semibold">Redeemed At:</span>
                            <span id="redeemedAtDetail" class="ml-1"></span>
                        </div>
                        <div>
                            <span class="font-semibold">Points:</span>
                            <span id="pointsDetail" class="ml-1"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    // Get guide ID from URL (e.g., /admin/guides/1/edit)
    const urlParts = window.location.pathname.split('/');
    const guideId = urlParts[urlParts.length - 2] || urlParts.pop();
    const token = localStorage.getItem('admin_token');
    const errorDiv = document.getElementById('error');

    // Fetch guide details
    async function fetchGuide() {
        if (!token) {
            errorDiv.textContent = 'You must be logged in as admin.';
            return;
        }
        try {
            const response = await fetch(`/api/admin/guides/${guideId}`, {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            const guide = await response.json();
            if (!response.ok) {
                errorDiv.textContent = guide.message || 'Failed to fetch guide.';
                return;
            }
            fillGuideForm(guide.guide);
        } catch (err) {
            errorDiv.textContent = 'Network error';
        }
    }

    function fillGuideForm(guide) {
        document.getElementById('guideName').textContent = guide.full_name || 'Guide Details';
        document.getElementById('guideId').textContent = guide.id ? `ID: ${guide.id}` : '';
        document.getElementById('full_name').value = guide.full_name || '';
        document.getElementById('mobile_number').value = guide.mobile_number || '';
        document.getElementById('date_of_birth').value = guide.date_of_birth || '';
        document.getElementById('email').value = guide.email || '';
        document.getElementById('whatsapp_number').value = guide.whatsapp_number || '';
        if (guide.profile_photo) {
            document.getElementById('profilePhotoPreview').innerHTML =
                `<img src="/storage/${guide.profile_photo}" alt="Profile" class="w-32 h-32 rounded-full object-cover">`;
        } else {
            document.getElementById('profilePhotoPreview').innerHTML = `<span>?</span>`;
        }
    }

    // Update all profile fields
    document.getElementById('updateGuideForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        errorDiv.textContent = '';
        const form = e.target;
        const formData = new FormData(form);
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
            const data = await response.json();
            if (!response.ok) {
                errorDiv.textContent = data.message || 'Failed to update guide';
            } else {
                alert('Guide updated successfully!');
                fetchGuide();
            }
        } catch (err) {
            errorDiv.textContent = 'Network error';
        }
    });

    document.getElementById('removeGuideBtn').addEventListener('click', async function() {
        if (!confirm('Are you sure you want to remove this guide?')) return;
        errorDiv.textContent = '';
        try {
            const response = await fetch(`/api/admin/guides/${guideId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            if (!response.ok) {
                errorDiv.textContent = data.message || 'Failed to remove guide';
            } else {
                alert('Guide removed successfully!');
                window.location.href = '/admin/dashboard';
            }
        } catch (err) {
            errorDiv.textContent = 'Network error';
        }
    });

    // Add Visit Form
    document.getElementById('addVisitForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        document.getElementById('visitError').textContent = '';
        const visit_date = document.getElementById('visit_date').value;
        const pax_count = document.getElementById('pax_count').value;
        try {
            const response = await fetch('/api/admin/visits', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    guide_id: guideId,
                    visit_date: visit_date,
                    pax_count: pax_count
                })
            });
            const data = await response.json();
            if (!response.ok) {
                document.getElementById('visitError').textContent = data.message || 'Failed to add visit';
            } else {
                alert('Visit added successfully!');
                document.getElementById('addVisitForm').reset();
                fetchRedemption();
            }
        } catch (err) {
            document.getElementById('visitError').textContent = 'Network error';
        }
    });

    // Redemption Info
    async function fetchRedemption() {
        try {
            const response = await fetch(`/api/admin/guides/${guideId}/redemption`, {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            if (!response.ok) {
                document.getElementById('redeemedAtDetail').textContent = '-';
                document.getElementById('pointsDetail').textContent = '-';
                return;
            }
            document.getElementById('redeemedAtDetail').textContent = data.redemption?.redeemed_at || '-';
            document.getElementById('pointsDetail').textContent = data.redemption?.points ?? '-';
        } catch (err) {
            document.getElementById('redeemedAtDetail').textContent = '-';
            document.getElementById('pointsDetail').textContent = '-';
        }
    }

    fetchGuide();
    fetchRedemption();

    // Optional: Show preview of new profile photo before upload
    document.getElementById('profile_photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                document.getElementById('profilePhotoPreview').innerHTML =
                    `<img src="${evt.target.result}" alt="Profile" class="w-32 h-32 rounded-full object-cover">`;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
</body>
</html>
