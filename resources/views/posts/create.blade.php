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
            <label class="form-label" for="type">Type</label>
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
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_paid" value="1" id="is_paid" @checked(old('is_paid'))>
            <label class="form-check-label" for="is_paid">Paid post (PPV)</label>
        </div>
        <div class="mb-3">
            <label class="form-label" for="price">Price (USD cents, e.g. 499 = $4.99)</label>
            <input class="form-control" type="number" name="price" id="price" min="0" step="1" value="{{ old('price', 499) }}">
            @error('price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
        <button class="btn btn-ffm" type="submit">Publish</button>
        <a class="btn btn-link" href="{{ route('posts.index') }}">Cancel</a>
    </form>
</div>
@endsection
