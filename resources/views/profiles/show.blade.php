@extends('layouts.app')
@section('title', $profileUser->displayName())

@section('content')
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-inline">
        <ul class="mb-0 small">@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
    </div>
@endif

@php
    $subPrice = (int) ($profileUser->creatorSettings?->subscription_price ?? 0);
    $isPaidCreator = $profileUser->isCreator() && $subPrice > 0;
@endphp

@auth
    @if ($isPaidCreator && auth()->id() !== $profileUser->id && empty($isSubscribed))
        <div class="card mb-3 p-0 overflow-hidden" style="background: linear-gradient(135deg, #f97316 0%, #ec4899 48%, #a855f7 100%); border: none;">
            <div class="p-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="text-white">
                    <div class="fw-bold fs-5 mb-0">Unlock {{ $profileUser->displayName() }}’s full access</div>
                    <div class="small" style="opacity:.9;">Subscribe now — paid posts, exclusive drops, closer access</div>
                </div>
                <form method="POST" action="{{ route('subscribe', $profileUser) }}">
                    @csrf
                    <button class="btn btn-light fw-bold px-4" type="submit" style="min-height:48px; color:#0b0f1a;">
                        Subscribe ${{ number_format($subPrice / 100, 2) }}/mo
                    </button>
                </form>
            </div>
        </div>
    @endif
@endauth

<div class="card card-ffm p-4 mb-3">
    <div class="d-flex gap-3 align-items-start flex-wrap">
        <img src="{{ $profileUser->profile?->avatar_path ? asset($profileUser->profile->avatar_path) : '/public/logo-monogram.png' }}" alt="" width="72" height="72" class="rounded-circle">
        <div class="flex-grow-1">
            <h1 class="h3 mb-1">{{ $profileUser->displayName() }}</h1>
            <div class="text-secondary">{{ '@'.$profileUser->username }}</div>
            @if ($profileUser->profile?->bio)
                <p class="mt-2 mb-0">{{ $profileUser->profile->bio }}</p>
            @endif
        </div>
        @auth
            @if (auth()->id() !== $profileUser->id && $profileUser->isCreator())
                <div class="d-flex flex-column gap-2" style="min-width:180px">
                    @if (auth()->user()->following->contains($profileUser->id))
                        <form method="POST" action="{{ route('unfollow', $profileUser) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-primary w-100" type="submit">Unfollow</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('follow', $profileUser) }}">
                            @csrf
                            <button class="btn btn-outline-primary w-100" type="submit">Follow</button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('subscribe', $profileUser) }}">
                        @csrf
                        <button class="btn btn-ffm w-100" type="submit">
                            Subscribe ${{ number_format(($profileUser->creatorSettings?->subscription_price ?? 0) / 100, 2) }}/mo
                        </button>
                    </form>

                    <form method="POST" action="{{ route('messages.start', $profileUser) }}">
                        @csrf
                        <button class="btn btn-outline-primary w-100" type="submit">Message</button>
                    </form>
                    <a class="btn btn-outline-primary w-100" href="{{ route('video-messages.request', $profileUser) }}">🎬 Request video</a>
                    <a class="btn btn-outline-primary w-100" href="{{ route('gifts.leaderboard', $profileUser->username) }}">🏆 Top Gifters</a>

                    <div class="mt-2">
                        @include('partials.tip-gifts')
                    </div>
                </div>
            @endif
        @else
            @if ($profileUser->isCreator())
                <div class="w-100 mt-3">
                    @php
                        $subPrice = (int) ($profileUser->creatorSettings?->subscription_price ?? 0);
                    @endphp
                    @if ($subPrice > 0)
                        <div class="badge text-bg-warning mb-2">Paid membership · ${{ number_format($subPrice / 100, 2) }}/mo</div>
                    @else
                        <div class="badge text-bg-success mb-2">Free to follow</div>
                    @endif
                    <h2 class="h6 mb-2">Join {{ $profileUser->displayName() }} on FansFollow</h2>
                    <form method="POST" action="{{ route('register.attempt') }}" class="row g-2 align-items-end">
                        @csrf
                        @if (!empty($joinLink))
                            <input type="hidden" name="join_code" value="{{ $joinLink->code }}">
                        @endif
                        <input type="hidden" name="role" value="fan">
                        <input type="hidden" name="terms" value="1">
                        <input type="hidden" name="age_confirm" value="1">
                        <div class="col-md-3">
                            <label class="form-label small">Name</label>
                            <input class="form-control" name="name" required maxlength="80" value="{{ old('name') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Username</label>
                            <input class="form-control" name="username" required maxlength="30" value="{{ old('username') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Email</label>
                            <input class="form-control" type="email" name="email" required value="{{ old('email') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Password</label>
                            <input class="form-control" type="password" name="password" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Date of birth (18+)</label>
                            <input class="form-control" type="date" name="date_of_birth" required max="{{ date('Y-m-d', strtotime('-18 years')) }}" value="{{ old('date_of_birth') }}">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-ffm w-100" type="submit">Join</button>
                        </div>
                    </form>
                    <p class="small text-secondary mt-2 mb-0">
                        By joining you confirm you are 18+.
                        Already have an account?
                        <a href="{{ route('login') }}{{ !empty($joinLink) ? '?join_code='.$joinLink->code : '' }}">Login</a>
                    </p>
                </div>
            @else
                <a class="btn btn-ffm" href="{{ route('login') }}">Login to follow</a>
            @endif
        @endauth
    </div>
</div>
@if ($posts->isEmpty())
    <p class="text-secondary">No published posts yet.</p>
@else
    <div class="row g-3">
        @foreach ($posts as $post)
            <div class="col-md-4">
                <div class="card card-ffm p-3 h-100">
                    <div class="small text-secondary mb-2">{{ $post->type->value }} · {{ $post->published_at?->diffForHumans() }}</div>
                    <p class="mb-2">{{ \Illuminate\Support\Str::limit($post->body, 120) }}</p>
                    @if ($post->is_paid)
                        <span class="badge text-bg-warning">Paid ${{ number_format($post->price / 100, 2) }}</span>
                    @else
                        <span class="badge text-bg-secondary">Free</span>
                    @endif
                    <a class="small mt-2" href="{{ route('posts.show', $post) }}">View</a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-3">{{ $posts->links() }}</div>
@endif

@if (!empty($giftTotals) && $giftTotals->isNotEmpty())
    <div class="card card-ffm p-3 mt-4">
        <h2 class="h6 mb-2">Gift wall</h2>
        <div class="d-flex flex-wrap gap-2">
            @foreach ($giftTotals as $key => $stats)
                @php
                    $meta = \App\Support\TipCatalog::forKey($key);
                @endphp
                @if ($meta)
                    <span class="badge text-bg-dark border border-warning border-opacity-25 px-3 py-2">
                        {{ $meta['emoji'] }} ×{{ $stats['count'] }}
                        <span class="text-secondary small ms-1">${{ number_format($stats['amount']/100, 0) }}</span>
                    </span>
                @endif
            @endforeach
        </div>
    </div>
@endif

@if (!empty($recentTips) && $recentTips->isNotEmpty())
    <div class="card card-ffm p-3 mt-3">
        <h2 class="h6 mb-2">Recent gifts</h2>
        <ul class="list-unstyled mb-0 small">
            @foreach ($recentTips as $tip)
                <li class="mb-1">
                    @if ($tip->gift_key)
                        @php $meta = \App\Support\TipCatalog::forKey($tip->gift_key); @endphp
                        {{ $meta['emoji'] ?? '🎁' }}
                    @else
                        💸
                    @endif
                    <strong>{{ '@'.($tip->from?->username ?? 'Someone') }}</strong>
                    · ${{ number_format($tip->amount / 100, 2) }}
                    <span class="text-secondary">· {{ $tip->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endif
@endsection

@push('scripts')
<script src="{{ asset('js/gif-gifts.js') }}" defer></script>
<script>
window.FFM_FLASH = {
    key: @json(session('gift_flash')),
    from: @json(session('gift_from')),
    tier: @json(session('gift_tier'))
};
</script>
@endpush
