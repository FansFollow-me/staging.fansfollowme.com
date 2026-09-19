@extends('layouts.app')
@section('title', 'Shop')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Shop</h1>
    @auth
        <div class="d-flex gap-2">
            <a class="btn btn-outline-primary" href="{{ route('shop.purchases') }}">My purchases</a>
            @if (auth()->user()->isCreator() || auth()->user()->isAdmin())
                <a class="btn btn-ffm" href="{{ route('shop.create') }}">Add product</a>
            @endif
        </div>
    @endauth
</div>

@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

@if ($products->isEmpty())
    <p class="text-secondary">No products yet.</p>
@else
    <div class="row g-3">
        @foreach ($products as $product)
            <div class="col-md-3">
                <div class="card card-ffm p-3 h-100">
                    <h2 class="h6">{{ $product->title }}</h2>
                    <div class="small text-secondary mb-2">by {{ $product->creator->username }}</div>
                    <p class="small flex-grow-1">{{ \Illuminate\Support\Str::limit($product->description ?? '', 80) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>${{ number_format($product->price / 100, 2) }}</strong>
                        <a class="btn btn-sm btn-ffm" href="{{ route('shop.show', $product) }}">View</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-3">{{ $products->links() }}</div>
@endif
@endsection
