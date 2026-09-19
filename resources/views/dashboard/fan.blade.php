@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Hey, {{ $user->displayName() }}</h1>
        <p class="text-secondary mb-0">Your fan dashboard</p>
    </div>
    <a class="btn btn-ffm" href="{{ route('page.explore') }}">Explore creators</a>
    <a class="btn btn-outline-primary" href="{{ route('messages.index') }}">Messages</a>
</div>
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif
<div class="row g-3">
    <div class="col-md-3">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6 text-secondary">Wallet</h2>
            <p class="fs-4 fw-bold mb-2">${{ number_format(($user->wallet->balance ?? 0) / 100, 2) }}</p>
            <a class="btn btn-sm btn-ffm" href="{{ route('wallet.show') }}">Open wallet</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6 text-secondary">Shop</h2>
            <p class="small text-secondary mb-2">Digital products from creators</p>
            <a class="btn btn-sm btn-outline-primary" href="{{ route('shop.index') }}">Browse</a>
            <a class="small d-block mt-1" href="{{ route('shop.purchases') }}">My purchases</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6 text-secondary">Live</h2>
            <p class="small text-secondary mb-2">Public, group, and 1v1 rooms</p>
            <a class="btn btn-sm btn-outline-primary" href="{{ route('live.index') }}">Open live</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6 text-secondary">Creators</h2>
            <p class="small text-secondary mb-2">Follow and tip</p>
            <a class="btn btn-sm btn-outline-primary" href="{{ route('page.creators') }}">Directory</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6 text-secondary">Reels</h2>
            <p class="small text-secondary mb-2">Short clips from creators</p>
            <a class="btn btn-sm btn-outline-primary" href="{{ route('reels.index') }}">Watch reels</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6 text-secondary">Stories</h2>
            <p class="small text-secondary mb-2">24-hour updates</p>
            <a class="btn btn-sm btn-outline-primary" href="{{ route('stories.index') }}">View stories</a>
        </div>
    </div>
</div>
@endsection
