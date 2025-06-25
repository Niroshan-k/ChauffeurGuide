<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Items</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 via-yellow-50 to-blue-100 min-h-screen flex flex-col items-center">
    @include('layouts.header')
    <main class="flex-1 flex items-center justify-center w-full">
        <div class="mx-auto mt-16 w-full max-w-2xl">
            <a href="/admin/add-item" class="flex max-w-2xl mb-5 items-center gap-2 px-4 py-3 bg-black rounded-lg text-white transition hover:bg-gray-800 shadow">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4" />
                </svg>
                Add Items
            </a>
            <div class="bg-white/90 rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-blue-700 mb-6 text-center">Update Items</h2>
                <div id="itemStatus" class="text-center text-sm mb-4"></div>
                <div id="itemsList" class="space-y-6"></div>
            </div>
        </div>
    </main>
    <script>
    const adminToken = localStorage.getItem('admin_token');
    const itemsList = document.getElementById('itemsList');
    const itemStatus = document.getElementById('itemStatus');

    async function loadItems() {
        itemsList.innerHTML = '<div class="text-center text-gray-500">Loading...</div>';
        try {
            const response = await fetch('/api/admin/items', {
                headers: {
                    'Authorization': 'Bearer ' + adminToken,
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            if (!response.ok) {
                itemsList.innerHTML = `<div class="text-red-600">${data.message || 'Failed to load items.'}</div>`;
                return;
            }
            renderItems(data.items || data);
        } catch (err) {
            itemsList.innerHTML = '<div class="text-red-600">Network error.</div>';
        }
    }

    function renderItems(items) {
        if (!items.length) {
            itemsList.innerHTML = '<div class="text-gray-500">No items found.</div>';
            return;
        }
        itemsList.innerHTML = items.map(item => `
            <div class="flex flex-col sm:flex-row items-center gap-4 border-b pb-4">
                <input type="text" value="${item.name}" id="name_${item.id}" class="px-3 py-2 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 transition w-40" />
                <input type="number" value="${item.points}" id="points_${item.id}" min="1" class="px-3 py-2 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 transition w-24" />
                <button onclick="updateItem(${item.id})" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow transition focus:ring-2 focus:ring-blue-400">Update</button>
                <button onclick="deleteItem(${item.id})" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold shadow transition focus:ring-2 focus:ring-red-400">Delete</button>
            </div>
        `).join('');
    }

    async function updateItem(id) {
        itemStatus.textContent = '';
        const name = document.getElementById(`name_${id}`).value;
        const points = document.getElementById(`points_${id}`).value;
        try {
            const response = await fetch(`/api/admin/items/${id}`, {
                method: 'PUT',
                headers: {
                    'Authorization': 'Bearer ' + adminToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ name, points })
            });
            const data = await response.json();
            if (!response.ok) {
                itemStatus.innerHTML = `<span class="text-red-600">${data.message || 'Update failed.'}</span>`;
                return;
            }
            itemStatus.innerHTML = `<span class="text-green-600">Item updated!</span>`;
            loadItems();
        } catch (err) {
            itemStatus.innerHTML = `<span class="text-red-600">Network error.</span>`;
        }
    }

    async function deleteItem(id) {
        if (!confirm('Are you sure you want to delete this item?')) return;
        itemStatus.textContent = '';
        try {
            const response = await fetch(`/api/admin/items/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + adminToken,
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            if (!response.ok) {
                itemStatus.innerHTML = `<span class="text-red-600">${data.message || 'Delete failed.'}</span>`;
                return;
            }
            itemStatus.innerHTML = `<span class="text-green-600">Item deleted!</span>`;
            loadItems();
        } catch (err) {
            itemStatus.innerHTML = `<span class="text-red-600">Network error.</span>`;
        }
    }

    loadItems();
    </script>
</body>
</html>