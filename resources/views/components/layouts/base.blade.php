<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ trim(($title ?? '') . ' - ' . config('app.name', 'Laravel'), ' -') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] dark:bg-zinc-950 dark:text-[#EDEDEC]">
    <div class="flex min-h-screen flex-col">
        

        <main {{ $attributes->class(['flex-1']) }}>
            {{ $slot }}
        </main>
    </div>
</body>

</html>