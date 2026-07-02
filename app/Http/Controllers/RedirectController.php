<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function handle($code, Request $request)
    {
        $link = Link::where('short_code', $code)->firstOrFail();

        $link->clicks()->create([
            'ip_address' => $request->ip(),
            'clicked_at' => now(),
        ]);

        return redirect()->away($link->original_url);
    }
}
