@extends('layouts.app')
@section('title', 'New post')

@section('content')
<h1 class="h3 mb-3">New post</h1>
<div class="card card-ffm p-4 col-lg-7">
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="body">Caption</label>
            <textarea class="form-control" name="body" id="body" rows="4" required>{{ old('body') }}</textarea>
            @error('body')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="type">Media type</label>
            <select class="form-select" name="type" id="type">
                @foreach (['text','photo','video','audio','reel'] as $type)
                    <option value="{{ $type }}" @selected(old('type', 'text') === $type)>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="media">Media (optional)</label>
            <input class="form-control" type="file" name="media" id="media">
            @error('media')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label d-block">Who can see this post?</label>
            <div class="d-flex flex-column gap-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="access" id="access_free" value="free"
                           @checked(old('access', 'free') === 'free') onchange="togglePpvPrice()">
                    <label class="form-check-label" for="access_free">
                        <strong>Free</strong>
                        <span class="text-secondary small d-block">Visible to everyone</span>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="access" id="access_subscribers" value="subscribers"
                           @checked(old('access') === 'subscribers') onchange="togglePpvPrice()">
                    <label class="form-check-label" for="access_subscribers">
                        <strong>Subscribers only</strong>
                        <span class="text-secondary small d-block">Unlocked with an active subscription (no extra charge)</span>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="access" id="access_ppv" value="ppv"
                           @checked(old('access') === 'ppv') onchange="togglePpvPrice()">
                    <label class="form-check-label" for="access_ppv">
                        <strong>Pay-per-view (PPV)</strong>
                        <span class="text-secondary small d-block">Locked for everyone (including subscribers) until they buy it</span>
                    </label>
                </div>
            </div>
            @error('access')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3" id="ppv-price-wrap" style="display:{{ old('access') === 'ppv' ? 'block' : 'none' }};">
            <label class="form-label" for="price">Price (USD cents, minimum 100 = $1.00)</label>
            <input class="form-control" type="number" name="price" id="price" min="100" step="1"
                   value="{{ old('price', 499) }}">
            <div class="form-text">Charged once per fan via wallet. Subscribers still pay for PPV.</div>
            @error('price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <button class="btn btn-ffm" type="submit">Publish</button>
        <a class="btn btn-link" href="{{ route('posts.index') }}">Cancel</a>
    </form>
</div>

<script>
function togglePpvPrice() {
    var ppv = document.getElementById('access_ppv');
    var wrap = document.getElementById('ppv-price-wrap');
    if (ppv && wrap) {
        wrap.style.display = ppv.checked ? 'block' : 'none';
    }
}
togglePpvPrice();
</script>
@endsection
