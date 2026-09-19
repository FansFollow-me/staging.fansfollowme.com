@extends('layouts.app')
@section('title', 'Gifts received')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Gifts received</h1>
    <a class="btn btn-outline-primary" href="{{ route('gifts.leaderboard', $user->username) }}">Top gifters</a>
</div>

@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

@if ($tips->isEmpty())
    <p class="text-secondary">No gifts yet. Share your profile and QR.</p>
@else
    <div class="card card-ffm p-0">
        @foreach ($tips as $tip)
            <div class="d-flex flex-wrap align-items-center gap-3 p-3 border-bottom border-secondary border-opacity-25">
                <div style="font-size:1.5rem;">
                    {{ \App\Support\TipCatalog::forKey($tip->gift_key)['emoji'] ?? '💸' }}
                </div>
                <div class="flex-grow-1">
                    <div class="fw-semibold">
                        {{ '@'.($tip->from?->username ?? 'Someone') }}
                        sent
                        {{ \App\Support\TipCatalog::forKey($tip->gift_key)['label'] ?? 'a tip' }}
                    </div>
                    <div class="small text-secondary">
                        ${{ number_format($tip->amount / 100, 2) }}
                        · {{ $tip->created_at->diffForHumans() }}
                        @if ($tip->thanked_at)
                            · {{ \App\Http\Controllers\GiftReactionController::REACTIONS[$tip->reaction]['emoji'] ?? '❤️' }} Thanked
                        @endif
                    </div>
                </div>
                @unless ($tip->thanked_at)
                    <div class="d-flex gap-1 flex-wrap">
                        @foreach (\App\Http\Controllers\GiftReactionController::REACTIONS as $key => $meta)
                            <form method="POST" action="{{ route('gifts.thank', $tip) }}">
                                @csrf
                                <input type="hidden" name="reaction" value="{{ $key }}">
                                <button class="btn btn-sm btn-ffm" type="submit">{{ $meta['emoji'] }} {{ $meta['label'] }}</button>
                            </form>
                        @endforeach
                    </div>
                @endunless
            </div>
        @endforeach
    </div>
    <div class="mt-3">{{ $tips->links() }}</div>
@endif
@endsection
