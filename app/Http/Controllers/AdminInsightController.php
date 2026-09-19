<?php

namespace App\Http\Controllers;

use App\Models\FeatureRequest;
use App\Models\Tip;
use App\Models\VideoRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminInsightController extends Controller
{
    public function featureRequests(Request $request): View
    {
        $requests = FeatureRequest::with('user')
            ->latest()
            ->paginate(30);

        $totals = FeatureRequest::query()
            ->selectRaw('feature, COUNT(*) as c')
            ->groupBy('feature')
            ->orderByDesc('c')
            ->get();

        return view('admin.feature-requests', compact('requests', 'totals'));
    }

    public function gifts(Request $request): View
    {
        $tips = Tip::with(['from', 'creator'])
            ->latest()
            ->paginate(30);

        $videoRequests = VideoRequest::with(['fan', 'creator'])
            ->latest()
            ->limit(20)
            ->get();

        return view('admin.gifts', compact('tips', 'videoRequests'));
    }
}
