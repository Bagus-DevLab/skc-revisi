<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyCertificatesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        
        // Ambil kursus yang statusnya 'finished' di tabel pivot enrollments
        $certificates = $user->courses()
                            ->wherePivot('status', 'finished')
                            ->get();

        return view('my-certificates', compact('certificates'));
    }
}
