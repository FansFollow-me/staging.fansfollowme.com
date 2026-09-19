@extends('layouts.app')
@section('title', 'Top Gifters — '.$creator->username)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">🏆 Top Gifters</h1>
        <p class="text-secondary mb-0">@{{ $creator->username }}</p>
    </div>
    <a class="btn btn-outline-primary" href="{{ route('profile', $creator->username) }}">Back to profile</a>
</div>

<div class="d-flex gap-2 mb-4">
    @foreach (['week' => 'This Week', 'month' => 'This Month', 'all' => 'All Time'] as $p => $label)
        <a class="btn btn-sm {{ $period === $p ? 'btn-ffm' : 'btn-outline-primary' }}"
           href="{{ route('gifts.leaderboard', ['username' => $creator->username, 'period' => $p]) }}">{{ $label }}</a>
    @endforeach
</div>

@if ($rows->isEmpty())
    <p class="text-secondary">No gifts yet for this period. Be the first.</p>
@else
    <div class="card card-ffm p-0">
        @foreach ($rows as $i => $row)
            @php $rank = $i + 1; @endphp
            <div class="d-flex align-items-center gap-3 p-3 border-bottom border-secondary border-opacity-25 {{ $rank <= 3 ? 'bg-warning bg-opacity-10' : '' }}">
                <div style="width:2.5rem;text-align:center;font-size:1.25rem;">
                    {{ $medals[$i] ?? $rank }}
                </div>
                <div class="flex-grow-1">
                    <a href="{{ route('profile', $row->username) }}" class="fw-semibold">{{ '@'.$row->username }}</a>
                    <div class="small text-secondary">{{ $row->gift_count }} gift(s)</div>
                </div>
                <div class="fs-5 fw-bold {{ $rank <= 3 ? 'text-warning' : '' }}">{{ $row->total_display }}</div>
            </div>
        @endforeach
    </div>
@endif
@endsection
