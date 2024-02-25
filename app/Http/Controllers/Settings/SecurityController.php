<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SecurityController extends Controller
{
    public function index(Request $request)
    {
        return view('settings.security.index', [
            'user' => $request->user(),
        ]);
    }
}
