@extends('layouts.app')
@section('title', 'Start live')

@section('content')
<h1 class="h3 mb-3">Start live room</h1>
<div class="card card-ffm p-4 col-lg-6">
    <form method="POST" action="{{ route('live.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input class="form-control" name="title" required maxlength="120" value="{{ old('title') }}">
            @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="2">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Mode</label>
            <select class="form-select" name="mode">
                <option value="public">Public</option>
                <option value="group">Group</option>
                <option value="one_to_one">1v1</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Access</label>
            <select class="form-select" name="access">
                <option value="free">Free</option>
                <option value="subscribers_only">Subscribers only</option>
                <option value="ppv">Paid ticket</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Ticket price (USD, if paid)</label>
            <div class="input-group" style="max-width:220px;">
                <span class="input-group-text">$</span>
                <input class="form-control" type="number" name="price" min="0" max="500" step="0.01"
                       value="{{ old('price', '10.00') }}">
            </div>
            @error('price')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="allow_4k" value="1" id="allow_4k" checked>
            <label class="form-check-label" for="allow_4k">Allow 4K</label>
        </div>
        <button class="btn btn-ffm" type="submit">Create room</button>
    </form>
</div>
@endsection
