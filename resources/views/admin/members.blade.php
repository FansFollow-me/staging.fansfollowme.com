@extends('layouts.app')
@section('title', 'Admin · Members')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Members</h1>
    <a class="btn btn-outline-primary" href="{{ route('admin.dashboard') }}">Back</a>
</div>
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

<form class="mb-3 d-flex gap-2" method="GET" action="{{ route('admin.members') }}">
    <input class="form-control" style="max-width:280px" name="q" value="{{ $q }}" placeholder="Search username or email">
    <button class="btn btn-outline-primary" type="submit">Search</button>
</form>

<div class="card card-ffm p-3">
    <table class="table table-dark table-sm align-middle mb-0">
        <thead>
            <tr><th>User</th><th>Email</th><th>Role</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($members as $member)
                <tr>
                    <td>
                        <a href="{{ route('profile', $member->username) }}">{{ '@'.$member->username }}</a>
                        <div class="small text-secondary">{{ $member->profile?->display_name }}</div>
                    </td>
                    <td class="small">{{ $member->email }}</td>
                    <td><span class="badge text-bg-secondary">{{ $member->role->value }}</span></td>
                    <td>{{ $member->status }}</td>
                    <td>
                        @unless ($member->isAdmin())
                            <form method="POST" action="{{ route('admin.suspend', $member) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-warning" type="submit">
                                    {{ $member->status === 'active' ? 'Suspend' : 'Restore' }}
                                </button>
                            </form>
                        @endunless
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-secondary">No members found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $members->links() }}</div>
@endsection
