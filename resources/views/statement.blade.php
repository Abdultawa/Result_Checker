<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statement of Result</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Hide all elements outside the .shadow element when printing */
        @media print {
            body > *:not(.body) {
                display: none !important;
            }
        }
    </style>
</head>
<body class="p-12">
    <div class="flex flex-col justify-center items-center body">
        <h1 class="text-center font-extrabold text-3xl mt-3 uppercase">Higher Institution Kaduna state, Nigeria</h1>
        <img src="/InstitutionLogo.png" alt="" style="width:170px; height:120px;">
        <h1 class="font-semibold text-2xl font-mono">This is to Certify that</h1>
        <p class="text-xl mt-12">{{ $payment->firstname }} {{ $payment->lastname }} with Registration number of {{ $payment->regNo }}</p>
        <span class="text-center my-2 mt-12">Having completed an approved course of study and passed the <br>prescribed examinations, had, this day, under the authority <br>of the Academic Board, been awarded the in</span>
        <h1 class="font-extrabold text-2xl mt-9">DEGREE (BSc)</h1>
        <span class="mt-12">Of</span>
        <span class="text-xl font-bold mt-12">Department: {{ $payment->dept }}</span>
        <div class="flex mt-12">
            <div class="flex mr-6">
                <span>REGISTRAR: </span>
                <img src="/sign.png" alt="" class="w-16 h-6">
            </div>
            <div class="flex">
                <span>RECTOR: </span>
                <img src="/sign.png" alt="" class="w-16 h-6">
            </div>
        </div>
        <span class="mt-12 mb-5">Date: {{date("jS F Y")}}</span>
    </div>
    <center>
        <!-- Print button -->
        <button onclick="window.print()" class="mt-8 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Print This Page</button>
    </center>
</body>
</html>
