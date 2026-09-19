<?php

namespace App\Http\Controllers;

use App\Models\WithdrawalRequest;
use App\Services\WalletService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WithdrawalController extends Controller
{
    public function __construct(private WalletService $wallets)
    {
    }

    public function index(Request $request): View
    {
        $requests = WithdrawalRequest::where('creator_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return view('withdrawals.index', [
            'requests' => $requests,
            'balance' => $request->user()->wallet?->balance ?? 0,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'integer', 'min:1000', 'max:100000000'],
            'method' => ['required', 'in:bank,paypal,other'],
            'details' => ['nullable', 'string', 'max:255'],
        ]);

        $user = $request->user();
        $balance = $user->wallet?->balance ?? 0;

        if ($data['amount'] > $balance) {
            return back()->withErrors(['amount' => 'Amount exceeds wallet balance']);
        }

        // Hold funds + create request atomically so a create failure cannot orphan a debit
        try {
            DB::transaction(function () use ($user, $data) {
                $this->wallets->debit($user, (int) $data['amount'], 'withdrawal_hold', null, null, [
                    'method' => $data['method'],
                ]);

                WithdrawalRequest::create([
                    'creator_id' => $user->id,
                    'amount' => (int) $data['amount'],
                    'currency' => 'USD',
                    'method' => $data['method'],
                    'payout_method' => $data['method'],
                    'details' => $data['details'] ?? null,
                    'status' => 'pending',
                    'requested_at' => now(),
                    'estimated_arrival' => now()->addWeekdays(5),
                ]);
            });
        } catch (\RuntimeException $e) {
            return back()->withErrors(['amount' => 'Insufficient balance']);
        }

        return back()->with('status', 'Withdrawal requested — funds held; admin review next');
    }

    public function adminIndex(Request $request): View
    {
        $requests = WithdrawalRequest::with('creator')
            ->latest()
            ->paginate(25);

        return view('admin.withdrawals', compact('requests'));
    }

    public function approve(Request $request, WithdrawalRequest $withdrawal): RedirectResponse
    {
        if (! in_array($withdrawal->status, ['pending', 'processing'], true)) {
            return back()->withErrors(['withdrawal' => 'Already processed']);
        }

        $withdrawal->update([
            'status' => 'paid',
            'processed_at' => now(),
            'estimated_arrival' => now()->addWeekdays(5),
        ]);

        app(\App\Services\NotificationService::class)->push(
            $withdrawal->creator,
            'withdrawal_approved',
            'Withdrawal paid',
            '$'.number_format($withdrawal->amount / 100, 2).' sent via '.$withdrawal->method.' — arrives in 2–5 business days.'
        );

        return back()->with('status', 'Marked paid');
    }

    public function reject(Request $request, WithdrawalRequest $withdrawal): RedirectResponse
    {
        if (! in_array($withdrawal->status, ['pending', 'processing'], true)) {
            return back()->withErrors(['withdrawal' => 'Already processed']);
        }

        $data = $request->validate([
            'status_reason' => ['required', 'string', 'max:255'],
        ]);

        $this->wallets->credit(
            $withdrawal->creator,
            $withdrawal->amount,
            'withdrawal_refund',
            'withdrawal',
            $withdrawal->id
        );

        $withdrawal->update([
            'status' => 'rejected',
            'status_reason' => $data['status_reason'],
            'processed_at' => now(),
        ]);

        app(\App\Services\NotificationService::class)->push(
            $withdrawal->creator,
            'withdrawal_rejected',
            'Withdrawal rejected',
            $data['status_reason'],
        );

        return back()->with('status', 'Rejected — funds returned to wallet');
    }
}
