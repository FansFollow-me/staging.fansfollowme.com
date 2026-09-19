<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'subject_type' => ['required', 'in:post,user'],
            'subject_id' => ['required', 'integer'],
            'reason' => ['required', 'in:spam,abuse,nudity,fraud,other'],
            'details' => ['nullable', 'string', 'max:1000'],
        ]);

        $exists = match ($data['subject_type']) {
            'post' => Post::whereKey($data['subject_id'])->exists(),
            'user' => User::whereKey($data['subject_id'])->exists(),
            default => false,
        };

        if (! $exists) {
            return back()->withErrors(['subject_id' => 'Report target not found']);
        }

        Report::create([
            'reporter_id' => $request->user()->id,
            'subject_type' => $data['subject_type'],
            'subject_id' => $data['subject_id'],
            'reason' => $data['reason'],
            'details' => $data['details'] ?? null,
            'status' => 'open',
        ]);

        return back()->with('status', 'Report submitted. Thank you.');
    }

    public function adminIndex(): View
    {
        $reports = Report::with('reporter')
            ->latest()
            ->paginate(25);

        return view('admin.reports', compact('reports'));
    }

    public function resolve(Request $request, Report $report): RedirectResponse
    {
        $data = $request->validate([
            'action' => ['required', 'in:dismiss,remove_content,suspend_user'],
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $note = $data['admin_note'] ?? null;

        if ($data['action'] === 'remove_content' && $report->subject_type === 'post') {
            Post::whereKey($report->subject_id)->delete();
            $note = trim(($note ? $note.' ' : '').'Post removed by admin.');
        }

        if ($data['action'] === 'suspend_user') {
            $userId = $report->subject_type === 'user'
                ? $report->subject_id
                : Post::withTrashed()->whereKey($report->subject_id)->value('creator_id');

            if ($userId) {
                User::whereKey($userId)->where('role', '!=', 'admin')->update(['status' => 'suspended']);
                $note = trim(($note ? $note.' ' : '').'User suspended.');
                $target = User::find((int) $userId);
                if ($target) {
                    app(\App\Services\NotificationService::class)->push(
                        $target,
                        'moderation',
                        'Account suspended',
                        'Contact support if this is a mistake.'
                    );
                }
            }
        }

        $report->update([
            'status' => $data['action'] === 'dismiss' ? 'dismissed' : 'actioned',
            'admin_note' => $note,
            'resolved_at' => now(),
        ]);

        return back()->with('status', 'Report resolved');
    }
}
