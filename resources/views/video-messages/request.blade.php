@extends('layouts.app')
@section('title', 'Request a video')

@section('content')
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-inline">
        <ul class="mb-0 small">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

@php
    $s = $creator->creatorSettings;
    $t1 = (int) ($s?->video_tier1_price ?: 5000);
    $t2 = (int) ($s?->video_tier2_price ?: 10000);
    $t3 = (int) ($s?->video_tier3_price ?: 20000);
    $tiers = \App\Http\Controllers\VideoMessageController::TIERS;
@endphp

<div class="card card-ffm p-4 col-lg-6">
    <h1 class="h4 mb-1">Request a video</h1>
    <p class="text-secondary mb-3">From {{ '@'.$creator->username }} · separate from shop</p>

    <form method="POST" action="{{ route('video-messages.store', $creator) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">What kind of video?</label>
            <select class="form-select" name="occasion" id="vm-occasion" required>
                @foreach (\App\Http\Controllers\VideoMessageController::OCCASIONS as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        {{-- Standard occasions: 3 creator-set tiers --}}
        <div id="vm-tiers" class="mb-3">
            <label class="form-label">Length / word count</label>
            <div class="d-grid gap-2">
                <label class="card card-ffm p-3 d-flex justify-content-between align-items-center" style="cursor:pointer;">
                    <span>
                        <input class="form-check-input me-2" type="radio" name="tier" value="1" checked>
                        <strong>Short</strong>
                        <span class="text-secondary small d-block ms-4">{{ $tiers[1]['words'] }} · ~30s</span>
                    </span>
                    <span class="text-warning fw-bold">${{ number_format($t1 / 100, 2) }}</span>
                </label>
                <label class="card card-ffm p-3 d-flex justify-content-between align-items-center" style="cursor:pointer;">
                    <span>
                        <input class="form-check-input me-2" type="radio" name="tier" value="2">
                        <strong>Medium</strong>
                        <span class="text-secondary small d-block ms-4">{{ $tiers[2]['words'] }} · ~1 min</span>
                    </span>
                    <span class="text-warning fw-bold">${{ number_format($t2 / 100, 2) }}</span>
                </label>
                <label class="card card-ffm p-3 d-flex justify-content-between align-items-center" style="cursor:pointer;">
                    <span>
                        <input class="form-check-input me-2" type="radio" name="tier" value="3">
                        <strong>Long</strong>
                        <span class="text-secondary small d-block ms-4">{{ $tiers[3]['words'] }} · ~2–3 min</span>
                    </span>
                    <span class="text-warning fw-bold">${{ number_format($t3 / 100, 2) }}</span>
                </label>
            </div>
        </div>

        {{-- Brand: custom price OR negotiate --}}
        <div id="vm-brand" class="mb-3 d-none">
            <label class="form-label">Brand promo</label>
            <div class="d-grid gap-2 mb-3">
                <label class="card card-ffm p-3" style="cursor:pointer;">
                    <input class="form-check-input me-2" type="radio" name="brand_mode" value="set_price" checked>
                    <strong>I set the price now</strong>
                    <span class="text-secondary small d-block ms-4">Pay from wallet immediately</span>
                </label>
                <label class="card card-ffm p-3" style="cursor:pointer;">
                    <input class="form-check-input me-2" type="radio" name="brand_mode" value="negotiate">
                    <strong>Message for a quote</strong>
                    <span class="text-secondary small d-block ms-4">Creator sends a price first — no charge yet</span>
                </label>
            </div>
            <div id="vm-custom-price">
                <label class="form-label">Your brand budget (USD)</label>
                <input class="form-control" type="number" name="custom_price" min="500" step="100" value="{{ old('custom_price', 25000) }}">
                <div class="form-text">Min $50. Creator can accept or message you.</div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Brief</label>
            <textarea class="form-control" name="brief" rows="4" maxlength="500" required placeholder="Name, occasion, what to say…">{{ old('brief') }}</textarea>
        </div>
        <button class="btn btn-ffm w-100" type="submit">Send request</button>
    </form>
</div>

@once
@push('scripts')
<script>
(function () {
    var sel = document.getElementById('vm-occasion');
    var tiers = document.getElementById('vm-tiers');
    var brand = document.getElementById('vm-brand');
    if (!sel) return;
    function sync() {
        var isBrand = sel.value === 'promote_brand';
        tiers.classList.toggle('d-none', isBrand);
        brand.classList.toggle('d-none', !isBrand);
    }
    sel.addEventListener('change', sync);
    sync();
})();
</script>
@endpush
@endonce
@endsection
