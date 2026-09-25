@extends('layouts.app')
@section('title', $post->creator->displayName())

@section('content')
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

<div class="card card-ffm overflow-hidden col-lg-8 p-0">
    <div class="p-3 d-flex justify-content-between align-items-start">
        <div class="d-flex gap-2 align-items-center">
            <img src="{{ $post->creator->avatarUrl() }}" alt="" width="40" height="40" class="rounded-circle" style="object-fit:cover;">
            <div>
                <a href="{{ route('profile', $post->creator->username) }}" class="fw-semibold text-decoration-none">{{ $post->creator->displayName() }}</a>
                <div class="text-secondary small">{{ '@'.$post->creator->username }} · {{ $post->published_at?->diffForHumans() }}</div>
            </div>
        </div>
        @if ($post->is_paid)
            <span class="badge text-bg-warning">Paid ${{ number_format($post->price / 100, 2) }}</span>
        @endif
    </div>

    @if ($locked)
        <div class="p-5 text-center" style="min-height:280px;background:#0f172a;">
            <i class="fas fa-lock mb-2"></i>
            <p class="mb-2">This post is locked.</p>
            @auth
                <form method="POST" action="{{ route('posts.unlock', $post) }}" class="d-inline">
                    @csrf
                    <button class="btn btn-ffm" type="submit">
                        Unlock for ${{ number_format($post->price / 100, 2) }} (wallet)
                    </button>
                </form>
                <div class="small text-secondary mt-2">or subscribe to {{ '@'.$post->creator->username }}</div>
            @else
                <a class="btn btn-ffm" href="{{ route('login') }}">Log in to unlock</a>
            @endauth
        </div>
    @else
        @foreach ($post->media as $media)
            @if ($media->type === 'image')
                <img src="{{ $media->url() }}" alt="" class="w-100" style="max-height:640px;object-fit:cover;">
            @endif
        @endforeach
        @if ($post->body)
            <div class="p-3 fs-5" style="white-space: pre-wrap;">{{ $post->body }}</div>
        @endif
    @endif

    @auth
        @if (auth()->id() !== $post->creator_id)
            <details class="mt-4">
                <summary class="small text-secondary" style="cursor:pointer;">Report this post</summary>
                <form method="POST" action="{{ route('reports.store') }}" class="mt-2 row g-2">
                    @csrf
                    <input type="hidden" name="subject_type" value="post">
                    <input type="hidden" name="subject_id" value="{{ $post->id }}">
                    <div class="col-md-4">
                        <select class="form-select form-select-sm" name="reason">
                            <option value="spam">Spam</option>
                            <option value="abuse">Abuse</option>
                            <option value="nudity">Nudity</option>
                            <option value="fraud">Fraud</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control form-control-sm" name="details" maxlength="1000" placeholder="Optional details">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-sm btn-outline-warning w-100" type="submit">Report</button>
                    </div>
                </form>
            </details>
        @endif
    @endauth
</div>
@endsection
