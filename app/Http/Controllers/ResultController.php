<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function show()
    {
        return view('dashboard');
    }
    public function store(Request $request)
{
    $request->validate([
        'import' => 'required|file|mimes:csv,txt|max:2048', // Adjust max file size as needed
    ]);

    if ($request->hasFile('import')) {
        $file = $request->file('import');
        $fileName = $file->getClientOriginalName(); // Retrieve the original file name

        // Move the uploaded file to a temporary location
        $file->move(storage_path('app/public'), $fileName);

        // Read the CSV file and insert data into the database
        if (($handle = fopen(storage_path('app/public/') . $fileName, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                Result::create([
                    'studentName' => $row[0],
                    'regNo' => $row[1],
                    'course' => $row[2],
                    'semester' => $row[3],
                    'grade' => $row[4],
                    'credit' => $row[5],
                    'point' => $row[6],
                    'level' => $row[7]
                ]);
            }
            fclose($handle);

            // Delete the uploaded file after processing
            unlink(storage_path('app/public/') . $fileName);

            return redirect()->back()->with('success', 'Data imported successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to read the CSV file');
        }
    }

    return redirect()->back()->with('error', 'No file uploaded');
}

        public function deleteResults()
        {
            // Delete all results from the results table
            Result::truncate();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'All results have been deleted successfully.');
        }

}
