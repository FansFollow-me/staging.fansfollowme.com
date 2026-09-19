@extends('layouts.app')
@section('title', 'My video messages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Custom video messages</h1>
    <a class="btn btn-outline-primary" href="{{ route('dashboard') }}">Dashboard</a>
</div>

@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

@if ($requests->isEmpty())
    <p class="text-secondary">No requests yet. Open a creator profile and send a request.</p>
@else
    <div class="card card-ffm p-0">
        @foreach ($requests as $req)
            <a class="d-flex justify-content-between align-items-center p-3 border-bottom border-secondary border-opacity-25 text-decoration-none"
               href="{{ route('video-messages.show', $req) }}">
                <div>
                    <div class="fw-semibold">
                        @if ($req->fan_id === $user->id)
                            To {{ '@'.$req->creator?->username }}
                        @else
                            From {{ '@'.$req->fan?->username }}
                        @endif
                    </div>
                    <div class="small text-secondary">{{ $req->occasion ?: 'Custom video' }} · ${{ number_format($req->price / 100, 2) }}</div>
                </div>
                <span class="badge text-bg-{{ $req->status === 'completed' ? 'success' : ($req->status === 'rejected' ? 'danger' : 'warning') }}">
                    {{ $req->status }}
                </span>
            </a>
        @endforeach
    </div>
    <div class="mt-3">{{ $requests->links() }}</div>
@endif
@endsection
