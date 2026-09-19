@extends('layouts.app')
@section('title', 'Creator Studio')

@section('content')
@php
    $giftCount = \App\Models\Tip::where('to_creator_id', $user->id)->count();
    $giftVolume = (int) \App\Models\Tip::where('to_creator_id', $user->id)->sum('amount');
    $pendingVideos = \App\Models\VideoRequest::where('creator_id', $user->id)->where('status', 'pending')->count();
    $pendingWithdrawals = \App\Models\WithdrawalRequest::where('creator_id', $user->id)->where('status', 'pending')->count();
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Creator Studio</h1>
        <p class="text-secondary mb-0">{{ $user->displayName() }}</p>
    </div>
    <div class="d-flex gap-2">
        <a class="btn btn-outline-primary" href="{{ route('messages.index') }}">Messages</a>
        <a class="btn btn-outline-primary" href="{{ route('wallet.show') }}">Wallet</a>
        <a class="btn btn-ffm" href="{{ route('profile', $user->username) }}">View profile</a>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6 text-secondary">Subscription</h2>
            <p class="fs-4 fw-bold mb-1">${{ number_format(($user->creatorSettings?->subscription_price ?? 0) / 100, 2) }}/mo</p>
            <a class="small" href="{{ route('settings.page') }}">Edit profile</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6 text-secondary">Wallet</h2>
            <p class="fs-4 fw-bold mb-1">${{ number_format(($user->wallet->balance ?? 0) / 100, 2) }}</p>
            <a class="small" href="{{ route('wallet.show') }}">Transactions</a>
            @if ($pendingWithdrawals > 0)
                <div class="small text-warning mt-1">{{ $pendingWithdrawals }} withdrawal pending</div>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6 text-secondary">Gifts received</h2>
            <p class="fs-4 fw-bold mb-1">{{ $giftCount }}</p>
            <p class="small text-secondary mb-1">${{ number_format($giftVolume / 100, 2) }} volume</p>
            <a class="btn btn-sm btn-ffm" href="{{ route('gifts.inbox') }}">Open inbox</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6 text-secondary">Video requests</h2>
            <p class="fs-4 fw-bold mb-1">{{ $pendingVideos }}</p>
            <p class="small text-secondary mb-1">waiting to record</p>
            <a class="btn btn-sm btn-ffm" href="{{ route('video-messages.mine') }}">Open requests</a>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6 text-secondary">QR join</h2>
            <p class="small text-secondary mb-2">In-person signups</p>
            <a class="btn btn-sm btn-ffm" href="{{ route('join.my-qr') }}">My QR</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6 text-secondary">Live 4K</h2>
            <p class="small text-secondary mb-2">Public / group / 1v1</p>
            <a class="btn btn-sm btn-ffm" href="{{ route('live.create') }}">Start live</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6 text-secondary">Analytics</h2>
            <p class="small text-secondary mb-2">Earnings by source + posts</p>
            <a class="btn btn-sm btn-ffm" href="{{ route('analytics.show') }}">Open analytics</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6 text-secondary">Video pricing</h2>
            <p class="small text-secondary mb-2">3 tiers + brand promo</p>
            <a class="btn btn-sm btn-ffm" href="{{ route('settings.video-pricing') }}">Set prices</a>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6">Content</h2>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('posts.index') }}">My posts</a>
                <a href="{{ route('posts.create') }}">New post</a>
                <a href="{{ route('stories.create') }}">Add story</a>
                <a href="{{ route('reels.create') }}">Upload reel</a>
                <a href="{{ route('reels.mine') }}">My reels</a>
                <a href="{{ route('live.index') }}">Live rooms</a>
                <a href="{{ route('gifts.inbox') }}">Gifts received</a>
                <a href="{{ route('settings.video-pricing') }}">Video pricing</a>
                <a href="{{ route('video-messages.mine') }}">Video requests</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6">Shop</h2>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('shop.index') }}">Browse shop</a>
                <a href="{{ route('shop.mine') }}">My products</a>
                <a href="{{ route('shop.create') }}">Add product</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-ffm p-3 h-100">
            <h2 class="h6">Growth</h2>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('join.my-qr') }}">QR analytics</a>
                <a href="{{ route('vault.index') }}">Vault</a>
                <a href="{{ route('referrals.index') }}">Referrals</a>
                <a href="{{ route('earnings.show') }}">Earnings</a>
                <a href="{{ route('analytics.show') }}">Analytics</a>
                <a href="{{ route('age-verification.show') }}">Age verify</a>
                <a href="{{ route('profile', $user->username) }}">Public profile</a>
                <a href="{{ route('messages.index') }}">Inbox</a>
            </div>
        </div>
    </div>
</div>
@endsection
