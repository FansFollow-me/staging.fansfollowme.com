@extends('layouts.app')
@section('title', 'Stories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Stories</h1>
    @auth
        @if (auth()->user()->isCreator() || auth()->user()->isAdmin())
            <a class="btn btn-ffm" href="{{ route('stories.create') }}">Create Story</a>
        @endif
    @endauth
</div>
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif
@if ($stories->isEmpty())
    <p class="text-secondary">No active stories.</p>
@else
    <div class="row g-3">
        @foreach ($stories as $creatorId => $group)
            <div class="col-md-3">
                <div class="card card-ffm p-3 h-100">
                    <a href="{{ route('profile', $group->first()->creator->username) }}" class="fw-semibold">{{ '@'.$group->first()->creator->username }}</a>
                    <div class="small text-secondary">{{ $group->count() }} story(ies)</div>
                    <a class="btn btn-sm btn-ffm mt-2" href="{{ route('stories.show', $group->first()) }}">View</a>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
