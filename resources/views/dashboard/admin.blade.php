@extends('layouts.app')
@section('title', 'Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Admin</h1>
    <div class="d-flex gap-2">
        <a class="btn btn-outline-primary" href="{{ route('admin.members') }}">Members</a>
        <a class="btn btn-outline-primary" href="{{ route('admin.posts') }}">Posts</a>
        <a class="btn btn-outline-primary" href="{{ route('admin.reports') }}">Reports</a>
        <a class="btn btn-outline-primary" href="{{ route('admin.payments') }}">Payments</a>
        <a class="btn btn-outline-primary" href="{{ route('admin.gifts') }}">Gifts</a>
        <a class="btn btn-outline-primary" href="{{ route('admin.feature-requests') }}">Feedback</a>
        <a class="btn btn-ffm" href="{{ route('admin.withdrawals') }}">Withdrawals</a>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

<div class="row g-3">
    @foreach ([
        ['Users', $stats['users']],
        ['Creators', $stats['creators']],
        ['Fans', $stats['fans']],
        ['Posts', $stats['posts']],
        ['Active subs', $stats['active_subs']],
        ['Tip volume', '$'.number_format($stats['tips_volume']/100, 2)],
        ['Shop volume', '$'.number_format($stats['shop_volume']/100, 2)],
        ['Deposits', '$'.number_format($stats['deposits']/100, 2)],
    ] as [$label, $value])
        <div class="col-md-3">
            <div class="card card-ffm p-3">
                <div class="text-secondary small">{{ $label }}</div>
                <div class="fs-4 fw-bold">{{ $value }}</div>
            </div>
        </div>
    @endforeach
</div>
@endsection
