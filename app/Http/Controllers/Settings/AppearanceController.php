<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppearanceController extends Controller
{
    /**
     * Display the appearance settings page.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('settings.appearance.index');
    }
}