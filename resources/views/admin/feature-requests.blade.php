@extends('layouts.app')
@section('title', 'Admin · Feature requests')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Feature requests</h1>
    <a class="btn btn-outline-primary" href="{{ route('admin.dashboard') }}">Back</a>
</div>

<div class="row g-3 mb-4">
    @forelse ($totals as $row)
        <div class="col-md-3">
            <div class="card card-ffm p-3">
                <div class="text-secondary small">{{ $row->feature }}</div>
                <div class="fs-4 fw-bold">{{ $row->c }}</div>
            </div>
        </div>
    @empty
        <p class="text-secondary">No feedback yet.</p>
    @endforelse
</div>

<div class="card card-ffm p-3">
    <table class="table table-dark table-sm align-middle mb-0">
        <thead><tr><th>Feature</th><th>User</th><th>Message</th><th>When</th></tr></thead>
        <tbody>
            @forelse ($requests as $req)
                <tr>
                    <td>{{ $req->feature }}</td>
                    <td>{{ $req->user?->username ?? 'Guest' }}</td>
                    <td class="small">{{ \Illuminate\Support\Str::limit($req->message, 80) }}</td>
                    <td class="small text-secondary">{{ $req->created_at->diffForHumans() }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-secondary">No requests.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $requests->links() }}</div>
@endsection
