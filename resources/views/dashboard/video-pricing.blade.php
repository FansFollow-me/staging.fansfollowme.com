@extends('layouts.app')
@section('title', 'Video message pricing')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Video message pricing</h1>
    <a class="btn btn-outline-primary" href="{{ route('creator.dashboard') }}">Studio</a>
</div>

@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

<div class="card card-ffm p-4 col-lg-6">
    <p class="text-secondary small">You set 3 tiers. Fans pick length. Brand promo is custom price or quote.</p>
    <form method="POST" action="{{ route('settings.video-pricing.update') }}">
        @csrf
        @foreach ($tiers as $n => $meta)
            <div class="mb-3">
                <label class="form-label">Tier {{ $n }} — {{ $meta['label'] }} <span class="text-secondary">({{ $meta['words'] }})</span></label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <div class="input-group" style="max-width:180px;">
                        <span class="input-group-text">$</span>
                        <input class="form-control" type="number" name="video_tier{{ $n }}_price" min="1" max="500" step="0.01"
                               value="{{ old('video_tier'.$n.'_price', \App\Support\Money::centsToInput($user->creatorSettings->{'video_tier'.$n.'_price'} ?? [5000,10000,20000][$n-1])) }}">
                    </div>
                </div>
                @error('video_tier'.$n.'_price')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
        @endforeach
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="video_messages_enabled" value="1" id="vm-on"
                @checked(old('video_messages_enabled', $user->creatorSettings?->video_messages_enabled ?? true))>
            <label class="form-check-label" for="vm-on">Accept video message requests</label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="brand_promo_enabled" value="1" id="brand-on"
                @checked(old('brand_promo_enabled', $user->creatorSettings?->brand_promo_enabled ?? true))>
            <label class="form-check-label" for="brand-on">Accept brand promo requests (custom price / quote)</label>
        </div>
        <button class="btn btn-ffm" type="submit">Save pricing</button>
    </form>
</div>
@endsection
