@extends('layouts.app')
@section('title', 'Edit profile')

@section('content')
@php
    // Same URL builder as the public profile (app /media route, not asset())
    $avatarSrc = $user->avatarUrl();
    $coverSrc = $user->coverUrl();
@endphp

<div class="container" style="max-width:720px;">
  <h1 class="h3 mb-3">Edit profile</h1>

  {{-- Status is flashed by layouts.app; errors once at the top --}}
  @if ($errors->any())
    <div class="alert alert-danger alert-inline mb-3">
      <ul class="mb-0 small">
        @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('settings.page.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Profile photo & cover --}}
    <div class="card card-ffm p-4 mb-3">
      <h2 class="h5 mb-3">Profile photo &amp; cover</h2>

      <div class="mb-4">
        <label class="form-label">Profile photo</label>
        <div class="d-flex align-items-center gap-3 mb-2">
          <img id="avatar-preview"
               src="{{ $avatarSrc }}"
               alt="Profile photo" width="80" height="80" class="rounded-circle"
               style="object-fit:cover; border:2px solid rgba(249,115,22,.5);">
          <div class="flex-grow-1">
            <div class="small text-secondary mb-2">JPG, PNG, or WebP · max 5MB</div>
            <div class="d-flex flex-wrap gap-2">
              <label class="btn btn-ffm-outline mb-0">
                Replace
                <input type="file" name="avatar" id="avatar-input" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" hidden>
              </label>
              @if ($user->profile?->avatar_path)
                <label class="btn btn-ffm-outline mb-0">
                  <input type="checkbox" name="remove_avatar" value="1" class="form-check-input me-1">
                  Remove
                </label>
              @endif
            </div>
            <div class="small text-muted mt-1" id="avatar-filename"></div>
          </div>
        </div>
      </div>

      <div class="mb-2">
        <label class="form-label">Cover image</label>
        <div class="mb-2 overflow-hidden" style="background:#0f172a; border:1px solid rgba(148,163,184,.18); border-radius:12px; aspect-ratio: 3 / 1;">
          <img id="cover-preview"
               src="{{ $coverSrc }}"
               alt="Cover" class="w-100 h-100"
               style="object-fit:cover; {{ $coverSrc ? '' : 'display:none;' }}">
        </div>
        <div class="small text-secondary mb-2">JPG, PNG, or WebP · max 5MB</div>
        <div class="d-flex flex-wrap gap-2">
          <label class="btn btn-ffm-outline mb-0">
            Replace
            <input type="file" name="cover" id="cover-input" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" hidden>
          </label>
          @if ($user->profile?->cover_path)
            <label class="btn btn-ffm-outline mb-0">
              <input type="checkbox" name="remove_cover" value="1" class="form-check-input me-1">
              Remove
            </label>
          @endif
        </div>
        <div class="small text-muted mt-1" id="cover-filename"></div>
      </div>
    </div>

    {{-- Profile details --}}
    <div class="card card-ffm p-4 mb-3">
      <h2 class="h5 mb-3">Profile details</h2>
      <div class="mb-3">
        <label class="form-label" for="display_name">Display name</label>
        <input class="form-control" id="display_name" name="display_name" value="{{ old('display_name', $user->profile?->display_name) }}" required>
      </div>
      <div class="mb-1">
        <label class="form-label" for="bio">Bio</label>
        <textarea class="form-control" id="bio" name="bio" rows="4">{{ old('bio', $user->profile?->bio) }}</textarea>
        <div class="form-text">Shown on your public profile.</div>
      </div>
    </div>

    {{-- Subscription (creators / admins) --}}
    @if ($user->isCreator() || $user->isAdmin())
      @php
        $subCents = (int) ($user->creatorSettings?->subscription_price ?? 0);
        $subFree = old('subscription_free') !== null
          ? (bool) old('subscription_free')
          : $subCents <= 0;
        $subDollars = old('subscription_price', $subCents > 0 ? \App\Support\Money::centsToInput($subCents) : '9.99');
      @endphp
      <div class="card card-ffm p-4 mb-3">
        <h2 class="h5 mb-3">Subscription</h2>
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" name="subscription_free" value="1"
                 id="subscription_free" @checked($subFree) onchange="toggleSubPrice()">
          <label class="form-check-label" for="subscription_free">
            Free profile (no subscription needed)
          </label>
        </div>
        <div id="sub-price-wrap" style="display:{{ $subFree ? 'none' : 'block' }};">
          <label class="form-label" for="subscription_price">Subscription price</label>
          <div class="input-group" style="max-width:220px;">
            <span class="input-group-text">$</span>
            <input class="form-control" type="number" name="subscription_price" id="subscription_price"
                   min="1" max="100" step="0.01" value="{{ $subDollars }}">
          </div>
          <div class="form-text">Per month. Minimum $1.00 · Maximum $100.00. Existing subscribers keep their current price until renewal.</div>
        </div>
        @error('subscription_price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
      </div>
    @endif

    <div class="d-flex gap-2">
      <button class="btn btn-ffm" type="submit">Save</button>
    </div>
  </form>
</div>

<script>
(function () {
  function bindPreview(inputId, previewId, filenameId, mode) {
    var input = document.getElementById(inputId);
    var preview = document.getElementById(previewId);
    var nameEl = document.getElementById(filenameId);
    if (!input) return;
    input.addEventListener('change', function () {
      var file = input.files && input.files[0];
      if (!file) {
        if (nameEl) nameEl.textContent = '';
        return;
      }
      if (nameEl) nameEl.textContent = file.name;
      var url = URL.createObjectURL(file);
      if (preview) {
        preview.src = url;
        preview.style.display = '';
      }
    });
  }
  bindPreview('avatar-input', 'avatar-preview', 'avatar-filename');
  bindPreview('cover-input', 'cover-preview', 'cover-filename');

  function toggleSubPrice() {
    var free = document.getElementById('subscription_free');
    var wrap = document.getElementById('sub-price-wrap');
    if (free && wrap) {
      wrap.style.display = free.checked ? 'none' : 'block';
    }
  }
  toggleSubPrice();
})();
</script>
@endsection
