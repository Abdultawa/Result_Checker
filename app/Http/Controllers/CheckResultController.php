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
    public function showResult($RegNo, $Semester)
    {
        // Fetch the student's results based on the registration number and semester
        $results = Result::where('RegNo', $RegNo)->where('Semester', $Semester)->get();
        
        // Pass the results data to the view and return the view
        return view('result.show', ['results' => $results]);
    }
}
