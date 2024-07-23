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
            'level' => 'required'
        ]);

        // Retrieve the form data
        $regNo = $request->input('RegNo');
        $semester = $request->input('Semester');
        $level = $request->input('level');

        // Check if the result exists in the database
        $result = Result::where('RegNo', $regNo)->where('Semester', $semester)->where('level', $level)->first();

        // If the result does not exist, redirect back with an error message
        if (!$result) {
            return Redirect::route('welcome')->with('error', 'Result not found for the given registration number and semester.');
        }

        // If the result exists, redirect to the route that displays the result
        return Redirect::route('result', ['RegNo' => $regNo, 'Semester' => $semester, 'level' => $level]);
    }
    public function calculateGPA($results, $previousResults = [])
    {
        // Define the grade values
        $grade = [
            'A' => 5,
            'AB' => 4.5,
            'B' => 4,
            'BC' => 3.5,
            'C' => 3,
            'CD' => 2.5,
            'D' => 2,
            'E' => 1,
            'F' => 0
        ];
    
        // Initialize variables to store total grade points and total credits
        $totalGradePoints = 0;
        $totalCredits = 0;
    
        // Loop through each result of the current semester
        foreach ($results as $result) {
            // Check if Grade exists and is not empty
            if (isset($grade[$result->grade]) && $result->grade !== '') {
                // Assuming each result has a 'grade' and 'credits' property
                $gradeValue = $grade[ucwords($result->grade)];
                $credits = $result->credit;
    
                // Add to the total grade points and total credits
                $totalGradePoints += $gradeValue * $credits;
                $totalCredits += $credits;
            }
        }
    
        // Loop through each result of the previous semesters
        foreach ($previousResults as $result) {
            // Check if Grade exists and is not empty
            if (isset($grade[$result->grade]) && $result->grade !== '') {
                // Assuming each result has a 'grade' and 'credits' property
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
    
    public function showResult($RegNo, $Semester, $level)
    {
        // Fetch the student's results for the current semester and level
        $currentResults = Result::where('RegNo', $RegNo)->where('Semester', $Semester)->where('level', $level)->get();
    
        // Fetch the student's results for all previous semesters and levels
        $previousResults = Result::where('RegNo', $RegNo)
                                  ->where(function($query) use ($Semester, $level) {
                                      $query->where('Semester', '<', $Semester)
                                            ->orWhere('level', '<', $level);
                                  })
                                  ->get();
    
        // Calculate GPA including both current and previous results
        $gpa = $this->calculateGPA($currentResults, $previousResults);
    
        // Pass the results data, GPA, and grade array to the view and return the view
        return view('result.show', ['results' => $currentResults, 'gpa' => $gpa]);
    }
    
}
