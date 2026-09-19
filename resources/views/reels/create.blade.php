@extends('layouts.app')
@section('title', 'Upload Reel')

@section('content')
<h1 class="h3 mb-3">Upload Reel</h1>
<div class="card card-ffm p-4 col-lg-6">
    <form method="POST" action="{{ route('reels.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Caption</label>
            <input class="form-control" name="caption" maxlength="500" value="{{ old('caption') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Video (mp4, webm, mov — max 100MB)</label>
            <input class="form-control" type="file" name="video" required accept="video/*">
            @error('video')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Thumbnail (optional)</label>
            <input class="form-control" type="file" name="thumbnail" accept="image/*">
        </div>
        <button class="btn btn-ffm" type="submit">Publish</button>
        <a class="btn btn-link" href="{{ route('reels.index') }}">Cancel</a>
    </form>
</div>
@endsection
