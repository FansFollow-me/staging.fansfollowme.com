@extends('layouts.app')
@section('title', 'Video request')

@section('content')
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

<div class="card card-ffm p-4 col-lg-7">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h1 class="h4 mb-1">{{ $videoRequest->occasion ?: 'Custom video message' }}</h1>
            <p class="text-secondary small mb-0">
                Fan {{ '@'.$videoRequest->fan?->username }}
                → Creator {{ '@'.$videoRequest->creator?->username }}
                · ${{ number_format($videoRequest->price / 100, 2) }}
            </p>
        </div>
        <span class="badge text-bg-{{ $videoRequest->status === 'completed' ? 'success' : ($videoRequest->status === 'rejected' ? 'danger' : 'warning') }}">
            {{ $videoRequest->status }}
        </span>
    </div>

    <div class="mb-3">
        <div class="text-secondary small mb-1">Brief</div>
        <div style="white-space:pre-wrap;">{{ $videoRequest->brief }}</div>
    </div>

    @if ($videoRequest->status === 'completed' && $videoRequest->video_path)
        <video controls class="w-100 rounded mb-3" style="max-height:420px;">
            <source src="{{ asset('storage/'.$videoRequest->video_path) }}" type="video/mp4">
        </video>
        <a class="btn btn-ffm" href="{{ route('video-messages.download', $videoRequest) }}">Download video</a>
    @elseif (auth()->id() === $videoRequest->creator_id && in_array($videoRequest->status, ['pending', 'accepted'], true))
        <form method="POST" action="{{ route('video-messages.complete', $videoRequest) }}" enctype="multipart/form-data" class="mb-3">
            @csrf
            <div class="mb-3">
                <label class="form-label">Upload finished video (mp4, max 200MB)</label>
                <input class="form-control" type="file" name="video" accept="video/*" required>
                @error('video')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <button class="btn btn-ffm" type="submit">Deliver to fan</button>
        </form>
        <form method="POST" action="{{ route('video-messages.reject', $videoRequest) }}" onsubmit="return confirm('Reject and refund fan?')">
            @csrf
            <button class="btn btn-outline-danger" type="submit">Reject & refund</button>
        </form>
    @elseif ($videoRequest->status === 'pending')
        <p class="text-secondary mb-0">Waiting on creator to record…</p>
    @endif
</div>
@endsection
