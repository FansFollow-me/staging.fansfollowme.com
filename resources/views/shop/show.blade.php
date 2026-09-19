@extends('layouts.app')
@section('title', $product->title)

@section('content')
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-inline">
        <ul class="mb-0 small">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="card card-ffm p-4 col-lg-7">
    <div class="small text-secondary">{{ $product->type }} · by {{ $product->creator->username }}</div>
    <h1 class="h3 mt-1">{{ $product->title }}</h1>
    <p class="text-secondary">{{ $product->description }}</p>
    <div class="fs-3 fw-bold text-warning mb-3">${{ number_format($product->price / 100, 2) }}</div>
    @auth
        @if (auth()->id() !== $product->creator_id)
            <form method="POST" action="{{ route('shop.buy', $product) }}">
                @csrf
                <button class="btn btn-ffm" type="submit">Buy with wallet</button>
            </form>
            <p class="small text-secondary mt-2 mb-0">Need funds? <a href="{{ route('wallet.show') }}">Top up wallet</a></p>
        @else
            <p class="small text-secondary mb-0">This is your product.</p>
        @endif
    @else
        <a class="btn btn-ffm" href="{{ route('login') }}">Login to buy</a>
    @endauth
</div>
@endsection
