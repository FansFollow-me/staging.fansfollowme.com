@extends('layouts.app')
@section('title', 'My products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">My products</h1>
    <a class="btn btn-ffm" href="{{ route('shop.create') }}">Add product</a>
</div>
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif
@if ($products->isEmpty())
    <p class="text-secondary">No products yet.</p>
@else
    <div class="table-responsive card card-ffm p-3">
        <table class="table table-dark table-sm align-middle mb-0">
            <thead><tr><th>Title</th><th>Price</th><th>Active</th><th></th></tr></thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->title }}</td>
                        <td>${{ number_format($product->price / 100, 2) }}</td>
                        <td>{{ $product->is_active ? 'Yes' : 'No' }}</td>
                        <td><a href="{{ route('shop.show', $product) }}">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
