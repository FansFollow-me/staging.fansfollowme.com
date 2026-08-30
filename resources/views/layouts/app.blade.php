<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@section('title')@show {{ $settings->title }}</title>
@include('includes.css_general')
@yield('css')
</head>
<body>
@include('includes.navbar')
<main role="main">
@yield('content')
</main>
@include('includes.footer')
@include('includes.javascript_general')
@yield('javascript')
</body>
</html>
