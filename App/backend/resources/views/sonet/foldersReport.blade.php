<!doctype html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Отчет</title>
</head>
<body>
    <h1>Отчет по папкам</h1>
    <div><b>Всего папок:</b> {{ $user->folders()->count() }}</div>
    <br>
    <ul>
        @foreach($user->folders()->orderByDesc('created_at')->get() as $folder)
            <li>{{ $folder->title }} ({{ $folder->notes()->count() }} заметок) [Создана: {{ $folder->created_at }}]</li>
        @endforeach
    </ul>
</body>
</html>
