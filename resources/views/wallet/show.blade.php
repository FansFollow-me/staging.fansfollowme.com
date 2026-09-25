@extends('layouts.app')
@section('title', 'Wallet')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Wallet</h1>
    <a class="btn btn-outline-primary" href="{{ route('dashboard') }}">Dashboard</a>
</div>

@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card card-ffm p-4">
            <div class="text-secondary small">Balance</div>
            <div class="fs-2 fw-bold">${{ number_format(($user->wallet->balance ?? 0) / 100, 2) }}</div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card card-ffm p-4">
            <h2 class="h6">Add funds</h2>
            <p class="small text-secondary">Test card: 4242 4242 4242 4242 &middot; any future date &middot; any CVC. Amount is in cents (1000 = $10).</p>
            <form method="POST" action="{{ route('wallet.add-funds') }}" class="d-flex gap-2 flex-wrap">
                @csrf
                <input class="form-control" style="max-width:160px" type="number" name="amount" min="100" step="100" value="1000" required>
                <button class="btn btn-ffm" type="submit">Pay with card</button>
            </form>
            @error('amount')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

<div class="card card-ffm p-4">
    <h2 class="h6 mb-3">Transactions</h2>
    @if ($transactions->isEmpty())
        <p class="text-secondary mb-0">No transactions yet.</p>
    @else
        <div class="table-responsive">
            <table class="table table-dark table-sm align-middle mb-0">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Balance</th>
                        <th>When</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $tx)
                        <tr>
                            <td>{{ $tx->type }}</td>
                            <td class="{{ $tx->amount >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $tx->amount >= 0 ? '+' : '' }}${{ number_format(abs($tx->amount) / 100, 2) }}
                            </td>
                            <td>${{ number_format($tx->balance_after / 100, 2) }}</td>
                            <td class="text-secondary small">{{ $tx->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $transactions->links() }}</div>
    @endif
</div>
@endsection
