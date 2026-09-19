@extends('layouts.app')
@section('title', 'Live')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Live rooms</h1>
    @auth
        @if (auth()->user()->isCreator() || auth()->user()->isAdmin())
            <a class="btn btn-ffm" href="{{ route('live.create') }}">Start live</a>
        @endif
    @endauth
</div>
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif
@if ($rooms->isEmpty())
    <p class="text-secondary">No live rooms yet.</p>
@else
    <div class="row g-3">
        @foreach ($rooms as $room)
            <div class="col-md-4">
                <div class="card card-ffm p-3 h-100">
                    <div class="d-flex justify-content-between">
                        <span class="badge text-bg-{{ $room->status === 'live' ? 'danger' : 'secondary' }}">{{ strtoupper($room->status) }}</span>
                        <span class="badge text-bg-warning">{{ $room->access }}</span>
                    </div>
                    <h2 class="h6 mt-2">{{ $room->title }}</h2>
                    <div class="small text-secondary mb-2">{{ '@'.$room->creator->username }} · {{ $room->mode }}</div>
                    @if ($room->access === 'ppv')
                        <div class="mb-2">${{ number_format($room->price / 100, 2) }}</div>
                    @endif
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('live.show', $room) }}">Open</a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-3">{{ $rooms->links() }}</div>
@endif
@endsection
