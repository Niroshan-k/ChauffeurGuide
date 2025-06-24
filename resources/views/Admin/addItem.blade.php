<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Item</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen flex flex-col items-center">
    @include('layouts.header')
    <main class="flex-1 flex items-center justify-center w-full">
        <div class="mx-auto mt-16 max-w-lg w-full border bg-white/90 rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-blue-700 mb-6 text-center">Add New Item</h2>
            <form id="addItemForm" class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Item Name</label>
                    <input type="text" name="name" id="item_name" class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 transition" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Points</label>
                    <input type="number" name="points" id="item_points" min="1" class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 transition" required>
                </div>
                <div id="addItemStatus" class="text-center text-sm"></div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition flex items-center justify-center gap-2">
                    <span id="addItemBtnText">Add Item</span>
                    <svg id="addItemSpinner" class="hidden animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                </button>
            </form>
        </div>
    </main>
</body>
</html>
<script>
const addItemForm = document.getElementById('addItemForm');
const addItemStatus = document.getElementById('addItemStatus');
const addItemBtnText = document.getElementById('addItemBtnText');
const addItemSpinner = document.getElementById('addItemSpinner');
const adminToken = localStorage.getItem('admin_token');

addItemForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    addItemStatus.textContent = '';
    addItemBtnText.textContent = 'Adding...';
    addItemSpinner.classList.remove('hidden');

    const name = document.getElementById('item_name').value;
    const points = document.getElementById('item_points').value;

    try {
        const response = await fetch('/api/admin/items', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + adminToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name, points })
        });
        const result = await response.json();
        addItemBtnText.textContent = 'Add Item';
        addItemSpinner.classList.add('hidden');
        if (!response.ok) {
            addItemStatus.innerHTML = `<span class="text-red-600">${result.message || 'Failed to add item.'}</span>`;
            return;
        }
        addItemStatus.innerHTML = `<span class="text-green-600 font-semibold">Item added successfully!</span>`;
        addItemForm.reset();
    } catch (err) {
        addItemBtnText.textContent = 'Add Item';
        addItemSpinner.classList.add('hidden');
        addItemStatus.innerHTML = `<span class="text-red-600">Network error.</span>`;
    }
});
</script>