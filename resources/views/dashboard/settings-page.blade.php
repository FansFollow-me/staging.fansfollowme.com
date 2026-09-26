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
})();
</script>
@endsection
