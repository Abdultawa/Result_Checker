<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200 font-sans antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-xl mx-auto bg-white rounded-lg overflow-hidden shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold mb-4">Make Payment</h2>
                <i>Pls make sure you provide your correct name and registration number</i>
                <form action="{{ route('processPayment') }}" method="POST">
                    @csrf
                    <div class="mb-4 mt-2">
                        <label for="firstname" class="block text-sm font-medium text-gray-700">Firstname</label>
                        <input type="text" name="firstname" id="firstname" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter Firstname">
                    </div>
                    <div class="mb-4">
                        <label for="lastname" class="block text-sm font-medium text-gray-700">Lastname</label>
                        <input type="text" name="lastname" id="lastname" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter Lastname">
                    </div>
                    <div class="mb-4">
                        <label for="regNo" class="block text-sm font-medium text-gray-700">RegNo</label>
                        <input type="text" name="regNo" id="regNo" value="" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter RegNo">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter email">
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Pay Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if (session()->has('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="fixed bg-red-500 text-white py-2 px-4 rounded-xl bottom-3 right-3 text-sm">
        <p>{{ session('error') }}</p>
    </div>
    @endif
</body>
</html>
