@extends('layouts.app')
@section('title', $room->title)

@section('content')
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-inline">
        <ul class="mb-0 small">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card card-ffm p-4">
            <div class="d-flex gap-2 mb-2 flex-wrap">
                <span class="badge text-bg-{{ $room->status === 'live' ? 'danger' : 'secondary' }}">{{ strtoupper($room->status) }}</span>
                <span class="badge text-bg-warning">{{ $room->access }}</span>
                <span class="badge text-bg-secondary">{{ $room->mode }}</span>
                @if ($room->allow_4k)
                    <span class="badge text-bg-info">4K ready</span>
                @endif
            </div>
            <h1 class="h3">{{ $room->title }}</h1>
            <p class="text-secondary">{{ $room->description }}</p>
            <div class="mb-3">Hosted by <a href="{{ route('profile', $room->creator->username) }}">{{ '@'.$room->creator->username }}</a></div>

            @if ($canJoin)
                <div class="alert alert-success alert-inline mb-3">
                    You can join this room.
                    <div class="small mt-1 text-secondary">Stream player connects when Agora keys are configured. Gifts work now.</div>
                </div>
                @auth
                    @if (auth()->id() !== $room->creator_id)
                        @include('partials.tip-gifts', ['profileUser' => $room->creator])
                    @endif
                @endauth
            @else
                <div class="alert alert-warning alert-inline">
                    @guest
                        <a href="{{ route('login') }}">Log in</a> to join.
                    @else
                        @if ($room->access === 'subscribers_only')
                            Subscribe to {{ '@'.$room->creator->username }} to join.
                        @elseif ($room->access === 'ppv')
                            This room requires a ${{ number_format($room->price / 100, 2) }} ticket.
                        @else
                            You cannot join this room.
                        @endif
                    @endguest
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card card-ffm p-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <h2 class="h6 mb-0">Live gift wall</h2>
                <a href="{{ route('gifts.showcase') }}" class="small">Preview FX</a>
            </div>
            <div id="live-gift-feed" class="gif-wall" style="max-height:420px;overflow-y:auto;">
                @forelse ($recentTips as $tip)
                    @php
                        $meta = \App\Support\TipCatalog::forKey($tip->gift_key);
                        $tier = (int) ($meta['tier'] ?? 1);
                        $cls = $tier >= 9 ? 'tier-legend' : ($tier >= 7 ? 'tier-high' : '');
                    @endphp
                    <div class="gif-wall-item {{ $cls }}">
                        <span class="gif-wall-emoji">{{ $meta['emoji'] ?? '💸' }}</span>
                        <div class="gif-wall-body">
                            <div class="gif-wall-user">{{ '@'.($tip->from?->username ?? 'Someone') }}</div>
                            <div class="gif-wall-gift">{{ $meta['label'] ?? 'a tip' }}</div>
                        </div>
                        <span class="gif-wall-amt">${{ number_format($tip->amount / 100, 0) }}</span>
                    </div>
                @empty
                    <p class="text-secondary small mb-0">No gifts yet — be first.</p>
                @endforelse
            </div>
            <div class="small text-secondary mt-2">On-stream animation hooks up when Agora is live.</div>
        </div>
    </div>
</div>
@endsection
