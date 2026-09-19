@extends('layouts.app')
@section('title', 'Admin · Payments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Payments</h1>
    <a class="btn btn-outline-primary" href="{{ route('admin.dashboard') }}">Back</a>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card card-ffm p-3 mb-3">
            <h2 class="h6">Tips</h2>
            <table class="table table-dark table-sm mb-0">
                <thead><tr><th>From</th><th>To</th><th>Gift</th><th>Amount</th><th>When</th></tr></thead>
                <tbody>
                    @forelse ($tips as $tip)
                        <tr>
                            <td>{{ '@'.$tip->from?->username }}</td>
                            <td>{{ '@'.$tip->creator?->username }}</td>
                            <td>{{ $tip->gift_key ?: '—' }}</td>
                            <td>${{ number_format($tip->amount / 100, 2) }}</td>
                            <td class="small text-secondary">{{ $tip->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-secondary">No tips yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-ffm p-3 mb-3">
            <h2 class="h6">Shop sales</h2>
            <table class="table table-dark table-sm mb-0">
                <thead><tr><th>Product</th><th>Buyer</th><th>Amount</th></tr></thead>
                <tbody>
                    @forelse ($sales as $sale)
                        <tr>
                            <td class="small">{{ $sale->product?->title }}</td>
                            <td>{{ '@'.$sale->buyer?->username }}</td>
                            <td>${{ number_format($sale->amount / 100, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-secondary">No sales yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-ffm p-3 mb-3">
            <h2 class="h6">Subscriptions</h2>
            <table class="table table-dark table-sm mb-0">
                <thead><tr><th>Fan</th><th>Creator</th><th>Status</th><th>Price</th></tr></thead>
                <tbody>
                    @forelse ($subscriptions as $sub)
                        <tr>
                            <td>{{ '@'.$sub->fan?->username }}</td>
                            <td>{{ '@'.$sub->creator?->username }}</td>
                            <td>{{ $sub->status }}</td>
                            <td>${{ number_format($sub->price / 100, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-secondary">No subscriptions yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-ffm p-3 mb-3">
            <h2 class="h6">Deposits</h2>
            <table class="table table-dark table-sm mb-0">
                <thead><tr><th>Amount</th><th>When</th></tr></thead>
                <tbody>
                    @forelse ($deposits as $dep)
                        <tr>
                            <td>${{ number_format($dep->amount / 100, 2) }}</td>
                            <td class="small text-secondary">{{ $dep->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-secondary">No deposits yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
