@extends('layouts.app')
@section('title', 'Edit profile')

@section('content')
@php
    // Same URL builder as the public profile (app /media route, not asset())
    $avatarSrc = $user->avatarUrl();
    $coverSrc = $user->coverUrl();
@endphp

<h1 class="h3 mb-3">Edit profile</h1>

@if ($errors->any())
    <div class="alert alert-danger col-lg-6">
        <ul class="mb-0 small">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card card-ffm p-4 col-lg-6">
    <form method="POST" action="{{ route('settings.page.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="form-label fw-bold">Profile photo</label>
            <div class="d-flex align-items-center gap-3 mb-2">
                <img id="avatar-preview"
                     src="{{ $avatarSrc }}"
                     alt="Profile photo" width="80" height="80" class="rounded-circle"
                     style="object-fit:cover; border:2px solid rgba(249,115,22,.5);">
                <div class="flex-grow-1">
                    <div class="small text-secondary mb-2">JPG, PNG, or WebP · max 5MB</div>
                    <div class="d-flex flex-wrap gap-2">
                        <label class="btn btn-outline-primary btn-sm mb-0">
                            Replace
                            <input type="file" name="avatar" id="avatar-input" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" hidden>
                        </label>
                        @if ($user->profile?->avatar_path)
                            <label class="btn btn-outline-secondary btn-sm mb-0">
                                <input type="checkbox" name="remove_avatar" value="1" class="form-check-input me-1">
                                Remove
                            </label>
                        @endif
                    </div>
                    <div class="small text-muted mt-1" id="avatar-filename"></div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold">Cover image</label>
            <div class="mb-2 rounded-3 overflow-hidden" style="background:#1f2937; height:120px;">
                <img id="cover-preview"
                     src="{{ $coverSrc }}"
                     alt="Cover" class="w-100 h-100"
                     style="object-fit:cover; {{ $coverSrc ? '' : 'display:none;' }}">
            </div>
            <div class="small text-secondary mb-2">JPG, PNG, or WebP · max 5MB</div>
            <div class="d-flex flex-wrap gap-2">
                <label class="btn btn-outline-primary btn-sm mb-0">
                    Replace
                    <input type="file" name="cover" id="cover-input" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" hidden>
                </label>
                @if ($user->profile?->cover_path)
                    <label class="btn btn-outline-secondary btn-sm mb-0">
                        <input type="checkbox" name="remove_cover" value="1" class="form-check-input me-1">
                        Remove
                    </label>
                @endif
            </div>
            <div class="small text-muted mt-1" id="cover-filename"></div>
        </div>

        @if ($user->isCreator() || $user->isAdmin())
            @php
                $subCents = (int) ($user->creatorSettings?->subscription_price ?? 0);
                $subFree = old('subscription_free') !== null
                    ? (bool) old('subscription_free')
                    : $subCents <= 0;
                $subDollars = old('subscription_price', $subCents > 0 ? \App\Support\Money::centsToInput($subCents) : '9.99');
            @endphp
            <div class="mb-4">
                <label class="form-label fw-bold">Subscription price</label>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="subscription_free" value="1"
                           id="subscription_free" @checked($subFree) onchange="toggleSubPrice()">
                    <label class="form-check-label" for="subscription_free">
                        Free profile (no subscription needed)
                    </label>
                </div>
                <div id="sub-price-wrap" style="display:{{ $subFree ? 'none' : 'block' }};">
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

        <div class="mb-3">
            <label class="form-label">Display name</label>
            <input class="form-control" name="display_name" value="{{ old('display_name', $user->profile?->display_name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Bio</label>
            <textarea class="form-control" name="bio" rows="4">{{ old('bio', $user->profile?->bio) }}</textarea>
        </div>
        <button class="btn btn-ffm" type="submit">Save</button>
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
