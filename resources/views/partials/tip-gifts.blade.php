@php
    use App\Support\TipCatalog;
    $gifts = TipCatalog::all();
@endphp
<link href="{{ asset('css/tip-gifts.css') }}" rel="stylesheet">
<link href="{{ asset('css/gif-gifts.css') }}" rel="stylesheet" id="gif-gifts-css">

<form method="POST" action="{{ route('tip', $profileUser) }}" id="tip-gift-form">
    @csrf
    <input type="hidden" name="gift_key" id="tip-gift-key" value="">
    <input type="hidden" name="amount" id="tip-gift-amount" value="100">

    <div class="tip-gift-grid mb-3" id="tip-gift-grid">
        @foreach ($gifts as $i => $gift)
            <label class="tip-gift-card{{ $i >= 6 ? ' tip-gift-extra' : '' }}"
                   data-gift="{{ $gift['key'] }}" data-amount="{{ $gift['amount'] }}" data-tier="{{ $gift['tier'] }}"
                   @if($i >= 6) style="display:none;" @endif>
                <input type="radio" name="_gift_radio" value="{{ $gift['key'] }}">
                <span class="gift-emoji">{{ $gift['emoji'] }}</span>
                <span class="gift-label">{{ $gift['label'] }}</span>
                <span class="gift-price">${{ number_format($gift['amount'] / 100, 0) }}</span>
                <span class="gift-blurb">{{ $gift['blurb'] }}</span>
            </label>
        @endforeach
    </div>
    @if (count($gifts) > 6)
        <button type="button" class="btn btn-ffm-outline mb-3" id="tip-gift-see-all">See all gifts</button>
    @endif

    <div class="d-flex gap-2 flex-wrap align-items-center">
        <button class="btn btn-ffm" type="submit" id="tip-send-btn">Send Fist Bump</button>
        <span class="small text-secondary">Uses wallet · <a href="{{ route('wallet.show') }}">Add funds</a></span>
    </div>
</form>

@once
@push('scripts')
<script src="{{ asset('js/gif-gifts.js') }}"></script>
<script>
window.FFM_GIFT_META = @json(\App\Support\TipCatalog::jsMap());
</script>
<script>
(function () {
    var form = document.getElementById('tip-gift-form');
    if (!form) return;
    var keyInput = document.getElementById('tip-gift-key');
    var amountInput = document.getElementById('tip-gift-amount');
    var sendBtn = document.getElementById('tip-send-btn');
    var cards = form.querySelectorAll('.tip-gift-card');

    function select(card) {
        cards.forEach(function (c) { c.classList.remove('selected'); });
        card.classList.add('selected');
        var key = card.getAttribute('data-gift');
        keyInput.value = key;
        amountInput.value = card.getAttribute('data-amount');
        var label = card.querySelector('.gift-label');
        if (sendBtn && label) sendBtn.textContent = 'Send ' + label.textContent;

        if (window.GiftFX) {
            var meta = (window.FFM_GIFT_META && window.FFM_GIFT_META[key]) || {};
            window.GiftFX.play({
                gift_key: key,
                emoji: meta.emoji,
                label: meta.label,
                amount: meta.amount ? Math.round(meta.amount / 100) : null,
                tier: meta.tier || 1
            });
        }
    }

    cards.forEach(function (card) {
        card.addEventListener('click', function (e) {
            e.preventDefault();
            select(card);
        });
    });

    var seeAll = document.getElementById('tip-gift-see-all');
    if (seeAll) {
        seeAll.addEventListener('click', function () {
            var extras = form.querySelectorAll('.tip-gift-extra');
            var open = seeAll.getAttribute('data-open') === '1';
            extras.forEach(function (el) {
                el.style.display = open ? 'none' : '';
            });
            seeAll.setAttribute('data-open', open ? '0' : '1');
            seeAll.textContent = open ? 'See all gifts' : 'Show fewer gifts';
        });
    }
})();
</script>
@endpush
@endonce
