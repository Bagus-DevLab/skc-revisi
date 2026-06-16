<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotepadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('notepad');
    }
}
