@extends('layouts.app')
@section('title', 'Withdrawals')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Withdrawals</h1>
    <a class="btn btn-outline-primary" href="{{ route('wallet.show') }}">Wallet</a>
</div>
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-inline">
        <ul class="mb-0 small">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card card-ffm p-4 h-100">
            <div class="text-secondary small">Available balance</div>
            <div class="fs-3 fw-bold mb-3">${{ number_format($balance / 100, 2) }}</div>
            <form method="POST" action="{{ route('withdrawals.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Amount (USD cents, min $10)</label>
                    <input class="form-control" type="number" name="amount" min="1000" max="{{ $balance }}" value="{{ old('amount', min(5000, max(1000, $balance))) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Payout method</label>
                    <select class="form-select" name="method">
                        <option value="bank">Bank</option>
                        <option value="paypal">PayPal</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Account details</label>
                    <input class="form-control" name="details" maxlength="255" placeholder="IBAN / PayPal email" value="{{ old('details') }}">
                </div>
                <button class="btn btn-ffm" type="submit">Request withdrawal</button>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-ffm p-4 h-100">
            <h2 class="h6 mb-2">Payout FAQ</h2>
            <ul class="small text-secondary mb-0" style="padding-left:1.1rem;line-height:1.7;">
                <li><strong class="text-white">Hold:</strong> wallet funds are held as soon as you request a withdrawal.</li>
                <li><strong class="text-white">pending</strong> — submitted, under admin review</li>
                <li><strong class="text-white">processing</strong> — approved, payment being sent</li>
                <li><strong class="text-white">paid</strong> — admin marked sent; arrives in ~2–5 business days by method</li>
                <li><strong class="text-white">rejected</strong> — always includes a reason; funds returned to wallet</li>
            </ul>
        </div>
    </div>
</div>

<div class="card card-ffm p-3">
    <h2 class="h6">History</h2>
    @if ($requests->isEmpty())
        <p class="text-secondary mb-0">No requests yet.</p>
    @else
        <div class="table-responsive">
            <table class="table table-dark table-sm align-middle mb-0">
                <thead><tr><th>Amount</th><th>Method</th><th>Status</th><th>ETA</th><th>When</th></tr></thead>
                <tbody>
                    @foreach ($requests as $r)
                        @php
                            $badge = match($r->status) {
                                'paid' => 'success',
                                'rejected' => 'danger',
                                'processing' => 'info',
                                default => 'warning',
                            };
                            $label = match($r->status) {
                                'pending' => 'Submitted, under review',
                                'processing' => 'Approved, sending payment',
                                'paid' => 'Sent — arrives in 2–5 business days',
                                'rejected' => 'Rejected: '.($r->status_reason ?: 'see admin note'),
                                default => ucfirst($r->status),
                            };
                        @endphp
                        <tr>
                            <td>${{ number_format($r->amount / 100, 2) }}</td>
                            <td>{{ $r->method }}</td>
                            <td>
                                <span class="badge text-bg-{{ $badge }}">{{ $label }}</span>
                                @if ($r->status === 'rejected' && $r->status_reason)
                                    <div class="small text-danger mt-1">{{ $r->status_reason }}</div>
                                @endif
                            </td>
                            <td class="small">{{ $r->estimated_arrival?->toFormattedDateString() ?? '—' }}</td>
                            <td class="small text-secondary">{{ $r->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $requests->links() }}</div>
    @endif
</div>
@endsection
