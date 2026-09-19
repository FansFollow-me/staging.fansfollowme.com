@extends('layouts.app')
@section('title', 'Story')

@section('content')
<div class="card card-ffm p-4 col-lg-6 mx-auto">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <a href="{{ route('profile', $story->creator->username) }}" class="fw-semibold">{{ '@'.$story->creator->username }}</a>
        <span class="small text-secondary">{{ $story->expires_at?->diffForHumans() }}</span>
    </div>
    @if ($story->type === 'text')
        <div class="p-4 rounded-3 text-center" style="background:rgba(255,255,255,.06);min-height:200px;">
            <p class="lead mb-0">{{ $story->body }}</p>
        </div>
    @else
        @if ($story->media_path)
            @if (str_contains($story->media_path, '.mp4') || str_contains($story->media_path, '.webm'))
                <video controls class="w-100 rounded">
                    <source src="{{ asset('storage/'.$story->media_path) }}" type="video/mp4">
                </video>
            @else
                <img src="{{ asset('storage/'.$story->media_path) }}" class="img-fluid rounded" alt="">
            @endif
        @endif
        @if ($story->body)
            <p class="mt-3">{{ $story->body }}</p>
        @endif
    @endif
</div>
@endsection
