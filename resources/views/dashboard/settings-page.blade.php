@extends('layouts.app')
@section('title', 'Edit profile')

@section('content')
<h1 class="h3 mb-3">Edit profile</h1>
<div class="card card-ffm p-4 col-lg-6">
    <form method="POST" action="{{ route('settings.page.update') }}">
        @csrf
        @method('PUT')
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
@endsection
