@extends('layouts.app')

@push('head')
<link href="{{ asset('css/tip-gifts.css') }}" rel="stylesheet">
<link href="{{ asset('css/gif-gifts.css') }}?v=palm1" rel="stylesheet" id="gif-gifts-css">
@endpush

@section('title', 'Gift Animations Showcase')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h1 class="h4 mb-1">Gift Animations</h1>
            <p class="text-secondary mb-0 small">Click any gift to fire its live animation. Tier 5+ is full-screen cinematic.</p>
        </div>
        <div class="small text-secondary">SugarBook-class FX · no real spend</div>
    </div>

    <div class="row g-2" id="showcase-grid">
        @foreach ($gifts as $gift)
        <div class="col-6 col-md-4 col-lg-3">
            <button type="button"
                class="tip-gift-card w-100 showcase-card"
                data-gift="{{ $gift['key'] }}"
                data-amount="{{ $gift['amount'] }}"
                data-tier="{{ $gift['tier'] }}"
                data-emoji="{{ $gift['emoji'] }}"
                data-label="{{ $gift['label'] }}"
                style="cursor:pointer;border:none;">
                <span class="gift-emoji">{{ $gift['emoji'] }}</span>
                <span class="gift-label">{{ $gift['label'] }}</span>
                <span class="gift-price">${{ number_format($gift['amount'] / 100, 0) }}</span>
                @if (!empty($gift['mystery']))
                    <span class="badge bg-warning text-dark" style="font-size:10px;">SEALED</span>
                @endif
                <span class="badge bg-dark border" style="font-size:10px;">T{{ $gift['tier'] }}</span>
            </button>
        </div>
        @endforeach
    </div>

    <div class="mt-4 d-flex flex-wrap gap-2">
        <button type="button" class="btn btn-outline-light btn-sm" id="demo-combo">Combo ×5 Champagne</button>
        <button type="button" class="btn btn-outline-warning btn-sm" id="demo-legend">Legend stack</button>
        <a href="{{ asset('gift-fx-comparison.html') }}" class="btn btn-outline-info btn-sm">V3 vs V4 comparison</a>
        <a href="{{ url('/vikingcoach') }}" class="btn btn-ffm btn-sm">Tip a real creator →</a>
    </div>
</div>

<script src="{{ asset('js/gif-gifts.js') }}?v=palm1"></script>
<script>
window.FFM_GIFT_META = @json($meta);
document.getElementById('showcase-grid').addEventListener('click', function (e) {
    var card = e.target.closest('.showcase-card');
    if (!card || !window.GiftFX) return;
    var key = card.dataset.gift;
    var m = window.FFM_GIFT_META[key] || {};
    window.GiftFX.play({
        gift_key: key,
        emoji: card.dataset.emoji,
        label: card.dataset.label,
        amount: Number(card.dataset.amount) / 100,
        amount_cents: Number(card.dataset.amount),
        tier: Number(card.dataset.tier),
        image: m.image || null,
        from: 'Showcase'
    });
});
document.getElementById('demo-combo').addEventListener('click', function () {
    var i = 0;
    function once() {
        if (i++ >= 5) return;
        window.GiftFX.play({ gift_key: 'champagne', emoji: '🥂', label: 'Glass of Champagne', amount: 50, tier: 3, from: 'Combo' });
        setTimeout(once, 420);
    }
    once();
});
document.getElementById('demo-legend').addEventListener('click', function () {
    var seq = ['mystery_box', 'diamond_bracelet', 'luxury_watch', 'luxury_holiday', 'sports_car'];
    var i = 0;
    function once() {
        if (i >= seq.length) return;
        var key = seq[i++];
        var m = window.FFM_GIFT_META[key];
        window.GiftFX.play({ gift_key: key, emoji: m.emoji, label: m.label, amount: m.amount / 100, tier: m.tier, image: m.image, from: 'Legend' });
        setTimeout(once, 3200);
    }
    once();
});
</script>
@endsection
