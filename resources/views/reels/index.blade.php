@extends('layouts.app')
@section('title', 'Reels')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Reels</h1>
    @auth
        @if (auth()->user()->isCreator() || auth()->user()->isAdmin())
            <a class="btn btn-ffm" href="{{ route('reels.create') }}">Upload Reel</a>
        @endif
    @endauth
</div>
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif
@if ($reels->isEmpty())
    <p class="text-secondary">No reels yet.</p>
@else
    <div class="row g-3">
        @foreach ($reels as $reel)
            <div class="col-md-3">
                <div class="card card-ffm p-2 h-100">
                    @if ($reel->thumbnail_path)
                        <img src="{{ asset('storage/'.$reel->thumbnail_path) }}" class="img-fluid rounded" alt="">
                    @else
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="height:200px;">
                            <i class="fas fa-video fa-2x text-white"></i>
                        </div>
                    @endif
                    <div class="p-2">
                        <div class="small text-secondary">{{ $reel->creator->username }} · {{ number_format($reel->views) }} views</div>
                        <p class="small mb-1">{{ \Illuminate\Support\Str::limit($reel->caption ?? '', 60) }}</p>
                        <a class="small" href="{{ route('reels.show', $reel) }}">Watch</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-3">{{ $reels->links() }}</div>
@endif
@endsection
