@extends('layouts.app')
@section('title', 'Reel')

@section('content')
<div class="card card-ffm p-4 col-lg-8">
    <video controls class="w-100 rounded mb-3" style="max-height:70vh;">
        <source src="{{ \App\Support\UploadStorage::publicUrl($reel->video_path) }}" type="video/mp4">
    </video>
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <a href="{{ route('profile', $reel->creator->username) }}" class="fw-semibold">{{ '@'.$reel->creator->username }}</a>
            <p class="text-secondary mb-0">{{ $reel->caption }}</p>
        </div>
        <span class="badge text-bg-secondary">{{ number_format($reel->views) }} views</span>
    </div>
</div>
@endsection
