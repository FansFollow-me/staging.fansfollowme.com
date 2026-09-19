@extends('layouts.app')
@section('title', 'Admin · Gifts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Gifts & video requests</h1>
    <a class="btn btn-outline-primary" href="{{ route('admin.dashboard') }}">Back</a>
</div>

<h2 class="h6">Recent tips / gifts</h2>
<div class="card card-ffm p-3 mb-4">
    <table class="table table-dark table-sm mb-0">
        <thead><tr><th>From</th><th>To</th><th>Gift</th><th>Amount</th><th>Thanked</th></tr></thead>
        <tbody>
            @forelse ($tips as $tip)
                <tr>
                    <td>{{ '@'.($tip->from?->username ?? '?') }}</td>
                    <td>{{ '@'.($tip->creator?->username ?? '?') }}</td>
                    <td>{{ \App\Support\TipCatalog::forKey($tip->gift_key)['label'] ?? 'Tip' }}</td>
                    <td>${{ number_format($tip->amount / 100, 2) }}</td>
                    <td>{{ $tip->thanked_at ? 'Yes' : '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-secondary">No gifts yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mb-4">{{ $tips->links() }}</div>

<h2 class="h6">Video requests</h2>
<div class="card card-ffm p-3">
    <table class="table table-dark table-sm mb-0">
        <thead><tr><th>Fan</th><th>Creator</th><th>Occasion</th><th>Price</th><th>Status</th></tr></thead>
        <tbody>
            @forelse ($videoRequests as $v)
                <tr>
                    <td>{{ '@'.($v->fan?->username ?? '?') }}</td>
                    <td>{{ '@'.($v->creator?->username ?? '?') }}</td>
                    <td>{{ $v->occasion }}</td>
                    <td>${{ number_format($v->price / 100, 2) }}</td>
                    <td>{{ $v->status }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-secondary">No video requests.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
