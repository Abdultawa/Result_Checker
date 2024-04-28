<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CheckResultController extends Controller
{
    public function show()
    {
        return view('welcome');
    }

    public function check(Request $request)
    {
        // Validate the form data
        $request->validate([
            'RegNo' => 'required|string',
            'Semester' => 'required|string',
        ]);
    
        // Retrieve the form data
        $regNo = $request->input('RegNo');
        $semester = $request->input('Semester');
    
        // Check if the result exists in the database
        $result = Result::where('RegNo', $regNo)->where('Semester', $semester)->first();
    
        // If the result does not exist, redirect back with an error message
        if (!$result) {
            return Redirect::route('welcome')->with('error', 'Result not found for the given registration number and semester.');
        }
    
        // If the result exists, redirect to the route that displays the result
        return Redirect::route('result', ['RegNo' => $regNo, 'Semester' => $semester]);
    }
    public function calculateGPA($results)
{
    // Define the grade values
    $grade = [
        'A' => 5,
        'AB'=>4.5,
        'B' => 4,
        'BC'=>3.5,
        'C' => 3,
        'CD'=>2.5,
        'D' => 2,
        'E' => 1,
        'F' => 0
    ];

    // Initialize variables to store total grade points and total credits
    $totalGradePoints = 0;
    $totalCredits = 0;

    // Loop through each result
    foreach ($results as $result) {
        // Check if Grade exists and is not empty
        if (isset($grade[$result->grade]) && $result->grade !== '') {
            // Assuming each result has a 'Grade' and 'Credits' property
            $gradeValue = $grade[ucwords($result->grade)];
            $credits = $result->credit;

            // Add to the total grade points and total credits
            $totalGradePoints += $gradeValue * $credits;
            $totalCredits += $credits;
        }
    }

    // Calculate GPA
    if ($totalCredits > 0) {
        $gpa = $totalGradePoints / $totalCredits;
    } else {
        $gpa = 0; // Handle division by zero
    }

    return $gpa;
}
public function showResult($RegNo, $Semester)
{
    // Fetch the student's results based on the registration number and semester
    $results = Result::where('RegNo', $RegNo)->where('Semester', $Semester)->get();

    // Calculate GPA
    $gpa = $this->calculateGPA($results);

    // Pass the results data, GPA, and grade array to the view and return the view
    return view('result.show', ['results' => $results, 'gpa' => $gpa]);
}
}
