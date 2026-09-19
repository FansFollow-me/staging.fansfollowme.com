<?php

namespace App\Http\Controllers;

use App\Models\FeatureRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComingSoonController extends Controller
{
    /**
     * Product roadmap teaser — no trademarked brand names.
     * Competitions / leagues / custom video messages.
     */
    public function show(): View
    {
        return view('coming-soon.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'feature' => ['required', 'string', 'max:80'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        FeatureRequest::create([
            'user_id' => $request->user()?->id,
            'feature' => $data['feature'],
            'message' => $data['message'] ?? null,
            'source' => 'coming_soon',
        ]);

        return back()->with('status', 'Thanks — your feedback was recorded.');
    }
}
