@extends('layouts.app')
@section('title', 'Join '.$creator->username)

@section('content')
@php
    $price = (int) ($creator->creatorSettings?->subscription_price ?? 0);
    $isPaid = $price > 0;
@endphp

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-ffm p-4 text-center">
            <img src="{{ $creator->profile?->avatar_path ? asset($creator->profile->avatar_path) : '/public/logo-monogram.png' }}" alt="" width="88" height="88" class="rounded-circle mx-auto mb-3">
            <h1 class="h4 mb-1">Join {{ $creator->displayName() }} on FansFollow</h1>
            <p class="text-secondary mb-3">
                @if ($creator->profile?->bio)
                    {{ \Illuminate\Support\Str::limit($creator->profile->bio, 120) }}
                @else
                    You scanned their QR — sign up in 30 seconds.
                @endif
            </p>

            @if ($isPaid)
                <div class="badge text-bg-warning mb-3 px-3 py-2">
                    Paid membership · ${{ number_format($price / 100, 2) }}/mo
                </div>
                <p class="small text-secondary mb-3">Sign up free, then subscribe to unlock full access.</p>
            @else
                <div class="badge text-bg-success mb-3 px-3 py-2">Free to follow</div>
            @endif

            <div class="d-grid gap-2">
                <a class="btn btn-ffm" href="{{ route('register', ['join_code' => $link->code]) }}">
                    Sign up free
                </a>
                <a class="btn btn-outline-primary" href="{{ route('login') }}?join_code={{ $link->code }}">
                    I already have an account
                </a>
            </div>
            <p class="small text-secondary mt-3 mb-0">After signup you’ll land on {{ '@'.$creator->username }}’s page.</p>
        </div>
    </div>
</div>
@endsection
