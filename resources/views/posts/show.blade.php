@extends('layouts.app')
@section('title', 'Post')

@section('content')
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

<div class="card card-ffm p-4 col-lg-8">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <div class="text-secondary small">{{ $post->type->value }} · {{ $post->published_at?->diffForHumans() }}</div>
            <a href="{{ route('profile', $post->creator->username) }}" class="fw-semibold">{{ $post->creator->displayName() }}</a>
        </div>
        @if ($post->is_paid)
            <span class="badge text-bg-warning">Paid ${{ number_format($post->price / 100, 2) }}</span>
        @else
            <span class="badge text-bg-secondary">Free</span>
        @endif
    </div>

    @if ($post->media->isNotEmpty())
        @foreach ($post->media as $media)
            @if ($media->type === 'image')
                <img src="{{ asset('storage/'.$media->path) }}" alt="" class="img-fluid rounded-3 mb-3">
            @else
                <p class="text-secondary small">Media: {{ $media->path }}</p>
            @endif
        @endforeach
    @endif

    @if ($locked)
        <div class="alert alert-warning">
            <p class="mb-2">This post is locked.</p>
            @auth
                <form method="POST" action="{{ route('posts.unlock', $post) }}" class="d-inline">
                    @csrf
                    <button class="btn btn-ffm" type="submit">
                        Unlock for ${{ number_format($post->price / 100, 2) }} (wallet)
                    </button>
                </form>
                <span class="small text-secondary ms-2">or subscribe to {{ $post->creator->username }}</span>
            @else
                <a href="{{ route('login') }}">Log in</a> to unlock.
            @endauth
        </div>
    @else
        <div class="fs-5" style="white-space: pre-wrap;">{{ $post->body }}</div>
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
