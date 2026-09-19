@extends('layouts.app')
@section('title', 'Explore')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Explore</h1>
    <div class="d-flex gap-2">
        <a class="btn btn-sm btn-outline-primary" href="{{ route('reels.index') }}">Reels</a>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('live.index') }}">Live</a>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('shop.index') }}">Shop</a>
    </div>
</div>
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

<h2 class="h5 mb-3">Creators</h2>
<div class="row g-3 mb-4">
    @forelse ($creators as $creator)
        <div class="col-md-3">
            <div class="card card-ffm p-3 h-100">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <img src="{{ $creator->profile?->avatar_path ? asset($creator->profile->avatar_path) : '/public/logo-monogram.png' }}" alt="" width="40" height="40" class="rounded-circle">
                    <div>
                        <a href="{{ route('profile', $creator->username) }}" class="fw-semibold">{{ '@'.$creator->username }}</a>
                        <div class="small text-secondary">{{ $creator->profile?->display_name }}</div>
                    </div>
                </div>
                <p class="small text-secondary flex-grow-1">{{ \Illuminate\Support\Str::limit($creator->profile?->bio ?? '', 70) }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="small text-warning">${{ number_format(($creator->creatorSettings?->subscription_price ?? 0) / 100, 2) }}/mo</span>
                    <a class="btn btn-sm btn-ffm" href="{{ route('profile', $creator->username) }}">View</a>
                </div>
            </div>
        </div>
    @empty
        <p class="text-secondary">No creators yet.</p>
    @endforelse
</div>
<div class="mb-4">{{ $creators->links() }}</div>

<h2 class="h5 mb-3">Latest posts</h2>
<div class="row g-3">
    @forelse ($posts as $post)
        <div class="col-md-4">
            <div class="card card-ffm p-3 h-100">
                <div class="small text-secondary mb-1">{{ '@'.$post->creator?->username }} · {{ $post->published_at?->diffForHumans() }}</div>
                <p class="mb-2">{{ \Illuminate\Support\Str::limit($post->body, 120) }}</p>
                @if ($post->is_paid)
                    <span class="badge text-bg-warning align-self-start">${{ number_format($post->price / 100, 2) }}</span>
                @else
                    <span class="badge text-bg-secondary align-self-start">Free</span>
                @endif
                <a class="small mt-2" href="{{ route('posts.show', $post) }}">Open</a>
            </div>
        </div>
    @empty
        <p class="text-secondary">No posts yet.</p>
    @endforelse
</div>
<div class="mt-3">{{ $posts->links() }}</div>
@endsection
