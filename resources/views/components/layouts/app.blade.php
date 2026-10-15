<!DOCTYPE html>
<html lang="en" class="bg-white antialiased motion-safe:scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Wombat: see where your Mac’s disk space went' }}</title>
    <meta name="description" content="Wombat is a small, native disk space app for macOS. It digs through your Mac, shows what fills the disk and helps you clear out caches, build leftovers and old node_modules, without deleting anything you didn’t pick.">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Wombat">
    <meta property="og:title" content="Wombat: see where your Mac’s disk space went">
    <meta property="og:description" content="A small, native disk space app for macOS. Wombat digs through your disk and helps you clear out what you don’t need.">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:image" content="{{ asset('images/og.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="The Wombat app icon next to the words: Dig up where your disk space went.">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    @fonts

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-neutral-950">
    <div class="isolate">
        {{ $slot }}
    </div>
</body>
</html>
