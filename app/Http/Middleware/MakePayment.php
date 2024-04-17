<?php

namespace App\Http\Middleware;

use App\Models\Result;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MakePayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $regNo = $request->route('regNo');
        
        // Retrieve the student's result based on the registration number
        $result = Result::where('RegNo', $regNo)->first();

        // Check if the result exists and if the student's level is 400
        if ($result && $result->level == 400) {
            // If the student's level is 400, allow the request to proceed
            return $next($request);
        } else {
            // If the student's level is not 400, deny access with a 403 error
            return abort(403, 'Unauthorized');
        }
    }
}
