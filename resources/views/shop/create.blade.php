@extends('layouts.app')
@section('title', 'Add product')

@section('content')
<h1 class="h3 mb-3">Add product</h1>
<div class="card card-ffm p-4 col-lg-6">
    <form method="POST" action="{{ route('shop.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input class="form-control" name="title" value="{{ old('title') }}" required maxlength="120">
            @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Price (USD)</label>
            <div class="input-group" style="max-width:220px;">
                <span class="input-group-text">$</span>
                <input class="form-control" type="number" name="price" min="1" max="10000" step="0.01"
                       value="{{ old('price', '19.99') }}" required>
            </div>
            @error('price')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Digital file (optional for now)</label>
            <input class="form-control" type="file" name="file">
            @error('file')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <button class="btn btn-ffm" type="submit">Publish</button>
        <a class="btn btn-link" href="{{ route('shop.mine') }}">Cancel</a>
    </form>
</div>
@endsection
