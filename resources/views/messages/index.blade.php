@extends('layouts.app')
@section('title', 'Messages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Messages</h1>
    <a class="btn btn-outline-primary" href="{{ route('dashboard') }}">Dashboard</a>
</div>

@if ($conversations->isEmpty())
    <p class="text-secondary">No conversations yet. Open a creator profile and start a chat.</p>
@else
    <div class="card card-ffm p-0">
        @foreach ($conversations as $row)
            <a class="d-flex justify-content-between align-items-center p-3 border-bottom border-secondary border-opacity-25 text-decoration-none"
               href="{{ route('messages.show', $row['conversation']) }}">
                <div>
                    <div class="fw-semibold">@{{ $row['other']?->username ?? 'Unknown' }}</div>
                    <div class="small text-secondary">{{ \Illuminate\Support\Str::limit($row['last']->body ?? '', 50) }}</div>
                </div>
                @if ($row['unread'] > 0)
                    <span class="badge text-bg-warning">{{ $row['unread'] }}</span>
                @endif
            </a>
        @endforeach
    </div>
@endif
@endsection
