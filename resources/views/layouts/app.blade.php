<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ECサイト</title>
</head>

<body>

    @include('layouts.navigation')

    <main>
        {{ $slot }}
    </main>

</body>
</html>