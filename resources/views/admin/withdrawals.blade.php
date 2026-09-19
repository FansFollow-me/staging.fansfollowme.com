@extends('layouts.app')
@section('title', 'Admin · Withdrawals')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Withdrawals</h1>
    <a class="btn btn-outline-primary" href="{{ route('admin.dashboard') }}">Back</a>
</div>
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

<div class="card card-ffm p-3">
    <table class="table table-dark table-sm align-middle mb-0">
        <thead>
            <tr><th>Creator</th><th>Amount</th><th>Method</th><th>Details</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($requests as $r)
                <tr>
                    <td>{{ $r->creator?->username }}</td>
                    <td>${{ number_format($r->amount / 100, 2) }}</td>
                    <td>{{ $r->method }}</td>
                    <td class="small">{{ $r->details }}</td>
                    <td>{{ $r->status }}</td>
                    <td class="text-end">
                        @if ($r->status === 'pending')
                            <form method="POST" action="{{ route('admin.withdrawals.approve', $r) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success" type="submit">Approve</button>
                            </form>
                            <form method="POST" action="{{ route('admin.withdrawals.reject', $r) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-danger" type="submit">Reject</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-secondary">No withdrawal requests.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $requests->links() }}</div>
@endsection
