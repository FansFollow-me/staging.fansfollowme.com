@extends('layouts.app')
@section('title', 'My Reels')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">My Reels</h1>
    <a class="btn btn-ffm" href="{{ route('reels.create') }}">Upload</a>
</div>
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif
<div class="card card-ffm p-3">
    <table class="table table-dark table-sm mb-0">
        <thead><tr><th>Caption</th><th>Views</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse ($reels as $reel)
                <tr>
                    <td>{{ \Illuminate\Support\Str::limit($reel->caption ?? '', 40) }}</td>
                    <td>{{ number_format($reel->views) }}</td>
                    <td>{{ $reel->status }}</td>
                    <td><a href="{{ route('reels.show', $reel) }}">View</a></td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-secondary">No reels yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
