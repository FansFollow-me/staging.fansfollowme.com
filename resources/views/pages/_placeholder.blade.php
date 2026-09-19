@extends('layouts.app')
@section('title', ucfirst(str_replace('-', ' ', $page ?? 'Page')))

@section('content')
<div class="py-5 text-center">
    <h1 class="h2">{{ ucfirst(str_replace('-', ' ', request()->path())) }}</h1>
    <p class="text-secondary">This marketing page is wired. Port the full mockup markup into <code>resources/views/pages/{{ request()->path() }}.blade.php</code> for pixel parity.</p>
    <a class="btn btn-ffm" href="{{ route('home') }}">Home</a>
</div>
@endsection
