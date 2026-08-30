<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@section('title')@show {{ $settings->title }}</title>
<link href="/css/ffm-brand.css" rel="stylesheet">
</head>
<body>
@yield('content')
</body>
</html>
