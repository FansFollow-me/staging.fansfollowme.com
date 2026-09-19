@extends('layouts.app')
@section('title', 'Notifications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Notifications</h1>
    <form method="POST" action="{{ route('notifications.readAll') }}">
        @csrf
        <button class="btn btn-sm btn-outline-primary" type="submit">Mark all read</button>
    </form>
</div>
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

@if ($notifications->isEmpty())
    <p class="text-secondary">No notifications yet.</p>
@else
    <div class="card card-ffm p-0">
        @foreach ($notifications as $n)
            <div class="d-flex justify-content-between align-items-start p-3 border-bottom border-secondary border-opacity-25 {{ $n->read_at ? 'opacity-75' : '' }}">
                <div>
                    <div class="fw-semibold">{{ $n->title }}</div>
                    @if ($n->body)
                        <div class="small text-secondary">{{ $n->body }}</div>
                    @endif
                    <div class="small text-secondary" style="font-size:.7rem;">{{ $n->created_at->diffForHumans() }}</div>
                </div>
                @unless ($n->read_at)
                    <form method="POST" action="{{ route('notifications.read', $n) }}">
                        @csrf
                        <button class="btn btn-sm btn-link text-warning" type="submit">Mark read</button>
                    </form>
                @endunless
            </div>
        @endforeach
    </div>
    <div class="mt-3">{{ $notifications->links() }}</div>
@endif
@endsection
