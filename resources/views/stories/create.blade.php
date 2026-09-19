@extends('layouts.app')
@section('title', 'Create Story')

@section('content')
<h1 class="h3 mb-3">Create Story</h1>
<div class="card card-ffm p-4 col-lg-6">
    <form method="POST" action="{{ route('stories.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Type</label>
            <select class="form-select" name="type">
                <option value="media">Media (photo/video)</option>
                <option value="text">Text only</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Text / Caption</label>
            <textarea class="form-control" name="body" rows="3" maxlength="500">{{ old('body') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Media (optional)</label>
            <input class="form-control" type="file" name="media" accept="image/*,video/*">
            @error('media')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <button class="btn btn-ffm" type="submit">Post Story</button>
        <a class="btn btn-link" href="{{ route('stories.index') }}">Cancel</a>
    </form>
</div>
@endsection
