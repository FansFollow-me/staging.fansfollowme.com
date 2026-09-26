@extends('layouts.app')
@section('title', 'Admin · Posts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Posts</h1>
    <a class="btn btn-outline-primary" href="{{ route('admin.dashboard') }}">Back</a>
</div>
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

<div class="card card-ffm p-3">
    <table class="table table-dark table-sm align-middle mb-0">
        <thead>
            <tr><th>Creator</th><th>Preview</th><th>Type</th><th>Paid</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($posts as $post)
                <tr>
                    <td>{{ '@'.$post->creator?->username }}</td>
                    <td class="small">{{ \Illuminate\Support\Str::limit($post->body, 60) }}</td>
                    <td>{{ $post->type->value }}</td>
                    <td>
                        @if ($post->isSubscribersOnly())
                            Subscribers
                        @elseif ($post->isPpv())
                            PPV ${{ number_format($post->price / 100, 2) }}
                        @else
                            Free
                        @endif
                    </td>
                    <td>
                        <a class="small" href="{{ route('posts.show', $post) }}">View</a>
                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="d-inline ms-2" onsubmit="return confirm('Delete this post?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-secondary">No posts.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $posts->links() }}</div>
@endsection
