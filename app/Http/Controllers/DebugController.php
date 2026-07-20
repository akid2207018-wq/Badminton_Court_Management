<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class DebugController extends Controller
{
    public function show(Request $request): View
    {
        $visitCount = $request->session()->get('visit_count', 0);
        $request->session()->put('visit_count', $visitCount + 1);
        $request->session()->put('last_visit', now()->format('Y-m-d h:i:s A'));

        $lastCourt = Cookie::get('last_court', 'None yet');

        return view('debug.cookies-sessions', [
            'visitCount' => $request->session()->get('visit_count'),
            'lastVisit'  => $request->session()->get('last_visit'),
            'lastCourt'  => $lastCourt,
        ]);
    }

    public function resetSession(Request $request)
    {
        $request->session()->forget('visit_count');
        $request->session()->forget('last_visit');

        return redirect()->route('debug.cookies-sessions')
            ->with('success', 'Session cleared. Visit count reset to 0.');
    }

    public function clearCookie()
    {
        Cookie::forget('last_court');

        return redirect()->route('debug.cookies-sessions')
            ->with('success', 'Cookie cleared. No last viewed court.');
    }
}
