@extends('layouts.app')
@section('title', 'Earnings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Earnings</h1>
    <div class="d-flex gap-2">
        <a class="btn btn-sm btn-outline-primary" href="{{ route('withdrawals.index') }}">Withdrawals</a>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('wallet.show') }}">Wallet</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-ffm p-3">
            <div class="text-secondary small">Wallet balance</div>
            <div class="fs-4 fw-bold">${{ number_format($totals['balance'] / 100, 2) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3">
            <div class="text-secondary small">Lifetime tips</div>
            <div class="fs-4 fw-bold">${{ number_format($totals['tips'] / 100, 2) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3">
            <div class="text-secondary small">Lifetime shop</div>
            <div class="fs-4 fw-bold">${{ number_format($totals['sales'] / 100, 2) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3">
            <div class="text-secondary small">Active subs</div>
            <div class="fs-4 fw-bold">{{ $totals['active_subs'] }}</div>
        </div>
    </div>
</div>

<div class="card card-ffm p-4">
    <h2 class="h6 mb-3">Last 30 days</h2>
    @php
        $max = max(1, collect($chart)->max('total'));
    @endphp
    <div style="display:flex;align-items:flex-end;gap:3px;height:160px;">
        @foreach ($chart as $row)
            @php $h = (int) round(($row['total'] / $max) * 150); @endphp
            <div title="{{ $row['date'] }} · ${{ number_format($row['total']/100, 2) }}"
                 style="flex:1;background:linear-gradient(180deg,#f97316,#a855f7);height:{{ max(2, $h) }}px;border-radius:3px 3px 0 0;min-width:4px;"></div>
        @endforeach
    </div>
    <div class="d-flex justify-content-between small text-secondary mt-2">
        <span>30 days ago</span>
        <span>Today</span>
    </div>
    <p class="small text-secondary mt-3 mb-0">Chart = tips + shop sales + new sub prices per day. Wire Stripe for real cash flow.</p>
</div>
@endsection
