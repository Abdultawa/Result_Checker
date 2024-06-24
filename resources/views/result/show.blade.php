<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200 font-sans antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <a href="/" class="text-indigo-600 hover:text-indigo-900">Back to Home</a>
    </div>
    <div class="flex justify-between px-9">
        @if($results->isNotEmpty())
            <h1 class="text-2xl font-semibold">Name: {{ $results->first()->studentName }}</h1>
            <h1 class="text-2xl font-semibold">Matric No: {{ $results->first()->regNo }}</h1>
        @else
            <h1>No results found</h1>
        @endif
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 overflow-x-auto">
        <div class="overflow-hidden border border-gray-300 shadow-sm sm:rounded-lg">
            @if($results->isNotEmpty())
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Point</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($results as $result)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $result->course }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $result->semester }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $result->grade }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $result->point }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $result->level }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="bg-gray-200 shadow rounded-xl max-w-8 p-4 mt-4">
                <h2 class="text-2xl font-semibold text-gray-800">GPA: {{ number_format($gpa, 2) }}</h2>
            </div>
            @else
                <p class="text-center py-4">No results found for the specified criteria.</p>
            @endif
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 float-right">
    @if ($results->isNotEmpty() && $results->first()->level == 400 && $results->first()->semester == 'Second Semester')
        <a href="{{ route('makePayment', ['regNo' => $results->first()->regNo]) }}" class="text-indigo-600 hover:text-indigo-900">Make Payment</a>
    @endif
    </div>
</body>
</html>
