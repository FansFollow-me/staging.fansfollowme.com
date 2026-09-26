@extends('layouts.app')
@section('title', $profileUser->displayName())
@section('meta_description', \Illuminate\Support\Str::limit($profileUser->profile?->bio ?: $profileUser->displayName().' on FansFollow.me', 160))

@php
    $subPrice = (int) ($profileUser->creatorSettings?->subscription_price ?? 0);
    $isPaidCreator = $profileUser->isCreator() && $subPrice > 0;
    $cover = $profileUser->coverUrl();
    $avatar = $profileUser->avatarUrl();
    $loginUrl = $loginUrl ?? route('login');
    $signupUrl = $signupUrl ?? route('register');
@endphp

@push('head')
<style>
.ffm-profile { color: #e5e7eb; }
.ffm-profile-cover {
    height: 220px;
    background: {{ $cover ? "center/cover no-repeat url('{$cover}')" : 'linear-gradient(135deg, #1e3a8a, #6366f1, #a855f7)' }};
    border-bottom: 1px solid rgba(148,163,184,.12);
}
@media (min-width: 768px) { .ffm-profile-cover { height: 280px; } }
.ffm-profile-avatar {
    width: 112px; height: 112px; border-radius: 50%;
    border: 4px solid #0b0f1a; object-fit: cover;
    margin-top: -56px; background: #111827;
}
@media (min-width: 768px) { .ffm-profile-avatar { width: 132px; height: 132px; margin-top: -66px; } }
.ffm-profile-name { font-weight: 800; letter-spacing: -.02em; }
.ffm-profile-handle { color: #94a3b8; }
.ffm-profile-stats { color: #94a3b8; font-size: .9rem; gap: 1.25rem; }
.ffm-profile-stats strong { color: #fff; }
.ffm-post { overflow: hidden; }
.ffm-post-media {
    width: 100%;
    aspect-ratio: 4 / 3;
    max-height: 520px;
    object-fit: cover;
    object-position: top center;
    background: #0f172a;
    display: block;
}
.ffm-post-locked {
    min-height: 240px;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    background: linear-gradient(180deg, rgba(15,23,42,.2), rgba(2,6,23,.92)),
                {{ $cover ? "center/cover url('{$cover}')" : '#111827' }};
    text-align: center; padding: 2rem 1rem;
}
.ffm-guest-bar {
    position: sticky; bottom: 0; z-index: 20;
    background: rgba(11,15,26,.92); backdrop-filter: blur(12px);
    border-top: 1px solid rgba(148,163,184,.16);
    padding: .85rem 0;
}
</style>
@endpush

@section('fullbleed')
<div class="ffm-profile">
    <div class="ffm-profile-cover" role="img" aria-label="{{ $profileUser->displayName() }} cover"></div>
    <div class="container pb-5">
        @if (session('status'))
            <div class="alert alert-success alert-inline mt-3">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-inline mt-3">
                <ul class="mb-0 small">@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="d-flex flex-wrap align-items-end gap-3">
            <img class="ffm-profile-avatar" src="{{ $avatar }}" alt="{{ $profileUser->displayName() }}">
            <div class="flex-grow-1 pb-1">
                <h1 class="h3 ffm-profile-name mb-0">
                    {{ $profileUser->displayName() }}
                    @if ($profileUser->creatorSettings?->is_verified)
                        <span class="text-info" title="Verified"><i class="fas fa-circle-check"></i></span>
                    @endif
                </h1>
                <div class="ffm-profile-handle">{{ '@'.$profileUser->username }}</div>
            </div>
            <div class="d-flex flex-wrap gap-2 pb-2">
                @auth
                    @if (auth()->id() === $profileUser->id)
                        <a class="btn btn-outline-primary" href="{{ route('join.my-qr') }}">My QR</a>
                    @elseif ($profileUser->isCreator())
                        @if (auth()->user()->following->contains($profileUser->id))
                            <form method="POST" action="{{ route('unfollow', $profileUser) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-primary" type="submit">Following</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('follow', $profileUser) }}">
                                @csrf
                                <button class="btn btn-outline-primary" type="submit">Follow</button>
                            </form>
                        @endif
                        @if ($isPaidCreator && empty($isSubscribed))
                            <form method="POST" action="{{ route('subscribe', $profileUser) }}">
                                @csrf
                                <button class="btn btn-ffm" type="submit">Subscribe ${{ number_format($subPrice / 100, 2) }}/mo</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('messages.start', $profileUser) }}">
                            @csrf
                            <button class="btn btn-outline-primary" type="submit">Message</button>
                        </form>
                    @endif
                @else
                    @if ($isPaidCreator)
                        <a class="btn btn-ffm" href="{{ $loginUrl }}">Subscribe ${{ number_format($subPrice / 100, 2) }}/mo</a>
                    @else
                        <a class="btn btn-ffm" href="{{ $loginUrl }}">Follow</a>
                    @endif
                    <a class="btn btn-outline-primary" href="{{ $loginUrl }}">Log in</a>
                @endauth
                @if (!empty($shareJoinUrl))
                    <button type="button" class="btn btn-outline-primary" data-share-qr-btn>
                        <i class="fas fa-share-nodes"></i> Share
                    </button>
                @endif
            </div>
        </div>

        @php
            $profileBadges = collect($profileUser->profile?->badges ?? []);
            if ($profileUser->profile?->category) { $profileBadges->push($profileUser->profile->category); }
            if ($profileUser->creatorSettings?->is_verified) { $profileBadges->push('Verified'); }
            $profileBadges = $profileBadges->map(fn ($b) => trim((string) $b))->filter()->unique()->values();
        @endphp
        @if ($profileBadges->isNotEmpty())
            <div class="d-flex flex-wrap gap-1 mt-3">
                @foreach ($profileBadges as $badgeLabel)
                    <span class="badge text-bg-warning">{{ $badgeLabel }}</span>
                @endforeach
            </div>
        @endif

        @if ($profileUser->profile?->bio)
            <p class="mt-3 mb-2" style="max-width:42rem; line-height:1.55;">{{ $profileUser->profile->bio }}</p>
        @endif

        <div class="d-flex ffm-profile-stats mt-2">
            <span><strong>{{ number_format($postCount ?? $posts->total()) }}</strong> posts</span>
            <span><strong>{{ number_format($followerCount ?? 0) }}</strong> followers</span>
            @if ($isPaidCreator)
                <span>Paid · ${{ number_format($subPrice / 100, 2) }}/mo</span>
            @elseif ($profileUser->isCreator())
                <span>Free to follow</span>
            @endif
        </div>

        @auth
            @if ($isPaidCreator && auth()->id() !== $profileUser->id && empty($isSubscribed))
                <div class="card mt-3 p-0 overflow-hidden" style="background: linear-gradient(135deg, #f97316 0%, #ec4899 48%, #a855f7 100%); border: none;">
                    <div class="p-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="text-white">
                            <div class="fw-bold mb-0">Unlock {{ $profileUser->displayName() }}’s exclusive posts</div>
                            <div class="small" style="opacity:.9;">Subscribe to see locked photos and drops</div>
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
            @if (auth()->id() !== $profileUser->id && $profileUser->isCreator())
                <div class="mt-3">@include('partials.tip-gifts')</div>
            @endif
        @endauth

        <hr class="border-secondary border-opacity-25 my-4">

        @if ($posts->isEmpty())
            <p class="text-secondary">No published posts yet.</p>
        @else
            <div class="row g-4">
                @foreach ($posts as $post)
                    @php
                        $locked = $post->isLockedFor(auth()->user());
                        $media = $post->media->first();
                        $postUrl = route('profile.post', ['username' => $profileUser->username, 'post' => $post]);
                    @endphp
                    <div class="col-12 col-lg-8">
                        <article class="card card-ffm ffm-post">
                            @if ($locked)
                                <div class="ffm-post-locked">
                                    <i class="fas fa-lock mb-2"></i>
                                    <div class="fw-bold">
                                        @if ($post->isPpv())
                                            Unlock for ${{ number_format($post->price / 100, 2) }}
                                        @else
                                            Subscribe to unlock
                                        @endif
                                    </div>
                                    <div class="small text-secondary mb-3">{{ $post->accessLabel() }} · {{ $post->published_at?->diffForHumans() }}</div>
                                    @guest
                                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                                            <a class="btn btn-ffm" href="{{ $loginUrl }}">Log in to unlock</a>
                                            <a class="btn btn-outline-primary" href="{{ $signupUrl }}">Join</a>
                                        </div>
                                    @else
                                        @if ($post->isPpv())
                                            @if ((auth()->user()->wallet?->balance ?? 0) >= $post->price)
                                                <form method="POST" action="{{ route('posts.unlock', $post) }}">
                                                    @csrf
                                                    <button class="btn btn-ffm" type="submit">
                                                        Unlock for ${{ number_format($post->price / 100, 2) }} (wallet)
                                                    </button>
                                                </form>
                                            @else
                                                <a class="btn btn-ffm" href="{{ route('wallet.show') }}">Add funds</a>
                                            @endif
                                        @else
                                            <form method="POST" action="{{ route('subscribe', $profileUser) }}">
                                                @csrf
                                                <button class="btn btn-ffm" type="submit">Subscribe to unlock</button>
                                            </form>
                                        @endif
                                    @endguest
                                </div>
                            @else
                                @if ($media)
                                    <a href="{{ $postUrl }}">
                                        <img class="ffm-post-media" src="{{ $media->url() }}" alt="">
                                    </a>
                                @endif
                                <div class="p-3">
                                    <div class="small text-secondary mb-2">
                                        {{ $post->published_at?->diffForHumans() }}
                                        @if ($post->isSubscribersOnly())
                                            <span class="badge text-bg-info ms-1">Subscribers</span>
                                        @elseif ($post->isPpv())
                                            <span class="badge text-bg-warning ms-1">PPV ${{ number_format($post->price / 100, 2) }}</span>
                                        @endif
                                    </div>
                                    @if ($post->body)
                                        <p class="mb-2">{{ $post->body }}</p>
                                    @endif
                                    <a class="small" href="{{ $postUrl }}">Open post</a>
                                </div>
                            @endif
                        </article>
                    </div>
                @endforeach
            </div>
            <div class="mt-3">{{ $posts->links() }}</div>
        @endif

        @if (!empty($giftTotals) && $giftTotals->isNotEmpty())
            <div class="card card-ffm p-3 mt-4 col-lg-8">
                <h2 class="h6 mb-2">Gift wall</h2>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($giftTotals as $key => $stats)
                        @php $meta = \App\Support\TipCatalog::forKey($key); @endphp
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
    </div>

    @guest
        <div class="ffm-guest-bar">
            <div class="container d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div>
                    <div class="fw-bold">{{ $isPaidCreator ? 'Subscribe to' : 'Follow' }} {{ $profileUser->displayName() }} on FansFollow.me</div>
                    <div class="small text-secondary">Log in or join to follow, subscribe, and unlock posts.</div>
                </div>
                <div class="d-flex gap-2">
                    <a class="btn btn-outline-primary" href="{{ $loginUrl }}">Log in</a>
                    <a class="btn btn-ffm" href="{{ $signupUrl }}">Join</a>
                </div>
            </div>
        </div>
    @endguest
</div>

@php
    $shareQrUrl = $shareJoinUrl ?? null;
    $shareQrLabel = $profileUser->displayName();
    $shareQrHandle = $profileUser->username;
@endphp
@if (!empty($shareQrUrl))
<div id="profile-share-modal" style="display:none;position:fixed;inset:0;z-index:2000;background:rgba(2,6,23,.72);align-items:center;justify-content:center;padding:1rem;">
  <div class="card card-ffm p-4 text-center" style="width:min(420px,100%);position:relative;">
    <button type="button" id="profile-share-close" class="btn btn-sm btn-outline-secondary" style="position:absolute;top:10px;right:10px;" aria-label="Close">&times;</button>
    <img src="{{ $avatar }}" alt="" width="64" height="64" class="rounded-circle mx-auto mb-2" style="object-fit:cover;">
    <h2 class="h5 mb-1">{{ $shareQrLabel }}</h2>
    <div class="text-secondary mb-3">{{ '@'.$shareQrHandle }}</div>
    <div id="profile-share-qr" class="mx-auto" style="width:220px;height:220px;background:#fff;padding:10px;border-radius:12px;"></div>
    <p class="small text-secondary mt-2 mb-2">Scan to follow me on FansFollow.me</p>
    <code class="d-block small mb-3 text-break" id="profile-share-url">{{ $shareQrUrl }}</code>
    <div class="d-flex gap-2">
      <button type="button" class="btn btn-outline-primary flex-fill" id="profile-share-copy">Copy Link</button>
      <button type="button" class="btn btn-ffm flex-fill" id="profile-share-native">Share</button>
    </div>
  </div>
</div>
<script src="{{ asset('js/qrcode.min.js') }}?v=qr3"></script>
<script>
(function () {
  var url = @json($shareQrUrl);
  var modal = document.getElementById('profile-share-modal');
  var qrEl = document.getElementById('profile-share-qr');
  var openBtn = document.querySelector('[data-share-qr-btn]');
  var closeBtn = document.getElementById('profile-share-close');
  var copyBtn = document.getElementById('profile-share-copy');
  var nativeBtn = document.getElementById('profile-share-native');
  function render() {
    if (!window.QRCode || !qrEl) return;
    qrEl.innerHTML = '';
    new QRCode(qrEl, { text: url, width: 200, height: 200, colorDark: '#000000', colorLight: '#ffffff', correctLevel: QRCode.CorrectLevel.H });
  }
  function open() { if (!modal) return; modal.style.display = 'flex'; document.body.style.overflow = 'hidden'; render(); }
  function close() { if (!modal) return; modal.style.display = 'none'; document.body.style.overflow = ''; }
  if (openBtn) openBtn.addEventListener('click', open);
  if (closeBtn) closeBtn.addEventListener('click', close);
  if (modal) modal.addEventListener('click', function (e) { if (e.target === modal) close(); });
  if (copyBtn) copyBtn.addEventListener('click', function () {
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(url).then(function () { copyBtn.textContent = 'Copied!'; setTimeout(function () { copyBtn.textContent = 'Copy Link'; }, 1500); });
    } else { window.prompt('Copy this link:', url); }
  });
  if (nativeBtn) nativeBtn.addEventListener('click', function () {
    if (navigator.share) { navigator.share({ title: @json($shareQrLabel) + ' on FansFollow.me', url: url }).catch(function () {}); }
    else if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(url).then(function () { nativeBtn.textContent = 'Copied!'; setTimeout(function () { nativeBtn.textContent = 'Share'; }, 1500); });
    } else { window.prompt('Copy this link:', url); }
  });
})();
</script>
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
