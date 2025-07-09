<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccessibilityController extends Controller
{
    /**
     * Show the accessibility settings page.
     */
    public function edit(): View
    {
        return view('settings.accessibility');
    }

    /**
     * Update the user's accessibility settings.
     */
    public function update(Request $request)
    {
        // Note: Most accessibility settings are saved client-side in localStorage
        // This is intentional to make settings work even for guests
        // This method is for future server-side accessibility settings
        
        return back()->with('status', __('messages.settings_updated'));
    }
} 