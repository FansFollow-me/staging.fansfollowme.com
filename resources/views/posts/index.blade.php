@extends('layouts.app')
@section('title', 'My posts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">My posts</h1>
    <a class="btn btn-ffm" href="{{ route('posts.create') }}">New post</a>
</div>

@if ($posts->isEmpty())
    <div class="card card-ffm p-4 text-center">
        <p class="text-secondary mb-3">No posts yet. Share free content or lock premium posts for subscribers and buyers.</p>
        <a class="btn btn-ffm" href="{{ route('posts.create') }}">Create your first post</a>
    </div>
@else
    <div class="row g-3">
        @foreach ($posts as $post)
            <div class="col-md-4">
                <div class="card card-ffm p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge text-bg-secondary">{{ $post->type->value }}</span>
                        @if ($post->is_paid)
                            <span class="badge text-bg-warning">${{ number_format($post->price / 100, 2) }}</span>
                        @else
                            <span class="badge text-bg-dark">Free</span>
                        @endif
                    </div>
                    <p class="flex-grow-1">{{ \Illuminate\Support\Str::limit($post->body, 140) }}</p>
                    <a class="small" href="{{ route('posts.show', $post) }}">View</a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-3">{{ $posts->links() }}</div>
@endif
@endsection
