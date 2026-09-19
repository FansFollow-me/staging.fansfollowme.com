@extends('layouts.app')
@section('title', 'Chat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">{{ '@'.$other?->username ?? 'Chat' }}</h1>
    <a class="btn btn-sm btn-outline-primary" href="{{ route('messages.index') }}">Inbox</a>
</div>

<div class="card card-ffm p-3 mb-3" style="max-height:50vh;overflow-y:auto;">
    @forelse ($messages as $message)
        <div class="mb-2 {{ $message->user_id === auth()->id() ? 'text-end' : '' }}">
            <div class="d-inline-block text-start px-3 py-2 rounded-3"
                 style="max-width:75%;background:{{ $message->user_id === auth()->id() ? 'rgba(249,115,22,.25)' : 'rgba(255,255,255,.06)' }};">
                <div class="small" style="white-space: pre-wrap;">{{ $message->body }}</div>
                <div class="small text-secondary mt-1" style="font-size:.7rem;">{{ $message->created_at->diffForHumans() }}</div>
            </div>
        </div>
    @empty
        <p class="text-secondary mb-0">Say hello.</p>
    @endforelse
</div>

<form method="POST" action="{{ route('messages.send', $conversation) }}" class="d-flex gap-2">
    @csrf
    <input class="form-control" name="body" required maxlength="5000" placeholder="Write a message…">
    <button class="btn btn-ffm" type="submit">Send</button>
</form>
@endsection
