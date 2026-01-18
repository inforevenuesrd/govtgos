<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="revenuesrd">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-control" content="no-cache">
    <title>
        @yield('title')
    </title>
    <x-partials.styles />
    @yield('style')
</head>
<body>
    <x-partials.header />
      <div class="container">
        <div class="main-content-container">
            {{$slot}}
        </div>
      </div>
    <x-partials.footer />
    <x-partials.scripts />
</body>
</html>